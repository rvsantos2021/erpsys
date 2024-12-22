<?php

namespace App\Models;

use CodeIgniter\Model;

class TransportadoraModel extends Model
{
    protected $table            = 'transportadoras';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\Transportadora';
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
        //'razao_social' => 'required|max_length[100]|is_unique[transportadora.razao_social,id,{id}]',
    ];

    protected $validationMessages   = [
        // 'razao_social' => [
        //     'required'  => 'O campo Razão Social é obrigatório.',
        //     'is_unique' => 'A Razão Social informada já está cadastrada. Informe outra para continuar.',
        // ],
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
     * Método que recupera todas as transportadoras da tabela
     * 
     * @return array|null
     */
    public function getAllTransportadoras()
    {
        $fields = [
            'transportadoras.id',
            'transportadoras.tipo',
            'transportadoras.razao_social',
            'transportadoras.nome_fantasia',
            'transportadoras.cnpj',
            'transportadoras.inscricao_estadual',
            'transportadoras.telefone',
            'transportadoras.celular',
            'transportadoras.email',
            'transportadoras.obs',
            'transportadoras.active',
            'transportadoras.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy('transportadoras.razao_social')
            ->findAll();
    }

    /**
     * Método que recupera todas as transportadoras da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getTransportadoras($params_array)
    {
        $fields = [
            'transportadoras.id',
            'transportadoras.tipo',
            'transportadoras.razao_social',
            'transportadoras.nome_fantasia',
            'transportadoras.cnpj',
            'transportadoras.inscricao_estadual',
            'transportadoras.telefone',
            'transportadoras.celular',
            'transportadoras.email',
            'transportadoras.obs',
            'transportadoras.active',
            'transportadoras.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('transportadoras.razao_social', $params_array['search']);
            $this->orLike('transportadoras.nome_fantasia', $params_array['search']);
            $this->orLike('transportadoras.cnpj', $params_array['search']);
            $this->orLike('transportadoras.email', $params_array['search']);
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
    public function countTransportadoras($search)
    {
        $this->select('COUNT(transportadoras.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('transportadoras.razao_social', $search);
            $this->orLike('transportadoras.nome_fantasia', $search);
            $this->orLike('transportadoras.cnpj', $search);
            $this->orLike('transportadoras.email', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
