<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addCalendarUser extends Migration
{
    /*
    * When user joins calendar this table keeps information about which user joined which calendar.
    * This table also can keeps information about in which company and in what department user works.
        But it's not implemented yet.
        It should be just a cosmetic information for supervisor.
    * If calendar or user is deleted the row connecting them should also be deleted by CASCADE.
        But deleting function is not implemented yet.
    */
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
                'null' => true,
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
