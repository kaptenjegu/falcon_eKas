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
            Data ESP
        </div>

        <div class="card-body">
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addForm"><i class="fa fa-plus"></i> Tambah Data ESP</a>
            <br>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode ESP</th>
                            <th>Deskripsi ESP</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($esp32 as $v) {
                            echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . $v->kode_esp . '</td>
                                    <td>' . $v->deskripsi_esp . '</td>
                                    <td>
                                        <a href="#" class="btn btn-warning" onclick="get_data(\'' . $v->id_esp . '\')"><i class="fa fa-edit"></i> Edit</a>&emsp;
                                        <a href="' . base_url('Esp32/variabel/' . $v->id_esp) . '" class="btn btn-info" style="color: white;"><i class="fa fa-list"></i> Variabel</a>&emsp;
                                        <a href="' . base_url('Esp32/cmd/' . $v->id_esp) . '" class="btn btn-success" style="color: white;"><i class="fa fa-list"></i> Control</a>&emsp;
                                        <a href="' . base_url('Esp32/user/' . $v->id_esp) . '" class="btn btn-primary" style="color: white;"><i class="fa fa-users"></i> Pengguna</a>&emsp;
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
                <h4 class="modal-title" id="myModalLabel">Tambah Data ESP</h4>
            </div>
            <form method="POST" action="<?= base_url('Esp32/tambah_data/') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode ESP</label>
                        <input type="text" class="form-control" name="kode_esp" placeholder="contoh kode : SBY_001" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi ESP</label>
                        <input type="text" class="form-control" name="deskripsi_esp" placeholder="diisi minimal tentang lokasi esp berada" required>
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
<div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Data ESP</h4>
            </div>
            <form method="POST" action="<?= base_url('Esp32/edit_data/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_esp" id="id_esp">
                    <div class="form-group">
                        <label>Kode ESP</label>
                        <input type="text" class="form-control" name="kode_esp" id="kode_esp" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi ESP</label>
                        <input type="text" class="form-control" name="deskripsi_esp" id="deskripsi_esp" placeholder="diisi minimal tentang lokasi esp berada" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="<?= base_url('Esp32/hapus_data/' . $v->id_esp) ?>" onclick="return confirm('Apakah anda ingin menghapus ESP ini?')" style="left: 4%;position: absolute;color: white;" type="button" class="btn btn-danger">Hapus</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- EDIT -->