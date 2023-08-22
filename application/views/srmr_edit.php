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
<div class="container-fluid" style="height: 1700px;">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= $url ?>"><?= $judul ?></a> \ Edit
        </li>
    </ol>


    <!-- DataTables Example -->

    <?= $this->session->flashdata('msg') ?>
    <a href="<?= base_url('Srmr/download_dokumen/' . $this->uri->segment(3)) ?>" target="_blank" class="btn btn-primary"><i class="fa fa-download"></i> Download Dokumen</a><br><br>
            
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-cart-plus"></i>
            Edit Data Pengajuan <?= get_lokasi() ?>
        </div>
        <div class="card-body">
            <form action="<?= base_url('Srmr/simpan_edit_data/') ?>" method="POST">
                <input type="hidden" name="id_data" value="<?= $this->uri->segment(3) ?>">
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" class="form-control tgl_data" name="tgl_data" value="<?= $srmr->tgl_data ?>" required>
                </div>
                <div class="form-group">
                    <label>Nomor</label>
                    <input type="text" class="form-control" value="<?= $srmr->nomor_data ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Proyek</label>
                    <input type="text" class="form-control" name="proyek_data" maxlength="50" value="<?= $srmr->proyek_data ?>" required>
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" class="form-control" name="subject_data" maxlength="50" value="<?= $srmr->subject_data ?>" required>
                </div>
                <div class="form-group">
                    <label>Nama Customer</label>
                    <input type="text" class="form-control" name="customer_data" maxlength="40" value="<?= $srmr->customer_data ?>" required>
                </div>
                <div class="form-group">
                    <label>Kode Proyek</label>
                    <input type="text" class="form-control" name="kode_proyek" maxlength="20" value="<?= $srmr->kode_proyek ?>" required>
                </div>
                <div class="form-group">
                    <label>Jenis Permintaan</label>
                    <select class="form-control" name="jenis_data" required>
                        <option value="1" <?php if ($srmr->jenis_data == 1) {
                                                echo 'selected="selected"';
                                            } ?>>Service Request(SR)</option>
                        <option value="2" <?php if ($srmr->jenis_data == 2) {
                                                echo 'selected="selected"';
                                            } ?>>Material Request(MR)</option>
                    </select>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Estimasi</th>
                                <th>Deskripsi</th>
                                <th>Qty</th>
                                <th>Nominal</th>
                                <th>Total</th>
                                <th>Remark</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($data_srmr as $v) {
                                echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . $v->estimasi_data . '</td>
                                    <td>' . $v->deskripsi_data . '</td>
                                    <td>' . (float)$v->qty_data . ' ' . $v->satuan_data . '</td>
                                    <td>Rp. ' . number_format($v->nominal_data, 0, ',', '.') . '</td>
                                    <td>Rp. ' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td>
                                    <td>' . $v->remark_data . '</td>
                                    <td>
                                    <button type="button" class="btn btn-warning" onclick="get_data(\'' . $v->id_detail . '\')"><i class="fa fa-list"></i> Detail</button>&emsp;
                                    <a href="' . base_url('Srmr/hapus_detail/' . $v->id_data . '/' . $v->id_detail) . '" class="btn btn-danger" style="margin: 5px;" onclick="return confirm(\'Apakah anda ingin menghapus data ' . $v->deskripsi_data . ' ?\')"><i class="fa fa-trash"></i> Hapus Data</a>
                                    </td>
                                    </tr>';
                                $no += 1;
                            }
                            ?>
                        </tbody>
                    </table>
                    <br>
                    <button type="submit" class="btn btn-primary">Simpan</button>&emsp;
                    <a href="<?= base_url('srmr') ?>" class="btn btn-default">Kembali</a>
            </form>
        </div>
    </div>
</div>
</div>
<!-- /.container-fluid -->


<!--  EDIT-->
<div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Data Kas</h4>

            </div>
            <form method="POST" action="<?= base_url('Srmr/simpan_edit_detail/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_data" value="<?= $this->uri->segment(3) ?>">
                    <input type="hidden" name="id_detail" id="id_detail">
                    <div class="form-group">
                        <label>Tanggal Estimasi</label>
                        <input type="date" class="form-control tgl_data" name="estimasi_data" id="estimasi_data">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi_data" id="deskripsi_data" required>
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" step="0.001" class="form-control" id="qty_data" name="qty_data" required>
                    </div>
                    <div class="form-group">
                        <label>Satuan</label>
                        <input type="text" class="form-control" id="satuan_data" name="satuan_data" required>
                    </div>
                    <div class="form-group">
                        <label>Nominal</label>
                        <input type="number" class="form-control" id="nominal_data" name="nominal_data" required>
                    </div>
                    <div class="form-group">
                        <label>Remark</label>
                        <input type="text" class="form-control" name="remark_data" id="remark_data" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
                <br>
                <br>

            </form>
        </div>
    </div>
</div>
<!-- EDIT -->