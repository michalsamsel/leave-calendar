<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addDepartment extends Migration
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
        $this->forge->createTable('department');
    }

    public function down()
    {
        $this->forge->dropDatabase('department');
    }
}
