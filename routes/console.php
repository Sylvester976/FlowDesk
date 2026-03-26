<?php

use Illuminate\Support\Facades\Schedule;

// ── Annual docket reset — runs at midnight on Jan 1 ──────────
Schedule::command('docket:reset')
    ->yearlyOn(1, 1, '00:00')
    ->withoutOverlapping()
    ->runInBackground()
    ->onSuccess(function () {
        \Illuminate\Support\Facades\Log::info('Annual docket reset completed successfully.');
    });

// ── Log pruning — runs on the 1st of each month at 1am ───────
// ApplicationLog: keeps 2 years
// AuthLog: keeps 1 year
Schedule::command('model:prune', [
    '--model' => [
        \App\Models\ApplicationLog::class,
        \App\Models\AuthLog::class,
    ],
])
    ->monthlyOn(1, '01:00')
    ->withoutOverlapping()
    ->runInBackground()
    ->onSuccess(function () {
        \Illuminate\Support\Facades\Log::info('Log pruning completed successfully.');
    });
