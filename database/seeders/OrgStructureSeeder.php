<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrgStructureSeeder extends Seeder
{
    public function run(): void
    {
        // ── Directorates ─────────────────────────────────────────
        $directorates = [
            ['name' => 'Digital Infrastructure',                    'code' => 'DI'],
            ['name' => 'Digital Government and Data Governance',     'code' => 'DGDG'],
            ['name' => 'Digital Economy and Emerging Technologies',  'code' => 'DEET'],
            ['name' => 'ICT Security',                              'code' => 'ICTS'],
            ['name' => 'Administration',                            'code' => 'ADMIN'],
        ];

        foreach ($directorates as $dir) {
            DB::table('directorates')->updateOrInsert(
                ['code' => $dir['code']],
                array_merge($dir, [
                    'is_active'  => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        $this->command->info('Directorates seeded: ' . count($directorates));

        // ── Divisions (departments) ───────────────────────────────
        $divisionsByDir = [
            'DI' => [
                ['name' => 'ICT Connectivity',              'code' => 'DI-CON'],
                ['name' => 'Data Centre and Cloud Services','code' => 'DI-DCC'],
                ['name' => 'ICT Field Services',            'code' => 'DI-FS'],
            ],
            'DGDG' => [
                ['name' => 'Digital Government Services',   'code' => 'DGDG-DGS'],
                ['name' => 'Data Governance',               'code' => 'DGDG-DG'],
            ],
            'DEET' => [
                ['name' => 'Partnership, Research and Emerging Technologies', 'code' => 'DEET-PRET'],
                ['name' => 'Digital Products and Services', 'code' => 'DEET-DPS'],
                ['name' => 'Digital Inclusion and Skilling','code' => 'DEET-DIS'],
            ],
            'ICTS' => [
                ['name' => 'Cyber Security',                'code' => 'ICTS-CS'],
            ],
            'ADMIN' => [
                ['name' => 'Administration',                'code' => 'ADMIN-ADM'],
                ['name' => 'Human Resource Management and Development', 'code' => 'ADMIN-HRM'],
                ['name' => 'Finance',                       'code' => 'ADMIN-FIN'],
                ['name' => 'Accounts',                      'code' => 'ADMIN-ACC'],
                ['name' => 'Central Planning and Project Monitoring',   'code' => 'ADMIN-CPM'],
                ['name' => 'Supply Chain Management',       'code' => 'ADMIN-SCM'],
                ['name' => 'ICT Division',                  'code' => 'ADMIN-ICT'],
                ['name' => 'Legal Services',                'code' => 'ADMIN-LS'],
                ['name' => 'Public Communications',         'code' => 'ADMIN-PC'],
                ['name' => 'Internal Audit',                'code' => 'ADMIN-IA'],
            ],
        ];

        $total = 0;
        foreach ($divisionsByDir as $dirCode => $divisions) {
            $dirId = DB::table('directorates')->where('code', $dirCode)->value('id');
            if (! $dirId) continue;

            foreach ($divisions as $div) {
                DB::table('departments')->updateOrInsert(
                    ['code' => $div['code']],
                    array_merge($div, [
                        'directorate_id' => $dirId,
                        'is_active'      => true,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ])
                );
                $total++;
            }
        }

        $this->command->info("Divisions seeded: {$total}");

        // ── Job titles per role ───────────────────────────────────
        $roleJobTitles = [
            'ps' => [
                ['name' => 'Principal Secretary', 'is_default' => true],
            ],
            'secretary' => [
                ['name' => 'Secretary',           'is_default' => true],
                ['name' => 'Secretary ICT',       'is_default' => false],
            ],
            'assistant_secretary' => [
                ['name' => 'Assistant Secretary', 'is_default' => true],
            ],
            'director' => [
                ['name' => 'Director',                          'is_default' => true],
                ['name' => 'Director, ICT Infrastructure',      'is_default' => false],
                ['name' => 'Director, Digital Government',      'is_default' => false],
                ['name' => 'Director, Digital Economy',         'is_default' => false],
                ['name' => 'Director, ICT Security',            'is_default' => false],
                ['name' => 'Director, Human Resource',          'is_default' => false],
                ['name' => 'Director, Finance',                 'is_default' => false],
                ['name' => 'Director, Central Planning',        'is_default' => false],
                ['name' => 'Director, Supply Chain',            'is_default' => false],
                ['name' => 'Director, Legal Services',          'is_default' => false],
            ],
            'deputy_director' => [
                ['name' => 'Deputy Director',                   'is_default' => true],
                ['name' => 'Deputy Director, ICT',              'is_default' => false],
                ['name' => 'Deputy Director, Human Resource',   'is_default' => false],
                ['name' => 'Deputy Director, Supply Chain',     'is_default' => false],
                ['name' => 'Deputy Director, Finance',          'is_default' => false],
            ],
            'assistant_director' => [
                ['name' => 'Assistant Director',                'is_default' => true],
                ['name' => 'Assistant Director, ICT',           'is_default' => false],
                ['name' => 'Assistant Director, HRM',           'is_default' => false],
                ['name' => 'Assistant Director, Supply Chain',  'is_default' => false],
                ['name' => 'Assistant Director, Office Admin',  'is_default' => false],
            ],
            'principal_officer' => [
                ['name' => 'Principal ICT Officer',             'is_default' => true],
                ['name' => 'Principal HRM Officer',             'is_default' => false],
                ['name' => 'Principal Finance Officer',         'is_default' => false],
                ['name' => 'Principal Supply Chain Officer',    'is_default' => false],
                ['name' => 'Principal Economist',               'is_default' => false],
                ['name' => 'Principal Legal Officer',           'is_default' => false],
                ['name' => 'Principal Communications Officer',  'is_default' => false],
                ['name' => 'Principal Accountant',              'is_default' => false],
            ],
            'senior_officer' => [
                ['name' => 'Senior ICT Officer',                'is_default' => true],
                ['name' => 'Senior HRM Officer',                'is_default' => false],
                ['name' => 'Senior Finance Officer',            'is_default' => false],
                ['name' => 'Senior Supply Chain Officer',       'is_default' => false],
                ['name' => 'Senior Economist',                  'is_default' => false],
                ['name' => 'Senior Accountant',                 'is_default' => false],
                ['name' => 'Senior Principal Finance Officer',  'is_default' => false],
            ],
            'officer' => [
                ['name' => 'ICT Officer I',                     'is_default' => true],
                ['name' => 'ICT Officer II',                    'is_default' => false],
                ['name' => 'Assistant ICT Officer',             'is_default' => false],
                ['name' => 'HRM Officer',                       'is_default' => false],
                ['name' => 'HRM Officer II',                    'is_default' => false],
                ['name' => 'Finance Officer',                   'is_default' => false],
                ['name' => 'Accounts Officer',                  'is_default' => false],
                ['name' => 'Supply Chain Officer',              'is_default' => false],
                ['name' => 'Economist',                         'is_default' => false],
                ['name' => 'Legal Officer',                     'is_default' => false],
                ['name' => 'Communications Officer',            'is_default' => false],
                ['name' => 'Planning Officer',                  'is_default' => false],
                ['name' => 'Personal Assistant',                'is_default' => false],
                ['name' => 'Management Officer',                'is_default' => false],
            ],
        ];

        $titleCount = 0;
        foreach ($roleJobTitles as $roleName => $titles) {
            $roleId = DB::table('roles')->where('name', $roleName)->value('id');
            if (! $roleId) continue;

            foreach ($titles as $title) {
                DB::table('job_titles')->updateOrInsert(
                    ['role_id' => $roleId, 'name' => $title['name']],
                    array_merge($title, [
                        'role_id'    => $roleId,
                        'is_active'  => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ])
                );
                $titleCount++;
            }
        }

        $this->command->info("Job titles seeded: {$titleCount}");
    }
}
