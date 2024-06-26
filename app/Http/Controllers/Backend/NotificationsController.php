<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
    public function index(Request $request) {
        return view('backend.notifications.index');
    }

    public function stats() {
        return (NotificationResource::collection(auth()->user()->notifications()->paginate(15)))->additional([
            'unreadCount' => auth()->user()->unreadNotifications()->count()
        ]);
    }

    public function redirect(DatabaseNotification $notification) {
        abort_if($notification->notifiable_type != $this->notifiableType() || $notification->notifiable_id != auth()->id(), 404);

        $notification->markAsRead();

        return redirect($this->notificationUrl($notification));
    }

    protected function notificationUrl($notification) {
        $type = explode('\\', $notification->type);
        $type = end($type);

        $urls = [
            'subscription_payment_status.in_review' => route('admin.subscriptions.index', ['payment_id' => $notification->data['data_id']]),
            'SubscriptionPaymentStatusNotification' => route('school.subscription.index', ['payment_id' => $notification->data['data_id']])
        ];

        return $urls[$notification->data['notification_type']] ?? $urls[$type] ?? route(getRoutePrefix().'.notifications.index');
    }

    protected function guardName() {
        return Auth::guard()->getName();
    }

    protected function notifiableType() {
        return Auth::guard()->getProvider()->getModel();
    }
}
