<?php

namespace ikepu_tp\SecureAuth\app\Notifications;

use ikepu_tp\SecureAuth\app\Models\Sa_login_history;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Sa_login_history $sa_login_history)
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
            ->subject("ログインのお知らせ")
            ->line('以下のデバイスからログインがありました。')
            ->line('不審なログインの場合はログイン用パスワードの変更をしてください。')
            ->lines([
                "",
                'デバイス：' . $this->sa_login_history->device,
                "ブラウザ：" . $this->sa_login_history->browser,
                'IPアドレス：' . $this->sa_login_history->ip_address,
                'ログイン日時：' . $this->sa_login_history->created_at,
            ]);
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