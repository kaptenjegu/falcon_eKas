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
            Data Riwayat Permintaan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor</th>
                            <th>Tanggal</th>                            
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Tipe</th>
                            <th>Download</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($srmr as $v) {
                            if ($v->status_data == 1) {
                                $status_data = 'dibuat';
                            } elseif ($v->status_data == 2) {
                                $status_data = '<span style="color: green;">disetujui</span>';
                            } else {
                                $status_data = '<span style="color: red;">ditolak</span>';
                            }

                            if ($v->jenis_data == 1) {
                                $jenis_data = 'SR';
                            } else {
                                $jenis_data = 'MR';
                            }
                            
                            $nomor = format_nomor_dokumen($v->kode_proyek,$v->nomor_data,$v->jenis_data);

                            echo '<tr>
                                    <td>' . $no . '</td>
                                    <td><b>' . $nomor . '</b></td>
                                    <td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td>                                    
                                    <td>' . $v->proyek_data . '</td>
                                    <td>' . $status_data . '</td>
                                    <td>' . $jenis_data . '</td>
                                    <td><a href="' . base_url('Srmr/download_dokumen/' . $v->id_data) . '" target="_blank" class="btn btn-primary"><i class="fa fa-download"></i> Download Dokumen</a></td>
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
