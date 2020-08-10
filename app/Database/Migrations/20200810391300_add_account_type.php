<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addAccountType extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('account_type');
    }

    public function down()
    {
        $this->forge->dropDatabase('account_type');
    }
}
