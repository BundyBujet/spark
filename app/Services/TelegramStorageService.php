<?php

namespace App\Services;

use App\Enums\TelegramFileSource;
use App\Enums\TelegramFileType;
use App\Models\TelegramFile;
use App\Repositories\TelegramFileRepository;
use Illuminate\Http\StreamedResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;

class TelegramStorageService
{
    public function __construct(
        protected Nutgram $bot,
        protected TelegramFileRepository $repository
    ) {}

    /**
     * Upload a file from the web to the storage channel and persist metadata.
     *
     * @throws InvalidArgumentException if TELEGRAM_STORAGE_CHANNEL_ID is not set
     */
    public function uploadToStorageChannel(UploadedFile $file, ?int $uploadedBy = null): TelegramFile
    {
        $channelId = config('nutgram.config.storage_channel_id') ?: env('TELEGRAM_STORAGE_CHANNEL_ID');
        if (empty($channelId)) {
            throw new InvalidArgumentException(
                'TELEGRAM_STORAGE_CHANNEL_ID is not set. Get your channel ID by sending /channelid in the channel and add it to .env.'
            );
        }

        $inputFile = InputFile::make($file->getRealPath(), $file->getClientOriginalName());
        $message = $this->bot->sendDocument(
            document: $inputFile,
            chat_id: $channelId
        );

        if (! $message || ! $message->document) {
            throw new \RuntimeException('Failed to send document to Telegram.');
        }

        $doc = $message->document;
        return $this->repository->create([
            'file_id' => $doc->file_id,
            'message_id' => $message->message_id,
            'chat_id' => (string) $channelId,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'source' => TelegramFileSource::Web->value,
            'type' => TelegramFileType::Document->value,
            'uploaded_by' => $uploadedBy,
        ]);
    }

    /**
     * Record a file received from Telegram (webhook) without uploading.
     */
    public function recordFileFromTelegram(array $messageData): TelegramFile
    {
        $source = $messageData['source'] ?? TelegramFileSource::Telegram->value;
        $type = $messageData['type'] ?? TelegramFileType::Document->value;

        return $this->repository->create([
            'file_id' => $messageData['file_id'],
            'message_id' => $messageData['message_id'] ?? null,
            'chat_id' => $messageData['chat_id'] ?? null,
            'original_name' => $messageData['original_name'] ?? 'unknown',
            'mime_type' => $messageData['mime_type'] ?? null,
            'size' => $messageData['size'] ?? null,
            'source' => $source,
            'type' => $type,
            'telegram_user_id' => $messageData['telegram_user_id'] ?? null,
        ]);
    }

    /**
     * Build a signed download URL for the file server (VPS). Redirect user to this URL to download.
     * Requires TELEGRAM_FILE_SERVER_URL and TELEGRAM_FILE_SERVER_SECRET in .env.
     */
    public function getSignedFileDownloadUrl(TelegramFile $file, ?int $expiresMinutes = null): string
    {
        $baseUrl = config('nutgram.config.file_server_url');
        $secret = config('nutgram.config.file_server_secret');
        if (empty($baseUrl) || empty($secret)) {
            throw new InvalidArgumentException(
                'TELEGRAM_FILE_SERVER_URL and TELEGRAM_FILE_SERVER_SECRET must be set in .env for signed download.'
            );
        }

        $path = $this->ensureTelegramFilePath($file);
        $path = ltrim(str_replace('\\', '/', $path), '/');
        // Path must be relative to VPS base /root/telegram-bot-api (strip that prefix)
        $path = preg_replace('#^root/telegram-bot-api/#', '', $path);
        $name = $file->original_name ?: 'download';
        $mime = $file->mime_type ?: 'application/octet-stream';
        $expiresMinutes = $expiresMinutes ?? config('nutgram.config.file_download_expires_minutes', 15);
        $exp = now()->addMinutes($expiresMinutes)->timestamp;

        $payload = ['path' => $path, 'name' => $name, 'mime' => $mime, 'exp' => $exp];

        $toSign = json_encode($payload);
        $payload['sig'] = base64_encode(hash_hmac('sha256', $toSign, $secret, true));
        $token = strtr(base64_encode(json_encode($payload)), '+/', '-_');

        return $baseUrl . '/download.php?token=' . $token;
    }

