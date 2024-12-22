<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFormasPagamentoTable extends Migration
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
            'contas_receber' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
            ],
            'contas_pagar' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
            ],
            'desconto' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
            ],
            'financeiro' => [
                'type'       => 'BOOLEAN',
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
        $this->forge->addUniqueKey('nome');

        $this->forge->createTable('formas_pagamento');
    }

    public function down()
    {
        $this->forge->dropTable('formas_pagamento');
    }
}
