<?php

namespace App\Database\Seeds;

class departmentSeeder extends \CodeIgniter\Database\Seeder
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
            $this->db->table('department')->insert($department);
        }
    }
}
