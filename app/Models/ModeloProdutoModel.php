<?php

namespace App\Models;

use CodeIgniter\Model;

class ModeloProdutoModel extends Model
{
    protected $table            = 'produtos_modelos';
    protected $returnType       = 'App\Entities\ModeloProduto';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'descricao',
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
        'descricao' => 'required|max_length[50]|is_unique[produtos_modelos.descricao,id,{id}]',
    ];

    protected $validationMessages   = [
        'descricao'          => [
            'required'  => 'Informe a Descrição',
            'is_unique' => 'Esta Descrição já existe. Altere para continuar',
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
     * Método que recupera todos os modelos de produtos da tabela
     * 
     * @return array|null
     */
    public function getAllModelos()
    {
        $fields = [
            'produtos_modelos.id',
            'produtos_modelos.descricao',
            'produtos_modelos.active',
            'produtos_modelos.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy('produtos_modelos.descricao')
            ->findAll();
    }

    /**
     * Método que recupera todos os modelos de produtos da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getModelos($params_array)
    {
        $fields = [
            'produtos_modelos.id',
            'produtos_modelos.descricao',
            'produtos_modelos.active',
            'produtos_modelos.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('produtos_modelos.descricao', $params_array['search']);
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
    public function countModelos($search)
    {
        $this->select('COUNT(produtos_modelos.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('produtos_modelos.descricao', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
