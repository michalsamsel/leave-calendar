<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addCalendar extends Migration
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
            'company_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'invite_code' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('company_id', 'company', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('calendar');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropDatabase('calendar');
    }
}
