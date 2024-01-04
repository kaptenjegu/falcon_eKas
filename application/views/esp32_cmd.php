<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url('Esp32') ?>">Data ESP</a> / <a href="<?= $url ?>">Control</a>
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
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addForm"><i class="fa fa-plus"></i> Tambah Control ESP</a>
            <br>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Control / Command</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($cmd as $v) {
                            echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . $v->nama_cmd . '</td>
                                    <td>
                                        <a href="#" class="btn btn-warning" onclick="get_data_cmd(\'' . $v->id_cmd_esp . '\')"><i class="fa fa-edit"></i> Edit</a>&emsp;
                                        <a href="' . base_url('Esp32/hapus_data_cmd/' . $v->id_cmd_esp . '/' . $v->id_esp) . '" class="btn btn-danger" onclick="return confirm(\'Apakah anda ingin menghapus variabel ' . $v->nama_cmd . '?\')"><i class="fa fa-trash"></i> Hapus</a>&emsp;
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
                <h4 class="modal-title" id="myModalLabel">Tambah Control/ Command ESP</h4>
            </div>
            <form method="POST" action="<?= base_url('Esp32/tambah_data_cmd/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_esp" value="<?= $this->uri->segment(3) ?>">
                    <div class="form-group">
                        <label>Kode Control / Command</label>
                        <input type="text" class="form-control" name="kode_cmd_esp" maxlength="100" placeholder="Untuk variabel dalam program" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Control / Command</label>
                        <input type="text" class="form-control" name="nama_cmd" maxlength="200" placeholder="Untuk nama yang tampil di tombol" required>
                    </div>
                    <div class="form-group">
                        <label>On Off terbalik?</label>
                        <select class="form-control" name="reverse_cmd_esp" required>
                            <option value="1">Ya</option>
                            <option value="0" selected="selected">Tidak</option>
                        </select>
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
<div class="modal fade" id="editFormCmd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Control / Command ESP</h4>
            </div>
            <form method="POST" action="<?= base_url('Esp32/edit_data_cmd/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_cmd_esp" id="id_cmd_esp">
                    <input type="hidden" name="id_esp" id="id_esp">
                    <div class="form-group">
                        <label>Kode Control / Command</label>
                        <input type="text" class="form-control" name="kode_cmd_esp" id="kode_cmd_esp" maxlength="100" placeholder="Untuk variabel dalam program" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Control / Command</label>
                        <input type="text" class="form-control" name="nama_cmd" id="nama_cmd" maxlength="200" placeholder="Untuk nama yang tampil di tombol" required>
                    </div>
                    <div class="form-group">
                        <label>On Off terbalik?</label>
                        <select class="form-control" name="reverse_cmd_esp" id="reverse_cmd_esp" required>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
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