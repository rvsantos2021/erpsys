<?php

namespace App\Models;

use CodeIgniter\Model;

class TransportadoraEnderecoModel extends Model
{
    protected $table            = 'transportadoras_enderecos';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\TransportadoraEndereco';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'transportadora_id',
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
     * Método que retorna todos os endereços do transportadora
     * 
     * @param int $transportadora_id
     * @return object | null
     */
    public function getEnderecosTransportadora(int $transportadora_id)
    {
        $fields = [
            'transportadoras_enderecos.id',
            'transportadoras_enderecos.tipo',
            'transportadoras_enderecos.cep',
            'transportadoras_enderecos.logradouro',
            'transportadoras_enderecos.numero',
            'transportadoras_enderecos.complemento',
            'transportadoras_enderecos.bairro',
            'transportadoras_enderecos.cidade_id',
            'cidades.nome as cidade',
            'cidades.cod_ibge',
            'cidades.uf',
            'transportadoras_enderecos.active',
        ];

        return $this->select($fields)
            ->join('cidades', 'cidades.id = transportadoras_enderecos.cidade_id')
            ->where('transportadoras_enderecos.transportadora_id', $transportadora_id)
            ->withDeleted(false)
            ->findAll();
    }
}
