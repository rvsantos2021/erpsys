<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{

    public function run()
    {
        $permissionModel = new \App\Models\PermissionModel();
        $qtdPermissions = 0;
        $permissionsPush = [];

        $permissionsPush = [
            [
                'name'        => 'listar-usuarios',
                'description' => 'Listar usuários',
            ],
            [
                'name'        => 'criar-usuarios',
                'description' => 'Criar novo usuário',
            ],
            [
                'name'        => 'editar-usuarios',
                'description' => 'Editar dados de usuário',
            ],
            [
                'name'        => 'excluir-usuarios',
                'description' => 'Excluir usuário',
            ],
        ];

        foreach ($permissionsPush as $permission) {
            $permissionModel->protect(false)->insert($permission);

            $qtdPermissions++;
        }

        echo "$qtdPermissions permissões inseridas com sucesso! <br />";
    }
}
