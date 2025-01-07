<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class LancamentoFinanceiro extends Entity
{
    protected $dates   = ['created_at', 'updated_at', 'deleted_at', 'data_lancamento', 'data_competencia'];
}