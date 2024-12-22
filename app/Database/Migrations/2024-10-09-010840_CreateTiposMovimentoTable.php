<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTiposMovimentoTable extends Migration
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
            'estoque' => [
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

        $this->forge->createTable('tipos_movimentos');
    }

    public function down()
    {
        $this->forge->dropTable('tipos_movimentos');
    }
}
