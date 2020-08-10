<?php

namespace App\Database\Seeds;

class accountTypeSeeder extends \CodeIgniter\Database\Seeder
{
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

        foreach ($accounts as $account) {
            $this->db->table('account_type')->insert($account);
        }
    }
}
