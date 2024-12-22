<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MarcasProdutosSeeder extends Seeder
{
    public function run()
    {
        $marcaModel = new \App\Models\MarcaProdutoModel();
        $marcaPush = [];

        $marcaPush = [
            [
                'descricao' => 'Padrão',
                'active'    => true,
            ],
        ];

        foreach ($marcaPush as $marca) {
            $marcaModel->insert($marca);
        }

        echo "Marca inserida com sucesso! <br />";
    }
}
