<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class addUser extends Migration
{
    // This table keeps information about users and their data required to log in.
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
