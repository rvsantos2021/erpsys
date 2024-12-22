<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo APP_NAME.' - '.APP_VERSION.' - '.$title; ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- app favicon -->
    <link rel="shortcut icon" href="<?php echo site_url('mentor/assets/'); ?>img/favicon.ico">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- plugin stylesheets -->
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('mentor/assets/'); ?>css/vendors.css" />
    <!-- app style -->
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('mentor/assets/'); ?>css/style.css" />
</head>

<body class="bg-white">
    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
        <div class="app-wrap">
            <!-- begin pre-loader -->
            <div class="loader">
                <div class="h-100 d-flex justify-content-center">
                    <div class="align-self-center">
                        <img src="<?php echo site_url('mentor/assets/'); ?>img/loader/loader.svg" alt="loader">
                    </div>
                </div>
            </div>
            <!-- end pre-loader -->

            <!--start login contant-->
            <div class="app-contant">
                <div class="bg-white">
                    <div class="container-fluid p-0">
                        <div class="row no-gutters">
                            <div class="col-sm-6 col-lg-5 col-xxl-3  align-self-center order-2 order-sm-1">
                                <div class="d-flex align-items-center h-100-vh">
                                    <div class="login p-50">
                                        <h1 class="mb-2"><?php echo APP_NAME.' - '.APP_VERSION; ?></h1>
                                        <p>Bem-vindo de volta. Informe seus dados de acesso.</p>
                                        <?php echo form_open('/', ['id' => 'signInForm', 'class' => 'mt-3 mt-sm-5 form-validate']); ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="control-label">Usuário*</label>
                                                    <input name="email" type="email" class="form-control" placeholder="usuario@email.com.br" autocomplete="email" autofocus required />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="control-label">Senha*</label>
                                                    <input name="password" type="password" class="form-control" placeholder="******" autocomplete="current-password" required />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-block d-sm-flex align-items-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="gridCheck">
                                                        <label class="form-check-label" for="gridCheck">
                                                            Lembrar-me
                                                        </label>
                                                    </div>
                                                    <a href="<?php echo site_url('login/forgot'); ?>" class="ml-auto">Esqueci a senha?</a>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <button type="submit" class="btn btn-primary fixed-button-width btn-login">Entrar</button>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <p>Não tem cadastro?<a href="#"> Registrar</a></p>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div id="response"></div>
                                                <?php echo $this->include('/mentor/layout/_messages'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-9 col-lg-7 bg-gradient o-hidden order-1 order-sm-2">
                                <div class="row align-items-center h-100">
                                    <div class="col-7 mx-auto ">
                                        <img class="img-fluid" src="<?php echo site_url('mentor/assets/'); ?>img/bg/login.svg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end login contant-->
        </div>
        <!-- end app-wrap -->
    </div>
    <!-- end app -->

    <!-- plugins -->
    <script src="<?php echo site_url('mentor/assets/'); ?>js/vendors.js"></script>
    <!-- custom app -->
    <script src="<?php echo site_url('mentor/assets/'); ?>js/app.js"></script>
    <!-- login app -->
    <script src="<?php echo site_url('mentor/assets/'); ?>js/login.js"></script>
</body>

</html>