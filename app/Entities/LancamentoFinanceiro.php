<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class LancamentoFinanceiro extends Entity
{
    protected $dates   = ['created_at', 'updated_at', 'deleted_at', 'data_lancamento', 'data_competencia'];
    // protected $casts   = [
    //     'valor' => 'float',
    // ];

    // protected $attributes = [
    //     'tipo_lancamento' => null,
    //     'origem_lancamento' => null,
    //     'conta_origem_id' => null,
    //     'conta_destino_id' => null,
    //     'valor' => 0.00,
    //     'data_lancamento' => null,
    //     'data_competencia' => null,
    //     'descricao' => null,
    //     'classificacao_conta_id' => null,
    //     'fornecedor_id' => null,
    //     'numero_documento' => null,
    //     'status' => 'pendente',
    //     'user_id' => null
    // ];
}