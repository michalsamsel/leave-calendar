<?php

namespace App\Database\Seeds;

class leaveTypeSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $leaves = [
            [
                'name' => 'Wypoczynkowy',
            ],
            [
                'name' => 'Okazjonalny',
            ],
            [
                'name' => 'Macierzyński',
            ],
        ];

        foreach ($leaves as $leave) {
            $this->db->table('leave_type')->insert($leave);
        }
    }
}
