<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCFOPsTable extends Migration
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
            'cfop' => [
                'type'       => 'VARCHAR',
                'constraint' => '4',
                'null'       => false,
            ],
            'descricao' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'complemento' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null'       => true,
                'default'    => null,
            ],
            'origem_destino' => [
                'type'       => 'CHAR',
                'constraint' => '1',
                'null'       => false,
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

        $this->forge->createTable('cfops');
    }

    public function down()
    {
        $this->forge->dropTable('cfops');
    }
}
