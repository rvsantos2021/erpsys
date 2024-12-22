<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HostSeeder extends Seeder
{
    public function run()
    {
        $this->call('GroupSeeder');
        $this->call('UserAdminSeeder');
        $this->call('PermissionSeeder');
        $this->call('EmpresaSeeder');
        $this->call('CidadesSeeder');
        $this->call('DepositosSeeder');
        $this->call('GruposProdutosSeeder');
        $this->call('MarcasProdutosSeeder');
        $this->call('ModelosProdutosSeeder');
        $this->call('SecoesProdutosSeeder');
        $this->call('TiposProdutosSeeder');
        $this->call('FunilPadraoSeeder');
    }
}
