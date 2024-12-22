<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $this->renderSection('title') ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>" class="csrf">
    <!-- app favicon -->
    <link rel="shortcut icon" href="<?= site_url('mentor/assets/'); ?>img/favicon.ico">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- plugin stylesheets -->
    <link rel="stylesheet" type="text/css" href="<?= site_url('mentor/assets/'); ?>css/vendors.css" />
    <!-- app style -->
    <link rel="stylesheet" type="text/css" href="<?= site_url('mentor/assets/'); ?>css/style.css" />
    <!-- custom style -->
    <link rel="stylesheet" type="text/css" href="<?= site_url('mentor/assets/'); ?>css/custom.css" />
    <?= $this->renderSection('styles') ?>
</head>

<body>
    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
        <div class="app-wrap">
            <!-- begin pre-loader -->
            <div class="loader">
                <div class="h-100 d-flex justify-content-center">
                    <div class="align-self-center">
                        <img src="<?= site_url('mentor/assets/'); ?>img/loader/loader.svg" alt="loader">
                    </div>
                </div>
            </div>
            <!-- end pre-loader -->
            <!-- begin app-header -->
            <?= $this->include('mentor/layout/_header'); ?>
            <!-- end app-header -->
            <!-- begin app-container -->
            <div class="app-container">
                <!-- begin app-nabar -->
                <aside class="app-navbar">
                    <!-- begin sidebar-nav -->
                    <?= $this->include('mentor/layout/_sidebar-nav'); ?>
                    <!-- end sidebar-nav -->
                </aside>
                <!-- end app-navbar -->
                <!-- begin app-main -->
                <div class="app-main" id="main">
                    <!-- begin container-fluid -->
                    <div class="container-fluid">
                        <!-- begin row -->
                        <div class="row">
                            <div class="col-md-12 m-b-30">
                                <!-- begin page title -->
                                <div class="d-block d-sm-flex flex-nowrap align-items-center">
                                    <div class="page-title mb-2 mb-sm-0">
                                        <h1><?= $title; ?></h1>
                                    </div>
                                    <div class="ml-auto d-flex align-items-center">
                                        <nav>
                                            <ol class="breadcrumb p-0 m-b-0">
                                                <li class="breadcrumb-item">
                                                    <a href="<?= site_url('/home'); ?>"><i class="ti ti-home"></i></a>
                                                </li>
                                                <?php if (isset($menu)) { ?>
                                                    <li class="breadcrumb-item">
                                                        <?= $menu; ?>
                                                    </li>
                                                <?php } ?>
                                                <?php if (isset($submenu)) { ?>
                                                    <li class="breadcrumb-item">
                                                        <?= $submenu; ?>
                                                    </li>
                                                <?php } ?>
                                                <li class="breadcrumb-item active text-primary" aria-current="page">
                                                    <?= $title; ?>
                                                </li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                                <!-- end page title -->
                            </div>
                        </div>
                        <!-- end row -->
                        <?= $this->renderSection('content') ?>
                        <!-- end container-fluid -->
                    </div>
                    <!-- end app-main -->
                </div>
                <!-- end app-container -->
                <!-- begin footer -->
                <footer class="footer">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-left">
                            <p>&copy; Copyright <?= date('Y'); ?>. Todos os direitos reservados</p>
                        </div>
                        <div class="col col-sm-6 ml-sm-auto text-center text-sm-right">
                            <p>Desenvolvido por <a href="https://prsystem.com.br" target="_blank">PRSystem - Sistemas Inteligentes</a></p>
                        </div>
                    </div>
                </footer>
                <!-- end footer -->
            </div>
            <!-- end app-wrap -->
        </div>
    </div>
    <!-- end app -->

    <!-- plugins -->
    <script src="<?= site_url('mentor/assets/'); ?>js/vendors.js"></script>
    <!-- custom app -->
    <script src="<?= site_url('mentor/assets/'); ?>js/app.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>