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
            Data Pinjam Aset <?= get_lokasi() ?>
        </div>

        <div class="card-body">
            <!--a href="#" class="btn btn-success" data-toggle="modal" data-target="#addForm"><i class="fa fa-plus"></i> Tambah Data Aset</a>
            <br>
            <br-->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User Peminjam / PIC</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($pinjam as $v) {
                            echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . $v->nama_user . '</td>
                                    <td>
                                        <a href="' . base_url('Pinjam/detail/' . $v->id_akun) . '" class="btn btn-warning"><i class="fa fa-list"></i> Detail</a>&emsp;
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
                <h4 class="modal-title" id="myModalLabel">Tambah Data Aset</h4>
            </div>
            <form method="POST" action="<?= base_url('Asset/tambah_data/') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" maxlength="200" required>
                    </div>
                    <div class="form-group">
                        <label>Quantity Barang</label>
                        <input type="number" class="form-control" name="qty_asli" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Kondisi Barang</label>
                        <select class="form-control" name="kondisi_barang" required>
                            <option value="1">Baik</option>
                            <option value="2">Rusak</option>
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
<div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Data Aset</h4>
            </div>
            <form method="POST" action="<?= base_url('Asset/edit_data/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_barang" id="id_barang">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" id="nama_barang" maxlength="200" required>
                    </div>
                    <div class="form-group">
                        <label>Quantity Barang</label>
                        <input type="number" class="form-control" name="qty_asli" id="qty_asli" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Kondisi Barang</label>
                        <select class="form-control" name="kondisi_barang" id="kondisi_barang" required>
                            <option value="1">Baik</option>
                            <option value="2">Rusak</option>
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