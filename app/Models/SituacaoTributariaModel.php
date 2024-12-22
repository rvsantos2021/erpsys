<?php

namespace App\Models;

use CodeIgniter\Model;

class SituacaoTributariaModel extends Model
{
    protected $table            = 'situacoes_tributarias';
    protected $returnType       = 'App\Entities\SituacaoTributaria';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'descricao',
        'cst',
        'tabela',
        'operacao',
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
        'descricao' => 'required|max_length[100]|is_unique[situacoes_tributarias.descricao,situacoes_tributarias.cst,id,{id}]',
    ];

    protected $validationMessages   = [
        'descricao'     => [
            'required'  => 'Informe a Descrição',
            'is_unique' => 'Já existe um registro com esta Descrição. Altere para continuar',
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
     * Método que recupera todas as Situações Tributárias da tabela
     * 
     * @return array|null
     */
    public function getAllCSTs()
    {
        $fields = [
            $this->table . '.id',
            $this->table . '.cst',
            $this->table . '.descricao',
            $this->table . '.tabela',
            $this->table . '.operacao',
            $this->table . '.active',
            $this->table . '.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy($this->table . '.cst')
            ->findAll();
    }

    /**
     * Método que recupera todas as Situações Tributárias da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getCSTs(array $params_array)
    {
        $fields = [
            $this->table . '.id',
            $this->table . '.cst',
            $this->table . '.descricao',
            $this->table . '.tabela',
            $this->table . '.operacao',
            $this->table . '.active',
            $this->table . '.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like($this->table . '.descricao', $params_array['search']);
            $this->orLike($this->table . '.tabela', $params_array['search']);
            $this->orLike($this->table . '.cst', $params_array['search']);
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
    public function countCSTs(string $search)
    {
        $this->select('COUNT(' . $this->table . '.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like($this->table . '.descricao', $search);
            $this->orLike($this->table . '.tabela', $search);
            $this->orLike($this->table . '.cst', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }

    /**
     * Método que retorna o ID da tabela por CST
     * 
     * @param string $cfop
     * @param string $tabela
     * @return int
     */
    public function getCSTId(string $cfop, string $tabela)
    {
        return $this->select($this->table . '.id')
            ->where($this->table . '.tabela', $tabela)
            ->where($this->table . '.cst', $cfop)
            ->withDeleted(false)
            ->find();
    }
}
