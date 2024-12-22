<?php

namespace App\Models;

use CodeIgniter\Model;

class FunilVendaModel extends Model
{
    protected $table            = 'funil_vendas';
    protected $returnType       = 'App\Entities\FunilVenda';
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
        'id'        => 'permit_empty|is_natural_no_zero',
        'descricao' => 'required|max_length[50]|is_unique[funil_vendas.descricao,id,{id}]',
    ];

    protected $validationMessages   = [
        'descricao' => [
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
     * Método que recupera todos os registros da tabela
     * 
     * @return array|null
     */
    public function getAllFunisVendas()
    {
        $fields = [
            'funil_vendas.id',
            'funil_vendas.descricao',
            'funil_vendas.active',
            'funil_vendas.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy('funil_vendas.descricao')
            ->findAll();
    }

    /**
     * Método que recupera todos os registros da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getFunisVendas($params_array)
    {
        $fields = [
            'funil_vendas.id',
            'funil_vendas.descricao',
            'funil_vendas.active',
            'funil_vendas.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('funil_vendas.descricao', $params_array['search']);
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
    public function countFunisVendas($search)
    {
        $this->select('COUNT(funil_vendas.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('funil_vendas.descricao', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
