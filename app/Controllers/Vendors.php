<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Traits\IntegrationsTrait;

class Vendors extends BaseController
{
    use IntegrationsTrait;

    public function buscarCep()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $cep = $this->request->getGet('cep');

        return $this->response->setJSON($this->apiViaCep($cep));
    }
}
