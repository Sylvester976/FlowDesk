<?php

use Illuminate\Support\Facades\Schedule;

// ── Annual docket reset — midnight Jan 1 ─────────────────────
Schedule::command('docket:reset')
    ->yearlyOn(1, 1, '00:00')
    ->withoutOverlapping()
    ->runInBackground();

// ── Post-trip upload reminders — daily at 8am ────────────────
Schedule::command('reminders:post-trip')
    ->dailyAt('08:00')
    ->withoutOverlapping()
    ->runInBackground();

// ── Log pruning — 1st of each month at 1am ───────────────────
Schedule::command('model:prune', [
    '--model' => [
        \App\Models\ApplicationLog::class,
        \App\Models\AuthLog::class,
    ],
])->monthlyOn(1, '01:00')->withoutOverlapping()->runInBackground();

// ── User Service delta sync — every 15 minutes ───────────────
// Keeps FlowDesk in sync with any changes made in User Service
// or other connected systems
Schedule::command('users:sync --delta')
    ->everyFifteenMinutes()
    ->withoutOverlapping()
    ->runInBackground()
    ->when(fn() => config('services.user_service.url') !== '');

// ── User Service full reconciliation — nightly at 2am ────────
// Catches anything missed by delta sync — resolves conflicts
Schedule::command('users:sync --full')
    ->dailyAt('02:00')
    ->withoutOverlapping()
    ->runInBackground()
    ->when(fn() => config('services.user_service.url') !== '');
