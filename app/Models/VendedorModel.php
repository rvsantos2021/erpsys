<?php

namespace App\Models;

use CodeIgniter\Model;

class VendedorModel extends Model
{
    protected $table            = 'vendedores';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\Vendedor';
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
        'perc_comissao',
        'obs',
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
        'razao_social' => 'required|max_length[100]|is_unique[vendedores.razao_social,id,{id}]',
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
     * Método que recupera todos os vendedores da tabela
     * 
     * @return array|null
     */
    public function getAllVendedores()
    {
        $fields = [
            'vendedores.id',
            'vendedores.tipo',
            'vendedores.razao_social',
            'vendedores.nome_fantasia',
            'vendedores.cnpj',
            'vendedores.inscricao_estadual',
            'vendedores.telefone',
            'vendedores.celular',
            'vendedores.email',
            'vendedores.data_nascimento',
            'vendedores.perc_comissao',
            'vendedores.obs',
            'vendedores.active',
            'vendedores.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy('vendedores.razao_social')
            ->findAll();
    }

    /**
     * Método que recupera todos os vendedores da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getVendedores($params_array)
    {
        $fields = [
            'vendedores.id',
            'vendedores.tipo',
            'vendedores.razao_social',
            'vendedores.nome_fantasia',
            'vendedores.cnpj',
            'vendedores.inscricao_estadual',
            'vendedores.telefone',
            'vendedores.celular',
            'vendedores.email',
            'vendedores.data_nascimento',
            'vendedores.perc_comissao',
            'vendedores.obs',
            'vendedores.active',
            'vendedores.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('vendedores.razao_social', $params_array['search']);
            $this->orLike('vendedores.nome_fantasia', $params_array['search']);
            $this->orLike('vendedores.cnpj', $params_array['search']);
            $this->orLike('vendedores.email', $params_array['search']);
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
    public function countVendedores($search)
    {
        $this->select('COUNT(vendedores.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('vendedores.razao_social', $search);
            $this->orLike('vendedores.nome_fantasia', $search);
            $this->orLike('vendedores.cnpj', $search);
            $this->orLike('vendedores.email', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
