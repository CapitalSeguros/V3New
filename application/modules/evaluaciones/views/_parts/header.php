<!DOCTYPE html>

<head lang="es">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--<link rel="shortcut icon" href="images/favicon.ico">-->

    <?= link_tag('assets/img/icon.png', 'apple-touch-icon-precomposed'); ?>
    <?= link_tag('assets/img/icon.png', 'shortcut icon'); ?>
    <title><?= $title ?></title>

    <!-- Viculamos los Estilos CSS -->
    <link href="<?= base_url(DIR_ASSETS . 'css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url(DIR_ASSETS . 'css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url(DIR_ASSETS . 'css/cap.css') ?>" rel="stylesheet" />
    <link href="<?= base_url(DIR_ASSETS . 'css/menu.css') ?>" rel="stylesheet" />
    <link href="<?= base_url(DIR_ASSETS . 'css/jquery-ui.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url(DIR_ASSETS . 'css/toastr.min.css') ?>" rel="stylesheet" />

    <link href="<?= base_url(DIR_ASSETS . 'css/nprogress.css') ?>" rel="stylesheet" />
    <!-- JS -->
    <script src="<?= base_url(DIR_ASSETS . 'js/jquery-3.4.1.min.js') ?>" type="text/javascript"></script>
    <script src="<?= site_url(DIR_ASSETS . 'js/jquery-ui.min.js'); ?>"></script>
    <!-- <script src="<?= site_url('assets/js/bootstrap-datepicker.min.js'); ?>"></script> -->
    <!-- <script src="<?= site_url('assets/js/locales/bootstrap-datepicker.es.min.js'); ?>"></script> -->
    <script src="<?= base_url(DIR_ASSETS . 'js/toastr.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url(DIR_ASSETS . 'js/sweetalert.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url(DIR_ASSETS . 'js/pace.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url(DIR_ASSETS . 'js/moment.min.js') ?>"></script>
    <script src="<?= base_url(DIR_ASSETS . 'js/lodash.min.js') ?>"></script>
    <?php if (isset($_scripts)) {
        foreach ($_scripts as $value) {
            echo $value;
        }
    }
    ?>
</head>

<body>
    <!--:::::::::: INICIO HEADER ::::::::::-->
    <header class="header-cap hidden-print">
        <div class="container-fluid">
            <div class="capsys-logotipo pull-left">
                <a href="./" class="navbar-brand" title="CAPSYS V3">
                    <img src="<?= base_url(DIR_ASSETS . 'images/logo.png') ?>" alt="CAPSYS">
                </a>
            </div>
            <ul class="user-perfil pull-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="usuario-nombre"><?= $this->tank_auth->get_usermail(); ?></span>
                        <i class="caret"></i>
                        <div class="user-perfil-extra hidden-xs">
                            <p><?= $this->tank_auth->get_usernamecomplete(); ?></p>
                        </div>
                        <img src="<?= DIR_IMAGES ?>images/default-Avatar.jpg" alt="<?= $this->tank_auth->get_usernamecomplete(); ?>" class="img-circle">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-perfil">
                        <li><a href="<?= base_url() . "miInfo" ?>" title="Perfil"><i class="fa fa-user"></i> Perfil</a></li>
                        <li><a href="<?= base_url() . "auth/logout" ?>" title="Salir"><i class="fa fa-sign-out"></i> Salir</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <nav class="navbar navbar-default">
            <div class="container-fluid menu-navbar">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <?php $this->load->view('_parts/menu') ?>
                </div>
            </div>
        </nav>
    </header>

    <section class="main">