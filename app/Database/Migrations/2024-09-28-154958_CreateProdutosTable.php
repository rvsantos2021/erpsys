<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProdutosTable extends Migration
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
            'tipo_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'codigo_barras' => [
                'type'           => 'VARCHAR',
                'constraint'     => '20',
                'null'           => true,
                'default'        => null,
            ],
            'descricao' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => false,
            ],
            'codigo_ncm' => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
                'null'           => true,
                'default'        => null,
            ],
            'cest' => [
                'type'           => 'VARCHAR',
                'constraint'     => '10',
                'null'           => true,
                'default'        => null,
            ],
            'referencia' => [
                'type'           => 'VARCHAR',
                'constraint'     => '30',
                'null'           => true,
                'default'        => null,
            ],
            'localizacao' => [
                'type'           => 'VARCHAR',
                'constraint'     => '30',
                'null'           => true,
                'default'        => null,
            ],
            'marca_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'modelo_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'grupo_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'unidade_entrada_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'unidade_saida_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'secao_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'estoque' => [
                'type'           => 'BOOLEAN',
                'null'           => false,
                'default'        => true,
            ],
            'peso_bruto' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'peso_liquido' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'estoque_inicial' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'estoque_minimo' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'estoque_maximo' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'estoque_atual' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'estoque_reservado' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'estoque_real' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'custo_bruto' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'custo_perc_desconto' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'custo_valor_desconto' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'custo_perc_ipi' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'custo_valor_ipi' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'custo_perc_st' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'custo_valor_st' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'custo_perc_frete' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'custo_valor_frete' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'custo_real' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,4',
                'null'           => true,
                'default'        => null,
            ],
            'photo' => [
                'type'           => 'VARCHAR',
                'null'           => true,
                'constraint'     => '255',
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

        $this->forge->createTable('produtos');
    }

    public function down()
    {
        $this->forge->dropTable('produtos');
    }
}
