<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url('Esp32') ?>">Data ESP</a> / <a href="<?= $url ?>">Variabel</a>
        </li>
    </ol>


    <!-- DataTables Example -->
    <?= $this->session->flashdata('msg') ?>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Data Variabel ESP <?= $kode_esp ?>
        </div>

        <div class="card-body">
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addForm"><i class="fa fa-plus"></i> Tambah Variabel ESP</a>
            <br>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Variabel</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($variabel as $v) {
                            echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . $v->nama_data_esp . '</td>
                                    <td>
                                        <a href="#" class="btn btn-warning" onclick="get_data_variabel(\'' . $v->id_data_esp . '\')"><i class="fa fa-edit"></i> Edit</a>&emsp;
                                        <a href="' . base_url('Esp32/hapus_data_variabel/' . $v->id_data_esp . '/' . $v->id_esp) . '" class="btn btn-danger" onclick="return confirm(\'Apakah anda ingin menghapus variabel ' . $v->nama_data_esp . '?\')"><i class="fa fa-trash"></i> Hapus</a>&emsp;
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

<!--  ADD-->
<div class="modal fade" id="addForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tambah Data Variabel ESP</h4>
            </div>
            <form method="POST" action="<?= base_url('Esp32/tambah_data_variabel/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_esp" value="<?= $this->uri->segment(3) ?>">
                    <div class="form-group">
                        <label>Nama Variabel</label>
                        <input type="text" class="form-control" name="nama_data_esp" maxlength="20" required>
                    </div>
                    <div class="form-group">
                        <label>Satuan Nilai</label>
                        <input type="text" class="form-control" name="satuan_data_esp" maxlength="10" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ADD -->

<!--  EDIT-->
<div class="modal fade" id="editFormVar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Data Variabel ESP</h4>
            </div>
            <form method="POST" action="<?= base_url('Esp32/edit_data_variabel/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_data_esp" id="id_data_esp">
                    <input type="hidden" name="id_esp" id="id_esp">
                    <div class="form-group">
                        <label>Nama Variabel</label>
                        <input type="text" class="form-control" name="nama_data_esp" id="nama_data_esp" maxlength="20" required>
                    </div>
                    <div class="form-group">
                        <label>Nilai</label>
                        <input type="text" class="form-control" id="value_data_esp" readonly>
                    </div>
                    <div class="form-group">
                        <label>Satuan Nilai</label>
                        <input type="text" class="form-control" name="satuan_data_esp" id="satuan_data_esp" maxlength="10" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- EDIT -->