<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresaEnderecoModel extends Model
{
    protected $table            = 'empresas_enderecos';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\EmpresaEndereco';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'empresa_id',
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
     * Método que retorna todos os endereços da empresa
     * 
     * @param int $empresa_id
     * @return object | null
     */
    public function getEnderecosEmpresa(int $empresa_id)
    {
        $fields = [
            'empresas_enderecos.id',
            'empresas_enderecos.tipo',
            'empresas_enderecos.cep',
            'empresas_enderecos.logradouro',
            'empresas_enderecos.numero',
            'empresas_enderecos.complemento',
            'empresas_enderecos.bairro',
            'empresas_enderecos.cidade_id',
            'cidades.nome as cidade',
            'cidades.cod_ibge',
            'cidades.uf',
            'empresas_enderecos.active',
        ];

        return $this->select($fields)
            ->join('cidades', 'cidades.id = empresas_enderecos.cidade_id')
            ->where('empresas_enderecos.empresa_id', $empresa_id)
            ->withDeleted(false)
            ->findAll();
    }
}
