<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <title>Aplikasi UTD PMI</title>

    <!-- Favicons -->
    <link href="<?= base_url('/assets/img/logo.png') ?>" rel="icon">

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('/assets/lib/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!--external css-->
    <link href="<?= base_url('/assets/lib/font-awesome/css/font-awesome.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('/assets/css/zabuto_calendar.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('/assets/lib/gritter/css/jquery.gritter.css') ?>" />
    <!-- Custom styles for this template -->
    <link href="<?= base_url('/assets/css/style.css') ?>" rel="stylesheet">
    <link href="<?= base_url('/assets/css/style-responsive.css') ?>" rel="stylesheet">
    <script src="<?= base_url('/assets/lib/chart-master/Chart.js') ?>"></script>
</head>

<body>
    <section id="container">
        <!--header start-->
        <header class="header black-bg">
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <!--logo start-->
            <a href="<?= base_url() ?>" class="logo"><b>UTD <span>PALANG MERAH INDONESIA</span></b></a>
            <!--logo end-->
        </header>
        <!--header end-->
        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse ">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu" id="nav-accordion">
                    <!-- <p class="centered"><a href="profile.html"><img src="<?= base_url('/assets/img/ui-sam.jpg') ?>" class="img-circle" width="80"></a></p> -->
                    <h5 class="centered"><?= $this->nama ?></h5>
                    <li class="mt">
                        <a class="<?= $this->Model->getPage('pmi') ?>" href="<?= base_url('pmi/') ?>">
                            <i class="fa fa-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a class="<?= $this->Model->getPage('pendonor') ?>" href="<?= base_url('pmi/pendonor') ?>">
                            <i class="fa fa-user"></i>
                            <span>Data Pendonor</span>
                        </a>
                    </li>
                    <li>
                        <a class="<?= $this->Model->getPage('stok') ?>" href="<?= base_url('pmi/stok') ?>">
                            <i class="fa fa-tint"></i>
                            <span>Data Stok Darah</span>
                        </a>
                    </li>
                    <li>
                        <a class="<?= $this->Model->getPage('permintaan') ?>" href="<?= base_url('pmi/permintaan') ?>">
                            <i class="fa fa-shopping-cart"></i>
                            <span>Permintaan Darah</span>
                            <span class="label label-danger pull-right mail-info"><?= $this->notifikasi == '0' ? '' : $this->notifikasi ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="<?= $this->Model->getPage('laporan') ?>" href="<?= base_url('pmi/laporan') ?>">
                            <i class="fa fa-print"></i>
                            <span>Laporan</span>
                        </a>
                    </li>
                    <hr>
                    <li class="mt">
                        <a href="<?= base_url('logout') ?>">
                            <i class="fa fa-sign-out"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->