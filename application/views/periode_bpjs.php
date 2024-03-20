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
            Tabel Data Periode BPJS
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Periode</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data_kas as $v) {
                            echo '<tr>
                            <td>' . $no . '</td>
                            <td>' . $v->nama_data_kas . '</td>
                            <td>
                                <a href="' . base_url('Bpjs/detail/' . $v->id_data_kas) . '" class="btn btn-primary"><i class="fa fa-list"></i> Detail</a>&emsp;
                            </td>
                            </tr>';
                            $no += 1;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer small text-muted"></div>
    </div>

</div>
<!-- /.container-fluid -->

<!--  ADD-->
<div class="modal fade" id="addForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tambah Periode Data Kas</h4>
            </div>
            <form method="POST" action="<?= base_url('Kas/tambah_data_kas/') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Periode (misal : Juli 2023)</label>
                        <input type="text" class="form-control" name="nama_data_kas" required>
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
                <h4 class="modal-title" id="myModalLabel">Edit Periode Data Kas</h4>
            </div>
            <form method="POST" action="<?= base_url('Kas/edit_data/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_data_kas" id="id_data_kas">
                    <div class="form-group">
                        <label>Nama Periode (misal : Juli 2023)</label>
                        <input type="text" class="form-control" name="nama_data_kas" id="nama_data_kas" required>
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