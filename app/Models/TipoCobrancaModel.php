<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoCobrancaModel extends Model
{
    protected $table            = 'cobrancas_tipos';
    protected $returnType       = 'App\Entities\TipoCobranca';
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

    // Validation
    protected $validationRules      = [
        'id'        => 'permit_empty|is_natural_no_zero',
        'descricao' => 'required|max_length[100]|is_unique[cobrancas_tipos.descricao,id,{id}]',
    ];

    protected $validationMessages   = [
        'descricao'     => [
            'required'  => 'Informe a Descrição',
            'is_unique' => 'Esta Descrição já existe. Altere para continuar',
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
     * Método que recupera todos os tipos de cobrança da tabela
     * 
     * @return array|null
     */
    public function getAllTipoCobrancas()
    {
        $fields = [
            'cobrancas_tipos.id',
            'cobrancas_tipos.descricao',
            'cobrancas_tipos.active',
            'cobrancas_tipos.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy('cobrancas_tipos.descricao')
            ->findAll();
    }

    /**
     * Método que recupera todos os tipos de cobrança da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getTipoCobrancas($params_array)
    {
        $fields = [
            'cobrancas_tipos.id',
            'cobrancas_tipos.descricao',
            'cobrancas_tipos.active',
            'cobrancas_tipos.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('cobrancas_tipos.descricao', $params_array['search']);
            $this->groupEnd();
        }

        if ($params_array['order'] != '') {
            $this->orderBy($params_array['order'], $params_array['dir']);
        }

        $this->limit($params_array['rowperpage'], $params_array['start']);

        return $this->findAll();
    }

    /**
     * Método que retorna a quantidade de registros da tabela
     * 
     * @param string $search
     * @return int
     */
    public function countTipoCobrancas($search)
    {
        $this->select('COUNT(cobrancas_tipos.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('cobrancas_tipos.descricao', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
