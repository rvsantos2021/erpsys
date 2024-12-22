<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProdutosPrecosTable extends Migration
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
            'produto_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'tabela_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'preco_custo' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'perc_lucro' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'preco_venda' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
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

        $this->forge->createTable('produtos_precos');
    }

    public function down()
    {
        $this->forge->dropTable('produtos_precos');
    }
}
