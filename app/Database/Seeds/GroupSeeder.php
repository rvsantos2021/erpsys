<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupSeeder extends Seeder
{

    public function run()
    {
        $groupModel = new \App\Models\GroupModel();
        $qtdGroups = 6;
        $groupsPush = [];

        $groupsPush = [
            [
                'name'        => 'Administrador',
                'description' => 'Grupo com acesso total ao sistema',
                'display'     => false
            ],
            [
                'name'        => 'Cliente',
                'description' => 'Grupo de Clientes com acesso ao sistema',
                'display'     => false
            ],
            [
                'name'        => 'Fornecedor',
                'description' => 'Grupo de Fornecedores com acesso ao sistema',
                'display'     => false
            ],
            [
                'name'        => 'Vendedor',
                'description' => 'Grupo de Vendedores com acesso ao sistema',
                'display'     => true
            ],
            [
                'name'        => 'Financeiro',
                'description' => 'Grupo de Usuários do Departamento Financeiro',
                'display'     => true
            ],
            [
                'name'        => 'Administrativo',
                'description' => 'Grupo de Usuários do Departamento Administrativo',
                'display'     => true
            ],
        ];

        foreach ($groupsPush as $group) {
            $groupModel->insert($group);
        }

        echo "$qtdGroups Grupos inseridos com sucesso! <br />";
    }
}
