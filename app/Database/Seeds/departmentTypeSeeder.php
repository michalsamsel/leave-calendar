<?php

namespace App\Database\Seeds;

class departmentTypeSeeder extends \CodeIgniter\Database\Seeder
{
    /*
    * This seed keeps starting values of departments in companies.
    * This list can be different and for now it isnt required to seed it into database.
    */
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

        $this->db->table('department_type')->insertBatch($departments);
    }
}
