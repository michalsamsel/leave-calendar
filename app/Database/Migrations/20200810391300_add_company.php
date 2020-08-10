<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addComapny extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'owner_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
            ],
            'city' => [
                'name' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('owner_id','user','id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('company');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropDatabase('company');
    }
}
