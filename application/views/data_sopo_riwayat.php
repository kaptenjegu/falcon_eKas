<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= $url ?>"><?= $judul ?></a>
        </li>
    </ol>

    <!-- DataTables Example -->
    <?= $this->session->flashdata('msg') ?>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Data Riwayat PO / SO
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor PO/SO</th>
                            <th>Nama Pekerjaan</th>
                            <th>Nominal</th>
                            <th>Tipe</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data_sopo as $v) {
                            switch ($v->status_project) {
                                case 1:
                                    $status_project = '<b><i>PO/SO Rilis</i></b>';
                                    break;
                                case 2:
                                    $status_project = '<span style="color: red;"><b>Pekerjaan/Pembelian selesai, dilanjutkan proses pembayaran.</b></span>';
                                    break;
                                case 3:
                                    $status_project = '<span style="color: green;"><b>Pembayaran Selesai</b></span>';
                                    break;
                                default:
                                    $status_project = '--';
                                    break;
                            }

                            switch ($v->jenis_project) {
                                case 1:
                                    $tipe = 'SO';
                                    break;
                                case 2:
                                    $tipe = 'PO';
                                    break;
                                default:
                                    $status_project = '--';
                                    break;
                            }

                            echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . $v->nomor_project . '</td>
                                    <td>' . $v->nama_project . '</td>
                                    <td>' . $v->nominal_project . '</td>
                                    <td>' . $tipe . '</td>
                                    <td>' . $status_project . '</td>
                                    </tr>';
                            $no += 1;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->