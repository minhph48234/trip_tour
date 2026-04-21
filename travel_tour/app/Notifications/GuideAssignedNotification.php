<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GuideAssignedNotification extends Notification
{
    use Queueable;

    protected $group;

    public function __construct($group)
    {
        $this->group = $group;
    }

    public function via($notifiable)
    {
        return ['database']; // lưu DB
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Bạn vừa được phân công tour: ' . $this->group->trip->tour->name,
            'group_id' => $this->group->id,
            'start_date' => $this->group->trip->start_date
        ];
    }
}