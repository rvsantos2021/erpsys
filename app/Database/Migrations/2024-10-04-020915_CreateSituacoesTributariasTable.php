<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSituacoesTributariasTable extends Migration
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
            'descricao' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'cst' => [
                'type'       => 'VARCHAR',
                'constraint' => '3',
                'null'       => true,
                'default'    => null,
            ],
            'tabela' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => false,
            ],
            'operacao' => [
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

        $this->forge->createTable('situacoes_tributarias');
    }

    public function down()
    {
        $this->forge->dropTable('situacoes_tributarias');
    }
}
