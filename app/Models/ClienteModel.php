<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\Cliente';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'tipo',
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'inscricao_estadual',
        'telefone',
        'celular',
        'email',
        'data_nascimento',
        'obs',
        'id_antigo',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id'           => 'permit_empty|is_natural_no_zero',
        'razao_social' => 'required|max_length[100]|is_unique[clientes.razao_social,id,{id}]',
    ];

    protected $validationMessages   = [
        'razao_social' => [
            'required'  => 'O campo Razão Social é obrigatório.',
            'is_unique' => 'A Razão Social informada já está cadastrada. Informe outra para continuar.',
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
     * Método que recupera todos os clientes da tabela
     * 
     * @return array|null
     */
    public function getAllClientes()
    {
        $fields = [
            'clientes.id',
            'clientes.tipo',
            'clientes.razao_social',
            'clientes.nome_fantasia',
            'clientes.cnpj',
            'clientes.inscricao_estadual',
            'clientes.telefone',
            'clientes.celular',
            'clientes.email',
            'clientes.data_nascimento',
            'clientes.obs',
            'clientes.active',
            'clientes.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy('clientes.razao_social')
            ->findAll();
    }

    /**
     * Método que recupera todos os clientes da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getClientes($params_array)
    {
        $fields = [
            'clientes.id',
            'clientes.tipo',
            'clientes.razao_social',
            'clientes.nome_fantasia',
            'clientes.cnpj',
            'clientes.inscricao_estadual',
            'clientes.telefone',
            'clientes.celular',
            'clientes.email',
            'clientes.data_nascimento',
            'clientes.obs',
            'clientes.active',
            'clientes.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('clientes.razao_social', $params_array['search']);
            $this->orLike('clientes.nome_fantasia', $params_array['search']);
            $this->orLike('clientes.cnpj', $params_array['search']);
            $this->orLike('clientes.email', $params_array['search']);
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
    public function countClientes($search)
    {
        $this->select('COUNT(clientes.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('clientes.razao_social', $search);
            $this->orLike('clientes.nome_fantasia', $search);
            $this->orLike('clientes.cnpj', $search);
            $this->orLike('clientes.email', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}