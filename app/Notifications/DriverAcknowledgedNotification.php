<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CarRequest;

class DriverAcknowledgedNotification extends Notification
{
    use Queueable;


    public $carRequest;
    /**
     * Create a new notification instance.
     */
    public function __construct(CarRequest $carRequest)
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
        return ['database']; // หรือ 'mail', 'telegram', ฯลฯ ตามระบบคุณ
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
    public function toArray($notifiable)
    {
        return [
            'title' => 'คนขับตอบกลับคำขอ',
            'message' => 'คนขับ ' . $this->carRequest->driver . ' ได้' .
                ($this->carRequest->acknowledgement_status === 'accepted' ? 'รับทราบ' : 'ไม่รับทราบ') .
                ' งานเมื่อ ' . now()->format('d/m/Y H:i') .
                ($this->carRequest->acknowledgement_status === 'rejected' ? "\nเหตุผล: " . $this->carRequest->acknowledgement_reason : ''),
            'url' => route('chief.acknowledgement_history'), // เปลี่ยนตามหน้าที่คุณต้องการให้ chief ไปดู
        ];
    }
}
