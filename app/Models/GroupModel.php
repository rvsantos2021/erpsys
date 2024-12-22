<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $table            = 'groups';
    protected $returnType       = 'App\Entities\Group';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'name',
        'description',
        'display',
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
        'name' => 'required|max_length[100]|is_unique[groups.name,id,{id}]',
    ];

    protected $validationMessages   = [
        'name'          => [
            'required'  => 'Informe o Nome do Grupo de Acesso',
            'is_unique' => 'Já existe um Grupo com este Nome. Altere para continuar',
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
     * Método que recupera todos os grupos da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getGroups($params_array)
    {
        $fields = [
            'groups.id',
            'groups.name',
            'groups.description',
            'groups.display',
            'groups.active',
            'groups.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('groups.name', $params_array['search']);
            $this->orLike('groups.description', $params_array['search']);
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
    public function countGroups($search)
    {
        $this->select('COUNT(groups.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('groups.name', $search);
            $this->orLike('groups.description', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
