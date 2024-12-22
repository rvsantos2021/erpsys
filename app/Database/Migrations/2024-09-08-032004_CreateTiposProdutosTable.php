<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTiposProdutosTable extends Migration
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
            'produto' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
            ],
            'servico' => [
                'type'       => 'BOOLEAN',
                'null'       => false,
            ],
            'materia_prima' => [
                'type'       => 'BOOLEAN',
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

        $this->forge->createTable('produtos_tipos');
    }

    public function down()
    {
        $this->forge->dropTable('produtos_tipos');
    }
}
