<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Use PS role for the system admin
        $roleId = DB::table('roles')->where('name', 'ps')->value('id');

        DB::table('users')->updateOrInsert(
            ['email' => 'admin@flowdesk.go.ke'],
            [
                'first_name'            => 'System',
                'last_name'             => 'Administrator',
                'email'                 => 'admin@flowdesk.go.ke',
                'password'              => Hash::make('Admin@1234'),
                'role_id'               => $roleId,
                'job_title_id'          => null,
                'department_id'         => null,
                'supervisor_id'         => null,
                'attached_to_id'        => null,
                'is_superadmin'         => true,
                'is_hr_admin'           => true,
                'pf_number'             => 'SYS-0001',
                'max_days_per_year'     => 365,
                'days_used_this_year'   => 0,
                'docket_year'           => now()->year,
                'status'                => 'active',
                'force_password_change' => false,
                'email_verified_at'     => now(),
                'created_at'            => now(),
                'updated_at'            => now(),
            ]
        );

        $this->command->info('Superadmin seeded: admin@flowdesk.go.ke / Admin@1234');
    }
}
