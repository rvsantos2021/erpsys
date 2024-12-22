<?php

namespace App\Models;

use CodeIgniter\Model;

class TabelaPrecoModel extends Model
{
    protected $table            = 'tabelas_precos';
    protected $returnType       = 'App\Entities\TabelaPreco';
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
        'descricao' => 'required|max_length[50]|is_unique[tabelas_precos.descricao,id,{id}]',
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
     * Método que recupera todos as tabelas de preços
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getAllTabelas()
    {
        $fields = [
            'tabelas_precos.id',
            'tabelas_precos.descricao',
            'tabelas_precos.active',
            'tabelas_precos.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(false)
            ->orderBy('tabelas_precos.descricao');

        return $this->findAll();
    }

    /**
     * Método que recupera todos as tabelas de preços
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getTabelas($params_array)
    {
        $fields = [
            'tabelas_precos.id',
            'tabelas_precos.descricao',
            'tabelas_precos.active',
            'tabelas_precos.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('tabelas_precos.descricao', $params_array['search']);
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
    public function countTabelas($search)
    {
        $this->select('COUNT(tabelas_precos.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('tabelas_precos.descricao', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }

    /**
     * Método que retorna a descrição da tabela de preço
     * 
     * @param int $id
     * @return string
     */
    public function getTabelaById($id)
    {
        return $this->select('tabelas_precos.descricao')
            ->where('tabelas_precos.id', $id)
            ->withDeleted(true)
            ->find();
    }
}
