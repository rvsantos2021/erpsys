<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteEnderecoModel extends Model
{
    protected $table            = 'clientes_enderecos';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\ClienteEndereco';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'cliente_id',
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
     * Método que retorna todos os endereços da cliente
     * 
     * @param int $cliente_id
     * @return object | null
     */
    public function getEnderecosCliente(int $cliente_id)
    {
        $fields = [
            'clientes_enderecos.id',
            'clientes_enderecos.tipo',
            'clientes_enderecos.cep',
            'clientes_enderecos.logradouro',
            'clientes_enderecos.numero',
            'clientes_enderecos.complemento',
            'clientes_enderecos.bairro',
            'clientes_enderecos.cidade_id',
            'cidades.nome as cidade',
            'cidades.cod_ibge',
            'cidades.uf',
            'clientes_enderecos.active',
        ];

        return $this->select($fields)
            ->join('cidades', 'cidades.id = clientes_enderecos.cidade_id')
            ->where('clientes_enderecos.cliente_id', $cliente_id)
            ->withDeleted(false)
            ->findAll();
    }
}
