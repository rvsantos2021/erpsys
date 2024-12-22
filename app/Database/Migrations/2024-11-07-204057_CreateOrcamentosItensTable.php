<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrcamentosItensTable extends Migration
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
            'orcamento_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'produto_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'obs' => [
                'type'           => 'VARCHAR',
                'constraint'     => '500',
            ],
            'quantidade' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => false,
                'default'        => 0,
            ],
            'valor_unitario' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'perc_acrescimo' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'valor_acrescimo' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'perc_desconto' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'valor_desconto' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'valor_despesas' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'valor_frete' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'valor_total' => [
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

        $this->forge->createTable('orcamentos_itens');
    }

    public function down()
    {
        $this->forge->dropTable('orcamentos_itens');
    }
}
