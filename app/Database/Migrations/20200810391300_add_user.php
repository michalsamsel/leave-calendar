<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addUser extends Migration
{
    /*
    * This table keeps information about all users.
    * Users can create account with one out of two diffrent previlages. Account types are: worker and supervisor.
    * If user wants to use account with diffrent previlages he needs to create a new account.
    * Users log in using email and password.
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
            'account_type_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'comment' => 'Used to log in to website.',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'Used to log in to website. Keep it encryptioned.',
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('account_type_id', 'account_type', 'id');

        $this->forge->createTable('user');

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropDatabase('user');
    }
}
