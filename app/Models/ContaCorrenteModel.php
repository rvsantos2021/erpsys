<?php

namespace App\Models;

use CodeIgniter\Model;

class ContaCorrenteModel extends Model
{
    protected $table            = 'contas_corrente';
    protected $returnType       = 'App\Entities\ContaCorrente';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'banco_id',
        'agencia',
        'numero',
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
        'descricao' => 'required|max_length[50]|is_unique[contas_corrente.descricao,id,{id}]',
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
     * Método que recupera todos as contas corrente da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getAllContas()
    {
        $fields = [
            'contas_corrente.id',
            'contas_corrente.banco_id',
            'bancos.descricao as banco',
            'contas_corrente.agencia',
            'contas_corrente.numero',
            'contas_corrente.descricao',
            'contas_corrente.active',
            'contas_corrente.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(false)
            ->join('bancos', 'bancos.id = contas_corrente.banco_id')
            ->orderBy('contas_corrente.descricao');

        return $this->findAll();
    }

    /**
     * Método que recupera todos as contas bancárias da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getContas($params_array)
    {
        $fields = [
            'contas_corrente.id',
            'contas_corrente.banco_id',
            'bancos.descricao as banco',
            'contas_corrente.agencia',
            'contas_corrente.numero',
            'contas_corrente.descricao',
            'contas_corrente.active',
            'contas_corrente.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true)
            ->join('bancos', 'bancos.id = contas_corrente.banco_id');

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('contas_corrente.descricao', $params_array['search']);
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
    public function countContas($search)
    {
        $this->select('COUNT(contas_corrente.id) AS count')
            ->withDeleted(true)
            ->join('bancos', 'bancos.id = contas_corrente.banco_id');

        if ($search != '') {
            $this->groupStart();
            $this->like('contas_corrente.descricao', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
