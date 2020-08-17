<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addCalendar extends Migration
{
    // This table saves information about existing calendars.
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
            'company_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'Name of calendar which displays in list for users.',
            ],
            'invite_code' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'comment' => 'Thanks to this code users can join to specific calendar.',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('owner_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('company_id', 'company', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('calendar');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropDatabase('calendar');
    }
}
