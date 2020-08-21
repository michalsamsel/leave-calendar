<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addLeaveType extends Migration
{
    /*
    * This dictionary table keeps data about diffrent types of leaves.
    * Names of leaves are used in Leave Application Form.
    * But it's not implemented yet. For now they just use default type of leave.
    */
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'comment' => 'Name of leave type.',
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->createTable('leave_type');
    }

    public function down()
    {
        $this->forge->dropDatabase('leave_type');
    }
}
