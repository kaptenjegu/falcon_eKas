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
  <script src="https://cdn.tiny.cloud/1/hxe5np4d3ld28isormowwrrr0xev1iy3o8jwliwk35rwi6va/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

  <style>
    .autocomplete-suggestions {
      border: 1px solid #999;
      background: #FFF;
      overflow: auto;
    }

    .autocomplete-suggestion {
      padding: 2px 5px;
      white-space: nowrap;
      overflow: hidden;
    }

    .autocomplete-selected {
      background: #F0F0F0;
    }

    .autocomplete-suggestions strong {
      font-weight: normal;
      color: #3399FF;
    }

    .autocomplete-group {
      padding: 2px 5px;
    }

    .autocomplete-group strong {
      display: block;
      border-bottom: 1px solid #000;
    }
  </style>



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

      <li class="nav-item dropdown <?php if ($page == 'Kas' or $page == 'Kas_bulan' or $page == 'Kas_breakdown' or $page == 'Kas_voucher' or $page == 'Tipe' or $page == 'Bpjs') {
                                      echo 'show';
                                    } ?>">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="<?php if ($page == 'Kas' or $page == 'Kas_bulan' or $page == 'Kas_breakdown' or $page == 'Kas_voucher' or $page == 'Tipe'  or $page == 'Bpjs') {
                                                                                                                                                    echo 'true';
                                                                                                                                                  } else {
                                                                                                                                                    echo 'false';
                                                                                                                                                  } ?>">
          <i class="fas fa-fw fa-table"></i>
          <span>KAS</span>
        </a>
        <div class="dropdown-menu <?php if ($page == 'Kas' or $page == 'Kas_bulan' or $page == 'Kas_breakdown' or $page == 'Kas_voucher' or $page == 'Tipe' or $page == 'Report_kas_periode' or $page == 'Bpjs') {
                                    echo 'show';
                                  } ?>" aria-labelledby="pagesDropdown">
          <a class="dropdown-item <?php if ($page == 'Kas' or $page == 'Kas_bulan' or $page == 'Kas_breakdown' or $page == 'Kas_voucher') {
                                    echo 'active';
                                  } ?>" href="<?= base_url('Kas') ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Data Kas</span>
          </a>
          <!--a class="dropdown-item <?php if ($page == 'Bpjs') {
                                    echo 'active';
                                  } ?>" href="<?= base_url('Bpjs') ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Data BPJS</span>
          </a-->
          <a class="dropdown-item <?php if ($page == 'Tipe') {
                                    echo 'active';
                                  } ?>" href="<?= base_url('Tipe') ?>">
            <i class="fas fa-fw fa-tag"></i>
            <span>Data Tipe Kas</span>
          </a>
          <a class="dropdown-item <?php if ($page == 'Report_kas_periode') {
                                    echo 'active';
                                  } ?>" href="<?= base_url('Kas/Report_kas_periode') ?>">
            <i class="fas fa-fw fa-download"></i>
            <span>Report Periode</span>
          </a>
        </div>
      </li>

      <li class="nav-item dropdown <?php if ($page == 'Tender' or $page == 'Tender_manage' or $page == 'Riwayat_tender') {
                                      echo 'show';
                                    } ?>">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="<?php if ($page == 'Tender' or $page == 'Tender_manage' or $page == 'Riwayat_tender') {
                                                                                                                                                    echo 'true';
                                                                                                                                                  } else {
                                                                                                                                                    echo 'false';
                                                                                                                                                  } ?>">
          <i class="fas fa-fw fa-fax"></i>
          <span>Marketing</span>
        </a>
        <div class="dropdown-menu <?php if ($page == 'Tender' or $page == 'Tender_manage' or $page == 'Riwayat_tender') {
                                    echo 'show';
                                  } ?>" aria-labelledby="pagesDropdown">
          <a class="dropdown-item <?php if ($page == 'Tender' or $page == 'Tender_manage') {
                                    echo 'active';
                                  } ?>" href="<?= base_url('Tender') ?>">
            <i class="fas fa-fw fa-handshake"></i>
            <span>Tender</span>
          </a>
          <a class="dropdown-item <?php if ($page == 'Riwayat_tender') {
                                    echo 'active';
                                  } ?>" href="<?= base_url('Tender/riwayat/') ?>">
            <i class="fas fa-fw fa-list"></i>
            <span>Riwayat Tender</span>
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

      <li class="nav-item dropdown <?php if ($page == 'Monitoring_bayar' or $page == 'Monitoring_riwayat_bayar') {
                                      echo 'show';
                                    } ?>">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="<?php if ($page == 'Monitoring_bayar' or $page == 'Monitoring_riwayat_bayar') {
                                                                                                                                                    echo 'true';
                                                                                                                                                  } else {
                                                                                                                                                    echo 'false';
                                                                                                                                                  } ?>">
          <i class="fas fa-fw fa-money-bill"></i>
          <span>Monitoring Bayar</span>
        </a>
        <div class="dropdown-menu <?php if ($page == 'Monitoring_bayar' or $page == 'Monitoring_riwayat_bayar') {
                                    echo 'show';
                                  } ?>" aria-labelledby="pagesDropdown">
          <a class="dropdown-item <?php if ($page == 'Monitoring_bayar') {
                                    echo 'active';
                                  } ?>" href="<?= base_url('Monitoring_bayar') ?>">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Data PO / SO</span>
          </a>
          <a class="dropdown-item <?php if ($page == 'Monitoring_riwayat_bayar') {
                                    echo 'active';
                                  } ?>" href="<?= base_url('Monitoring_bayar/riwayat/') ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Riwayat</span>
          </a>
        </div>
      </li>

      <li class="nav-item dropdown <?php if ($page == 'Esp32' or $page == 'User_esp') {
                                      echo 'show';
                                    } ?>">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="<?php if ($page == 'Esp32' or $page == 'User_esp') {
                                                                                                                                                    echo 'true';
                                                                                                                                                  } else {
                                                                                                                                                    echo 'false';
                                                                                                                                                  } ?>">
          <i class="fas fa-fw fa-cloud"></i>
          <span>Monitoring ESP</span>
        </a>
        <div class="dropdown-menu <?php if ($page == 'Esp32' or $page == 'User_esp') {
                                    echo 'show';
                                  } ?>" aria-labelledby="pagesDropdown">
          <a class="dropdown-item <?php if ($page == 'Esp32' or $page == 'User_esp') {
                                    echo 'active';
                                  } ?>" href="<?= base_url('Esp32') ?>">
            <i class="fas fa-fw fa-cloud"></i>
            <span>Data ESP</span>
          </a>
        </div>
      </li>
    </ul>

    <div id="content-wrapper">