<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrcamentosTable extends Migration
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
            'data_hora' => [
                'type'           => 'DATETIME',
                'null'           => true,
                'default'        => null,
            ],
            'status' => [
                'type'           => 'CHAR',
                'constraint'     => '1',
                'null'           => false,
            ],
            'cliente_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'vendedor_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'condicao_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'forma_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'negociacao_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => true,
            ],
            'obs' => [
                'type'           => 'VARCHAR',
                'constraint'     => '500',
            ],
            'valor_bruto' => [
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
            'valor_frete' => [
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

        $this->forge->createTable('orcamentos');
    }

    public function down()
    {
        $this->forge->dropTable('orcamentos');
    }
}
