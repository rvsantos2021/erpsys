<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionGroupModel extends Model
{
    protected $table            = 'permissions_groups';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'group_id',
        'permission_id'
    ];

    /**
     * Método que recupera as permissões de acesso do grupo
     * 
     * @param integer $group_id
     * @param integer $page_qty
     * @return array\null
     */
    public function recoverGroupPermissions(int $group_id, int $page_qty)
    {
        $fields = [
            'permissions_groups.id',
            'groups.id AS group_id',
            'permissions.id AS permission_id',
            'permissions.name',
            'permissions.description',
        ];

        return $this->select($fields)
            ->join('groups', 'groups.id = permissions_groups.group_id')
            ->join('permissions', 'permissions.id = permissions_groups.permission_id')
            ->where('permissions_groups.group_id', $group_id)
            ->groupBy('permissions.name, permissions.description',)
            ->paginate($page_qty);
    }

    public function findGroupPermissions(int $group_id)
    {
        $fields = [
            'permissions.id',
            'permissions.name',
            'permissions.description',
        ];

        return $this->select($fields)
            ->join('groups', 'groups.id = permissions_groups.group_id')
            ->join('permissions', 'permissions.id = permissions_groups.permission_id')
            ->where('permissions_groups.group_id', $group_id)
            ->groupBy('permissions.name, permissions.description')
            ->findAll();
    }
}
