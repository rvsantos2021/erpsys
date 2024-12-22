<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoProdutoModel extends Model
{
    protected $table            = 'produtos_tipos';
    protected $returnType       = 'App\Entities\TipoProduto';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'descricao',
        'produto',
        'servico',
        'materia_prima',
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
        'descricao' => 'required|max_length[50]|is_unique[produtos_tipos.descricao,id,{id}]',
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
     * Método que recupera todos os tipos de produtos da tabela
     * 
     * @return array|null
     */
    public function getAllTipoProdutos()
    {
        $fields = [
            'produtos_tipos.id',
            'produtos_tipos.descricao',
            'produtos_tipos.produto',
            'produtos_tipos.servico',
            'produtos_tipos.materia_prima',
            'produtos_tipos.active',
            'produtos_tipos.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy('produtos_tipos.descricao')
            ->findAll();
    }

    /**
     * Método que recupera todos os tipos de produtos da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getTipoProdutos($params_array)
    {
        $fields = [
            'produtos_tipos.id',
            'produtos_tipos.descricao',
            'produtos_tipos.produto',
            'produtos_tipos.servico',
            'produtos_tipos.materia_prima',
            'produtos_tipos.active',
            'produtos_tipos.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('produtos_tipos.descricao', $params_array['search']);
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
    public function countTipoProdutos($search)
    {
        $this->select('COUNT(produtos_tipos.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('produtos_tipos.descricao', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
