<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class SituacaoTributaria extends Entity
{
    protected $entity = 'CST / CSOSN';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
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

    /**
     * Método que controla o label da tabela
     * @return string
     */
    public function tabelaControl()
    {
        $tabICMS   = '<span class="label label-success">ICMS</span>';
        $tabIPI    = '<span class="label label-default">IPI</span>';
        $tabPISCOF = '<span class="label label-warning">PIS/COFINS</span>';
        $tabCSOSN  = '<span class="label label-primary">CSOSN</span>';

        if ($this->tabela == 'ICMS') {
            return $tabICMS;
        } else if ($this->tabela == 'IPI') {
            return $tabIPI;
        } else if ($this->tabela == 'PIS/COFINS') {
            return $tabPISCOF;
        } else if ($this->tabela == 'CSOSN') {
            return $tabCSOSN;
        } else {
            return '';
        }
    }

    /**
     * Método que controla o label da operação
     * @return string
     */
    public function operacaoControl()
    {
        $opeAmbas   = '<span class="text-default text-semibold">AMBAS</span>';
        $opeSaida   = '<span class="text-success text-semibold">SAÍDA</span>';
        $opeEntrada = '<span class="text-warning text-semibold">ENTRADA</span>';

        if ($this->operacao == 'A') {
            return $opeAmbas;
        } else if ($this->operacao == 'S') {
            return $opeSaida;
        } else if ($this->operacao == 'E') {
            return $opeEntrada;
        } else {
            return '';
        }
    }
}
