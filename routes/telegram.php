<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Services\TelegramStorageService;
use SergiX44\Nutgram\Nutgram;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

$bot->onCommand('start', function (Nutgram $bot) {
    $bot->sendMessage('Hello! Send me a file to save it to your storage, or use /channelid to get this chat ID.');
})->description('Start the bot');

$bot->onCommand('channelid', function (Nutgram $bot) {
    $chatId = $bot->chatId();
    $bot->sendMessage("This chat ID: **{$chatId}**. Add it to TELEGRAM_STORAGE_CHANNEL_ID in .env if this is your storage channel.", parse_mode: 'Markdown');
})->description('Get this chat ID (for storage channel setup)');

// Channel posts: save files from the storage channel to DB (single source of truth)
$bot->onChannelPost(function (Nutgram $bot) {
    $channelId = config('nutgram.config.storage_channel_id') ?: env('TELEGRAM_STORAGE_CHANNEL_ID');
    if ($bot->chatId() != $channelId) {
        return;
    }

    $message = $bot->message();
    if (! $message) {
        return;
    }

    $fileId = null;
    $originalName = 'unknown';
    $mimeType = null;
    $size = null;
    $type = 'document';

    if ($message->document) {
        $doc = $message->document;
        $fileId = $doc->file_id;
        $originalName = $message->caption ?? $doc->file_name ?? 'document';
        $mimeType = $doc->mime_type;
        $size = $doc->file_size;
        $type = 'document';
    } elseif ($message->photo && count($message->photo) > 0) {
        $photo = end($message->photo);
        $fileId = $photo->file_id;
        $originalName = $message->caption ?? 'photo.jpg';
        $size = $photo->file_size;
        $type = 'photo';
    } elseif ($message->audio) {
        $audio = $message->audio;
        $fileId = $audio->file_id;
        $originalName = $message->caption ?? $audio->file_name ?? 'audio';
        $mimeType = $audio->mime_type;
        $size = $audio->file_size;
        $type = 'audio';
    } elseif ($message->video) {
        $video = $message->video;
        $fileId = $video->file_id;
        $originalName = $message->caption ?? $video->file_name ?? 'video';
        $mimeType = $video->mime_type;
        $size = $video->file_size;
        $type = 'video';
    } elseif ($message->voice) {
        $voice = $message->voice;
        $fileId = $voice->file_id;
        $originalName = 'voice.ogg';
        $mimeType = $voice->mime_type;
        $size = $voice->file_size;
        $type = 'voice';
    } elseif ($message->video_note) {
        $vn = $message->video_note;
        $fileId = $vn->file_id;
        $originalName = 'video_note.mp4';
        $size = $vn->file_size;
        $type = 'video_note';
    }

    if ($fileId === null) {
        return;
    }

    try {
        $service = app(TelegramStorageService::class);
        $service->recordFileFromTelegram([
            'file_id' => $fileId,
            'message_id' => $message->message_id,
            'chat_id' => $bot->chatId() !== null ? (string) $bot->chatId() : null,
            'original_name' => $originalName,
            'mime_type' => $mimeType,
            'size' => $size,
            'source' => 'channel',
            'type' => $type,
        ]);
        \Illuminate\Support\Facades\Log::info('Telegram storage: channel file saved', ['file_id' => $fileId, 'type' => $type]);
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::error('Telegram storage: failed to record channel file', [
            'exception' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
});

// Files sent to the bot: forward to storage channel (onChannelPost will save to DB)
$bot->onMessage(function (Nutgram $bot) {
    $message = $bot->message();
    if (! $message) {
        return;
    }

    $fileId = null;
    $originalName = 'unknown';
    $mimeType = null;
    $size = null;
    $type = 'document';

    if ($message->document) {
        $doc = $message->document;
        $fileId = $doc->file_id;
        $originalName = $message->caption ?? $doc->file_name ?? 'document';
        $mimeType = $doc->mime_type;
        $size = $doc->file_size;
        $type = 'document';
    } elseif ($message->photo && count($message->photo) > 0) {
        $photo = end($message->photo);
        $fileId = $photo->file_id;
        $originalName = $message->caption ?? 'photo.jpg';
        $size = $photo->file_size;
        $type = 'photo';
    } elseif ($message->audio) {
        $audio = $message->audio;
        $fileId = $audio->file_id;
        $originalName = $message->caption ?? $audio->file_name ?? 'audio';
        $mimeType = $audio->mime_type;
        $size = $audio->file_size;
        $type = 'audio';
    } elseif ($message->video) {
        $video = $message->video;
        $fileId = $video->file_id;
        $originalName = $message->caption ?? $video->file_name ?? 'video';
        $mimeType = $video->mime_type;
        $size = $video->file_size;
        $type = 'video';
    } elseif ($message->voice) {
        $voice = $message->voice;
        $fileId = $voice->file_id;
        $originalName = 'voice.ogg';
        $mimeType = $voice->mime_type;
        $size = $voice->file_size;
        $type = 'voice';
    } elseif ($message->video_note) {
        $vn = $message->video_note;
        $fileId = $vn->file_id;
        $originalName = 'video_note.mp4';
        $size = $vn->file_size;
        $type = 'video_note';
    }

    if ($fileId === null) {
        return;
    }

    $channelId = config('nutgram.config.storage_channel_id') ?: env('TELEGRAM_STORAGE_CHANNEL_ID');
    if (empty($channelId)) {
        $bot->sendMessage('Storage channel not configured. Set TELEGRAM_STORAGE_CHANNEL_ID in .env.');
        return;
    }

    try {
        $bot->forwardMessage(
            chat_id: $channelId,
            from_chat_id: $bot->chatId(),
            message_id: $message->message_id
        );
        $bot->sendMessage('File forwarded to your storage.');
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::error('Telegram storage: failed to forward file to channel', [
            'exception' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        $bot->sendMessage('Sorry, could not forward (e.g. add me as admin in the channel).');
    }
});
