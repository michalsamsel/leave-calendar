<?php

namespace App\Database\Seeds;

class accountTypeSeeder extends \CodeIgniter\Database\Seeder
{
    /*
    * This seed need to be put in database for correct working of application!!!
    * It has default account type: supervisor and worker.
    */
    public function run()
    {
        $accounts = [
            [
                'name' => 'Właściciel firmy',
            ],
            [
                'name' => 'Pracownik',
            ],
        ];

        $this->db->table('account_type')->insertBatch($accounts);
    }
}
