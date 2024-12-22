<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo APP_NAME . ' - ' . APP_VERSION . ' - ' . $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('styles'); ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<?php echo $this->include('layout/_messages'); ?>
<?php
// $authentication = service('authentication');

// if ($authentication->login('ricardo.santos@prsystem.com.br', 'unidax') == false) {
//     $return['error'] = 'Verifique suas credenciais e tente novamente!';
// }

// $userLogged = $authentication->getSessionUserData();

// echo '<br>';
// echo 'User: ' . $userLogged->name;
// echo '<br>';
// echo 'active: ' . $userLogged->active;
// echo '<br>';
// echo 'is_admin: ' . $userLogged->is_admin;
// echo '<br>';
// $session = session();
// echo $session->get('_ci_previous_url');
// echo '<br>';
// echo $barcode;
?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<?php echo $this->endSection(); ?>