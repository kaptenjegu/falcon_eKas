<!DOCTYPE html>
<html lang="en">
<?php date_default_timezone_set('Asia/Jakarta'); ?>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SMA Falcon Prima Tehnik</title>
  <link rel="icon" type="image/x-icon" href="<?= base_url() ?>vendor/image/logo1.png">
  <!-- Custom fonts for this template-->
  <link href="<?= base_url() ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="<?= base_url() ?>vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url() ?>vendor/css/sb-admin.css" rel="stylesheet">



</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="<?= base_url() ?>">Sistem Manajemen Administrasi</a>

    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></div>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?= $_SESSION['nama_user'] . ' - ' . get_lokasi() ?> <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="<?= base_url('Login/keluar/') ?>">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">

      <li class="nav-item dropdown <?php if ($page == 'Kas' or $page == 'Kas_bulan' or $page == 'Kas_breakdown' or $page == 'Kas_voucher' or $page == 'Tipe') {
                                      echo 'show';
                                    } ?>">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="<?php if ($page == 'Kas' or $page == 'Kas_bulan' or $page == 'Kas_breakdown' or $page == 'Kas_voucher' or $page == 'Tipe') {
                                                                                                                                                    echo 'true';
                                                                                                                                                  } else {
                                                                                                                                                    echo 'false';
                                                                                                                                                  } ?>">
          <i class="fas fa-fw fa-table"></i>
          <span>KAS</span>
        </a>
        <div class="dropdown-menu <?php if ($page == 'Kas' or $page == 'Kas_bulan' or $page == 'Kas_breakdown' or $page == 'Kas_voucher' or $page == 'Tipe') {
                                    echo 'show';
                                  } ?>" aria-labelledby="pagesDropdown">
          <a class="dropdown-item <?php if ($page == 'Kas' or $page == 'Kas_bulan' or $page == 'Kas_breakdown' or $page == 'Kas_voucher') {
                                    echo 'active';
                                  } ?>" href="<?= base_url('Kas') ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Data Kas</span>
          </a>
          <a class="dropdown-item <?php if ($page == 'Tipe') {
                                    echo 'active';
                                  } ?>" href="<?= base_url('Tipe') ?>">
            <i class="fas fa-fw fa-tag"></i>
            <span>Data Tipe Kas</span>
          </a>
        </div>
      </li>

      <li class="nav-item dropdown <?php if ($page == 'Srmr' or $page == 'srmr_manage' or $page == 'Riwayat_srmr') {
                                      echo 'show';
                                    } ?>">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="<?php if ($page == 'Srmr' or $page == 'srmr_manage' or $page == 'Riwayat_srmr') {
                                                                                                                                                    echo 'true';
                                                                                                                                                  } else {
                                                                                                                                                    echo 'false';
                                                                                                                                                  } ?>">
          <i class="fas fa-fw fa-luggage-cart"></i>
          <span>Procurement</span>
        </a>
        <div class="dropdown-menu <?php if ($page == 'Srmr' or $page == 'srmr_manage' or $page == 'Riwayat_srmr') {
                                    echo 'show';
                                  } ?>" aria-labelledby="pagesDropdown">
          <a class="dropdown-item <?php if ($page == 'Srmr' or $page == 'srmr_manage') {
                                    echo 'active';
                                  } ?>" href="<?= base_url('Srmr') ?>">
            <i class="fas fa-fw fa-cart-plus"></i>
            <span>SR || MR</span>
          </a>
          <a class="dropdown-item <?php if ($page == 'Riwayat_srmr') {
                                    echo 'active';
                                  } ?>" href="<?= base_url('Riwayat_srmr') ?>">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Riwayat SR || MR</span>
          </a>
        </div>
      </li>
      <?php if (cek_permission($_SESSION['id_akun'], 'aset') == true) { ?>
        <li class="nav-item dropdown <?php if ($page == 'Asset' or $page == 'Pinjam_aset') {
                                        echo 'show';
                                      } ?>">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="<?php if ($page == 'Srmr' or $page == 'srmr_manage' or $page == 'Riwayat_srmr') {
                                                                                                                                                      echo 'true';
                                                                                                                                                    } else {
                                                                                                                                                      echo 'false';
                                                                                                                                                    } ?>">
            <i class="fas fa-fw fa-cubes"></i>
            <span>Manajemen Aset</span>
          </a>
          <div class="dropdown-menu <?php if ($page == 'Asset' or $page == 'Pinjam' or $page == 'Pengembalian') {
                                      echo 'show';
                                    } ?>" aria-labelledby="pagesDropdown">
            <a class="dropdown-item <?php if ($page == 'Asset') {
                                      echo 'active';
                                    } ?>" href="<?= base_url('Asset') ?>">
              <i class="fas fa-fw fa-cubes"></i>
              <span>Data Aset</span>
            </a>
            <a class="dropdown-item <?php if ($page == 'Pinjam') {
                                      echo 'active';
                                    } ?>" href="<?= base_url('Pinjam') ?>">
              <i class="fas fa-fw fa-exchange-alt"></i>
              <span>Data Pinjam</span>
            </a>
            <a class="dropdown-item <?php if ($page == 'Pengembalian') {
                                      echo 'active';
                                    } ?>" href="<?= base_url('Pengembalian') ?>">
              <i class="fas fa-fw fa-exchange-alt"></i>
              <span>Data Pengembalian</span>
            </a>
          </div>
        </li>
      <?php } ?>
    </ul>

    <div id="content-wrapper">