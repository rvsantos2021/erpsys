<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Libraries\Token;

class User extends Entity
{
    protected $entity = 'Usuário';

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
     * Método que faz a validação da senha do usuário
     */
    public function verifyPassword(string $password)
    {
        return password_verify($password, $this->password);
    }

    /**
     * Método que valida se o usuário logado tem permissão para acessar a rota
     * 
     * @param $permission
     * @return boolean
     */
    public function validatePermissionLoggedUser(string $permission): bool
    {
        if ($this->is_admin == true) {
            return true;
        }

        if (empty($this->permissions)) {
            return false;
        }

        if (in_array($permission, $this->permissions) == false) {
            return false;
        }

        return true;
    }

    /**
     * Método que inicia o reset da senha
     * 
     * return void
     */
    public function startPasswordReset(): void
    {
        $token = new Token();

        $this->reset_token = $token->getValue();
        $this->reset_hash = $token->getHash();
        $this->reset_hash_expires = date('Y-m-d H:i:s', time() + 7200);
    }
}
