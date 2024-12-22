<?php

namespace App\Models;

use CodeIgniter\Model;

class CondicaoPagamentoModel extends Model
{
    protected $table            = 'condicoes_pagamento';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\CondicaoPagamento';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'nome',
        'entrada',
        'perc_entrada',
        'qtd_parcelas',
        'dias_parcela1',
        'dias_parcelas',
        'tabela_id',
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
        'nome' => 'required|max_length[100]|is_unique[condicoes_pagamento.nome,id,{id}]',
    ];

    protected $validationMessages   = [
        'nome' => [
            'required'  => 'O campo Nome é obrigatório.',
            'is_unique' => 'O Nome informado já está cadastrado. Informe outro para continuar.',
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
     * Método que recupera todas as condições de pagamento da tabela
     * 
     * @return array|null
     */
    public function getAllCondicoesPagamento()
    {
        $fields = [
            'condicoes_pagamento.id',
            'condicoes_pagamento.nome',
            'condicoes_pagamento.entrada',
            'condicoes_pagamento.perc_entrada',
            'condicoes_pagamento.qtd_parcelas',
            'condicoes_pagamento.dias_parcela1',
            'condicoes_pagamento.dias_parcelas',
            'condicoes_pagamento.tabela_id',
            'tabelas_precos.descricao as tabela',
            'condicoes_pagamento.active',
            'condicoes_pagamento.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->join('tabelas_precos', 'tabelas_precos.id = condicoes_pagamento.tabela_id')
            ->orderBy('condicoes_pagamento.nome')
            ->findAll();
    }

    /**
     * Método que recupera todas as condições de pagamento da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getCondicoesPagamento($params_array)
    {
        $fields = [
            'condicoes_pagamento.id',
            'condicoes_pagamento.nome',
            'condicoes_pagamento.entrada',
            'condicoes_pagamento.perc_entrada',
            'condicoes_pagamento.qtd_parcelas',
            'condicoes_pagamento.dias_parcela1',
            'condicoes_pagamento.dias_parcelas',
            'condicoes_pagamento.tabela_id',
            'tabelas_precos.descricao as tabela',
            'condicoes_pagamento.active',
            'condicoes_pagamento.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true)
            ->join('tabelas_precos', 'tabelas_precos.id = condicoes_pagamento.tabela_id');

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('condicoes_pagamento.nome', $params_array['search']);
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
    public function countCondicoesPagamento($search)
    {
        $this->select('COUNT(condicoes_pagamento.id) AS count')
            ->withDeleted(true)
            ->join('tabelas_precos', 'tabelas_precos.id = condicoes_pagamento.tabela_id');

        if ($search != '') {
            $this->groupStart();
            $this->like('condicoes_pagamento.nome', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
