<?php

namespace App\Controllers;

use App\Traits\IntegrationsTrait;

class Home extends BaseController
{
    use IntegrationsTrait;

    public function index(): string
    {
        $data = array(
            'title' => 'Home',
            'barcode' => $this->barcode(),
        );

        return view(APP_THEME . '/dashboards/index', $data);
    }

    public function dynamicRoute()
    {
        $auth = new \App\Libraries\Authentication();
        $user = userIsLogged();

        if ($user->is_admin) {
            // return $this->index();
            $dashboardController = new \App\Controllers\DashboardFinanceiro();
            return $dashboardController->index();
        } elseif ($user->is_finance) {
            $dashboardController = new \App\Controllers\DashboardFinanceiro();
            return $dashboardController->index();
        } elseif ($user->is_vendor) {
            // Adicione o controller de vendor quando criar
            return $this->index(); 
        }

        return $this->index();
    }

    public function testeCEP()
    {
        $cep = '13040-108';

        return $this->response->setJSON($this->apiViaCep($cep));
    }

    public function barcode()
    {
        // Make Barcode object of Code128 encoding.
        $barcode = (new \Picqer\Barcode\Types\TypeEan13())->getBarcode('081231723897');
        // Output the barcode as HTML in the browser with a HTML Renderer
        $renderer = new \Picqer\Barcode\Renderers\HtmlRenderer();

        return $renderer->render($barcode);
    }

    public function email()
    {
        $email = service('email');

        $email->setFrom('noreply@syscorp.com', 'SysCorp - 2024');
        $email->setTo('rv_santos@msn.com');
        // $email->setCC('another@another-example.com');
        // $email->setBCC('them@their-example.com');

        $email->setSubject('SysCorp - 2024 - [Recuperação de Senha]');
        $email->setMessage('Recuperação de Senha do Sistema SysCorp - 2024');

        if ($email->send()) {
            echo 'E-mail enviado com sucesso!';
        } else {
            echo $email->printDebugger();
        }
    }
}
