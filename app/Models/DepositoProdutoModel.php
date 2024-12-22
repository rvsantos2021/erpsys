<?php

namespace App\Models;

use CodeIgniter\Model;

class DepositoProdutoModel extends Model
{
    protected $table            = 'produtos_depositos';
    protected $returnType       = 'App\Entities\DepositoProduto';
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
        'descricao' => 'required|max_length[100]|is_unique[produtos_depositos.descricao,id,{id}]',
    ];

    protected $validationMessages   = [
        'descricao'          => [
            'required'  => 'Informe o Nome do Depósito',
            'is_unique' => 'Já existe um Depósito com este Nome. Altere para continuar',
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
     * Método que recupera todos os depósitos da tabela
     * 
     * @return array|null
     */
    public function getAllDepositos()
    {
        $fields = [
            'produtos_depositos.id',
            'produtos_depositos.descricao',
            'produtos_depositos.active',
            'produtos_depositos.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy('produtos_depositos.descricao')
            ->findAll();
    }

    /**
     * Método que recupera todos os depósitos da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getDepositos($params_array)
    {
        $fields = [
            'produtos_depositos.id',
            'produtos_depositos.descricao',
            'produtos_depositos.active',
            'produtos_depositos.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('produtos_depositos.descricao', $params_array['search']);
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
    public function countDepositos($search)
    {
        $this->select('COUNT(produtos_depositos.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('produtos_depositos.descricao', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
