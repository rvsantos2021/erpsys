<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBancosTable extends Migration
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
            'codigo' => [
                'type'       => 'VARCHAR',
                'constraint' => '5',
                'null'       => true,
                'default'    => null,
            ],
            'descricao' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
            ],
            'photo' => [
                'type'       => 'VARCHAR',
                'null'       => true,
                'constraint' => '255',
            ],
            'active' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
                'default'    => true,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'default'    => null,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'default'    => null,
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'default'    => null,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable('bancos');
    }

    public function down()
    {
        $this->forge->dropTable('bancos');
    }
}
