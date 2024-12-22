<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransportadorasVeiculosTable extends Migration
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
            'transportadora_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'placa' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => false,
            ],
            'uf' => [
                'type'       => 'VARCHAR',
                'constraint' => '2',
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

        $this->forge->createTable('transportadora_veiculos');
    }

    public function down()
    {
        $this->forge->dropTable('transportadora_veiculos');
    }
}
