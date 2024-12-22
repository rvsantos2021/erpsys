<?php

namespace App\Models;

use CodeIgniter\Model;

class EstoqueDepositoModel extends Model
{
    protected $table            = 'estoque_depositos';
    protected $returnType       = 'App\Entities\EstoqueDeposito';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'descricao',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

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
     * Método que recupera os estoques do produdo informado
     * 
     * @param int $produto_id
     * @return array|null
     */
    public function getEstoqueProduto(int $produto_id)
    {
        $fields = [
            'estoque_depositos.id',
            'estoque_depositos.deposito_id',
            'produtos_depositos.descricao',
            'estoque_depositos.estoque',
            'produtos_depositos.active',
            'produtos_depositos.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(false)
            ->join('produtos_depositos', 'produtos_depositos.id = estoque_depositos.deposito_id')
            ->where('estoque_depositos.produto_id', $produto_id);

        return $this->findAll();
    }
}
