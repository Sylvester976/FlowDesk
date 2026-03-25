<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ResetDaysDocket extends Command
{
    protected $signature   = 'docket:reset';
    protected $description = 'Reset annual foreign travel days docket for all staff (runs Jan 1)';

    public function handle(): int
    {
        $year  = now()->year;
        $count = User::where('status', 'active')
            ->where(fn($q) => $q->whereNull('docket_year')->orWhere('docket_year', '<', $year))
            ->count();

        if ($count === 0) {
            $this->info("Docket already reset for {$year}. Nothing to do.");
            return self::SUCCESS;
        }

        User::where('status', 'active')
            ->where(fn($q) => $q->whereNull('docket_year')->orWhere('docket_year', '<', $year))
            ->update([
                'days_used_this_year' => 0,
                'docket_year'         => $year,
            ]);

        $this->info("Docket reset for {$count} staff member(s) — year {$year}.");
        Log::info("Annual docket reset: {$count} staff updated for year {$year}.");

        return self::SUCCESS;
    }
}
