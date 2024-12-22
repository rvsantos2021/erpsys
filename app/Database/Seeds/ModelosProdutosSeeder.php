<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ModelosProdutosSeeder extends Seeder
{
    public function run()
    {
        $modeloModel = new \App\Models\ModeloProdutoModel();
        $modeloPush = [];

        $modeloPush = [
            [
                'descricao' => 'Padrão',
                'active'    => true,
            ],
        ];

        foreach ($modeloPush as $modelo) {
            $modeloModel->insert($modelo);
        }

        echo "Modelo inserido com sucesso! <br />";
    }
}
