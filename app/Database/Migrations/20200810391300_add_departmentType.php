<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addDepartmentType extends Migration
{
    /*
    * This dictionary table keeps information about diffrent departments in companies.
    * If working user is connected with calendar he should be able to  choose in which department he works.
    * If there's no department in which user works. He should be able to add it on it's own.
    * Usage of this table is not implemented yet.
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
