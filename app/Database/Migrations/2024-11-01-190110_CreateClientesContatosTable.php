<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientesContatosTable extends Migration
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
            'cliente_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'cargo_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'nome' => [
                'type'           => 'VARCHAR',
                'null'           => true,
                'constraint'     => '50',
            ],
            'telefone' => [
                'type'           => 'VARCHAR',
                'null'           => true,
                'constraint'     => '20',
            ],
            'celular' => [
                'type'           => 'VARCHAR',
                'null'           => true,
                'constraint'     => '20',
            ],
            'email' => [
                'type'           => 'VARCHAR',
                'null'           => true,
                'constraint'     => '200',
            ],
            'data_nascimento' => [
                'type'           => 'DATE',
                'null'           => true,
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

        $this->forge->createTable('clientes_contatos');
    }

    public function down()
    {
        $this->forge->dropTable('clientes_contatos');
    }
}
