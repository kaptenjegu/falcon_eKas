<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url('Kas') ?>">Kas</a> / <a href="<?= $url ?>"><?= $judul . $judul_periode->nama_data_kas ?></a>
        </li>
    </ol>


    <!-- DataTables Example -->
    <?= $this->session->flashdata('msg') ?>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Data Kas <?= get_lokasi() ?>
        </div>

        <div class="card-body">
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addForm"><i class="fa fa-plus"></i> Tambah Minggu</a>
            <br><br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Total Pengeluaran</th>
                            <th>Total Kas</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data_minggu as $v) {
                            echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . $v->nama_minggu . '</td>
                                    <td>Rp. ' . number_format($v->dana_pengajuan, 0, ',', '.') . '</td>
                                    <td>Rp. ' . number_format($v->dana_pengajuan, 0, ',', '.') . '</td>
                                    <td>
                                    <a href="#" class="btn btn-warning" onclick="get_data(\'' . $v->id_minggu . '\')"><i class="fa fa-edit"></i> Edit</a>&emsp;
                                        <a href="' . base_url('Kas_breakdown/detail/' . $judul_periode->id_data_kas . '/' . $v->id_minggu) . '" class="btn btn-primary"><i class="fa fa-list"></i> Breakdown</a>
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
                <h4 class="modal-title" id="myModalLabel">Tambah Data Minggu</h4>
            </div>
            <form method="POST" action="<?= base_url('Kas_bulan/tambah_data/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_data_kas" value="<?= $this->db->escape_str($this->uri->segment(3)) ?>">
                    <input type="hidden" name="id_lokasi" value="<?= $_SESSION['id_lokasi'] ?>">
                    <div class="form-group">
                        <label>Nama Data</label>
                        <input type="text" class="form-control" name="nama_minggu" required>
                    </div>
                    <!--div class="form-group">
                        <label>Lokasi</label>
                        <select class="form-control" name="id_lokasi">
                            <?php
                            /*foreach ($lokasi as $v) {
                                $s = '';
                                if (isset($user)) {
                                    if ($v->id_lokasi == $user->id_lokasi) {
                                        $s = 'selected="selected"';
                                    } else {
                                        $s = '';
                                    }
                                }
                                echo '<option value="' . $v->id_lokasi . '" ' . $s  . '>' . $v->nama_lokasi . '</option>';
                            }*/
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label id="dana_pengajuan2">Dana Pengajuan</label>
                        <input type="text" class="form-control" name="dana_pengajuan" id="dana_pengajuan" required>
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
<div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Data Minggu</h4>
            </div>
            <form method="POST" action="<?= base_url('Kas_bulan/edit_data/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_data_kas" value="<?= $this->db->escape_str($this->uri->segment(3)) ?>">
                    <input type="hidden" name="id_lokasi" value="<?= $_SESSION['id_lokasi'] ?>">
                    <input type="hidden" name="id_minggu" id="id_minggu">
                    <div class="form-group">
                        <label>Nama Data</label>
                        <input type="text" class="form-control" name="nama_minggu" id="nama_minggu" required>
                    </div>
                    <!--div class="form-group">
                        <label>Dana Pengajuan</label>
                        <input type="text" class="form-control" name="dana_pengajuan" id="dana_pengajuan_edit" required>
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
<!-- EDIT -->