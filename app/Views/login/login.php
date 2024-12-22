<!doctype html>
<html class="fixed">

<head>
    <!-- Basic -->
    <meta charset="UTF-8">
    <title><?php echo APP_NAME . ' - ' . APP_VERSION . ' - ' . $title; ?></title>
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Web Fonts  -->
    <link href="<?php echo site_url('assets/'); ?>stylesheets/fonts.css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>vendor/bootstrap-datepicker/css/datepicker3.css" />
    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>stylesheets/theme.css" />
    <!-- Skin CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>stylesheets/skins/default.css" />
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>stylesheets/theme-custom.css">
    <!-- Head Libs -->
    <script src="<?php echo site_url('assets/'); ?>vendor/modernizr/modernizr.js"></script>
</head>

<body>
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- start: page -->
    <section class="body-sign loaded">
        <div class="center-sign">
            <a href="#" class="logo pull-left">
                <img src="<?php echo site_url('assets/'); ?>images/<?php echo APP_LOGOBAR; ?>" height="50" style="margin-top: 17px" alt="" />
            </a>
            <div class="panel panel-sign">
                <div class="panel-title-sign mt-xl text-right">
                    <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Entrar</h2>
                </div>
                <div class="panel-body">
                    <?php echo form_open('/', ['id' => 'signInForm', 'class' => 'form-validate']) ?>
                    <div class="form-group mb-lg">
                        <label>Usuário</label>
                        <div class="input-group input-group-icon">
                            <input name="email" type="email" class="form-control input-lg" placeholder="usuario@email.com.br" autocomplete="email" autofocus required />
                            <span class="input-group-addon">
                                <span class="icon icon-lg">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group mb-lg">
                        <div class="clearfix">
                            <label class="pull-left">Senha</label>
                            <a href="<?php echo site_url('login/forgot'); ?>" class="pull-right">Esqueceu a senha?</a>
                        </div>
                        <div class="input-group input-group-icon">
                            <input name="password" type="password" class="form-control input-lg" placeholder="******" autocomplete="current-password" required />
                            <span class="input-group-addon">
                                <span class="icon icon-lg">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="checkbox-custom checkbox-default">

                            </div>
                        </div>
                        <div class="col-sm-4 text-right">
                            <button type="submit" class="btn btn-warning fixed-button-width hidden-xs btn-login">Entrar</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                    <hr>
                    <div class="row">
                        <div class=" col-sm-12">
                            <div id="response"></div>
                            <?php echo $this->include('layout/_messages'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-center text-muted mt-md mb-md">
                &copy; Copyright <?php echo date('Y'); ?>. Desenvolvido por <a href="https://prsystem.com.br" target="_blank">PRSystem</a>.
            </p>
        </div>
    </section>
    <!-- end: page -->

    <!-- Vendor -->
    <script src="<?php echo site_url('assets/'); ?>vendor/jquery/jquery.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/nanoscroller/nanoscroller.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/magnific-popup/magnific-popup.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jquery-placeholder/jquery.placeholder.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jquery-validation/jquery.validate.js"></script>
    <!-- Theme Base, Components and Settings -->
    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
    <!-- Theme Custom -->
    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.custom.js"></script>
    <!-- Theme Initialization Files -->
    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
    <!-- login app -->
    <script src="<?php echo site_url('assets/'); ?>javascripts/login.js"></script>
</body>

</html>