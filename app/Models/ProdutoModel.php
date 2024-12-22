<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table            = 'produtos';
    protected $returnType       = 'App\Entities\Produto';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'tipo_id',
        'codigo_barras',
        'descricao',
        'codigo_ncm',
        'cest',
        'referencia',
        'marca_id',
        'modelo_id',
        'grupo_id',
        'unidade_entrada_id',
        'unidade_saida_id',
        'setor_id',
        'estoque',
        'peso_bruto',
        'peso_liquido',
        'estoque_inicial',
        'estoque_minimo',
        'estoque_maximo',
        'estoque_atual',
        'estoque_reservado',
        'estoque_real',
        'custo_bruto',
        'custo_perc_desconto',
        'custo_valor_desconto',
        'custo_perc_ipi',
        'custo_valor_ipi',
        'custo_perc_st',
        'custo_valor_st',
        'custo_perc_frete',
        'custo_valor_frete',
        'custo_real',
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
        'id'   => 'permit_empty|is_natural_no_zero',
        'descricao' => 'required|max_length[100]|is_unique[produtos.descricao,id,{id}]',
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
     * Método que recupera todos os produtos da tabela
     * 
     * @return array|null
     */
    public function getAllProdutos()
    {
        $fields = [
            'produtos.id',
            'produtos.codigo_ncm',
            'produtos.referencia',
            'produtos.descricao',
            'produtos.localizacao',
            'produtos.photo',
            'produtos.active',
            'produtos.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy('produtos.descricao')
            ->findAll();
    }

    /**
     * Método que recupera todos os produtos da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getProdutos($params_array)
    {
        $fields = [
            'produtos.id',
            'produtos.codigo_ncm',
            'produtos.referencia',
            'produtos.descricao',
            'produtos.localizacao',
            'produtos.photo',
            'produtos.active',
            'produtos.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('produtos.descricao', $params_array['search']);
            $this->orLike('produtos.codigo_ncm', $params_array['search']);
            $this->orLike('produtos.referencia', $params_array['search']);
            $this->orLike('produtos.localizacao', $params_array['search']);
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
    public function countProdutos($search)
    {
        $this->select('COUNT(produtos.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('produtos.descricao', $search);
            $this->orLike('produtos.codigo_ncm', $search);
            $this->orLike('produtos.referencia', $search);
            $this->orLike('produtos.localizacao', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
