<?php

namespace App\Notifications;

use App\Models\PlatformPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PublishFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public PlatformPost $platformPost
    ) {}

    public function via(object $notifiable): array
    {
        $channels = ['database'];

        if (config('services.telegram.bot_token')) {
            $channels[] = TelegramChannel::class;
        }

        if ($notifiable->email) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $content = $this->platformPost->contentItem;
        $platform = strtoupper($this->platformPost->socialAccount->platform);

        return (new MailMessage)
            ->subject("❌ Gagal Publish ke {$platform}")
            ->greeting('Oops!')
            ->line("Konten \"{$content->title}\" gagal dipublish ke {$platform}.")
            ->line("Error: {$this->platformPost->error_message}")
            ->line("Percobaan: {$this->platformPost->attempt_count}/3")
            ->action('Retry di Dashboard', url('/admin/platform-posts'))
            ->line('Silakan cek koneksi akun atau coba lagi nanti.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'format' => 'filament',
            'title' => '❌ Publish Gagal',
            'body' => "Gagal publish ke " . strtoupper($this->platformPost->socialAccount->platform) . ": " . $this->platformPost->error_message,
            'platform_post_id' => $this->platformPost->id,
            'error' => $this->platformPost->error_message,
        ];
    }

    public function toTelegram(object $notifiable): array
    {
        $content = $this->platformPost->contentItem;
        $platform = strtoupper($this->platformPost->socialAccount->platform);

        return [
            'text' => "❌ *Publish Gagal*\n\n"
                . "Konten: {$content->title}\n"
                . "Platform: {$platform}\n"
                . "Error: {$this->platformPost->error_message}\n"
                . "Attempts: {$this->platformPost->attempt_count}/3",
            'parse_mode' => 'Markdown',
        ];
    }
}
