<?php

namespace App\Notifications;

use App\Models\ConcurrenceStep;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationNotConcurred extends Notification
{
    use Queueable;

    public function __construct(
        public ConcurrenceStep $step
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $app = $this->step->application;

        return [
            'application_id'   => $app->id,
            'reference_number' => $app->reference_number,
            'travel_type'      => $app->travel_type,
            'approver_name'    => $this->step->approver->full_name,
            'comments'         => $this->step->comments,
            'message'          => "Your application {$app->reference_number} was not concurred by {$this->step->approver->full_name}."
                . ($this->step->comments ? " Reason: {$this->step->comments}" : ''),
            'url'              => route('travel.show', $app->id),
            'icon'             => 'bi-x-circle',
            'color'            => 'danger',
        ];
    }
}
