<?php

namespace App\Console\Commands;

use App\Models\TravelApplication;
use App\Notifications\PostTripUploadDue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendPostTripReminders extends Command
{
    protected $signature   = 'reminders:post-trip';
    protected $description = 'Notify staff whose return date has passed but post-trip docs not uploaded';

    public function handle(): int
    {
        // Trips that returned yesterday or earlier, still concurred, no upload
        $apps = TravelApplication::where('status', 'concurred')
            ->whereDate('return_date', '<', now())
            ->whereDoesntHave('postTripUpload')
            ->with('user')
            ->get();

        $count = 0;
        foreach ($apps as $app) {
            try {
                // Only notify once per day — check if already notified today
                $alreadyNotified = $app->user->notifications()
                    ->where('type', PostTripUploadDue::class)
                    ->whereDate('created_at', today())
                    ->whereJsonContains('data->application_id', $app->id)
                    ->exists();

                if (! $alreadyNotified) {
                    $app->user->notify(new PostTripUploadDue($app));
                    $count++;
                }
            } catch (\Exception $e) {
                Log::error("Post-trip reminder failed for app {$app->id}: " . $e->getMessage());
            }
        }

        $this->info("Post-trip reminders sent: {$count}");
        return self::SUCCESS;
    }
}
