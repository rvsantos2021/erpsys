<?php

namespace App\Models;

use CodeIgniter\Model;

class LancamentoFinanceiroModel extends Model
{
    protected $table            = 'lancamentos_financeiros';
    protected $returnType       = 'App\Entities\LancamentoFinanceiro';
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'tipo_lancamento',
        'origem_lancamento',
        'conta_origem_id',
        'conta_destino_id',
        'valor',
        'data_lancamento',
        'data_competencia',
        'descricao',
        'classificacao_conta_id',
        'fornecedor_id',
        'numero_documento',
        'status',
        'user_id',
        'active',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'tipo_lancamento' => 'required|in_list[RECEITA,DESPESA,TRANSFERENCIA]',
        'origem_lancamento' => 'required|in_list[CONTA CORRENTE,CARTAO CREDITO,CAIXA,OUTRO]',
        'valor' => 'required|numeric|greater_than[0]',
        'data_lancamento' => 'required|valid_date',
        'status' => 'in_list[PENDENTE,CONCLUIDO,CANCELADO]',
        'user_id' => 'required|integer'
    ];

    protected $validationMessages   = [
        'tipo_lancamento'          => [
            'required'  => 'Tipo de Lançamento não informado',
            'in_list' => 'Tipo de Lançamento não encontrado',
        ],
        'origem_lancamento'          => [
            'required'  => 'Origem de Lançamento não informada',
            'in_list' => 'Origem de Lançamento não encontrada',
        ],
        'data_lancamento' => [
           'required'  => 'Data de Lançamento não informada',
           'valid_date' => 'Data de Lançamento inválida',
        ],
        'status' => [
            'in_list' => 'Status não encontrado',
        ],
        'user_id' => [
            'required'  => 'Usuário não informado',
            'integer' => 'Usuário não encontrado',
        ],
    ];

    // Relationships
    // public function contaOrigem()
    // {
    //     return $this->belongsTo(ContaCorrenteModel::class, 'conta_origem_id');
    // }

    // public function contaDestino()
    // {
    //     return $this->belongsTo(ContaCorrenteModel::class, 'conta_destino_id');
    // }

    // public function classificacao()
    // {
    //     return $this->belongsTo(ClassificacaoContaModel::class, 'classificacao_conta_id');
    // }

    // public function fornecedor()
    // {
    //     return $this->belongsTo(FornecedorModel::class, 'fornecedor_id');
    // }

    // public function usuario()
    // {
    //     return $this->belongsTo(UserModel::class, 'user_id');
    // }
}