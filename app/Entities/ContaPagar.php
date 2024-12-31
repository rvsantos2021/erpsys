<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class ContaPagar extends Entity
{
    protected $entity = 'Conta';

    protected $dates   = [
        'data_emissao',
        'data_vencimento',
        'data_pagamento',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts   = [
        'valor_total' => 'float',
        'valor_pago'  => 'float',
        'numero_parcela' => 'integer',
        'total_parcelas' => 'integer'
    ];

    /**
     * Método que controla os botões Excluir e Recuperar
     * @return string
     */
    public function buttonsControl()
    {
        if (APP_THEME == 'mentor') {
            $btnDelete = '<button title="Excluir ' . $this->entity . '" data-id="' . $this->id . '" class="btn btn-sm btn-icon btn-outline-danger btn-round btn-del"><i class="ti ti-trash"></i></button>';
            $btnRestore = '<button title="Restaurar ' . $this->entity . '" data-id="' . $this->id . '" class="btn btn-sm btn-icon btn-outline-success btn-round btn-undo"><i class="ti ti-back-left"></i></button>';
        } else {
            $btnDelete = '<button data-toggle="tooltip" data-original-title="Excluir ' . $this->entity . '" title="Excluir ' . $this->entity . '" data-id="' . $this->id . '" class="btn btn-xs btn-default text-danger btn-width-27 btn-del"><i class="fas fa-trash-alt"></i></button>';
            $btnRestore = '<button data-toggle="tooltip" data-original-title="Restaurar ' . $this->entity . '" title="Restaurar ' . $this->entity . '" data-id="' . $this->id . '" class="btn btn-xs btn-default text-success btn-width-27 btn-undo"><i class="fa fa-undo"></i></button>';
        }

        return ($this->deleted_at == null ? $btnDelete : $btnRestore);
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
            'PENDENTE' => 'warning',
            'PARCIAL' => 'info',
            'PAGO' => 'success',
            'CANCELADO' => 'danger'
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
}