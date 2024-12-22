<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProdutosImagensTable extends Migration
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
            'produto_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'descricao' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
                'null'           => true,
            ],
            'destaque' => [
                'type'           => 'BOOLEAN',
                'null'           => false,
                'default'        => false,
            ],
            'photo' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => true,
                'default'        => null,
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

        $this->forge->createTable('produtos_imagens');
    }

    public function down()
    {
        $this->forge->dropTable('produtos_imagens');
    }
}
