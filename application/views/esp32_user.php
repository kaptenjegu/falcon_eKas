<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url('Esp32') ?>">Data ESP</a> / <a href="<?= $url ?>">Pengguna</a>
        </li>
    </ol>


    <!-- DataTables Example -->
    <?= $this->session->flashdata('msg') ?>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Data Pengguna ESP <?= $kode_esp ?>
        </div>

        <div class="card-body">
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addForm"><i class="fa fa-plus"></i> Tambah Pengguna ESP</a>
            <br>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($user as $v) {
                            echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . $v->username . '</td>
                                    <td>
                                        <a href="#" class="btn btn-warning" onclick="get_data_user(\'' . $v->id_user . '\')"><i class="fa fa-edit"></i> Edit</a>&emsp;
                                        <a href="' . base_url('Esp32/hapus_data_user/' . $v->id_user . '/' . $v->id_esp) . '" class="btn btn-danger" onclick="return confirm(\'Apakah anda ingin menghapus ESP ini?\')"><i class="fa fa-trash"></i> Hapus</a>&emsp;
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
                <h4 class="modal-title" id="myModalLabel">Tambah Data Pengguna ESP</h4>
            </div>
            <form method="POST" action="<?= base_url('Esp32/tambah_data_user/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_esp" value="<?= $this->uri->segment(3) ?>">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" maxlength="100" required>
                    </div>
                    <!--div class="form-group">
                        <label>Role</label>
                        <input type="text" class="form-control" name="deskripsi_esp" placeholder="diisi minimal tentang lokasi esp berada" required>
                    </div-->
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
<div class="modal fade" id="editFormUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Pengguna ESP</h4>
            </div>
            <form method="POST" action="<?= base_url('Esp32/edit_data_user/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_user" id="id_user">
                    <input type="hidden" name="id_esp" id="id_esp">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" id="username" maxlength="100" required>
                    </div>
                    <input type="checkbox" name="reset"> Reset Password

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