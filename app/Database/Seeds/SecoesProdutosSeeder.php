<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SecoesProdutosSeeder extends Seeder
{
    public function run()
    {
        $secaoModel = new \App\Models\SecaoProdutoModel();
        $secaoPush = [];

        $secaoPush = [
            [
                'descricao' => 'Padrão',
                'active'    => true,
            ],
        ];

        foreach ($secaoPush as $secao) {
            $secaoModel->insert($secao);
        }

        echo "Seção inserida com sucesso! <br />";
    }
}
