<?php

namespace ikepu_tp\SecureAuth\app\Notifications;

use ikepu_tp\SecureAuth\app\Models\TFA;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TFANotify extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private TFA $tfa)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("2段階認証認証コード")
            ->line("以下のコードを入力し，認証してください。")
            ->line("認証コード： {$this->tfa->value}");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}