<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmpresasTable extends Migration
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
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => false,
            ],
            'nome_fantasia' => [
                'type'           => 'VARCHAR',
                'null'           => true,
                'constraint'     => '50',
            ],
            'cnpj' => [
                'type'           => 'VARCHAR',
                'constraint'     => '18',
            ],
            'inscricao_estadual' => [
                'type'           => 'VARCHAR',
                'null'           => true,
                'constraint'     => '20',
            ],
            'inscricao_municipal' => [
                'type'           => 'VARCHAR',
                'null'           => true,
                'constraint'     => '20',
            ],
            'cnae' => [
                'type'           => 'VARCHAR',
                'null'           => true,
                'constraint'     => '20',
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
            'contato' => [
                'type'           => 'VARCHAR',
                'null'           => true,
                'constraint'     => '50',
            ],
            'site' => [
                'type'           => 'VARCHAR',
                'null'           => true,
                'constraint'     => '200',
            ],
            'email' => [
                'type'           => 'VARCHAR',
                'null'           => true,
                'constraint'     => '200',
            ],
            'photo' => [
                'type'           => 'VARCHAR',
                'null'           => true,
                'constraint'     => '255',
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
        $this->forge->addUniqueKey(['razao_social']);

        $this->forge->createTable('empresas');
    }

    public function down()
    {
        $this->forge->dropTable('empresas');
    }
}
