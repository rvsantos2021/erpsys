<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FunilPadraoSeeder extends Seeder
{
    public function run()
    {
        $funilModel = new \App\Models\FunilVendaModel();
        $etapaModel = new \App\Models\FunilVendaEtapaModel();

        $funilPush = [];
        $funilPush = [
            [
                'descricao' => 'Funil Padrão',
                'active'    => true,
            ],
        ];

        foreach ($funilPush as $funil) {
            $funilModel->skipValidation(true)       // pular validação
                ->protect(false)                    // pular proteção dos campos allowedFields
                ->insert($funil);
        }

        $etapaPush = [];
        $etapaPush = [
            [
                'funil_id'  => 1,
                'ordem'     => 1,
                'descricao' => 'Sem contato',
                'active'    => true,
            ],
            [
                'funil_id'  => 1,
                'ordem'     => 2,
                'descricao' => 'Contato feito',
                'active'    => true,
            ],
            [
                'funil_id'  => 1,
                'ordem'     => 3,
                'descricao' => 'Identificação do interesse',
                'active'    => true,
            ],
            [
                'funil_id'  => 1,
                'ordem'     => 4,
                'descricao' => 'Apresentação',
                'active'    => true,
            ],
            [
                'funil_id'  => 1,
                'ordem'     => 5,
                'descricao' => 'Proposta enviada',
                'active'    => true,
            ],
        ];

        foreach ($etapaPush as $group) {
            $etapaModel->skipValidation(true)       // pular validação
                ->protect(false)                    // pular proteção dos campos allowedFields
                ->insert($group);
        }

        echo "Funil de vendas inserido com sucesso! <br />";
    }
}
