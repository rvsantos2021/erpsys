<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => false,
            ],
            'password' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
            'email' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
            'reset_hash' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => true,
                'default'        => null,
            ],
            'reset_hash_expires' => [
                'type'           => 'DATETIME',
                'null'           => true,
                'default'        => null,
            ],
            'photo' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => true,
                'default'        => null,
            ],
            'employee_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => true,
                'default'        => null,
            ],
            'active' => [
                'type'           => 'BOOLEAN',
                'null'           => false,
                'default'        => true,
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
                'default'        => null,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
                'default'        => null,
            ],
            'deleted_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
                'default'        => null,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');

        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
