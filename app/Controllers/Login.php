<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }

    /**
     * Métoque que exibe a view de login
     */
    public function login()
    {
        $data = array(
            'title' => 'Login',
        );

        return view(APP_THEME . '/login/login', $data);
    }

    /**
     * Método que processa a autenticação no sistema
     */
    public function authenticate()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $return = [];
        $return['token'] = csrf_hash();

        $authentication = service('authentication');

        if ($authentication->login($email, $password) == false) {
            $return['error'] = 'Usuário ou senha incorretos!';
        } else {
            $userLogged = $authentication->getSessionUserData();

            if ($userLogged->active == false) {
                $return['error'] = 'Este usuário encontra-se inativo no sistema!';

                session()->destroy();
            }

            if ($userLogged->is_customer) {
                $return['redirect'] = 'ext/customer';   // Redirecionar para a Área de Clientes
            } else if ($userLogged->is_vendor) {
                $return['redirect'] = 'ext/vendor';     // Redirecionar para a Área de Fornecedores
            } else {
                $return['redirect'] = 'home';
            }
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que processa o logout no sistema
     */
    public function logout()
    {
        service('authentication')->logout();

        return redirect()->to(site_url('/login/logout_message'));
    }

    /**
     * Método que exibe a mensagem de logout
     */
    public function logout_message()
    {
        return redirect()->to(site_url('/login'));
    }

    /**
     * Método que exibe a view de Esqueci a Senha
     */
    public function forgot_password()
    {
        $data = array(
            'title' => 'Esqueci a Senha',
        );

        return view(APP_THEME . '/login/forgot', $data);
    }

    /**
     * Método que faz o processamento da operação de esqueci a senha
     */
    public function forgot_proccess()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $email = $this->request->getPost('email');

        $user = $this->userModel->findUserByEmail($email);

        if ($user === null) {
            $return['error'] = 'O e-mail informado não foi encontrado!';

            return $this->response->setJSON($return);
        } else if ($user->active === false) {
            $return['error'] = 'Este usuário está inativo no sistema!';

            return $this->response->setJSON($return);
        }

        $user->startPasswordReset();

        $this->userModel->save($user);

        $this->send_mail_forgot_password($user);

        $return['success'] = 'Instruções enviadas para o e-mail informado!';

        return $this->response->setJSON($return);
    }

    /**
     * Método que exibe a view de Reset de Senha
     */
    public function reset(string $token = null)
    {
        if ($token === null) {
            return redirect()->to(site_url('/login/forgot'))->with('message-warning', 'Link inválido ou expirado!1');
        }

        $user = $this->userModel->findUserByToken($token);

        if ($user === null) {
            return redirect()->to(site_url('/login/forgot'))->with('message-warning', 'Link inválido ou expirado!2');
        }

        $data = array(
            'title' => 'Redefina a Senha',
            'token' => $token,
        );

        return view(APP_THEME . '/login/reset', $data);
    }

    /**
     * Método que faz o processamento da operação de reset da senha
     */
    public function reset_proccess()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $return = [];
        $return['token'] = csrf_hash();

        $post = $this->request->getPost();

        $user = $this->userModel->findUserByToken($post['token']);

        if ($user === null) {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = ['invalid' => 'Link inválido ou expirado!'];

            return $this->response->setJSON($return);
        }

        $post['reset_hash'] = null;
        $post['reset_hash_expires'] = null;

        unset($post['token']);
        unset($post['csrf_test_name']);
        unset($post['password_confirmation']);

        $user->fill($post);

        if ($this->userModel->protect(false)->save($user)) {
            session()->setFlashdata('message-success', 'Senha atualizada com sucesso!');

            $return['success'] = 'Senha atualizada com sucesso!';
            $return['redirect'] = 'login';

            return $this->response->setJSON($return);
        }

        if ($this->userModel->errors()) {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->userModel->errors();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que envia o e-mail de redefinição de senha
     * 
     * @param object $user
     * @return void
     */
    private function send_mail_forgot_password(object $user): void
    {
        $data = array(
            'user' => $user,
        );

        $email = service('email');

        $email->setFrom('noreply@syscorp.com', 'SysCorp - 2024');
        $email->setTo($user->email);
        // $email->setCC('another@another-example.com');
        // $email->setBCC('them@their-example.com');

        $email->setSubject(APP_NAME . ' - ' . APP_VERSION . ' - [Recuperação de Senha]');

        $message = view('/layout/emails/forgot_password', $data);

        $email->setMessage($message);

        $email->send();
    }
}
