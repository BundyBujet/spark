<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Services\TelegramChannelHandler;
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

$bot->onChannelPost(fn (Nutgram $bot) => app(TelegramChannelHandler::class)->handleChannelPost($bot));

$handleFileMessage = fn (Nutgram $bot) => app(TelegramChannelHandler::class)->handleIncomingMessage($bot);

$bot->onDocument($handleFileMessage);
$bot->onPhoto($handleFileMessage);
$bot->onAudio($handleFileMessage);
$bot->onVideo($handleFileMessage);
$bot->onVoice($handleFileMessage);
$bot->onVideoNote($handleFileMessage);
$bot->onMessage($handleFileMessage);
