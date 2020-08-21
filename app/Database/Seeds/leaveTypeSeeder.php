<?php

namespace App\Database\Seeds;

class leaveTypeSeeder extends \CodeIgniter\Database\Seeder
{
    /*
    * This seed need to be put in database for correct working of application!!!
    * For now application only needs at least one record in database for correct working!!!
    * It has default types of leaves.
    */
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

        $this->db->table('leave_type')->insertBatch($leaves);
    }
}
