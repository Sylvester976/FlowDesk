<?php

namespace App\Notifications;

use App\Models\TravelApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TravelApplicationSubmitted extends Notification
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
        $applicant = $this->application->user;
        $isConcurrer = $notifiable->id === $applicant->getConcurrer()?->id;

        return [
            'application_id'   => $this->application->id,
            'reference_number' => $this->application->reference_number,
            'travel_type'      => $this->application->travel_type,
            'type_label'       => $this->application->getTravelTypeLabel(),
            'applicant_name'   => $applicant->full_name,
            'applicant_id'     => $applicant->id,
            'destination'      => $this->application->country?->name
                ?? ($this->application->county?->name . ' County')
                ?? 'Unknown',
            'departure_date'   => $this->application->departure_date->format('d M Y'),
            'action_required'  => $isConcurrer && $this->application->isForeignOfficial(),
            'message'          => $isConcurrer
                ? "{$applicant->full_name} has submitted a foreign official travel application requiring your concurrence."
                : "{$applicant->full_name} has submitted a {$this->application->getTravelTypeLabel()} travel application.",
            'url'              => route('travel.show', $this->application->id),
            'icon'             => 'bi-airplane',
            'color'            => $isConcurrer ? 'warning' : 'info',
        ];
    }
}
