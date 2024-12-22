<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFunilVendasEtapasTable extends Migration
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
            'funil_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'ordem' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'descricao' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
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
        $this->forge->addForeignKey('funil_id', 'funil_vendas', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('funil_vendas_etapas');
    }

    public function down()
    {
        $this->forge->dropTable('funil_vendas_etapas');
    }
}
