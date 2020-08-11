<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addDepartmentType extends Migration
{
    // This dictionary table should keep different values of departments in companies.
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
                'comment' => 'Name of departments in companies',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('department_type');
    }

    public function down()
    {
        $this->forge->dropDatabase('department_type');
    }
}
