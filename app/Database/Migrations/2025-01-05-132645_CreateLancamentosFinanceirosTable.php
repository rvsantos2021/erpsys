<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLancamentosFinanceirosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'tipo_lancamento' => [
                'type' => 'ENUM',
                'constraint' => ['RECEITA', 'DESPESA', 'TRANSFERENCIA'],
                'null' => false
            ],
            'origem_lancamento' => [
                'type' => 'ENUM',
                'constraint' => ['CONTA CORRENTE', 'CARTAO CREDITO', 'CAIXA', 'OUTRO'],
                'null' => false
            ],
            'conta_origem_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'conta_destino_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'valor' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false
            ],
            'data_lancamento' => [
                'type' => 'DATE',
                'null' => false
            ],
            'data_competencia' => [
                'type' => 'DATE',
                'null' => true
            ],
            'descricao' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'classificacao_conta_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'numero_documento' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['PENDENTE', 'CONCLUIDO', 'CANCELADO'],
                'default' => 'PENDENTE'
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false
            ],
            'active' => [
                'type'    => 'BOOLEAN',
                'default' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);

        if ($this->db->tableExists('classificacoes_contas')) {
            $this->forge->addForeignKey('classificacao_conta_id', 'classificacoes_contas', 'id', 'SET NULL', 'CASCADE');
        }

        if ($this->db->tableExists('contas_correntes')) {
            $this->forge->addForeignKey('conta_origem_id', 'contas_correntes', 'id', 'SET NULL', 'CASCADE');
            $this->forge->addForeignKey('conta_destino_id', 'contas_correntes', 'id', 'SET NULL', 'CASCADE');
        }

        if ($this->db->tableExists('users')) {
            $this->forge->addForeignKey('user_id', 'users', 'id', 'RESTRICT', 'CASCADE');
        }

        $this->forge->createTable('lancamentos_financeiros');
    }

    public function down()
    {
        $this->forge->dropTable('lancamentos_financeiros');
    }
}