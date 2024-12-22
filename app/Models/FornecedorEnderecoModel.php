<?php

namespace App\Models;

use CodeIgniter\Model;

class FornecedorEnderecoModel extends Model
{
    protected $table            = 'fornecedores_enderecos';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\FornecedorEndereco';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'fornecedor_id',
        'tipo',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade_id',
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
        'cep' => [
            'required'  => 'O campo CEP é obrigatório.',
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
     * Método que retorna todos os endereços do fornecedor
     * 
     * @param int $fornecedor_id
     * @return object | null
     */
    public function getEnderecosFornecedor(int $fornecedor_id)
    {
        $fields = [
            'fornecedores_enderecos.id',
            'fornecedores_enderecos.tipo',
            'fornecedores_enderecos.cep',
            'fornecedores_enderecos.logradouro',
            'fornecedores_enderecos.numero',
            'fornecedores_enderecos.complemento',
            'fornecedores_enderecos.bairro',
            'fornecedores_enderecos.cidade_id',
            'cidades.nome as cidade',
            'cidades.cod_ibge',
            'cidades.uf',
            'fornecedores_enderecos.active',
        ];

        return $this->select($fields)
            ->join('cidades', 'cidades.id = fornecedores_enderecos.cidade_id')
            ->where('fornecedores_enderecos.fornecedor_id', $fornecedor_id)
            ->withDeleted(false)
            ->findAll();
    }
}
