<?php

namespace App\Notifications;

use App\Models\CarRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CarRequestAssignedToDriver extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $carRequest;
    
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
        return ['database', 'mail']; // ถ้าอยากส่ง email ด้วย ให้เพิ่ม 'mail'
    }
    

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('แจ้งเตือนมอบหมายงานขับรถ')
            ->greeting('สวัสดีครับ/ค่ะ ' . $notifiable->name)
            ->line('คุณได้รับมอบหมายให้ขับรถในคำขอ #' . $this->carRequest->id)
            ->action('ดูรายละเอียด', url('/driver/assigned-jobs'))
            ->line('ขอบคุณที่ใช้งานระบบของเรา');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "คำขอรถหมายเลข {$this->carRequest->id} ได้รับการอนุมัติแล้ว กรุณาตรวจสอบงานที่ได้รับมอบหมาย",
            'url' => route('driver.assigned_jobs'),
        ];
    }
}
