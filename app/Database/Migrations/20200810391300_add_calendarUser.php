<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addCalendarUser extends Migration
{
    // This table saves information about users who joined calendars and users role in company.
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'calendar_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'user_department_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('calendar_id', 'calendar', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_department_id', 'department_type', 'id');
        $this->forge->createTable('calendar_user');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropDatabase('calendar_user');
    }
}
