<?php

namespace App\Services;

use App\Enums\TelegramFileType;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

class TelegramMessageParser
{
    /**
     * Extract file payload from a Telegram message if it contains a supported file type.
     *
     * @return array{file_id: string, message_id: int, original_name: string, mime_type: string|null, size: int|null, type: string}|null
     */
    public function parseMessagePayload(?Message $message): ?array
    {
        if ($message === null) {
            return null;
        }

        if ($message->document !== null) {
            $doc = $message->document;
            return [
                'file_id' => $doc->file_id,
                'message_id' => $message->message_id,
                'original_name' => $message->caption ?? $doc->file_name ?? 'document',
                'mime_type' => $doc->mime_type ?? null,
                'size' => $doc->file_size ?? null,
                'type' => TelegramFileType::Document->value,
            ];
        }

        if ($message->photo !== null && count($message->photo) > 0) {
            $photo = end($message->photo);
            return [
                'file_id' => $photo->file_id,
                'message_id' => $message->message_id,
                'original_name' => $message->caption ?? 'photo.jpg',
                'mime_type' => null,
                'size' => $photo->file_size ?? null,
                'type' => TelegramFileType::Photo->value,
            ];
        }

        if ($message->audio !== null) {
            $audio = $message->audio;
            return [
                'file_id' => $audio->file_id,
                'message_id' => $message->message_id,
                'original_name' => $message->caption ?? $audio->file_name ?? 'audio',
                'mime_type' => $audio->mime_type ?? null,
                'size' => $audio->file_size ?? null,
                'type' => TelegramFileType::Audio->value,
            ];
        }

        if ($message->video !== null) {
            $video = $message->video;
            return [
                'file_id' => $video->file_id,
                'message_id' => $message->message_id,
                'original_name' => $message->caption ?? $video->file_name ?? 'video',
                'mime_type' => $video->mime_type ?? null,
                'size' => $video->file_size ?? null,
                'type' => TelegramFileType::Video->value,
            ];
        }

        if ($message->voice !== null) {
            $voice = $message->voice;
            return [
                'file_id' => $voice->file_id,
                'message_id' => $message->message_id,
                'original_name' => 'voice.ogg',
                'mime_type' => $voice->mime_type ?? null,
                'size' => $voice->file_size ?? null,
                'type' => TelegramFileType::Voice->value,
            ];
        }

        if ($message->video_note !== null) {
            $vn = $message->video_note;
            return [
                'file_id' => $vn->file_id,
                'message_id' => $message->message_id,
                'original_name' => 'video_note.mp4',
                'mime_type' => null,
                'size' => $vn->file_size ?? null,
                'type' => TelegramFileType::VideoNote->value,
            ];
        }

        return null;
    }
}
