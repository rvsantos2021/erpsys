<?php

namespace App\Models;

use CodeIgniter\Model;

class CidadeModel extends Model
{
    protected $table            = 'cidades';
    protected $returnType       = 'App\Entities\Cidade';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'nome',
        'uf',
        'cod_ibge',
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
        //'nome' => 'required|max_length[100]|is_unique[cidades.nome,cidades.uf,id,{id}]',
    ];

    protected $validationMessages   = [
        'name'          => [
            'required'  => 'Informe o Nome da Cidade',
            //'is_unique' => 'Já existe uma Cidade com este Nome. Altere para continuar',
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
     * Método que recupera todos as cidades da tabela
     * 
     * @return array|null
     */
    public function getAllCidades()
    {
        $fields = [
            'cidades.id',
            'cidades.nome',
            'cidades.uf',
            'cidades.cod_ibge',
            'cidades.active',
            'cidades.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy('cidades.nome')
            ->findAll();
    }

    /**
     * Método que recupera todos as cidades da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getCidades($params_array)
    {
        $fields = [
            'cidades.id',
            'cidades.nome',
            'cidades.uf',
            'cidades.cod_ibge',
            'cidades.active',
            'cidades.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(false);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('cidades.nome', $params_array['search']);
            $this->orLike('cidades.uf', $params_array['search']);
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
    public function countCidades($search)
    {
        $this->select('COUNT(cidades.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('cidades.nome', $search);
            $this->orLike('cidades.uf', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }

    /**
     * Método que retorna o ID da cidade por IBGE
     * 
     * @param string $cod_ibge
     * @return int
     */
    public function getCidadeId($cod_ibge)
    {
        return $this->select('cidades.id')
            ->where('cidades.cod_ibge', $cod_ibge)
            ->withDeleted(false)
            ->find();
    }
}
