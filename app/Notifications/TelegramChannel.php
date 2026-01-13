<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class TelegramChannel
{
    public function send(object $notifiable, Notification $notification): void
    {
        $data = $notification->toTelegram($notifiable);

        $chatId = $notifiable->telegram_chat_id ?? config('services.telegram.default_chat_id');

        if (!$chatId) {
            return;
        }

        $botToken = config('services.telegram.bot_token');

        if (!$botToken) {
            return;
        }

        Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $data['text'],
            'parse_mode' => $data['parse_mode'] ?? 'HTML',
            'disable_web_page_preview' => $data['disable_preview'] ?? false,
        ]);
    }
}
