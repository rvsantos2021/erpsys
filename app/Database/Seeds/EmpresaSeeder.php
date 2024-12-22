<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    public function run()
    {
        $empresaModel = new \App\Models\EmpresaModel();
        $empresasPush = [];

        $empresasPush = [
            [
                'tipo'                => 'J',
                'razao_social'        => 'MD MÓVEIS CORPORATIVOS LTDA - ME',
                'nome_fantasia'       => 'MD MÓVEIS',
                'cnpj'                => '17.200.500/0001-70',
                'inscricao_estadual'  => '664.089.921.116',
                'inscricao_municipal' => null,
                'cnae'                => null,
                'telefone'            => '(16) 3524-6520',
                'celular'             => null,
                'contato'             => 'MARILDA',
                'site'                => 'www.mdmoveiscorporativos.com.br',
                'email'               => 'md@mdmoveiscorporativos.com.br',
                'photo'               => null,
                'active'              => true,
            ],
        ];

        foreach ($empresasPush as $empresa) {
            $empresaModel->insert($empresa);
        }

        echo "Empresa inserida com sucesso! <br />";
    }
}
