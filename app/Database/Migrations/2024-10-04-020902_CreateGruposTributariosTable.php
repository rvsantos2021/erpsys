<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGruposTributariosTable extends Migration
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
            'tipo_grupo' => [
                'type'       => 'VARCHAR',
                'constraint' => '4',
                'null'       => false,
            ],
            'tipo_tributacao' => [
                'type'       => 'VARCHAR',
                'constraint' => '4',
                'null'       => false,
            ],
            'cst' => [
                'type'       => 'VARCHAR',
                'constraint' => '3',
                'null'       => true,
                'default'    => null,
            ],
            'aliquota' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,4',
                'null'       => false,
                'default'    => 0.0000,
            ],
            'reducao' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,4',
                'null'       => false,
                'default'    => 0.0000,
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

        $this->forge->createTable('grupos_tributarios');
    }

    public function down()
    {
        $this->forge->dropTable('grupos_tributarios');
    }
}
