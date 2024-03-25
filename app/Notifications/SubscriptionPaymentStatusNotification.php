<?php

namespace App\Notifications;

use App\Models\Subscription\SubscriptionPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionPaymentStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $subscriptionPayment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SubscriptionPayment $subscriptionPayment)
    {
        $this->subscriptionPayment = $subscriptionPayment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = ['mail'];

        $databaseStatuses = [
            SubscriptionPayment::IN_REVIEW,
            SubscriptionPayment::CANCELED,
            SubscriptionPayment::COMPLETED
        ];

        $channels[] = in_array($this->subscriptionPayment->status, $databaseStatuses) ? 'database' : '';

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $status = $this->subscriptionPayment->status;

        switch ($status) {
            case SubscriptionPayment::FAILED:
                return $this->failedMessage();
                break;
            case SubscriptionPayment::CANCELED:
                return $this->canceledMessage();
                break;
            case SubscriptionPayment::COMPLETED:
                return $this->completedMessage();
                break;
            case SubscriptionPayment::ON_HOLD:
                return $this->onHoldMessage();
                break;
            case SubscriptionPayment::IN_REVIEW:
                return $this->inReviewMessage();
                break;
            case SubscriptionPayment::REFUNDED:
                return $this->refundedMessage();
                break;
            default:
                return $this->defaultMessage();
        }
    }

    protected function failedMessage()
    {
        return (new MailMessage)
            ->subject('فشل عملية الدفع')
            ->error()
            ->line('عذراً، فشلت عملية الدفع. يرجى المحاولة مرة أخرى.')
            ->line('سبب الفشل: ' . ($this->subscriptionPayment->comment ?: 'غير محدد'));
    }

    protected function canceledMessage()
    {
        return (new MailMessage)
            ->subject('إلغاء عملية الدفع')
            ->error()
            ->line('تم إلغاء عملية الدفع.')
            ->line('سبب الإلغاء: ' . ($this->subscriptionPayment->comment ?: 'غير محدد'));
    }

    protected function completedMessage()
    {
        return (new MailMessage)
            ->subject('تم تأكيد عملية الدفع بنجاح')
            ->line('تم تأكيد عملية الدفع بنجاح.')
            ->line('المبلغ: ' . $this->subscriptionPayment->amount . $this->subscriptionPayment->currency);
    }

    protected function onHoldMessage()
    {
        return (new MailMessage)
            ->subject('تك تعليق عملية الدفع')
            ->line('تم تعليق عملية الدفع لحين مراجعة البيانات.');
    }

    protected function inReviewMessage()
    {
        return (new MailMessage)
            ->subject('عملية دفع جديدة بإنتظار المراجعة')
            ->line('هناك عملية دفع جديدة تحتاج إلى مراجعة.')
            ->line('يرجى التحقق منها في لوحة التحكم الخاصة بالمشرفين.');
    }

    protected function refundedMessage()
    {
        return (new MailMessage)
            ->subject('رسالة استرداد الدفع')
            ->line('تم استرداد المبلغ المدفوع.');
    }

    protected function defaultMessage()
    {
        return (new MailMessage)
            ->subject('تم تحديث حالة الدفع')
            ->line('تم تسجيل تحديث في حالة الدفع. الرجاء التحقق منها.')
            ->line('الحالة الجديدة: ' . $this->subscriptionPayment->status);
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
            'notification_type' => 'subscription_payment_status.' . $this->subscriptionPayment->status,
            'data_id'          => $this->subscriptionPayment->id
        ];
    }
}
