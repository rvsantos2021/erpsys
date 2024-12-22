<?php

namespace App\Libraries;

class Authentication
{
    private $user;
    private $userModel;
    private $userGroupModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
        $this->userGroupModel = new \App\Models\UserGroupModel();
    }

    /**
     * Método que seta os dados da sessão do usuário logado
     * 
     * @param object $user
     * @return void
     */
    private function setLoggedUserData(object $user): void
    {
        $session = session();

        $session->regenerate();
        //$_SESSION['__ci_last_regenerate'] = time();

        $session->set('user_id', $user->id);
    }

    /**
     * Método que recupera as permissões do usuário logado
     * 
     * @return array|null
     */
    private function getLoggedUserPermissions()
    {
        $users_permissions = $this->userModel->getLoggedUserPermissions(session()->get('user_id'));

        return array_column($users_permissions, 'permission');
    }

    /**
     * Método que seta as permissões do usuário logado
     * 
     * @param object $user
     * @return object
     */
    private function setLoggedUserPermissions(object $user)
    {
        $user->is_admin = $this->isAdmin();

        if ($user->is_admin == true) {
            $user->is_customer = false;
            $user->is_vendor = false;
        } else {
            $user->is_customer = $this->isCustomer();
            $user->is_vendor = $this->isVendor();
        }

        if (($user->is_admin == false) && ($user->is_customer == false) && ($user->is_vendor == false)) {
            $user->permissions = $this->getLoggedUserPermissions();
        }

        return $user;
    }

    /**
     * Método que recupera os dados da sessão
     * 
     * @return object|null
     */
    public function getSessionUserData()
    {
        if (session()->has('user_id') == false) {
            return null;
        }

        $user = $this->userModel->find(session()->get('user_id'));

        // if (($user == null) || ($user->active == false)) {
        if ($user == null) {
            return null;
        }

        $user = $this->setLoggedUserPermissions($user);

        return $user;
    }

    /**
     * Mètodo que realiza o login na aplicação
     * 
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function login(string $email, string $password): bool
    {
        $user = $this->userModel->findUserByEmail($email);

        if ($user === null) {
            return false;
        }

        if ($user->verifyPassword($password) == false) {
            return false;
        }

        // if ($user->active == false) {
        //     return false;
        // }

        $this->setLoggedUserData($user);

        return true;
    }

    /**
     * Método que realizada o logout da aplicação
     * 
     * @return void
     */
    public function logout(): void
    {
        session()->destroy();
    }

    /**
     * Método que recupera os dados do usuário logado
     * 
     * @return object|null
     */
    public function getLoggedUserData()
    {
        if ($this->user === null) {
            $this->user = $this->getSessionUserData();
        }

        return $this->user;
    }

    /**
     * Método que verifica se o usuário está logado
     * 
     * @return bool
     */
    public function isLogged(): bool
    {
        return $this->getLoggedUserData() != null;
    }

    /**
     * Método que verifica se o usuário logado é um admin
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        $admin_group = 1;

        $admin = $this->userGroupModel->userIsInGroup($admin_group, session()->get('user_id'));

        if ($admin == null) {
            return false;
        }

        return true;
    }

    /**
     * Método que verifica se o usuário logado é um cliente
     * 
     * @return bool
     */
    public function isCustomer(): bool
    {
        $cust_group = 2;

        $customer = $this->userGroupModel->userIsInGroup($cust_group, session()->get('user_id'));

        if ($customer == null) {
            return false;
        }

        return true;
    }

    /**
     * Método que verifica se o usuário logado é um fornecedor
     * 
     * @return bool
     */
    public function isVendor(): bool
    {
        $vendor_group = 3;

        $vendor = $this->userGroupModel->userIsInGroup($vendor_group, session()->get('user_id'));

        if ($vendor == null) {
            return false;
        }

        return true;
    }
}
