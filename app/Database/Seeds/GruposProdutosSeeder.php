<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GruposProdutosSeeder extends Seeder
{
    public function run()
    {
        $grupoModel = new \App\Models\GrupoProdutoModel();
        $grupoPush = [];

        $grupoPush = [
            [
                'descricao' => 'Padrão',
                'active'    => true,
            ],
        ];

        foreach ($grupoPush as $grupo) {
            $grupoModel->insert($grupo);
        }

        echo "Grupo inserido com sucesso! <br />";
    }
}
