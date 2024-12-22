<?php

namespace App\Models;

use CodeIgniter\Model;

class UserGroupModel extends Model
{
    protected $table            = 'users_groups';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'group_id',
        'user_id'
    ];

    /**
     * Método que recupera os grupos de acesso do usuário
     * 
     * @param integer $user_id
     * @param integer $page_qty
     * @return array | null
     */
    public function recoverGroupsUser(int $user_id, int $page_qty)
    {
        $fields = [
            'users_groups.id',
            'groups.id AS group_id',
            'groups.name',
            'groups.description',
        ];

        return $this->select($fields)
            ->join('groups', 'groups.id = users_groups.group_id')
            ->join('users', 'users.id = users_groups.user_id')
            ->where('users_groups.user_id', $user_id)
            ->groupBy('groups.name')
            ->paginate($page_qty);
    }

    public function findGroupsUser(int $user_id)
    {
        $fields = [
            'groups.id',
            'groups.name',
        ];

        return $this->select($fields)
            ->join('groups', 'groups.id = users_groups.group_id')
            ->join('users', 'users.id = users_groups.user_id')
            ->where('users_groups.user_id', $user_id)
            ->groupBy('groups.name')
            ->findAll();
    }

    /**
     * Método que verifica se o usuário logado faz parte do grupo
     * Importante: utilizado apenas para verificar se é um cliente ou admin
     * 
     * @param int $group_id
     * @param int $user_id
     * @return object | null
     */
    public function userIsInGroup(int $group_id, int $user_id)
    {
        return $this->where('group_id', $group_id)
            ->where('user_id', $user_id)
            ->first();
    }
}
