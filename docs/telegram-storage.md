# Telegram Storage Feature

This feature lets you upload, list, and download files via your Telegram bot. Files can be uploaded from the admin web UI or by sending them to the bot in the Telegram app. All files are stored in a private Telegram channel and indexed in the app database.

## Prerequisites

- A Telegram bot (via [@BotFather](https://t.me/BotFather))
- A **private channel** where the bot is added as an **admin** (with permission to post)
- Local Bot API Server running (e.g. at `tel.reachrapid.net`) or the official Telegram API

## Environment

In `.env`:

```env
TELEGRAM_BOT_API_URL=https://tel.reachrapid.net
TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_BOT_API_IS_LOCAL=true
TELEGRAM_STORAGE_CHANNEL_ID=
```

- **TELEGRAM_STORAGE_CHANNEL_ID**: Required for web uploads. Leave empty until you obtain it (see below).

## Getting the Storage Channel ID

1. Create a **private channel** and add your bot as an **admin** (with permission to post messages).
2. Send any message in the channel, or forward a message from the channel to your bot.
3. In a **private chat** with your bot, send: `/channelid`
   - The bot replies with the current chat ID. For a **channel**, you must get the channel’s ID:
   - Add the bot to the channel, then send a message **in the channel** (e.g. "test"). The bot will receive an update with that chat’s ID. Use the Nutgram handler that replies with `chat_id` when it receives a message (e.g. in `routes/telegram.php` you can add a handler that, for any message, replies with "This chat ID: {chat_id}").
4. The channel ID is usually a negative number (e.g. `-1001234567890`). Put it in `.env` as `TELEGRAM_STORAGE_CHANNEL_ID=-1001234567890`.

## Webhook (production)

For "upload from Telegram" (sending files to the bot on your phone), Telegram must send updates to your app:

1. Expose your app over HTTPS (e.g. `https://your-domain.com`).
2. Set the webhook:
   ```bash
   php artisan nutgram:hook:set https://your-domain.com/api/telegram/webhook
   ```
3. The route `POST /api/telegram/webhook` is already registered in `routes/api.php` (no auth, no CSRF).

To remove the webhook:

```bash
php artisan nutgram:hook:remove
```

## Polling (local development)

If Telegram cannot reach your machine (e.g. localhost), use long polling.

**Important:** If a webhook is set on your bot, Telegram sends all updates to the webhook URL and **getUpdates (polling) returns nothing**. You must remove the webhook first:

```bash
php artisan nutgram:hook:remove
# Optional: drop pending updates so old messages are not processed
php artisan nutgram:hook:remove --drop-pending-updates
```

Check that no webhook is set:

```bash
php artisan nutgram:hook:info
```

Then start polling:

```bash
php artisan nutgram:run
```

Keep this running in a terminal. When you send a file to the bot in Telegram, the app will receive the update and save the file metadata. No webhook or public URL is required.

For local webhook testing you can use [ngrok](https://ngrok.com/):

```bash
ngrok http 80
php artisan nutgram:hook:set https://your-ngrok-url.ngrok.io/api/telegram/webhook
```

## Permissions

Only admins with the **Manage Telegram Storage** permission can access the Telegram Storage UI (list, upload, download, delete). Assign this permission to the desired role (e.g. Owner) via the Roles admin page or by running:

```bash
php artisan db:seed --class=TelegramStoragePermissionSeeder
```

## File size

With a **Local Bot API Server**, uploads and downloads support files up to **2 GB**. The form request allows up to 2 GB; you can lower the limit in `App\Http\Requests\TelegramFileUploadRequest` if needed.

## Summary

| Action            | From web                         | From Telegram (phone)                    |
|------------------|-----------------------------------|------------------------------------------|
| Upload           | Admin → Telegram Storage → Upload | Send file to bot (webhook or polling)    |
| List             | Admin → Telegram Storage          | Same list                                |
| Download         | Click Download in list            | Open link from web or use Telegram       |
| Get channel ID   | -                                 | Send `/channelid` to bot in the channel  |
