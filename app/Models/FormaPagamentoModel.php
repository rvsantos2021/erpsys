<?php

namespace App\Models;

use CodeIgniter\Model;

class FormaPagamentoModel extends Model
{
    protected $table            = 'formas_pagamento';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\FormaPagamento';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'nome',
        'contas_receber',
        'contas_pagar',
        'desconto',
        'financeiro',
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
        'nome' => 'required|max_length[100]|is_unique[formas_pagamento.nome,id,{id}]',
    ];

    protected $validationMessages   = [
        'nome' => [
            'required'  => 'O campo Nome é obrigatório.',
            'is_unique' => 'O nome informado já está cadastrado. Informe outro para continuar.',
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
     * Método que recupera todas as formas de pagamento da tabela
     * 
     * @return array|null
     */
    public function getAllFormasPagamento()
    {
        $fields = [
            'formas_pagamento.id',
            'formas_pagamento.nome',
            'formas_pagamento.contas_receber',
            'formas_pagamento.contas_pagar',
            'formas_pagamento.desconto',
            'formas_pagamento.financeiro',
            'formas_pagamento.active',
            'formas_pagamento.deleted_at',
        ];


        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy('formas_pagamento.nome')
            ->findAll();
    }

    /**
     * Método que recupera todas as formas de pagamento da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getFormasPagamento($params_array)
    {
        $fields = [
            'formas_pagamento.id',
            'formas_pagamento.nome',
            'formas_pagamento.contas_receber',
            'formas_pagamento.contas_pagar',
            'formas_pagamento.desconto',
            'formas_pagamento.financeiro',
            'formas_pagamento.active',
            'formas_pagamento.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('formas_pagamento.nome', $params_array['search']);
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
    public function countFormasPagamento($search)
    {
        $this->select('COUNT(formas_pagamento.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('formas_pagamento.nome', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
