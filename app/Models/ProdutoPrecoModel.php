<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoPrecoModel extends Model
{
    protected $table            = 'produtos_precos';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\ProdutoPreco';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'produto_id',
        'tabela_id',
        'preco_custo',
        'perc_lucro',
        'preco_venda',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id'  => 'permit_empty|is_natural_no_zero',
    ];

    protected $validationMessages   = [
        'tabela_id' => [
            'required'  => 'A Tabela é obrigatória.',
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
     * Método que retorna todos os preços do produto
     * 
     * @param int $produto_id
     * @return object | null
     */
    public function getPrecosProduto(int $produto_id)
    {
        $fields = [
            $this->table . '.id',
            $this->table . '.tabela_id',
            $this->table . '.preco_custo',
            $this->table . '.perc_lucro',
            $this->table . '.preco_venda',
            'tabelas_precos.descricao as tabela',
            $this->table . '.active',
        ];

        return $this->select($fields)
            ->join('tabelas_precos', 'tabelas_precos.id = ' . $this->table . '.tabela_id')
            ->where($this->table . '.produto_id', $produto_id)
            ->withDeleted(false)
            ->findAll();
    }
}
