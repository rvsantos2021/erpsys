<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DepositosSeeder extends Seeder
{
    public function run()
    {
        $depositoModel = new \App\Models\DepositoProdutoModel();

        $qtdDepositos = 0;
        $depositosPush = [];
        $depositosPush = [
            [
                'descricao' => 'Reservado',
                'active'    => true,
            ],
            [
                'descricao' => 'Principal',
                'active'    => true,
            ],
        ];

        foreach ($depositosPush as $deposito) {
            $depositoModel->skipValidation(true)    // pular validação
                ->protect(false)                    // pular proteção dos campos allowedFields
                ->insert($deposito);

            $qtdDepositos++;
        }

        echo "$qtdDepositos depósitos inseridos com sucesso! <br />";
    }
}
