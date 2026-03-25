<?php

namespace App\Notifications;

use App\Models\TravelApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationClosed extends Notification
{
    use Queueable;

    public function __construct(public TravelApplication $application) {}

    public function via(object $notifiable): array { return ['database']; }

    public function toDatabase(object $notifiable): array
    {
        return [
            'application_id'   => $this->application->id,
            'reference_number' => $this->application->reference_number,
            'message'          => "Your application {$this->application->reference_number} has been reviewed and closed. You may now submit a new travel application.",
            'url'              => route('travel.show', $this->application->id),
            'icon'             => 'bi-check2-circle',
            'color'            => 'success',
        ];
    }
}
