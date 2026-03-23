<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $roleId = DB::table('roles')->where('name', 'superadmin')->value('id');

        DB::table('users')->updateOrInsert(
            ['email' => 'admin@flowdesk.go.ke'],
            [
                'first_name'          => 'System',
                'last_name'           => 'Administrator',
                'email'               => 'admin@flowdesk.go.ke',
                'phone'               => null,
                'password'            => Hash::make('Admin@1234'),
                'role_id'             => $roleId,
                'department_id'       => null,
                'supervisor_id'       => null,
                'pf_number'           => 'SA-0001',
                'id_number'           => null,
                'passport_number'     => null,
                'max_days_per_year'   => 365,
                'days_used_this_year' => 0,
                'docket_year'         => now()->year,
                'status'              => 'active',
                'email_verified_at'   => now(),
                'created_at'          => now(),
                'updated_at'          => now(),
            ]
        );

        $this->command->info('Superadmin created: admin@flowdesk.go.ke / Admin@1234');
        $this->command->warn('Change the password immediately after first login.');
    }
}
