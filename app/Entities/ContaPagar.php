<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class ContaPagar extends Entity
{
    protected $datamap = [
        'fornecedor_nome'          => 'fornecedor.nome',
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
        'fornecedor_id'          => 'integer',
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
    public function getFornecedor()
    {
        return $this->fornecedor;
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

    // Métodos personalizados para manipulação de dados

    /**
     * Verifica se a conta está vencida
     * @return bool
     */
    public function estaVencida()
    {
        return $this->data_vencimento < Time::now() && $this->status !== 'PAGO';
    }

    /**
     * Calcula o saldo restante da conta
     * @return float
     */
    public function getSaldoRestante()
    {
        return $this->valor_total - $this->valor_pago;
    }

    /**
     * Verifica se o pagamento é parcial
     * @return bool
     */
    public function isPagamentoParcial()
    {
        return $this->valor_pago > 0 && $this->valor_pago < $this->valor_total;
    }

    /**
     * Formata o valor total para exibição
     * @return string
     */
    public function getValorTotalFormatado()
    {
        return 'R$ ' . number_format($this->valor_total, 2, ',', '.');
    }

    /**
     * Formata o valor pago para exibição
     * @return string
     */
    public function getValorPagoFormatado()
    {
        return 'R$ ' . number_format($this->valor_pago, 2, ',', '.');
    }

    /**
     * Retorna o status com formatação de cor
     * @return string
     */
    public function getStatusFormatado()
    {
        $cores = [
            'PENDENTE' => 'warning text-white',
            'PARCIAL' => 'info text-white',
            'PAGO' => 'success text-white',
            'CANCELADO' => 'default',
            'ATRASADO' => 'danger text-white',
        ];

        return sprintf(
            '<span class="badge bg-%s">%s</span>', 
            $cores[$this->status] ?? 'secondary', 
            $this->status
        );
    }

    /**
     * Verifica se a conta pode ser editada
     * @return bool
     */
    public function podeSerEditada()
    {
        return in_array($this->status, ['PENDENTE', 'PARCIAL']);
    }

    /**
     * Gera descrição completa da parcela
     * @return string
     */
    public function getDescricaoParcela()
    {
        if ($this->tipo_conta === 'PARCELADA') {
            return sprintf(
                'Parcela %d de %d', 
                $this->numero_parcela, 
                $this->total_parcelas
            );
        }

        return 'Conta Avulsa';
    }

    public function getDataVencimento()
    {
        // Obter valor diretamente sem processamento
        $value = $this->attributes['data_vencimento'] ?? null;
    
        // Se nulo, retornar data atual
        if ($value === null) {
            return date('Y-m-d');
        }
    
        // Se for objeto Time, converter para string
        if ($value instanceof Time) {
            return $value->toDateString();
        }
    
        // Se for string
        if (is_string($value)) {
            // Remover espaços e qualquer parte de tempo
            $value = trim(explode(' ', $value)[0]);
    
            // Formatos de data para tentar
            $formatos = [
                'Y-m-d',       // Formato padrão do banco
                'd/m/Y',       // Formato brasileiro
                'm/d/Y',       // Formato americano
                'Y-m-d H:i:s'  // Timestamp com hora
            ];
    
            foreach ($formatos as $formato) {
                $data = \DateTime::createFromFormat($formato, $value);
                if ($data) {
                    return $data->format('Y-m-d');
                }
            }
    
            // Último recurso: parse flexível
            try {
                $data = new \DateTime($value);
                return $data->format('Y-m-d');
            } catch (\Exception $e) {
                // Log de erro
                log_message('error', 'Erro na conversão de data: ' . $e->getMessage());
                return date('Y-m-d');
            }
        }
    
        // Fallback para qualquer outro tipo
        return date('Y-m-d');
    }
    
    public function setDataVencimento($value)
    {
        // Se nulo, usar data atual
        if ($value === null) {
            $this->attributes['data_vencimento'] = date('Y-m-d');
            return $this;
        }
    
        // Se for objeto Time, converter para string
        if ($value instanceof Time) {
            $this->attributes['data_vencimento'] = $value->toDateString();
            return $this;
        }
    
        // Se for string
        if (is_string($value)) {
            // Remover espaços e qualquer parte de tempo
            $value = trim(explode(' ', $value)[0]);
    
            // Formatos de data para tentar
            $formatos = [
                'Y-m-d',       // Formato padrão do banco
                'd/m/Y',       // Formato brasileiro
                'm/d/Y',       // Formato americano
                'Y-m-d H:i:s'  // Timestamp com hora
            ];
    
            foreach ($formatos as $formato) {
                $data = \DateTime::createFromFormat($formato, $value);
                if ($data) {
                    $this->attributes['data_vencimento'] = $data->format('Y-m-d');
                    return $this;
                }
            }
    
            // Último recurso: parse flexível
            try {
                $data = new \DateTime($value);
                $this->attributes['data_vencimento'] = $data->format('Y-m-d');
                return $this;
            } catch (\Exception $e) {
                // Log de erro
                log_message('error', 'Erro na conversão de data: ' . $e->getMessage());
                $this->attributes['data_vencimento'] = date('Y-m-d');
                return $this;
            }
        }
    
        // Fallback para qualquer outro tipo
        $this->attributes['data_vencimento'] = date('Y-m-d');

        return $this;
    }
}