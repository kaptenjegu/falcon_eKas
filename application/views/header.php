<!DOCTYPE html>
<html lang="en">
<?php date_default_timezone_set('Asia/Jakarta'); ?>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>e Kas Falcon Prima Tehnik</title>

  <!-- Custom fonts for this template-->
  <link href="<?= base_url() ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="<?= base_url() ?>vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url() ?>vendor/css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="<?= base_url() ?>">e-Kas Falcon Prima Tehnik</a>

    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></div>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item <?php if($page == 'Dashboard'){echo 'active';} ?>">
        <a class="nav-link" href="<?= base_url('Dashboard') ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      
      <li class="nav-item <?php if($page == 'Kas' OR $page == 'Kas_bulan' OR $page == 'Kas_breakdown'){echo 'active';} ?>">
        <a class="nav-link" href="<?= base_url('Kas') ?>">
          <i class="fas fa-fw fa-table"></i>
          <span>Data Kas</span></a>
      </li>
      
      <li class="nav-item <?php if($page == 'Laporan'){echo 'active';} ?>">
        <a class="nav-link" href="<?= base_url('Laporan') ?>">
          <i class="fas fa-fw fa-print"></i>
          <span>Laporan</span></a>
      </li>
    </ul>

    <div id="content-wrapper">

      