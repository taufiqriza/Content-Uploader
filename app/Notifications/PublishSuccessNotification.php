<?php

namespace App\Notifications;

use App\Models\PlatformPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PublishSuccessNotification extends Notification implements ShouldQueue
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
            ->subject("✅ Konten Berhasil Dipublish ke {$platform}")
            ->greeting('Selamat!')
            ->line("Konten \"{$content->title}\" berhasil dipublish ke {$platform}.")
            ->action('Lihat Post', $this->platformPost->external_url ?? url('/admin'))
            ->line('Terima kasih menggunakan Al-Amani Content Hub!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'format' => 'filament',
            'title' => '✅ Publish Berhasil',
            'body' => "Konten berhasil dipublish ke " . strtoupper($this->platformPost->socialAccount->platform),
            'platform_post_id' => $this->platformPost->id,
            'external_url' => $this->platformPost->external_url,
        ];
    }

    public function toTelegram(object $notifiable): array
    {
        $content = $this->platformPost->contentItem;
        $platform = strtoupper($this->platformPost->socialAccount->platform);

        return [
            'text' => "✅ *Publish Berhasil*\n\n"
                . "Konten: {$content->title}\n"
                . "Platform: {$platform}\n"
                . "Link: {$this->platformPost->external_url}",
            'parse_mode' => 'Markdown',
        ];
    }
}
