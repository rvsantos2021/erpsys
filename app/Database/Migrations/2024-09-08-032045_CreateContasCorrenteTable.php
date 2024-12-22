<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContasCorrenteTable extends Migration
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
            'banco_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => null,
            ],
            'agencia' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
                'default'    => null,
            ],
            'numero' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
                'default'    => null,
            ],
            'descricao' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
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

        $this->forge->createTable('contas_corrente');
    }

    public function down()
    {
        $this->forge->dropTable('contas_corrente');
    }
}
