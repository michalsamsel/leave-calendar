<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addCalendar extends Migration
{
    /*
    * This table keeps information about existing calendars.
    * Each calendar is connected with supervisor account and single company.
        This connection is made for easier generating Leave Application Form PDF.
    * Invite code lets join worker users to calendars.
    * If company or creator of calendar delete his account the calendar should also be deleted by CASCADE.
        But deleting function is not implemented yet.
    */
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
