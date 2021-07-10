<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserStatusUpdateNotification extends Notification
{
    use Queueable;

    protected $status;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $msg = "";
        switch ($this->status) {
            case 0:
                $msg = __('A regisztációja még nem került elfogadásra, kérjük várjon türelemmel.');
                break;
            case 1:
                $msg = __('Regisztráció elfogadva. A lenti gombra kattintva be tud jelentkezni.');
                break;
            case 2:
                $msg = __('Regisztráció elutasítva.');
                break;
        }
        $mail = (new MailMessage);
        $mail->line($msg);
        if ($this->status == 1) {
            $mail->action('Bejelentkezés', url('/'));
        }

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
