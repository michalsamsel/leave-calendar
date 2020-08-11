<?php

namespace App\Database\Seeds;

class departmentTypeSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $departments = [
            [
                'name' => 'Zarząd',
            ],
            [
                'name' => 'Biuro obsługi klienta',
            ],
            [
                'name' => 'Programiści',
            ],
            [
                'name' => 'Graficy',
            ],
            [
                'name' => 'Testerzy',
            ],
        ];

        foreach ($departments as $department) {
            $this->db->table('department_type')->insert($department);
        }
    }
}
