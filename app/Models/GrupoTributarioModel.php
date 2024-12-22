<?php

namespace App\Models;

use CodeIgniter\Model;

class GrupoTributarioModel extends Model
{
    protected $table            = 'grupos_tributarios';
    protected $returnType       = 'App\Entities\GrupoTributario';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'descricao',
        'tipo_grupo',
        'tipo_tributacao',
        'cst',
        'aliquota',
        'reducao',
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
        'descricao' => 'required|max_length[50]|is_unique[grupos_tributarios.descricao,grupos_tributarios.tipo_grupo,id,{id}]',
    ];

    protected $validationMessages   = [
        'descricao'     => [
            'required'  => 'Informe a Descrição do Grupo',
            'is_unique' => 'Já existe um Grupo com esta Descrição. Altere para continuar',
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
     * Método que recupera todos os Grupos Tributários da tabela
     * 
     * @return array|null
     */
    public function getAllGruposTributarios()
    {
        $fields = [
            $this->table . '.id',
            $this->table . '.descricao',
            $this->table . '.tipo_grupo',
            $this->table . '.tipo_tributacao',
            $this->table . '.cst',
            $this->table . '.aliquota',
            $this->table . '.reducao',
            $this->table . '.active',
            $this->table . '.deleted_at',
        ];

        return $this->select($fields)
            ->withDeleted(false)
            ->orderBy($this->table . '.descricao')
            ->findAll();
    }

    /**
     * Método que recupera todos os Grupos Tributários da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getGruposTributarios(array $params_array)
    {
        $fields = [
            $this->table . '.id',
            $this->table . '.descricao',
            $this->table . '.tipo_grupo',
            $this->table . '.tipo_tributacao',
            $this->table . '.cst',
            $this->table . '.aliquota',
            $this->table . '.reducao',
            $this->table . '.active',
            $this->table . '.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like($this->table . '.descricao', $params_array['search']);
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
    public function countGruposTributarios(string $search)
    {
        $this->select('COUNT(' . $this->table . '.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like($this->table . '.descricao', $search);
            $this->orLike($this->table . '.cst', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }

    /**
     * Método que retorna o ID da tabela por CST
     * 
     * @param string $cst
     * @return int
     */
    public function getGrupoTributarioId($cst)
    {
        return $this->select($this->table . '.id')
            ->where($this->table . '.cst', $cst)
            ->withDeleted(false)
            ->find();
    }
}
