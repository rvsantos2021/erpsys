<?php

namespace App\Models;

use CodeIgniter\Model;

class ClassificacaoContaModel extends Model
{
    protected $table            = 'classificacoes_contas';
    protected $returnType       = 'App\Entities\ClassificacaoConta';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'id_pai',
        'codigo',
        'tipo',
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
        'id'   => 'permit_empty|is_natural_no_zero',
        'descricao' => 'required|max_length[50]|is_unique[classificacoes_contas.descricao,id,tipo,{id},{tipo}]',
        'tipo' => 'required',
    ];

    protected $validationMessages   = [
        'descricao'     => [
            'required'  => 'Informe a Descrição',
            'is_unique' => 'Esta Descrição já existe. Altere para continuar',
        ],
        'tipo'          => [
            'required'  => 'Informe o Tipo',
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
     * Método que recupera todos as classificações da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getAllClassificacoes()
    {
        $fields = [
            'classificacoes_contas.id',
            'classificacoes_contas.id_pai',
            'classificacoes_contas.codigo',
            'classificacoes_contas.tipo',
            'classificacoes_contas.descricao',
            'classificacoes_contas.active',
            'classificacoes_contas.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(false)
            ->orderBy('classificacoes_contas.codigo');

        return $this->findAll();
    }

    /**
     * Método que recupera todos as classificações da tabela
     * 
     * @param array $params_array
     * @return array|null
     */
    public function getClassificacoes($params_array)
    {
        $fields = [
            'classificacoes_contas.id',
            'classificacoes_contas.id_pai',
            'classificacoes_contas.codigo',
            'classificacoes_contas.tipo',
            'classificacoes_contas.descricao',
            'classificacoes_contas.active',
            'classificacoes_contas.deleted_at',
        ];

        $this->select($fields)
            ->withDeleted(true);

        if ($params_array['search'] != '') {
            $this->groupStart();
            $this->like('classificacoes_contas.descricao', $params_array['search']);
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
    public function countClassificacoes($search)
    {
        $this->select('COUNT(classificacoes_contas.id) AS count')
            ->withDeleted(true);

        if ($search != '') {
            $this->groupStart();
            $this->like('classificacoes_contas.descricao', $search);
            $this->groupEnd();
        }

        return $this->countAllResults();
    }

    public function getCodigoClassificacao($id_pai = null)
    {
        $this->where('classificacoes_contas.id_pai', $id_pai);
        $this->orderBy('classificacoes_contas.id', 'DESC');
        $this->orderBy('classificacoes_contas.codigo', 'DESC');
        $this->limit(1);

        $result = $this->get()->getRow();

        if (isset($result->codigo) != null) {
            $codigo = explode('.', $result->codigo);

            if (isset($codigo[4])) {
                return $codigo[0] . '.' . $codigo[1] . '.' . $codigo[2] . '.' . $codigo[3] . '.' . strval(intval($codigo[4]) + 1);
            } else if (isset($codigo[3])) {
                return $codigo[0] . '.' . $codigo[1] . '.' . $codigo[2] . '.' . strval(intval($codigo[3]) + 1);
            } else if (isset($codigo[2])) {
                return $codigo[0] . '.' . $codigo[1] . '.' . strval(intval($codigo[2]) + 1);
            } else if (isset($codigo[1])) {
                return $codigo[0] . '.' . strval(intval($codigo[1]) + 1);
            } else if (isset($codigo[0])) {
                $this->where('classificacoes_contas.id', $id_pai);
                $this->orderBy('classificacoes_contas.codigo', 'DESC');
                $this->limit(1);

                $result = $this->get()->getRow();

                if (isset($result)) {
                    if ($result->codigo == '')
                        return strval(intval($codigo[0]) + 1);
                    else
                        return $result->codigo . '.' . strval(intval($codigo[0]) + 1);
                } else {
                    return strval(intval($codigo[0]) + 1);
                }
            }
        } else {
            $this->where('classificacoes_contas.id', $id_pai);
            $this->orderBy('classificacoes_contas.codigo', 'DESC');
            $this->limit(1);

            $result = $this->get()->getRow();

            if (!isset($result))
                return '1';
            else
                return $result->codigo . '.' . '1';
        }
    }
}
