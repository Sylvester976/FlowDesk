<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name'            => 'superadmin',
                'label'           => 'Super Administrator',
                'hierarchy_level' => 0,
                'can_supervise'   => true,
                'is_ps'           => false,
                'is_system'       => true,
            ],
            [
                'name'            => 'ps',
                'label'           => 'Principal Secretary',
                'hierarchy_level' => 1,
                'can_supervise'   => true,
                'is_ps'           => true,
                'is_system'       => true,
            ],
            [
                'name'            => 'hr',
                'label'           => 'Human Resource Officer',
                'hierarchy_level' => 2,
                'can_supervise'   => false,
                'is_ps'           => false,
                'is_system'       => false,
            ],
            [
                'name'            => 'secretary',
                'label'           => 'Secretary',
                'hierarchy_level' => 2,
                'can_supervise'   => true,
                'is_ps'           => false,
                'is_system'       => false,
            ],
            [
                'name'            => 'director',
                'label'           => 'Director',
                'hierarchy_level' => 3,
                'can_supervise'   => true,
                'is_ps'           => false,
                'is_system'       => false,
            ],
            [
                'name'            => 'senior_officer',
                'label'           => 'Senior Officer',
                'hierarchy_level' => 4,
                'can_supervise'   => true,
                'is_ps'           => false,
                'is_system'       => false,
            ],
            [
                'name'            => 'officer',
                'label'           => 'Officer',
                'hierarchy_level' => 5,
                'can_supervise'   => false,
                'is_ps'           => false,
                'is_system'       => false,
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                array_merge($role, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
