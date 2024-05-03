<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    private $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token, $email)
    {
        // Initialize the token and email properties for the password reset notification
        $this->token = [
            "token" => $token,
            "email" => $email,
        ];
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
     * Build the mail representation for password reset.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Configure the mail message for password reset
        return (new MailMessage)
            ->subject('بازنشانی کلمه عبور')
            ->line('شما این ایمیل را دریافت می کنید زیرا ما یک درخواست بازنشانی کلمه عبور برای حساب شما دریافت کردیم.')
            ->action('بازنشانی کلمه عبور', url(config('app.url') . route('password.reset', $this->token, false)))
            ->line('اگر بازنشانی کلمه عبور را درخواست نکردید، لطفا این پیام را نادیده بگیرید.');
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
