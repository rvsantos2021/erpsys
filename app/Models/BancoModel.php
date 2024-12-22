<?php

namespace App\Models;

use CodeIgniter\Model;

class BancoModel extends Model
{
    protected $table            = 'bancos';
    protected $returnType       = 'App\Entities\Banco';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'codigo',
        'descricao',
        'photo',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id'   => 'permit_empty|is_natural_no_zero',
        'codigo' => 'required|max_length[5]|is_unique[bancos.codigo,id,{id}]',
        'descricao' => 'required|max_length[100]|is_unique[bancos.descricao,id,{id}]',
    ];

    protected $validationMessages   = [
        'codigo'          => [
            'required'  => 'Informe o Código do Banco',
            'is_unique' => 'Já existe um Banco com este Código. Altere para continuar',
        ],
        'descricao'          => [
            'required'  => 'Informe o Nome do Banco',
            'is_unique' => 'Já existe um Banco com este Nome. Altere para continuar',
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
     * Método que recupera todos os bancos da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getAllBancos()
    {
        $fields = [
            'bancos.id',
            'bancos.codigo',
            'bancos.descricao',
            'bancos.photo',
            'bancos.active',
            'bancos.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(false)
            ->orderBy('bancos.descricao');

        return $this->findAll();
    }

    /**
     * Método que recupera todos os bancos da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getBancos($params_array)
    {
        $fields = [
            'bancos.id',
            'bancos.codigo',
            'bancos.descricao',
            'bancos.photo',
            'bancos.active',
            'bancos.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('bancos.codigo', $params_array['search']);
            $this->orLike('bancos.descricao', $params_array['search']);
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
    public function countBancos($search)
    {
        $this->select('COUNT(bancos.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('bancos.codigo', $search);
            $this->orLike('bancos.descricao', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }
}
