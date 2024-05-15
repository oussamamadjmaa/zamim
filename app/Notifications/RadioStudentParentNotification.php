<?php

namespace App\Notifications;

use App\Models\Radio;
use App\Models\StudentProfile;
use App\Channels\TwilioChannel;
use App\Models\Article;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Storage;
use Twilio\TwiML\Voice\Stop;

class RadioStudentParentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $radio, $article, $notificationChannels;

    public $customEmail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Radio $radio, Article $article, array $notificationChannels)
    {
        $this->radio = $radio;
        $this->article =  $article;
        $this->notificationChannels = $notificationChannels;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = [];
        if (in_array('mail', $this->notificationChannels) && $notifiable->profile?->parent_email) {
            $this->customEmail = $notifiable->profile?->parent_email;

            $via[] = 'mail';
        }

        if (in_array('whatsapp', $this->notificationChannels)) {
            $via[] = TwilioChannel::class;
        }
        return $via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $hijriDate = hijriDate($this->radio->radio_date);
        $file = Storage::disk('public')->path($this->article->attachment);
        $fileName = 'مقالة ' . $this->article->title . '.' . File::extension($file);
        $fileMimeType = Storage::disk('public')->mimeType($this->article->attachment);

        return (new MailMessage)
                    ->subject('مشاركة في الإذاعة المدرسية')
                    ->greeting('إلى ولي أمر الطالب/الطالبة '. $notifiable->name)
                    ->lines(
                        [
                            'تحية طيبة وبعد،',
                            "نود إعلامكم بأن ابنكم/ابنتكم {$notifiable->name} سيشارك في الإذاعة الصباحية لليوم {$hijriDate}. نود أن نعبر عن تقديرنا لمشاركة ابنكم/ابنتكم في هذه الفعالية التعليمية الهامة.",
                            'عنوان المقالة التي سيقدمها هو: '.$this->article->title,
                            'تم ادراج مرفق المقالة يمكنكم تحميلهم ورؤية محتواه'
                        ]
                    )
                    ->attach($file, ['as' => $fileName, 'mime' => $fileMimeType])
                    ->lines([
                        'نشكر لكم دعمكم وتشجيعكم المستمر لأبنائنا وبناتنا.',
                        'وتفضلوا بقبول فائق الاحترام.'
                    ]);
    }

    public function toTwilio($notifiable) {
        $hijriDate = hijriDate($this->radio->radio_date);
        $message = "إلى ولي أمر الطالب/الطالبة {$notifiable->name},\n\n";
        $message .= "نود إعلامكم بأن ابنكم/ابنتكم سيشارك في الإذاعة الصباحية ليوم " . $hijriDate . ".\n\n";
        $message .= "عنوان المقالة: {$this->article->title}.\n\n";
        $message .= "شكرًا لدعمكم.\n\n";
        $message .= $notifiable->school?->name;

        return [
            'body' => $message,
            'mediaUrl' => Storage::disk('public')->url($this->article->attachment)
        ];
    }
}
