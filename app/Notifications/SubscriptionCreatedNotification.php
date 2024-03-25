<?php

namespace App\Notifications;

use App\Models\Subscription\PlanSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $planSubscription;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PlanSubscription $planSubscription)
    {
        $this->planSubscription = $planSubscription;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('تأكيد اشتراك المدرسة في منصة الإذاعة المدرسية')
                    ->line('نأمل أن تكون بخير. يسرنا إعلامكم بتأكيد استلام رسوم الاشتراك الخاصة بمدرستكم في منصتنا الإذاعية المدرسية. تم تفعيل حسابكم بنجاح.')
                    ->line('نتمنى لكم تجربة ملهمة وفعّالة على منصتنا.')
                    ->line('في حال وجود أي استفسار، يُرجى الاتصال بفريق الدعم عبر البريد الإلكتروني')
                    ->line('شكرًا لتعاونكم، ونتمنى لكم عامًا دراسيًا ناجحًا!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
