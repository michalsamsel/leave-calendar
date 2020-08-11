<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addDayOfLeave extends Migration
{
    // This table saves information how mouch in specific year users have days of leave to use.
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
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
        $this->forge->createTable('day_of_leave');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropDatabase('day_of_leave');
    }
}
