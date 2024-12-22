<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteContatoModel extends Model
{
    protected $table            = 'clientes_contatos';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\ClienteContato';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'cliente_id',
        'cargo_id',
        'nome',
        'telefone',
        'celular',
        'email',
        'data_nascimento',
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
        'nome' => 'required|max_length[50]',
    ];

    protected $validationMessages   = [
        'nome' => [
            'required'  => 'O campo Nome é obrigatório.',
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
     * Método que recupera todos os contatos da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getContatos($params_array)
    {
        $fields = [
            'clientes_contatos.id',
            'clientes_contatos.cliente_id',
            'clientes.razao_social',
            'clientes_contatos.cargo_id',
            'cargos.descricao as cargo',
            'clientes_contatos.nome',
            'clientes_contatos.telefone',
            'clientes_contatos.celular',
            'clientes_contatos.email',
            'clientes_contatos.data_nascimento',
            'clientes_contatos.active',
            'clientes_contatos.created_at',
            'clientes_contatos.updated_at',
            'clientes_contatos.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true)
            ->join('clientes', 'clientes.id = clientes_contatos.cliente_id', 'LEFT')
            ->join('cargos', 'cargos.id = clientes_contatos.cargo_id', 'LEFT');

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('clientes.razao_social', $params_array['search']);
            $this->orLike('clientes_contatos.nome', $params_array['search']);
            $this->orLike('clientes_contatos.email', $params_array['search']);
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
    public function countContatos($search)
    {
        $this->select('COUNT(clientes_contatos.id) AS count')
            ->withDeleted(true)
            ->join('clientes', 'clientes.id = clientes_contatos.cliente_id', 'LEFT')
            ->join('cargos', 'cargos.id = clientes_contatos.cargo_id', 'LEFT');

        if ($search != '') {
            $this->groupStart();
            $this->like('clientes.razao_social', $search);
            $this->orLike('clientes_contatos.nome', $search);
            $this->orLike('clientes_contatos.email', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }

    public function getContatoById(int $id)
    {
        $fields = [
            'clientes_contatos.id',
            'clientes_contatos.cliente_id',
            'clientes.razao_social',
            'clientes_contatos.cargo_id',
            'cargos.descricao as cargo',
            'clientes_contatos.nome',
            'clientes_contatos.telefone',
            'clientes_contatos.celular',
            'clientes_contatos.email',
            'clientes_contatos.data_nascimento',
            'clientes_contatos.active',
            'clientes_contatos.created_at',
            'clientes_contatos.updated_at',
            'clientes_contatos.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true)
            ->join('clientes', 'clientes.id = clientes_contatos.cliente_id', 'LEFT')
            ->join('cargos', 'cargos.id = clientes_contatos.cargo_id', 'LEFT');

        return $this->find($id);
    }
}
