<?php

namespace App\Notifications;

use App\Models\TravelApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostTripUploadDue extends Notification
{
    use Queueable;

    public function __construct(
        public TravelApplication $application
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'application_id'   => $this->application->id,
            'reference_number' => $this->application->reference_number,
            'travel_type'      => $this->application->travel_type,
            'message'          => "Your trip for application {$this->application->reference_number} has ended. Please upload your post-trip documents.",
            'url'              => route('travel.post-trip'),
            'icon'             => 'bi-upload',
            'color'            => 'warning',
        ];
    }
}
