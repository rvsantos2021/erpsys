<!doctype html>
<html class="fixed sidebar-left-collapsed">

<head>
    <!-- Basic -->
    <meta charset="UTF-8">
    <title><?php echo $this->renderSection('title') ?></title>
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>" class="csrf">
    <!-- Web Fonts  -->
    <link href="<?php echo site_url('assets/'); ?>stylesheets/fonts.css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>vendor/bootstrap-datepicker/css/datepicker3.css" />
    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>vendor/select2/select2.css" />
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>vendor/morris/morris.css" />
    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>stylesheets/theme.css" />
    <!-- Skin CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>stylesheets/skins/default.css" />
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="<?php echo site_url('assets/'); ?>stylesheets/theme-custom.css">
    <!-- Head Libs -->
    <script src="<?php echo site_url('assets/'); ?>vendor/modernizr/modernizr.js"></script>
    <?php echo $this->renderSection('styles') ?>
</head>

<body>
    <section class="body">
        <!-- start: header -->
        <?= $this->include('layout/_header'); ?>
        <!-- end: header -->
        <div class="inner-wrapper">
            <!-- start: sidebar -->
            <?= $this->include('layout/_sidebar-left'); ?>
            <!-- end: sidebar -->
            <section role="main" class="content-body">
                <header class="page-header">
                    <h2><?php echo $title; ?></h2>
                    <div class="right-wrapper pull-right">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="<?php echo site_url('/home'); ?>">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <?php if (isset($menu)) { ?>
                                <li><span><?php echo $menu; ?></span></li>
                            <?php } ?>
                            <?php if (isset($submenu)) { ?>
                                <li><span><?php echo $submenu; ?></span></li>
                            <?php } ?>
                            <li><span><?php echo $title; ?></span></li>
                        </ol>
                        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
                    </div>
                </header>
                <!-- start: page -->
                <?php echo $this->renderSection('content') ?>
                <!-- end: page -->
            </section>
        </div>
        <?= $this->include('layout/_sidebar-right'); ?>
    </section>
    <!-- Vendor -->
    <script src="<?php echo site_url('assets/'); ?>vendor/jquery/jquery.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/nanoscroller/nanoscroller.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/magnific-popup/magnific-popup.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jquery-placeholder/jquery.placeholder.js"></script>
    <!-- Specific Page Vendor -->
    <script src="<?php echo site_url('assets/'); ?>vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jquery-appear/jquery.appear.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/select2/select2.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
    <!-- <script src="<?php echo site_url('assets/'); ?>vendor/jquery-easypiechart/jquery.easypiechart.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/flot/jquery.flot.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/flot/jquery.flot.pie.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/flot/jquery.flot.categories.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/flot/jquery.flot.resize.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jquery-sparkline/jquery.sparkline.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/raphael/raphael.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/morris/morris.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/gauge/gauge.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/snap-svg/snap.svg.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/liquid-meter/liquid.meter.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jqvmap/jquery.vmap.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jqvmap/maps/jquery.vmap.world.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script> -->
    <script src="<?php echo site_url('assets/'); ?>vendor/sweetalert2/sweetalert2.js"></script>
    <!-- Theme Base, Components and Settings -->
    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
    <!-- Theme Custom -->
    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.custom.js"></script>
    <!-- Theme Initialization Files -->
    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
    <!-- Examples -->
    <!-- <script src="<?php echo site_url('assets/'); ?>javascripts/dashboard/examples.dashboard.js"></script> -->
    <?php echo $this->renderSection('scripts') ?>
</body>

</html>