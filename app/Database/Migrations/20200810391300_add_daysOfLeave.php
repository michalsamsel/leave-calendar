<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addDayOfLeave extends Migration
{
    /*
    * This table keeps information about how much per year users have days of leave to use in specific calendar.
    * Worker can change that value in calendar view.
    * There is no default value beacuse number of days can be diffrent for each users.
    * Id calendar or user is deleted the data connected to them should also be delete by CASCADE.
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
            'number_of_days' => [
                'type' => 'INT',
                'unsigned' => true,
                'constraint' => 2,
                'comment' => 'Number of days users can use in specific year.',
            ],
            'year' => [
                'type' => 'YEAR',
                'comment' => 'Information about year for number_of_days collumn.',
            ]
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('calendar_id', 'calendar', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('days_of_leave');

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropDatabase('days_of_leave');
    }
}
