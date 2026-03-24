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
                'name'            => 'ps',
                'label'           => 'Principal Secretary',
                'hierarchy_level' => 1,
                'can_supervise'   => true,
                'is_ps'           => true,
                'is_system'       => true,
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
                'name'            => 'assistant_secretary',
                'label'           => 'Assistant Secretary',
                'hierarchy_level' => 3,
                'can_supervise'   => true,
                'is_ps'           => false,
                'is_system'       => false,
            ],
            [
                'name'            => 'director',
                'label'           => 'Director',
                'hierarchy_level' => 4,
                'can_supervise'   => true,
                'is_ps'           => false,
                'is_system'       => false,
            ],
            [
                'name'            => 'deputy_director',
                'label'           => 'Deputy Director',
                'hierarchy_level' => 5,
                'can_supervise'   => true,
                'is_ps'           => false,
                'is_system'       => false,
            ],
            [
                'name'            => 'assistant_director',
                'label'           => 'Assistant Director',
                'hierarchy_level' => 6,
                'can_supervise'   => true,
                'is_ps'           => false,
                'is_system'       => false,
            ],
            [
                'name'            => 'principal_officer',
                'label'           => 'Principal Officer',
                'hierarchy_level' => 7,
                'can_supervise'   => true,
                'is_ps'           => false,
                'is_system'       => false,
            ],
            [
                'name'            => 'senior_officer',
                'label'           => 'Senior Officer',
                'hierarchy_level' => 8,
                'can_supervise'   => true,
                'is_ps'           => false,
                'is_system'       => false,
            ],
            [
                'name'            => 'officer',
                'label'           => 'Officer',
                'hierarchy_level' => 9,
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

        // Reassign any users on old system roles to PS before deleting
        $psId = DB::table('roles')->where('name', 'ps')->value('id');
        DB::table('users')->whereIn('role_id',
            DB::table('roles')->whereIn('name', ['superadmin', 'hr'])->pluck('id')
        )->update(['role_id' => $psId]);

        // Now safe to delete
        DB::table('roles')->whereIn('name', ['superadmin', 'hr'])->delete();

        $this->command->info('Roles seeded: ' . count($roles));
    }
}
