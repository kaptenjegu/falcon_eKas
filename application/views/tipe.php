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
            Data Tipe
        </div>

        <div class="card-body">
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addForm"><i class="fa fa-plus"></i> Tambah Tipe</a>
            <br><br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tipe</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($tipe as $v) {
                            echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . $v->nama_tipe . '</td>
                                    <td>
                                    <button class="btn btn-warning" onclick="get_data(\'' . $v->id_tipe . '\')"><i class="fa fa-edit"></i> Edit</button>&emsp;
                                        <a href="' . base_url('Tipe/hapus_data/' . $v->id_tipe) . '" class="btn btn-danger" onclick="return confirm(\'Apakah anda ingin menghapus data tipe ' . $v->nama_tipe . ' ?\')"><i class="fa fa-trash"></i> Hapus</a>
                                    </td>
                                    </tr>';
                            $no += 1;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
    </div>

</div>
<!-- /.container-fluid -->

<!--  ADD-->
<div class="modal fade" id="addForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tambah Data Tipe</h4>
            </div>
            <form method="POST" action="<?= base_url('Tipe/tambah_data/') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Tipe</label>
                        <input type="text" class="form-control" name="nama_tipe" required>
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
                <h4 class="modal-title" id="myModalLabel">Edit Data Tipe</h4>
            </div>
            <form method="POST" action="<?= base_url('Tipe/edit_data/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_tipe" id="id_tipe">
                    <div class="form-group">
                        <label>Nama Tipe</label>
                        <input type="text" class="form-control" name="nama_tipe" id="nama_tipe" required>
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