<?php

namespace App\Notifications;

use App\Models\TravelApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostTripSubmitted extends Notification
{
    use Queueable;

    public function __construct(public TravelApplication $application) {}

    public function via(object $notifiable): array { return ['database']; }

    public function toDatabase(object $notifiable): array
    {
        $applicant = $this->application->user;
        return [
            'application_id'   => $this->application->id,
            'reference_number' => $this->application->reference_number,
            'applicant_name'   => $applicant->full_name,
            'message'          => "{$applicant->full_name} has submitted post-trip documents for {$this->application->reference_number}. Please review and close the application.",
            'url'              => route('travel.post-trip-review'),
            'icon'             => 'bi-upload',
            'color'            => 'info',
        ];
    }
}
