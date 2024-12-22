<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoImagemModel extends Model
{
    protected $table            = 'produtos_imagens';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\ProdutoImagem';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'produto_id',
        'descricao',
        'destaque',
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
        'id'  => 'permit_empty|is_natural_no_zero',
    ];

    protected $validationMessages   = [
        'photo' => [
            'required'  => 'A imagem é obrigatória.',
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
     * Método que retorna todas as imagens do produto
     * 
     * @param int $produto_id
     * @return object | null
     */
    public function getImagensProduto(int $produto_id)
    {
        $fields = [
            $this->table . '.id',
            $this->table . '.descricao',
            $this->table . '.destaque',
            $this->table . '.photo',
            $this->table . '.active',
        ];

        return $this->select($fields)
            ->where($this->table . '.produto_id', $produto_id)
            ->withDeleted(false)
            ->findAll();
    }
}
