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
            Data PO / SO
        </div>

        <div class="card-body">
            <?php if ($step1) { ?>
                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addForm"><i class="fa fa-plus"></i> Tambah Data PO / SO</a>
                <br>
                <br>
            <?php } ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor PO/SO</th>
                            <th>Nominal</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Opsi</th>
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

                            if ($_SESSION['id_jabatan'] == '6e5dfcdab3ed5991d49692be6442f415') {  //tax keu smd
                                $id_setor = 3;  //pembayaran selesai
                            } else {
                                $id_setor = 2;  // pekerjaan selesai
                            }

                            echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . $v->nomor_project . '</td>
                                    <td>' . $v->nominal_project . '</td>
                                    <td>' . $tipe . '</td>
                                    <td>' . $status_project . '</td>
                                    <td>
                                        <a href="' . base_url('Monitoring_bayar/setor_data/' . $v->id_project . '/' . $id_setor) . '" class="btn btn-info" onclick="return confirm(\'Apakah anda ingin menyelesaikan data nomor ' . $v->nomor_project . ' ?\')"><i class="fa fa-forward"></i></a>&emsp;';

                            if ($step1) {
                                echo '<a href="#" data-toggle="modal" data-target="#editForm" class="btn btn-warning" onclick="get_data(\'' . $v->id_project . '\')"><i class="fa fa-edit"></i> Edit</a>&emsp;
                                        <a href="' . base_url('Monitoring_bayar/hapus_data/' . $v->id_project) . '" class="btn btn-danger" onclick="return confirm(\'Apakah anda ingin menghapus data nomor ' . $v->nomor_project . ' ?\')"><i class="fa fa-trash"></i> Hapus</a>&emsp;';
                            }

                            echo '</td>
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

<!--  ADD-->
<div class="modal fade" id="addForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tambah Data PO / SO</h4>
            </div>
            <form method="POST" action="<?= base_url('Monitoring_bayar/tambah_data/') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Project</label>
                        <input type="text" class="form-control" name="nama_project" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor Project</label>
                        <input type="text" class="form-control" name="nomor_project" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Rilis Dokumen</label>
                        <input type="text" class="form-control" name="tgl_mulai" required>
                    </div>
                    <div class="form-group">
                        <label>Durasi Pekerjaan (Hari)</label>
                        <input type="number" class="form-control" name="durasi_project" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Vendor</label>
                        <input type="text" class="form-control" name="nama_vendor" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label>Nominal Project</label>
                        <input type="text" class="form-control" name="nominal_project" maxlength="10" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Project</label>
                        <select class="form-control" name="jenis_project" required>
                            <option value="1">SO</option>
                            <option value="2">PO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Lokasi Project</label>
                        <select class="form-control" name="lokasi_project" required>
                            <?php
                            foreach ($lokasi as $v) {
                                echo '<option value="' . $v->id_lokasi . '">' . $v->nama_lokasi . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ADD -->



<!--  EDIT-->
<div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Data Aset</h4>
            </div>
            <form method="POST" action="<?= base_url('Monitoring_bayar/edit_data/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_project" id="id_project">
                    <div class="form-group">
                        <label>Nama Project</label>
                        <input type="text" class="form-control" name="nama_project" id="nama_project" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor Project</label>
                        <input type="text" class="form-control" name="nomor_project" id="nomor_project" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Rilis Dokumen</label>
                        <input type="text" class="form-control" name="tgl_mulai" id="tgl_mulai" required>
                    </div>
                    <div class="form-group">
                        <label>Durasi Pekerjaan (Hari)</label>
                        <input type="number" class="form-control" name="durasi_project" id="durasi_project" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Vendor</label>
                        <input type="text" class="form-control" name="nama_vendor" id="nama_vendor" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label>Nominal Project</label>
                        <input type="text" class="form-control" name="nominal_project" id="nominal_project" maxlength="10" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Project</label>
                        <select class="form-control" name="jenis_project" id="jenis_project" required>
                            <option value="1">SO</option>
                            <option value="2">PO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Lokasi Project</label>
                        <select class="form-control" name="lokasi_project" id="lokasi_project" required>
                            <?php
                            foreach ($lokasi as $v) {
                                echo '<option value="' . $v->id_lokasi . '">' . $v->nama_lokasi . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- EDIT -->