<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SSEController extends Controller
{
    /**
     * Stream Server-Sent Events to the client.
     *
     * @return StreamedResponse
     */
    public function stream()
    {
        // Initialize the streamed response with SSE headers
        $response = new StreamedResponse(function () {
            try {
                // Keep track of processed messages
                $lastMessageId = 0;
                // In-memory message store (non-persistent, for demo)
                static $messages = [];

                // Listen for new messages in an infinite loop
                while (true) {
                    // Exit if client disconnects
                    if (connection_aborted()) {
                        Log::info('SSE: Client connection closed');
                        break;
                    }

                    // Check for new messages
                    if (count($messages) > $lastMessageId) {
                        $event = $messages[$lastMessageId];
                        echo "event: message.sent\n";
                        echo "data: " . json_encode($event) . "\n\n";
                        $lastMessageId++;
                    } else {
                        // Send ping to keep connection alive
                        echo ": ping\n\n";
                    }

                    // Flush output to client
                    ob_flush();
                    flush();

                    // Wait before next check
                    sleep(5);
                }
            } catch (\Exception $e) {
                // Log any errors for debugging
                Log::error('SSE Error: ' . $e->getMessage());
            }
        });

        // Set required SSE headers
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');

        return $response;
    }

    /**
     * Add a new message to the in-memory store.
     *
     * @param string $message
     * @param string $user
     * @return void
     */
    public static function addMessage($message, $user)
    {
        static $messages = [];
        $messages[] = [
            'user' => $user,
            'message' => $message,
        ];
    }
}
