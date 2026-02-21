<?php

namespace App\Services;

use App\Contracts\NotificationGateway;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppNotificationGateway implements NotificationGateway
{
    public function send(string $to, string $message, array $context = []): void
    {
        $appkey = config('whatsapp.appkey');
        $authkey = config('whatsapp.authkey');
        $baseUrl = rtrim(config('whatsapp.base_url', 'https://mart.reachrapid.net'), '/');
        $url = $baseUrl . '/api/create-message';
        $multipartData = [
            ['name' => 'appkey', 'contents' => $appkey],
            ['name' => 'authkey', 'contents' => $authkey],
            ['name' => 'to', 'contents' => $to],
            ['name' => 'message', 'contents' => $message],
        ];
        $response = Http::asMultipart()->post($url, $multipartData);

        if (! $response->successful()) {
            Log::error('WhatsApp API error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'to' => $to,
                'context' => $context,
            ]);

            throw new \RuntimeException(
                'WhatsApp API returned ' . $response->status() . ': ' . $response->body()
            );
        }
    }
}
