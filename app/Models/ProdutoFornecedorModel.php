<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoFornecedorModel extends Model
{
    protected $table            = 'produtos_fornecedores';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\ProdutoFornecedor';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'produto_id',
        'fornecedor_id',
        'codigo',
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
        'fornecedor_id' => [
            'required'  => 'O Fornecedor é obrigatório.',
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
     * Método que retorna todos os fornecedores do produto
     * 
     * @param int $produto_id
     * @return object | null
     */
    public function getFornecedoresProduto(int $produto_id)
    {
        $fields = [
            $this->table . '.id',
            $this->table . '.fornecedor_id',
            $this->table . '.codigo',
            'fornecedores.razao_social as fornecedor',
            $this->table . '.active',
        ];

        return $this->select($fields)
            ->join('fornecedores', 'fornecedores.id = ' . $this->table . '.fornecedor_id')
            ->where($this->table . '.produto_id', $produto_id)
            ->withDeleted(false)
            ->findAll();
    }
}
