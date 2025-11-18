<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCountries extends Command
{
    protected $signature = 'countries:install';
    protected $description = 'Create the countries table and seed all countries';

    public function handle()
    {
        $this->info("Migrating countries table...");
        \Artisan::call('migrate', ['--force' => true]);

        $this->info("Seeding countries...");
        \Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\CountrySeeder', '--force' => true]);

        $this->info("Countries installed successfully.");
        return 0;
    }
}
