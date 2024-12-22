<?php

namespace App\Models;

use CodeIgniter\Model;

class UnidadeProdutoModel extends Model
{
    protected $table            = 'produtos_unidades';
    protected $returnType       = 'App\Entities\UnidadeProduto';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'descricao',
        'abreviatura',
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
        'descricao' => 'required|max_length[100]|is_unique[produtos_unidades.descricao,id,{id}]',
        'abreviatura' => 'required|max_length[5]|is_unique[produtos_unidades.abreviatura,id,{id}]',
    ];

    protected $validationMessages   = [
        'descricao'          => [
            'required'  => 'Informe a Descrição da Unidade',
            'is_unique' => 'Já existe uma Unidade com esta Descrição. Altere para continuar',
        ],
        'abreviatura'          => [
            'required'  => 'Informe a Abreviatura da Unidade',
            'is_unique' => 'Já existe uma Unidade com esta Abreviatura. Altere para continuar',
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
     * Método que recupera todas as unidades da tabela
     * 
     * @return array|null
     */
    public function getAllUnidades()
    {
        $fields = [
            'produtos_unidades.id',
            'produtos_unidades.descricao',
            'produtos_unidades.abreviatura',
            'produtos_unidades.quantidade',
            'produtos_unidades.active',
            'produtos_unidades.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy('produtos_unidades.descricao')
            ->findAll();
    }

    /**
     * Método que recupera todas as unidades da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getUnidades($params_array)
    {
        $fields = [
            'produtos_unidades.id',
            'produtos_unidades.descricao',
            'produtos_unidades.abreviatura',
            'produtos_unidades.quantidade',
            'produtos_unidades.active',
            'produtos_unidades.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('produtos_unidades.descricao', $params_array['search']);
            $this->orLike('produtos_unidades.abreviatura', $params_array['search']);
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
    public function countUnidades($search)
    {
        $this->select('COUNT(produtos_unidades.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('produtos_unidades.descricao', $search);
            $this->orLike('produtos_unidades.abreviatura', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
