<?php

namespace App\Models;

use CodeIgniter\Model;

class FunilVendaEtapaModel extends Model
{
    protected $table            = 'funil_vendas_etapas';
    protected $returnType       = 'App\Entities\FunilVendaEtapa';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'funil_id',
        'ordem',
        'descricao',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id'        => 'permit_empty|is_natural_no_zero',
        //'descricao' => 'required|max_length[50]|is_unique[funil_vendas_etapas.descricao,id,{id}]',
    ];

    protected $validationMessages   = [
        'descricao' => [
            'required'  => 'Informe a Descrição',
            //'is_unique' => 'Esta Descrição já existe. Altere para continuar',
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
     * Método que recupera todos os registros da tabela
     * 
     * @return array|null
     */
    public function getEtapasFunilVendas(int $funil_id = null)
    {
        $fields = [
            'funil_vendas_etapas.id',
            'funil_vendas_etapas.ordem',
            'funil_vendas_etapas.descricao',
            'funil_vendas_etapas.active',
            'funil_vendas_etapas.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->where('funil_vendas_etapas.funil_id', $funil_id)
            ->orderBy('funil_vendas_etapas.ordem')
            ->findAll();
    }
}
