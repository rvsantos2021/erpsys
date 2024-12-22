<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Token;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $returnType       = 'App\Entities\User';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'name',
        'password',
        'email',
        'reset_hash',
        'reset_hash_expires',
        'photo',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id'                    => 'permit_empty|is_natural_no_zero',
        'name'                  => 'required|min_length[3]|max_length[100]',
        'email'                 => 'required|valid_email|max_length[255]|is_unique[users.email,id,{id}]',
        'password'              => 'required|min_length[5]',
        'password_confirmation' => 'required_with[password]|matches[password]'
    ];

    protected $validationMessages   = [
        'name'                  => [
            'required'          => 'Informe o Nome do Usuário',
        ],
        'email'                 => [
            'required'          => 'Informe um E-mail válido',
            'is_unique'         => 'Já existe o e-mail cadastrado. Altere para continuar',
        ],
        'password' => [
            'required'          => 'A Senha é obrigatória',
            'min_length'        => 'A Senha deve conter ao menos 6 caracteres',
        ],
        'password_confirmation' => [
            'required_with'     => 'A Confirmação da Senha está diferente',
            'matches'           => 'A Senha e a Confirmação de Senha devem ser iguais',
        ],
    ];

    // Callbacks
    protected $beforeInsert   = [
        'validateActive',
        'hashPassword'
    ];

    protected $beforeUpdate   = [
        'validateActive',
        'hashPassword'
    ];

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password']))
            return $data;

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        unset($data['data']['password_confirmation']);

        return $data;
    }

    protected function validateActive(array $data)
    {
        if (!isset($data['data']['active']))
            return $data;

        $data['data']['active'] = ($data['data']['active'] == 'on' ? true : false);

        return $data;
    }

    /**
     * Método que recupera o usuário que irá fazer o login na aplicação
     * 
     * @param string $email
     * @return object|null
     */
    public function findUserByEmail(string $email)
    {
        return $this->where('email', $email)->where('deleted_at', null)->withDeleted(true)->first();
    }

    /**
     * Método que recupera o usuário que irá fazer o login na aplicação
     * 
     * @param string $email
     * @return object|null
     */
    public function findUserByToken(string $token)
    {
        $token = new Token($token);
        $token_hash = $token->getHash();

        $user = $this->where('reset_hash', $token_hash)->where('deleted_at', null)->first();

        if ($user === null) {
            return null;
        }

        if ($user->reset_hash_expires < date('Y-m-d H:i:s')) {
            return null;
        }

        return $user;
    }

    /**
     * Método que recupera as permissões do usuário logado
     * 
     * @param int $user_id
     * @return array|null
     */
    public function getLoggedUserPermissions(int $user_id)
    {
        $fields = [
            'users.id',
            'users.name AS username',
            'users_groups.group_id',
            'users_groups.user_id',
            'permissions.name AS permission',
            'users.photo',
        ];

        return $this->select($fields)
            ->asArray()
            ->join('users_groups', 'users_groups.user_id = users.id')
            ->join('permissions_groups', 'permissions_groups.group_id = users_groups.group_id')
            ->join('permissions', 'permissions.id = permissions_groups.permission_id ')
            ->where('users.id', $user_id)
            ->groupBy('permissions.name')
            ->findAll();
    }

    /**
     * Método que recupera todos os usuários da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getUsers($params_array)
    {
        $fields = [
            'users.id',
            'users.name',
            'users.email',
            'users.photo',
            'users.active',
            'users.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('users.name', $params_array['search']);
            $this->orLike('users.email', $params_array['search']);
            $this->groupEnd();
        }

        if ($params_array['order'] != '') {
            $this->orderBy($params_array['order'], $params_array['dir']);
        }

        $this->limit($params_array['rowperpage'], $params_array['start']);

        return $this->findAll();
    }

    /**
     * Método que retorna a quantidade de registros da tabela
     * 
     * @param string $search
     * @return int
     */
    public function countUsers($search)
    {
        $this->select('COUNT(users.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('users.name', $search);
            $this->orLike('users.email', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
