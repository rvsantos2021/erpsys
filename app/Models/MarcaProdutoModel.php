<?php

namespace App\Models;

use CodeIgniter\Model;

class MarcaProdutoModel extends Model
{
    protected $table            = 'produtos_marcas';
    protected $returnType       = 'App\Entities\MarcaProduto';
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
        'descricao' => 'required|max_length[50]|is_unique[produtos_marcas.descricao,id,{id}]',
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
     * Método que recupera todas as marcas de produtos da tabela
     * 
     * @return array|null
     */
    public function getAllMarcas()
    {
        $fields = [
            'produtos_marcas.id',
            'produtos_marcas.descricao',
            'produtos_marcas.active',
            'produtos_marcas.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy('produtos_marcas.descricao')
            ->findAll();
    }

    /**
     * Método que recupera todas as marcas de produtos da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getMarcas($params_array)
    {
        $fields = [
            'produtos_marcas.id',
            'produtos_marcas.descricao',
            'produtos_marcas.active',
            'produtos_marcas.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('produtos_marcas.descricao', $params_array['search']);
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
    public function countMarcas($search)
    {
        $this->select('COUNT(produtos_marcas.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('produtos_marcas.descricao', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
