<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContasReceberTable extends Migration
{
    public function up()
    {
        // Criação da tabela contas_pagar
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'cliente_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false,
            ],
            'conta_pai_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'numero_documento' => [
                'type'           => 'VARCHAR',
                'constraint'     => 50,
                'null'           => true,
            ],
            'descricao' => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'valor_total' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,2',
                'null'           => false,
                'default'        => 0,
            ],
            'valor_previsto' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,2',
                'null'           => true,
                'default'        => 0,
            ],
            'valor_desconto' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,2',
                'default'        => 0,
            ],
            'valor_acrescimo' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,2',
                'default'        => 0,
            ],
            'valor_pago' => [
                'type'           => 'DECIMAL',
                'constraint'     => '10,2',
                'default'        => 0,
            ],
            'data_emissao' => [
                'type'           => 'DATE',
                'null'           => false,
            ],
            'data_vencimento' => [
                'type'           => 'DATE',
                'null'           => false,
            ],
            'data_pagamento' => [
                'type'           => 'DATE',
                'null'           => true,
            ],
            'status' => [
                'type'           => 'ENUM',
                'constraint'     => ['PENDENTE', 'PARCIAL', 'PAGO', 'CANCELADO', 'ATRASADO'],
                'default'        => 'PENDENTE',
            ],
            'tipo_conta' => [
                'type'           => 'ENUM',
                'constraint'     => ['AVULSA', 'PARCELADA'],
                'default'        => 'AVULSA',
            ],
            'numero_parcela' => [
                'type'           => 'INT',
                'constraint'     => 3,
                'default'        => 1,
            ],
            'total_parcelas' => [
                'type'           => 'INT',
                'constraint'     => 3,
                'default'        => 1,
            ],
            'classificacao_conta_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'forma_pagamento_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'conta_corrente_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'           => true,
            ],
            'previsao' => [
                'type'    => 'BOOLEAN',
                'default' => false,
            ],
            'active' => [
                'type'    => 'BOOLEAN',
                'default' => true,
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'deleted_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
        ]);

        // Definir chave primária
        $this->forge->addKey('id', true);

        // Adicionar chaves estrangeiras
        $this->forge->addForeignKey('cliente_id', 'clientes', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('conta_pai_id', 'contas_pagar', 'id', 'SET NULL', 'RESTRICT');
        $this->forge->addForeignKey('classificacao_conta_id', 'classificacoes_contas', 'id', 'SET NULL', 'RESTRICT');
        $this->forge->addForeignKey('forma_pagamento_id', 'formas_pagamento', 'id', 'SET NULL', 'RESTRICT');
        $this->forge->addForeignKey('conta_corrente_id', 'contas_corrente', 'id', 'CASCADE', 'SET NULL');

        // Criar tabela
        $this->forge->createTable('contas_receber');
    }

    public function down()
    {
        // Remover tabela caso precise reverter a migração
        $this->forge->dropTable('contas_receber');
    }
}
