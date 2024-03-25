<style>
    #tgl_data_edit::-webkit-calendar-picker-indicator {
        background: transparent;
        color: transparent;
        cursor: pointer;
        height: 20px;
        left: 0;
        position: absolute;
        right: 0;
        width: auto;
    }

    .btn-ungu {
        background-color: purple;
        color: white;
    }

    .btn-ungu:hover {
        background-color: #5c04a0;
        color: white;
    }
</style>
<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url('Kas') ?>">Kas</a> / <a href="<?= base_url('Kas_bulan/detail/' . $judul_periode->id_data_kas) ?>"><?= 'Data Kas Bulan ' . $judul_periode->nama_data_kas ?></a> / <a href="<?= $url ?>"><?= $judul . $judul_periode->nama_minggu ?></a>
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
            <div class="table-responsive">
                <a href="<?= base_url('Kas_breakdown/laporan/' . $this->uri->segment(4)) ?>" target="_blank" class="btn btn-info"><i class="fa fa-download"></i> Laporan RAB</a>&emsp;
                <a href="<?= base_url('Kas_breakdown/laporan_xls/' . $this->uri->segment(4)) ?>" target="_blank" class="btn btn-primary"><i class="fa fa-download"></i> Laporan RAB XLS</a>&emsp;
                <a href="<?= base_url('Kas_breakdown/laporan_pdf/' . $this->uri->segment(4)) ?>" target="_blank" class="btn btn-warning"><i class="fa fa-download"></i> Laporan RAB PDF</a>&emsp;
                <button class="btn btn-ungu" onclick="$('#uploadForm').modal('show')"><i class="fa fa-upload"></i> Import Excel</button>&emsp;
                <a href="<?= base_url('Kas_breakdown/laporan_pdf_non_bpjs/' . $this->uri->segment(4)) ?>" target="_blank" class="btn btn-danger"><i class="fa fa-download"></i> Laporan Non BPJS PDF</a>&emsp;
                <br><br>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Uraian</th>
                            <th>Tipe</th>
                            <th>Qty</th>
                            <th>Nominal</th>
                            <th>Jumlah</th>
                            <th>PIC</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data_kas as $v) {
                            if ($v->id_status == 1) {
                                $kkas = 'background-color: aqua;';
                                $vcr = '<a href="' . base_url('Kas_breakdown/cetak_voucher/' . $v->id_data) . '" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Voucher</a>';
                            } else {
                                $kkas = '';
                                $vcr = '';
                            }

                            if ($v->id_jenis_kas == 1) {  //keluar
                                $kkas .= 'color: #75050a;';
                            } else {
                                $kkas .= 'color: green;';
                            }
                            echo '<tr style="' . $kkas . '">
                                    <td>' . $no . '</td>
                                    <td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td>
                                    <td>' . $v->deskripsi_data . '</td>
                                    <td>' . $v->nama_tipe . '</td>
                                    <td>' . (float)$v->qty_data . '</td>
                                    <td>Rp. ' . number_format($v->nominal_data, 0, ',', '.') . '</td>
                                    <td>Rp. ' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td>
                                    <td>' . $v->pic_data . '</td>
                                    <td>
                                    <button class="btn btn-warning" onclick="get_data(\'' . $v->id_data . '\')"><i class="fa fa-list"></i> Detail</button>&emsp;
                                    <a href="' . base_url('Kas_breakdown/hapus_data/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $v->id_data) . '" class="btn btn-danger" style="margin: 5px;" onclick="return confirm(\'Apakah anda ingin menghapus data ' . $v->deskripsi_data . ' ?\')"><i class="fa fa-trash"></i> Hapus Data</a>
                                    </td>
                                    </tr>';
                            $no += 1;
                        }

                        $tipe_list = '';
                        foreach ($tipe as $v) {
                            $tipe_list .= '<option value=' . $v->id_tipe . '>' . $v->nama_tipe . '</option>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer small text-muted"></div>
    </div>

    <span id="msg"></span>
    <div class="card mb-3" style="height: 500px;">
        <div class="card-header">
            <center><b>Form Tambah Data</b></center>
        </div>

        <div class="card-body">
            <button class="btn btn-success add-1" id=""><i class="fa fa-plus"></i> Tambah Data Kas</button>
            <br><br>
            <div class="table-responsive">
                <table class="table" style="overflow-y: scroll;height: 350px;display:block;" width="100%">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Uraian</th>
                            <th>Status Anggaran</th>
                            <th>Tipe</th>
                            <th>Jenis Kas</th>
                            <th>Qty</th>
                            <th>Nominal</th>
                            <th>PIC</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <input type="hidden" id="id_minggu_data" value="<?= $judul_periode->id_minggu ?>">
                    <tbody id="data_isi">
                        <tr class="control-group">
                            <td><input type="date" name="tgl_data[]" required></td>
                            <td><input type="text" name="uraian_data[]" required></td>
                            <td>
                                <select name="id_status[]" required>
                                    <option value="2">RAB</option>
                                    <option value="1">Luar RAB</option>
                                </select>
                            </td>
                            <td>
                                <select name="id_tipe[]" required>
                                    <?= $tipe_list ?>
                                </select>
                            </td>
                            <td>
                                <select name="id_jenis_kas[]" required>
                                    <option value="1">Keluar</option>
                                    <option value="2">Masuk</option>

                                </select>
                            </td>
                            <td><input type="number" name="qty_data[]" step="0.001" required></td>
                            <td><input type="number" name="nominal_data[]" required></td>
                            <td><input type="text" name="pic_data[]" required></td>
                            <td><button class="btn btn-danger remove"><i class="fa fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card-footer small">
        <span class="">Catatan:
            <ul>
                <li>Untuk Tipe Kas, agar bisa ditampilkan di All Kas, maka pilih Jenis Kas Masuk</li>
                <li>Data dengan jenis kas Keluar dan bertipe Kas, tidak akan dihitung di All Kas</li>
                <li>Pengajuan Dana diatur ke jenis kas masuk</li>
                <li>Data BPJS wajib diawali dengan kalimat awal BPJS</li>
                <li>Penutupan kas, harus menggunakan kata awal "Penutupan" agar bisa dihitung</li>
                <li>Hati-hati dalam mengisi data, beberapa data tidak bisa diedit</li>
            </ul>

        </span>
        <br>
        <button onclick="form_data()" class="btn btn-info">Simpan</button>
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
                    <input type="hidden" name="id_data_kas" value="<?= $this->db->escape_str($this->uri->segment(3)) ?>">
                    <input type="hidden" name="id_minggu" value="<?= $this->db->escape_str($this->uri->segment(4)) ?>">
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
                        <select name="status_data_edit" class="form-control" id="status_data_edit" min="1" required>
                            <option value="1">Luar RAB</option>
                            <option value="2">RAB</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipe</label>
                        <select class="form-control" id="tipe_data_edit" name="tipe_data_edit" required>
                            <?= $tipe_list ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kas</label>
                        <select class="form-control" id="jenis_kas_edit" name="jenis_kas_edit" min="1" required>
                            <option value="1">Keluar</option>
                            <option value="2">Masuk</option>
                        </select>
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

<!--  Upload -->
<div class="modal fade" id="uploadForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Import File Excel</h4>
            </div>
            <form method="POST" action="<?= base_url('Kas_breakdown/upload_excel/') ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id_data_kas" value="<?= $this->db->escape_str($this->uri->segment(3)) ?>">
                    <input type="hidden" name="id_minggu" value="<?= $this->db->escape_str($this->uri->segment(4)) ?>">
                    <div class="form-group">
                        <label>Pilih Tipe</label>
                        <select name="id_tipe" class="form-control" required>
                            <?= $tipe_list ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status Anggaran</label>
                        <select name="id_status" class="form-control" required>
                            <option value="2">RAB</option>
                            <option value="1">Luar RAB</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kas</label>
                        <select name="id_jenis_kas" class="form-control" required>
                            <option value="1">Keluar</option>
                            <option value="2">Masuk</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>File Excel</label>
                        <input type="file" name="file_excel" class="form-control" accept="application/vnd.ms-excel" required>
                    </div>
                    <div class="form-group" style="font-weight: bold;">
                        Catatan :
                        <ul>
                            <li>File format hanya bisa XLS (Excel 2003)</li>
                            <li>Baris ke satu tidak diinput karena header tabel</li>
                            <li style="color: red;">Perhatikan urutan kolom : No,Tanggal,Uraian,Quantity, Harga, Jumlah, PIC</li>
                        </ul>
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
<!-- Upload -->