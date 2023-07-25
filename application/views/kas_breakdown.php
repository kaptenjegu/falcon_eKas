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
            <a href="<?= base_url('Kas_breakdown/laporan/' . $this->uri->segment(4))?>" target="_blank" class="btn btn-info"><i class="fa fa-download"></i> Laporan RAB</a>&emsp;
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
                            } else {
                                $kkas = '';
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
                                    <td>' . $v->qty_data . '</td>
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
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
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
                                    <option value="1">diluar RAB</option>
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
                            <td><input type="number" name="qty_data[]" required></td>
                            <td><input type="number" name="nominal_data[]" required></td>
                            <td><input type="text" name="pic_data[]" required></td>
                            <td><button class="btn btn-danger remove"><i class="fa fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer small"><button onclick="form_data()" class="btn btn-info">Simpan</button></div>
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
                        <input type="number" class="form-control" name="qty_data" id="qty_data_edit" required>
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