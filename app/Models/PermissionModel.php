<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table            = 'permissions';
    protected $returnType       = 'App\Entities\Permission';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'name',
        'description',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id'   => 'permit_empty|is_natural_no_zero',
        'name' => 'required|max_length[100]|is_unique[permissions.name,id,{id}]',
    ];

    protected $validationMessages   = [
        'name'          => [
            'required'  => 'Informe o Nome da Permissão',
            'is_unique' => 'Já existe uma Permissão com este Nome. Altere para continuar',
        ],
    ];

    // Callbacks
    protected $beforeInsert   = [
        'validateActive',
    ];

    protected $beforeUpdate   = [
        'validateActive',
    ];

    protected function validateActive(array $data)
    {
        if (!isset($data['data']['active']))
            return $data;

        $data['data']['active'] = ($data['data']['active'] == 'on' ? true : false);

        return $data;
    }

    /**
     * Método que recupera todos as permissões da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getPermissions($params_array)
    {
        $fields = [
            'permissions.id',
            'permissions.name',
            'permissions.description',
            'permissions.active',
            'permissions.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('permissions.name', $params_array['search']);
            $this->orLike('permissions.description', $params_array['search']);
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
    public function countPermissions($search)
    {
        $this->select('COUNT(permissions.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('permissions.name', $search);
            $this->orLike('permissions.description', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
