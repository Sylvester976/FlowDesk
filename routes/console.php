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

// ── Post-trip upload reminders — runs daily at 8am ───────────
Schedule::command('reminders:post-trip')
    ->dailyAt('08:00')
    ->withoutOverlapping()
    ->runInBackground();
