<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMovimentoEstoqueTable extends Migration
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
            'tipo_movimento_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'deposito_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'produto_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'produto_descricao' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'data_movimento' => [
                'type'       => 'DATETIME',
                'null'       => false,
            ],
            'descricao' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
            ],
            'movimento' => [
                'type'       => 'CHAR',
                'constraint' => '1',
                'null'       => false,
            ],
            'quantidade' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,4',
                'null'       => false,
            ],
            'valor' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,4',
                'null'       => false,
            ],
            'valor_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,4',
                'null'       => false,
            ],
            'estoque' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,4',
                'null'       => false,
            ],
            'status' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
                'default'    => false,
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

        $this->forge->createTable('estoque_movimentos');
    }

    public function down()
    {
        $this->forge->dropTable('estoque_movimentos');
    }
}
