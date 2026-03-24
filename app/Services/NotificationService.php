<?php

namespace App\Services;

use App\Models\ConcurrenceStep;
use App\Models\TravelApplication;
use App\Notifications\ApplicationConcurred;
use App\Notifications\ApplicationNotConcurred;
use App\Notifications\ApplicationReturned;
use App\Notifications\PostTripUploadDue;
use App\Notifications\TravelApplicationSubmitted;

class NotificationService
{
    /**
     * Fire when a travel application is submitted.
     * Notifies the supervisor (action required) and all others in the chain (info).
     */
    public static function applicationSubmitted(TravelApplication $app): void
    {
        $applicant  = $app->user;
        $notifyList = $applicant->getNotifyList();

        foreach ($notifyList as $recipient) {
            try {
                $recipient->notify(new TravelApplicationSubmitted($app));
            } catch (\Exception $e) {
                \Log::error("In-app notification failed for {$recipient->email}: " . $e->getMessage());
            }
        }
    }

    /**
     * Fire when supervisor concurs.
     */
    public static function applicationConcurred(ConcurrenceStep $step): void
    {
        try {
            $step->application->user->notify(new ApplicationConcurred($step));
        } catch (\Exception $e) {
            \Log::error("Concurred notification failed: " . $e->getMessage());
        }
    }

    /**
     * Fire when supervisor does not concur.
     */
    public static function applicationNotConcurred(ConcurrenceStep $step): void
    {
        try {
            $step->application->user->notify(new ApplicationNotConcurred($step));
        } catch (\Exception $e) {
            \Log::error("Not-concurred notification failed: " . $e->getMessage());
        }
    }

    /**
     * Fire when supervisor returns application.
     */
    public static function applicationReturned(ConcurrenceStep $step): void
    {
        try {
            $step->application->user->notify(new ApplicationReturned($step));
        } catch (\Exception $e) {
            \Log::error("Returned notification failed: " . $e->getMessage());
        }
    }

    /**
     * Fire when post-trip upload is due (called by scheduler after return date).
     */
    public static function postTripDue(TravelApplication $app): void
    {
        try {
            $app->user->notify(new PostTripUploadDue($app));
        } catch (\Exception $e) {
            \Log::error("Post-trip notification failed: " . $e->getMessage());
        }
    }
}
