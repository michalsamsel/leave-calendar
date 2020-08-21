<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addAccountType extends Migration
{
    /*
    * This dictionary table keeps information about diffrent types of accounts in database.
    * Basic version of calendar keeps only worker and supervisor account type.
    */
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
