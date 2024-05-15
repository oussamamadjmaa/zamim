<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Log;
use Twilio\Rest\Client;

class TwilioChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toTwilio($notifiable);

        try {
            $client = new Client(config('services.twilio.sid'), config('services.twilio.auth_token'));

            $sandboxMode  = config('services.twilio.sandbox_mode');
            $sandboxNumber  = config('services.twilio.sandbox_number');

            $client->messages->create(
                'whatsapp:' .  ($sandboxMode ? $sandboxNumber : $notifiable->routeNotificationForTwilio()),
                [
                    'from' => (string) 'whatsapp:'.config('services.twilio.phone_number'),
                    ...$message
                ]
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
