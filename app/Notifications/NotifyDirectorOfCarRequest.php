<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyDirectorOfCarRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $carRequest;

    public function __construct($carRequest)
    {
        $this->carRequest = $carRequest;
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'คำขอใช้รถใหม่',
            'massage' => 'มีค่าขอใช้รถจาก' . $this->carRequest->user->name,
            'url' => route('director.director_list'),
        ];
    }
}
