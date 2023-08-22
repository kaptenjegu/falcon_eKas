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
            <a href="<?= $url ?>"><?= $judul ?></a> \ Tambah
        </li>
    </ol>


    <!-- DataTables Example -->

    <?= $this->session->flashdata('msg') ?>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-cart-plus"></i>
            Tambah Data Pengajuan <?= get_lokasi() ?>
        </div>
        <div class="card-body">
            <form action="<?= base_url('Srmr/simpan_data/') ?>" method="POST">
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" class="form-control tgl_data" name="tgl_data" required>
                </div>
                <div class="form-group">
                    <label>Proyek</label>
                    <input type="text" class="form-control" name="proyek_data" maxlength="50" required>
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" class="form-control" name="subject_data" maxlength="50" required>
                </div>
                <div class="form-group">
                    <label>Nama Customer</label>
                    <input type="text" class="form-control" name="customer_data" maxlength="40" required>
                </div>
                <div class="form-group">
                    <label>Kode Proyek</label>
                    <input type="text" class="form-control" name="kode_proyek" maxlength="20" required>
                </div>
                <div class="form-group">
                    <label>Jenis Permintaan</label>
                    <select class="form-control" name="jenis_data" required>
                        <option value="1">Service Request(SR)</option>
                        <option value="2">Material Request(MR)</option>
                    </select>
                </div>
                
        </div>
    </div>

    <span id="msg"></span>
    <div class="card mb-3" style="height: 500px;">
        <div class="card-header">
            <center><b>Form Tambah Item</b></center>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="overflow-y: scroll;height: 650px;display:block;" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Estimasi</th>
                            <th>Deskripsi</th>
                            <th>Spesifikasi</th>
                            <th>Qty</th>
                            <th>Satuan</th>
                            <th>Nominal</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <input type="hidden" id="id_minggu_data" value="">
                    <tbody>
                        <?php for ($a = 1; $a <= 10; $a++) { ?>
                            <tr class="control-group">
                                <td><?= $a ?></td>
                                <td><input type="date" class="tgl_data" name="estimasi_data[]"></td>
                                <td><input type="text" name="deskripsi_data[]" maxlength="100"></td>
                                <td><input type="text" name="spek_data[]" maxlength="100"></td>
                                <td><input type="number" name="qty_data[]" step="0.001"></td>
                                <td><input type="text" name="satuan_data[]" maxlength="20"></td>
                                <td><input type="number" name="nominal_data[]"></td>
                                <td><input type="text" name="remark_data[]" maxlength="100"></td>
                            </tr>
                        <?php } ?>
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
            <form method="POST" action="<?= base_url('Kas_breakdown/edit_data/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_data" id="id_data">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="tgl_data" id="tgl_data_edit" required>
                    </div>
                    <div class="form-group">
                        <label>Uraian</label>
                        <input type="text" class="form-control" name="uraian_data" id="uraian_data_edit" required>
                    </div>
                    <div class="form-group">
                        <label>Status Anggaran</label>
                        <input type="text" class="form-control" id="status_data_edit" readonly>
                    </div>
                    <div class="form-group">
                        <label>Tipe</label>
                        <input type="text" class="form-control" id="tipe_data_edit" readonly>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kas</label>
                        <input type="text" class="form-control" id="jenis_kas_edit" readonly>
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" class="form-control" name="qty_data" step="0.001" id="qty_data_edit" required>
                    </div>
                    <div class="form-group">
                        <label>Nominal</label>
                        <input type="number" class="form-control" name="nominal_data" id="nominal_data_edit" required>
                    </div>
                    <div class="form-group">
                        <label>PIC</label>
                        <input type="text" class="form-control" name="pic_data" id="pic_data_edit" required>
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