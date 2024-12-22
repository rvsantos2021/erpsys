<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDepositoEstoqueTable extends Migration
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
            'deposito_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'produto_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'estoque' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => false,
                'default'        => 0,
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

        $this->forge->createTable('estoque_depositos');
    }

    public function down()
    {
        $this->forge->dropTable('estoque_depositos');
    }
}
