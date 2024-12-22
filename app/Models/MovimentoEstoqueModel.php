<?php

namespace App\Models;

use CodeIgniter\Model;

class MovimentoEstoqueModel extends Model
{
    protected $table            = 'estoque_movimentos';
    protected $returnType       = 'App\Entities\MovimentoEstoque';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'tipo_movimento_id',
        'deposito_id',
        'produto_id',
        'produto_descricao',
        'data_movimento',
        'descricao',
        'movimento',
        'quantidade',
        'valor',
        'valor_total',
        'estoque',
        'status',
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
    ];

    protected $validationMessages   = [];

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
     * Método que recupera todos os movimentos da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getMovimentos($params_array)
    {
        $fields = [
            'estoque_movimentos.id',
            'estoque_movimentos.tipo_movimento_id',
            'estoque_movimentos.deposito_id',
            'produtos_depositos.descricao as deposito',
            'estoque_movimentos.produto_id',
            ('estoque_movimentos.produto_id == 0' ? 'estoque_movimentos.produto_descricao' : 'produtos.descricao') . ' as produto_descricao',
            'produtos.codigo_barras',
            'produtos.referencia',
            'produtos.codigo_ncm',
            'estoque_movimentos.data_movimento',
            'estoque_movimentos.descricao',
            'estoque_movimentos.movimento',
            'estoque_movimentos.quantidade',
            'estoque_movimentos.valor',
            'estoque_movimentos.valor_total',
            'estoque_movimentos.estoque',
            'estoque_movimentos.status',
            'estoque_movimentos.active',
            'estoque_movimentos.deleted_at',
        ];

        $this->select($fields)
            ->join('produtos', 'produtos.id = estoque_movimentos.produto_id', 'LEFT')
            ->join('produtos_depositos', 'produtos_depositos.id = estoque_movimentos.deposito_id', 'LEFT')
            ->where('estoque_movimentos.status', 1)
            ->withDeleted(false);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('estoque_movimentos.descricao', $params_array['search']);
            $this->groupEnd();
        }

        if ($params_array['order'] != '') {
            $this->orderBy($params_array['order'], $params_array['dir']);
        }

        $this->limit($params_array['rowperpage'], $params_array['start']);

        return $this->findAll();
    }

    /**
     * Método que recupera todos os movimentos da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getMovimentosTemp()
    {
        $fields = [
            'estoque_movimentos.id',
            'estoque_movimentos.tipo_movimento_id',
            'estoque_movimentos.deposito_id',
            'estoque_movimentos.produto_id',
            ('estoque_movimentos.produto_id == 0' ? 'estoque_movimentos.produto_descricao' : 'produtos.descricao') . ' as produto_descricao',
            'produtos.codigo_barras',
            'produtos.referencia',
            'produtos.codigo_ncm',
            'estoque_movimentos.data_movimento',
            'estoque_movimentos.descricao',
            'estoque_movimentos.movimento',
            'estoque_movimentos.quantidade',
            'estoque_movimentos.valor',
            'estoque_movimentos.valor_total',
            'estoque_movimentos.estoque',
            'estoque_movimentos.status',
            'estoque_movimentos.active',
            'estoque_movimentos.deleted_at',
        ];

        $this->select($fields)
            ->join('produtos', 'produtos.id = estoque_movimentos.produto_id', 'LEFT')
            ->where('estoque_movimentos.status', 0)
            ->withDeleted(false);

        return $this->findAll();
    }

    /**
     * Método que retorna a quantidade de registros da tabela
     * 
     * @param string $search
     * @return int
     */
    public function countMovimentos($search)
    {
        $this->select('COUNT(estoque_movimentos.id) AS count')
            ->join('produtos', 'produtos.id = estoque_movimentos.produto_id', 'LEFT')
            ->where('estoque_movimentos.status', 1)
            ->withDeleted(false);

        if ($search != '') {
            $this->groupStart();
            $this->like('estoque_movimentos.descricao', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }

    /**
     * Método que retorna a quantidade de registros da tabela
     * 
     * @param string $search
     * @return int
     */
    public function countMovimentosTemp($search)
    {
        $this->select('COUNT(estoque_movimentos.id) AS count')
            ->join('produtos', 'produtos.id = estoque_movimentos.produto_id', 'LEFT')
            ->where('estoque_movimentos.status', 0)
            ->withDeleted(false);

        if ($search != '') {
            $this->groupStart();
            $this->like('estoque_movimentos.descricao', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
