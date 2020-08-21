<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addComapny extends Migration
{    
    /*
    * This table keeps information about company.
    * Company needs to be created before calendar, beacuse they will be connected.
        It's for Leave Application Form and if supervisor doesn't input calendar name,
        the default value for 'name field' will be company name.
    * If user deleted his account the all connected companies to him should also be deleted by CASCADE.
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
                'comment' => 'This saves information which user is owner of company.',
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'Name of company',
            ],
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'comment' => 'Tax identification number.',
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'Information for generting pdf, where company is registered.',
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('owner_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('company');

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropDatabase('company');
    }
}
