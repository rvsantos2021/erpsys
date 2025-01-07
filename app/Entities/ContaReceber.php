<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ContaReceber extends Entity
{
    protected $datamap = [
        'cliente_nome'             => 'cliente.nome',
        'classificacao_conta_nome' => 'classificacaoConta.nome',
        'forma_pagamento_nome'     => 'formaPagamento.nome',
        'conta_corrente_nome'      => 'contaCorrente.nome'
    ];

    protected $dates   = [
        'data_emissao',
        'data_vencimento',
        'data_pagamento',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'id'                     => 'integer',
        'cliente_id'             => 'integer',
        'conta_pai_id'           => 'integer',
        'classificacao_conta_id' => 'integer',
        'forma_pagamento_id'     => 'integer',
        'conta_corrente_id'      => 'integer',
        'valor_total'            => 'float',
        'valor_previsto'         => 'float',
        'valor_desconto'         => 'float',
        'valor_acrescimo'        => 'float',
        'valor_pago'             => 'float',
        'numero_parcela'         => 'integer',
        'total_parcelas'         => 'integer',
        'previsao'               => 'boolean',
        'active'                 => 'boolean',
    ];
    
    // Relacionamentos
    public function getCliente()
    {
        return $this->cliente;
    }

    public function getClassificacaoConta()
    {
        return $this->classificacaoConta;
    }

    public function getFormaPagamento()
    {
        return $this->formaPagamento;
    }

    public function getContaCorrente()
    {
        return $this->contaCorrente;
    }
}
