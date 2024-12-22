<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCondicoesPagamentoTable extends Migration
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
            'nome' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'entrada' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
            ],
            'perc_entrada' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
                'default'    => 0.00,
            ],
            'qtd_parcelas' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
            ],
            'dias_parcela1' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
            ],
            'dias_parcelas' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
            ],
            'tabela_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 1,
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
        $this->forge->addUniqueKey('nome');

        $this->forge->createTable('condicoes_pagamento');
    }

    public function down()
    {
        $this->forge->dropTable('condicoes_pagamento');
    }
}
