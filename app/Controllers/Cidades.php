<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Cidades extends BaseController
{
    private $cidadeModel;

    public function __construct()
    {
        $this->cidadeModel = new \App\Models\CidadeModel();
    }

    /**
     * Método que retorna o ID da cidade por IBGE
     * 
     * @return int
     */
    public function buscarIdCidade()
    {
        // if (!$this->request->isAJAX()) {
        //     return redirect()->back();
        // }

        $cod_ibge = $this->request->getGet('cod_ibge');

        $cidade = $this->cidadeModel->getCidadeId($cod_ibge);

        return json_encode($cidade);
    }
}
