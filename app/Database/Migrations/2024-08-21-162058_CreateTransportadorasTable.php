<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransportadorasTable extends Migration
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
            'tipo' => [
                'type'           => 'CHAR',
                'constraint'     => '1',
                'null'           => false,
            ],
            'razao_social' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'nome_fantasia' => [
                'type'       => 'VARCHAR',
                'null'       => true,
                'constraint' => '50',
            ],
            'cnpj' => [
                'type'       => 'VARCHAR',
                'constraint' => '18',
            ],
            'inscricao_estadual' => [
                'type'       => 'VARCHAR',
                'null'       => true,
                'constraint' => '20',
            ],
            'telefone' => [
                'type'       => 'VARCHAR',
                'null'       => true,
                'constraint' => '20',
            ],
            'celular' => [
                'type'       => 'VARCHAR',
                'null'       => true,
                'constraint' => '20',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'null'       => true,
                'constraint' => '200',
            ],
            'obs' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
            ],
            'id_antigo' => [
                'type'           => 'INT',
                'constraint'     => 11,
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
        $this->forge->addUniqueKey(['cnpj']);

        $this->forge->createTable('transportadoras');
    }

    public function down()
    {
        $this->forge->dropTable('transportadoras');
    }
}
