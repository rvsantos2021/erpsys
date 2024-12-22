<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FakeUserSeeder extends Seeder
{

    public function run()
    {
        $userModel = new \App\Models\UserModel();
        // $userFaker = \Faker\Factory::create();
        $usersPush = [];
        /*
        $qtdUsers = 2000;

        for ($i = 0; $i < $qtdUsers; $i++) {
            array_push($usersPush, [
                'name' => $userFaker->unique()->name,
                'password' => '123456',
                'email' => $userFaker->unique()->email,
                'active' => $userFaker->numberBetween(0, 1),
            ]);
        }

        $userModel->skipValidation(true)        // pular validação
            ->protect(false)                    // pular proteção dos campos allowedFields
            ->insertBatch($usersPush);
        */
        $qtdUsers = 1;
        $usersPush = [
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
                ->insert($usersPush);
        }

        echo "$qtdUsers registros inseridos com sucesso! ";
    }
}
