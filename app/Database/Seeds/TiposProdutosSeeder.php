<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TiposProdutosSeeder extends Seeder
{
    public function run()
    {
        $tipoModel = new \App\Models\TipoProdutoModel();

        $qtdTipos = 0;
        $tiposPush = [];
        $tiposPush = [
            [
                'descricao'     => 'Produto acabado',
                'produto'       => true,
                'active'        => true,
            ],
            [
                'descricao'     => 'Sub-Produto',
                'materia_prima' => true,
                'active'        => true,
            ],
        ];

        foreach ($tiposPush as $tipo) {
            $tipoModel->skipValidation(true)        // pular validação
                ->protect(false)                    // pular proteção dos campos allowedFields
                ->insert($tipo);

            $qtdTipos++;
        }

        echo "$qtdTipos tipos de produtos inseridos com sucesso! <br />";
    }
}
