<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ModeloProduto extends Entity
{
    protected $entity = 'Modelo';

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
}
