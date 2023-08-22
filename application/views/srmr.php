<style>
    .tgl_data::-webkit-calendar-picker-indicator {
        background: transparent;
        color: transparent;
        cursor: pointer;
        height: 20px;
        left: 0;
        position: absolute;
        right: 0;
        width: auto;
    }
</style>
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
            Data Permintaan <?= get_lokasi() ?>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <a href="<?= base_url('Srmr/tambah_data/') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Permintaan</a>&emsp;
                <br><br>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor</th>
                            <th>Tanggal</th>                            
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Tipe</th>
                            <th>Opsi</th>
                            <th>Persetujuan</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($srmr as $v) {
                            if ($v->status_data == 1) {
                                $status_data = 'dibuat';
                            } elseif ($v->status_data == 2) {
                                $status_data = 'disetujui';
                            } else {
                                $status_data = 'CANCEL';
                            }

                            if ($v->jenis_data == 1) {
                                $jenis_data = 'SR';
                            } else {
                                $jenis_data = 'MR';
                            }
                            $nomor = format_nomor_dokumen($v->kode_proyek,$v->nomor_data,$v->jenis_data);

                            echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . $nomor . '</td>
                                    <td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td>                                    
                                    <td>' . $v->proyek_data . '</td>
                                    <td>' . $status_data . '</td>
                                    <td>' . $jenis_data . '</td>
                                    <td>
                                        <a href="' . base_url('Srmr/edit_data/' .  $v->id_data) . '" class="btn btn-warning"><i class="fa fa-list"></i> Detail</a>&emsp;
                                        <a href="' . base_url('Srmr/hapus_data/' .  $v->id_data) . '" class="btn btn-danger" style="margin: 5px;" onclick="return confirm(\'Apakah anda ingin menghapus data Nomor ' . $nomor . ' ?\')"><i class="fa fa-trash"></i> Hapus Data</a>
                                    </td>
                                    <td>
                                        <a href="' . base_url('Srmr/acc_data/' .  $v->id_data) . '" class="btn btn-success" onclick="return confirm(\'Data Nomor ' . $nomor . ' disetujui ?\')"><i class="fa fa-check"></i></a>&emsp;
                                        <a href="' . base_url('Srmr/nacc_data/' .  $v->id_data) . '" class="btn btn-danger" onclick="return confirm(\'Data Nomor ' . $nomor . ' tidak disetujui ?\')"><i class="fa fa-minus-circle"></i></a>
                                    </td>
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
