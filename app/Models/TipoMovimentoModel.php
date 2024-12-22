<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoMovimentoModel extends Model
{
    protected $table            = 'tipos_movimentos';
    protected $returnType       = 'App\Entities\TipoMovimento';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'descricao',
        'movimento',
        'estoque',
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
        'descricao' => 'required|max_length[50]|is_unique[tipos_movimentos.descricao,id,{id}]',
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
     * Método que recupera todos os tipos de movimentos da tabela
     * 
     * @return array|null
     */
    public function getAllTipoMovimentos()
    {
        $fields = [
            $this->table . '.id',
            $this->table . '.descricao',
            $this->table . '.movimento',
            $this->table . '.estoque',
            $this->table . '.active',
            $this->table . '.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy($this->table . '.descricao')
            ->findAll();
    }

    /**
     * Método que recupera todos os tipos de movimentos da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getTipoMovimentos($params_array)
    {
        $fields = [
            $this->table . '.id',
            $this->table . '.descricao',
            $this->table . '.movimento',
            $this->table . '.estoque',
            $this->table . '.active',
            $this->table . '.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like($this->table . '.descricao', $params_array['search']);
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
    public function countTipoMovimentos($search)
    {
        $this->select('COUNT(' . $this->table . '.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like($this->table . '.descricao', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
