<?php

namespace App\Models;

use CodeIgniter\Model;

class TransportadoraVeiculoModel extends Model
{
    protected $table            = 'transportadora_veiculos';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\TransportadoraVeiculo';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'transportadora_id',
        'placa',
        'uf',
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
        'placa' => [
            'required'  => 'O campo placa é obrigatório.',
        ],
        'uf' => [
            'required'  => 'O campo UF é obrigatório.',
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
     * Método que retorna todos os veículos da transportadora
     * 
     * @param int $transportadora_id
     * @return object | null
     */
    public function getVeiculosTransportadora(int $transportadora_id)
    {
        $fields = [
            'transportadora_veiculos.id',
            'transportadora_veiculos.placa',
            'transportadora_veiculos.uf',
            'transportadora_veiculos.active',
        ];

        return $this->select($fields)
            ->where('transportadora_veiculos.transportadora_id', $transportadora_id)
            ->withDeleted(false)
            ->findAll();
    }
}
