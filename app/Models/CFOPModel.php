<?php

namespace App\Models;

use CodeIgniter\Model;

class CFOPModel extends Model
{
    protected $table            = 'cfops';
    protected $returnType       = 'App\Entities\CFOP';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'cfop',
        'descricao',
        'complemento',
        'origem_destino',
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
        'cfop'      => 'required|max_length[4]|is_unique[cfops.id,cfops.cfop,{id}]',
        // 'descricao' => 'required|max_length[100]|is_unique[cfops.descricao,cfop,{cfop}]',
        'descricao' => 'required|max_length[100]',
    ];

    protected $validationMessages   = [
        'cfop'     => [
            'required'  => 'Informe o CFOP',
            'is_unique' => 'Já existe um CFOP com este Código. Altere para continuar',
        ],
        'descricao'     => [
            'required'  => 'Informe a Descrição do CFOP',
            // 'is_unique' => 'Já existe um CFOP com esta Descrição. Altere para continuar',
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
     * Método que recupera todos os CFOPs da tabela
     * 
     * @return array|null
     */
    public function getAllCFOPs()
    {
        $fields = [
            $this->table . '.id',
            $this->table . '.cfop',
            $this->table . '.descricao',
            $this->table . '.complemento',
            $this->table . '.origem_destino',
            $this->table . '.active',
            $this->table . '.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy($this->table . '.cfop')
            ->findAll();
    }

    /**
     * Método que recupera todos os CFOPs da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getCFOPs($params_array)
    {
        $fields = [
            $this->table . '.id',
            $this->table . '.cfop',
            $this->table . '.descricao',
            $this->table . '.complemento',
            $this->table . '.origem_destino',
            $this->table . '.active',
            $this->table . '.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like($this->table . '.descricao', $params_array['search']);
            $this->orLike($this->table . '.cfop', $params_array['search']);
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
    public function countCFOPs($search)
    {
        $this->select('COUNT(' . $this->table . '.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like($this->table . '.descricao', $search);
            $this->orLike($this->table . '.cfop', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }

    /**
     * Método que retorna o ID da tabela por CFOP
     * 
     * @param string $cfop
     * @return int
     */
    public function getCFOPId($cfop)
    {
        return $this->select($this->table . '.id')
            ->where($this->table . '.cfop', $cfop)
            ->withDeleted(false)
            ->find();
    }
}
