<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserAdminSeeder extends Seeder
{
    public function run()
    {
        $userModel = new \App\Models\UserModel();
        $groupModel = new \App\Models\UserGroupModel();

        $qtdUsers = 0;
        $usersPush = [];
        $usersPush = [
            [
                'name'     => 'Admin',
                'password' => 'admin',
                'email'    => 'contato@prsystem.com.br',
                'active'   => true,
            ],
            [
                'name'     => 'Ricardo Santos',
                'password' => 'unidax',
                'email'    => 'ricardo.santos@prsystem.com.br',
                'active'   => true,
            ],
        ];

        foreach ($usersPush as $user) {
            $userModel->skipValidation(true)        // pular validação
                ->protect(false)                    // pular proteção dos campos allowedFields
                ->insert($user);

            $qtdUsers++;
        }

        $groupsPush = [];
        $groupsPush = [
            [
                'group_id ' => 1,
                'user_id '  => 1,
            ],
            [
                'group_id ' => 1,
                'user_id '  => 2,
            ],
        ];

        foreach ($groupsPush as $group) {
            $groupModel->skipValidation(true)       // pular validação
                ->protect(false)                    // pular proteção dos campos allowedFields
                ->insert($group);
        }

        echo "$qtdUsers usuários inseridos com sucesso! <br />";
    }
}
