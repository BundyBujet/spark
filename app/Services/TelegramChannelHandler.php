<?php

namespace App\Services;

use App\Enums\TelegramFileSource;
use App\Repositories\TelegramFileRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;

class TelegramChannelHandler
{
    public function __construct(
        protected TelegramMessageParser $parser,
        protected TelegramStorageService $storageService,
        protected TelegramFileRepository $repository
    ) {}

    /**
     * Handle channel post: if from storage channel and message has a file, record it in DB.
     */
    public function handleChannelPost(Nutgram $bot): void
    {
        $channelId = config('nutgram.config.storage_channel_id') ?: env('TELEGRAM_STORAGE_CHANNEL_ID');
        if ($channelId === null || $channelId === '') {
            return;
        }
        if ((string) $bot->chatId() !== (string) $channelId) {
            return;
        }

        $message = $bot->message();
        if ($message === null || $message->forward_origin !== null) {
            return;
        }

        $payload = $this->parser->parseMessagePayload($message);
        if ($payload === null) {
            return;
        }

        try {
            $this->storageService->recordFileFromTelegram([
                'file_id' => $payload['file_id'],
                'message_id' => $payload['message_id'],
                'chat_id' => $bot->chatId() !== null ? (string) $bot->chatId() : null,
                'original_name' => $payload['original_name'],
                'mime_type' => $payload['mime_type'],
                'size' => $payload['size'],
                'source' => TelegramFileSource::Channel->value,
                'type' => $payload['type'],
            ]);
            Log::info('Telegram storage: channel file saved', [
                'file_id' => $payload['file_id'],
                'type' => $payload['type'],
            ]);
        } catch (\Throwable $e) {
            Log::error('Telegram storage: failed to record channel file', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Handle incoming message: if it has a file, record in DB and forward to storage channel.
     */
    public function handleIncomingMessage(Nutgram $bot): void
    {
        $message = $bot->message();
        $payload = $this->parser->parseMessagePayload($message);
        if ($payload === null) {
            Log::debug('Telegram storage: handleIncomingMessage skipped – no file in message');
            return;
        }

        $channelId = config('nutgram.config.storage_channel_id') ?: env('TELEGRAM_STORAGE_CHANNEL_ID');
        if (empty($channelId)) {
            $bot->sendMessage('Storage channel not configured. Set TELEGRAM_STORAGE_CHANNEL_ID in .env.');
            return;
        }

        $recordData = [
            'file_id' => $payload['file_id'],
            'message_id' => $payload['message_id'],
            'chat_id' => (string) $channelId,
            'original_name' => $payload['original_name'],
            'mime_type' => $payload['mime_type'],
            'size' => $payload['size'],
            'source' => TelegramFileSource::Channel->value,
            'type' => $payload['type'],
        ];

        $savedId = null;
        try {
            $savedId = DB::transaction(function () use ($recordData) {
                $model = $this->repository->create($recordData);
                Log::info('Telegram storage: file from bot chat saved', [
                    'id' => $model->id,
                    'file_id' => $recordData['file_id'],
                    'type' => $recordData['type'],
                ]);
                return $model->id;
            });
        } catch (\Throwable $e) {
            Log::error('Telegram storage: failed to record file from bot chat', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file_id' => $payload['file_id'],
            ]);
            $bot->sendMessage('File forwarded but could not save to storage: ' . $e->getMessage());
        }

        try {
            $bot->forwardMessage(
                chat_id: $channelId,
                from_chat_id: $bot->chatId(),
                message_id: $payload['message_id']
            );
            $bot->sendMessage($savedId !== null
                ? 'File forwarded to your storage (saved #' . $savedId . ').'
                : 'File forwarded to your storage.');
        } catch (\Throwable $e) {
            Log::error('Telegram storage: failed to forward file to channel', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $bot->sendMessage('Sorry, could not forward (e.g. add me as admin in the channel).');
        }
    }
}
