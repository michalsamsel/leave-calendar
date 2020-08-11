<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addAccountType extends Migration
{
    // This dictionary table should keep two different values of accounts users can create.
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
                'comment' => 'Name of account type.',
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
