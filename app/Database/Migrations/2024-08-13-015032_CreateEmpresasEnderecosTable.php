<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmpresasEnderecosTable extends Migration
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
            'empresa_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'tipo' => [
                'type'           => 'CHAR',
                'constraint'     => '1',
                'null'           => false,
            ],
            'cep' => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
                'null'           => false,
            ],
            'logradouro' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => false,
            ],
            'numero' => [
                'type'           => 'VARCHAR',
                'constraint'     => '25',
                'null'           => true,
            ],
            'complemento' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null'           => true,
            ],
            'bairro' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null'           => false,
            ],
            'cidade_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
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

        $this->forge->createTable('empresas_enderecos');
    }

    public function down()
    {
        $this->forge->dropTable('empresas_enderecos');
    }
}
