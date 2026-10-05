<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;

/**
 * Password-reset email for admins, in Bahasa Malaysia. Links to the admin reset
 * route (admin.password.reset) rather than the framework default.
 */
class AdminResetPassword extends Notification
{
    use Queueable;

    public function __construct(public string $token) {}

    /** @return array<int, string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('admin.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        $expire = Config::get('auth.passwords.'.Config::get('auth.defaults.passwords').'.expire', 60);

        return (new MailMessage)
            ->subject('Tetapan Semula Kata Laluan — KofiLeads')
            ->greeting('Salam,')
            ->line('Kami menerima permintaan untuk menetapkan semula kata laluan akaun admin anda.')
            ->action('Tetapkan Semula Kata Laluan', $url)
            ->line("Pautan ini akan tamat tempoh dalam {$expire} minit.")
            ->line('Jika anda tidak membuat permintaan ini, abaikan e-mel ini — kata laluan anda kekal tidak berubah.')
            ->salutation('Terima kasih, Pasukan KofiLeads');
    }
}
