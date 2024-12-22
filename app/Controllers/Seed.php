<?php

namespace App\Controllers;

class Seed extends \CodeIgniter\Controller
{
    public function index()
    {
        $seeder = \Config\Database::seeder();

        try {
            $seeder->call('HostSeeder');

            echo "Tabelas semeadas com sucesso! <br />";
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }
}
