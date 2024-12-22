<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table            = 'empresas';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\Empresa';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'tipo',
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'inscricao_estadual',
        'inscricao_municipal',
        'cnae',
        'telefone',
        'celular',
        'contato',
        'site',
        'email',
        'photo',
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
        'razao_social' => 'required|max_length[100]|is_unique[empresas.razao_social,id,{id}]',
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
     * Método que recupera todas as empresas da tabela
     * 
     * @return array|null
     */
    public function getAllEmpresas()
    {
        $fields = [
            'empresas.id',
            'empresas.tipo',
            'empresas.razao_social',
            'empresas.nome_fantasia',
            'empresas.cnpj',
            'empresas.inscricao_estadual',
            'empresas.inscricao_municipal',
            'empresas.cnae',
            'empresas.telefone',
            'empresas.celular',
            'empresas.contato',
            'empresas.site',
            'empresas.email',
            'empresas.photo',
            'empresas.active',
            'empresas.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy('empresas.razao_social')
            ->findAll();
    }

    /**
     * Método que recupera todas as empresas da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getEmpresas($params_array)
    {
        $fields = [
            'empresas.id',
            'empresas.tipo',
            'empresas.razao_social',
            'empresas.nome_fantasia',
            'empresas.cnpj',
            'empresas.inscricao_estadual',
            'empresas.inscricao_municipal',
            'empresas.cnae',
            'empresas.telefone',
            'empresas.celular',
            'empresas.contato',
            'empresas.site',
            'empresas.email',
            'empresas.photo',
            'empresas.active',
            'empresas.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('empresas.razao_social', $params_array['search']);
            $this->orLike('empresas.nome_fantasia', $params_array['search']);
            $this->orLike('empresas.cnpj', $params_array['search']);
            $this->orLike('empresas.email', $params_array['search']);
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
    public function countEmpresas($search)
    {
        $this->select('COUNT(empresas.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('empresas.razao_social', $search);
            $this->orLike('empresas.nome_fantasia', $search);
            $this->orLike('empresas.cnpj', $search);
            $this->orLike('empresas.email', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