    /**
     * Get the download URL for a stored file (fetches file_path from Telegram if needed).
     */
    public function getFileDownloadUrl(TelegramFile $file): string
    {
        $path = $this->ensureTelegramFilePath($file);
        $isLocal = (bool) config('nutgram.config.is_local');
        $path = $this->normalizeFilePathForUrl($path, $isLocal);

        $baseUrl = rtrim(config('nutgram.config.api_url'), '/');
        $token = config('nutgram.token');

        return sprintf('%s/file/bot%s/%s', $baseUrl, $token, ltrim($path, '/'));
    }

    /**
     * Ensure file has telegram_file_path (fetch from Telegram API if missing). Returns the path.
     */
    private function ensureTelegramFilePath(TelegramFile $file): string
    {
        $path = $file->telegram_file_path;
        if (! empty($path)) {
            return $path;
        }
        $tgFile = $this->bot->getFile($file->file_id);
        if (! $tgFile || empty($tgFile->file_path)) {
            throw new \RuntimeException('Could not get file path from Telegram.');
        }
        $path = $tgFile->file_path;
        $file->update(['telegram_file_path' => $path]);

        return $path;
    }

    /**
     * Stream file download to the client (no redirect). Fetches from Bot API server and streams.
     */
    public function streamFileDownload(TelegramFile $file): StreamedResponse
    {
        $url = $this->getFileDownloadUrl($file);

        $response = Http::withOptions(['stream' => true])->get($url);
        if (! $response->successful()) {
            Log::warning('Telegram storage download: HTTP failure', [
                'raw_file_path' => $file->telegram_file_path,
                'requested_url' => $url,
                'status' => $response->status(),
            ]);
            $lastUrl = $url;
            $isLocal = (bool) config('nutgram.config.is_local');
            if ($isLocal && $file->telegram_file_path) {
                $path = $this->normalizeFilePathForUrl($file->telegram_file_path, true);
                $fallbackPath = 'documents/' . basename($path);
                $baseUrl = rtrim(config('nutgram.config.api_url'), '/');
                $token = config('nutgram.token');
                $lastUrl = sprintf('%s/file/bot%s/%s', $baseUrl, $token, $fallbackPath);
                $response = Http::withOptions(['stream' => true])->get($lastUrl);
            }
            if (! $response->successful()) {
                Log::warning('Telegram storage download: retry HTTP failure', [
                    'raw_file_path' => $file->telegram_file_path,
                    'requested_url' => $lastUrl,
                    'status' => $response->status(),
                ]);
                throw new \RuntimeException('Could not fetch file from Telegram (HTTP ' . $response->status() . ').');
            }
        }

        $mimeType = $file->mime_type ?: 'application/octet-stream';
        $filename = $this->sanitizeFilenameForDisposition($file->original_name ?: 'download');
        $inline = $this->shouldDispositionInline($mimeType);
        $disposition = $inline ? 'inline' : 'attachment';

        $headers = [
            'Content-Type' => $mimeType,
            'Content-Disposition' => sprintf('%s; filename="%s"', $disposition, addslashes($filename)),
        ];

        $stream = $response->toPsrResponse()->getBody();

        return new StreamedResponse(function () use ($stream) {
            while (! $stream->eof()) {
                echo $stream->read(8192);
                if (ob_get_level()) {
                    ob_flush();
                }
                flush();
            }
        }, 200, $headers);
    }

    /**
     * Normalize file_path for Local Bot API Server (relative path the server can serve).
     */
    private function normalizeFilePathForUrl(string $filePath, bool $isLocal): string
    {
        $path = ltrim($filePath, '/');
        if (! $isLocal) {
            return $path;
        }
        $segments = ['documents/', 'photos/', 'voice/', 'video/'];
        foreach ($segments as $seg) {
            if (str_contains($path, $seg)) {
                $pos = strpos($path, $seg);
                return substr($path, $pos);
            }
        }
        if (str_contains($path, 'root/') || str_contains($path, 'telegram-bot-api/')) {
            return basename($path);
        }
        return $path;
    }

    private function shouldDispositionInline(string $mimeType): bool
    {
        return str_starts_with($mimeType, 'image/') || $mimeType === 'application/pdf';
    }

    private function sanitizeFilenameForDisposition(string $filename): string
    {
        $filename = basename($filename);
        return preg_replace('/[^\w\s\-\.]/u', '_', $filename) ?: 'download';
    }
}
