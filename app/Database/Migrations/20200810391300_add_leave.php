<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addLeave extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'calendar_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'leave_type_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'from' => [
                'type' => 'DATE',
            ],
            'to' => [
                'type' => 'DATE',
            ],
            'working_days_used' => [
                'type' => 'INT',
                'constraint' => 2,
                'unsigned' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('calendar_id', 'calendar', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('leave_type_id', 'leave_type', 'id');
        $this->forge->createTable('leave');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropDatabase('leave');
    }
}
