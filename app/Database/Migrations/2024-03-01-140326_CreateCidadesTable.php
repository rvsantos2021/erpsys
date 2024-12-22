<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCidadesTable extends Migration
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
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null'           => false,
            ],
            'uf' => [
                'type'           => 'VARCHAR',
                'constraint'     => '2',
                'null'           => false,
            ],
            'cod_ibge' => [
                'type'           => 'VARCHAR',
                'constraint'     => '8',
                'null'           => true,
            ],
            'id_antigo' => [
                'type'           => 'INT',
                'constraint'     => 11,
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
        $this->forge->addUniqueKey(['nome', 'uf', 'cod_ibge']);

        $this->forge->createTable('cidades');
    }

    public function down()
    {
        $this->forge->dropTable('cidades');
    }
}
