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
            <a href="<?= base_url('Bpjs') ?>">Periode BPJS</a> / <a href="<?= base_url('Bpjs/detail/' . $judul_periode->id_data_kas) ?>"><?= 'Data BPJS Bulan ' . $judul_periode->nama_data_kas ?></a>
        </li>
    </ol>

    <!-- DataTables Example -->

    <?= $this->session->flashdata('msg') ?>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Data BPJS
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <!--a href="<?= base_url('Bpjs/laporan_xls/' . $this->uri->segment(3)) ?>" target="_blank" class="btn btn-primary"><i class="fa fa-download"></i> Laporan XLS</a-->
                <a href="<?= base_url('Bpjs/laporan_pdf/' . $this->uri->segment(3)) ?>" target="_blank" class="btn btn-warning"><i class="fa fa-download"></i> Laporan PDF</a>&emsp;
                <!--button class="btn btn-ungu" onclick="$('#uploadForm').modal('show')"><i class="fa fa-upload"></i> Import Excel</button-->&emsp;
                <br><br>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Uraian</th>
                            <!--th>Tipe</th-->
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
                        foreach ($bpjs as $v) {
                           if ($v->id_jenis_kas == 1) {  //keluar
                                $kkas = 'color: #75050a;';
                            } else {
                                $kkas = 'color: green;';
                            }
                            echo '<tr style="' . $kkas . '">
                                    <td>' . $no . '</td>
                                    <td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td>
                                    <td>' . $v->deskripsi_data . '</td>
                                    <td>' . (float)$v->qty_data . '</td>
                                    <td>Rp. ' . number_format($v->nominal_data, 0, ',', '.') . '</td>
                                    <td>Rp. ' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td>
                                    <td>' . $v->pic_data . '</td>
                                    <td>
                                    <button class="btn btn-warning" onclick="get_data(\'' . $v->id_bpjs . '\')"><i class="fa fa-edit"></i> Edit</button>&emsp;
                                    <a href="' . base_url('Bpjs/hapus_data/' . $v->id_bpjs . '/' . $this->uri->segment(3)) . '" class="btn btn-danger" style="margin: 5px;" onclick="return confirm(\'Apakah anda ingin menghapus data ' . $v->deskripsi_data . ' ?\')"><i class="fa fa-trash"></i> Hapus Data</a>
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

    <span id="msg"></span>
    <div class="card mb-3" style="height: 500px;">
        <div class="card-header">
            <center><b>Form Tambah Data</b></center>
        </div>

        <div class="card-body">
            <button class="btn btn-success add-1" id=""><i class="fa fa-plus"></i> Tambah Data</button>
            <br><br>
            <div class="table-responsive">
                <table class="table" style="overflow-y: scroll;height: 350px;display:block;" width="100%">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Uraian</th>
                            <th>Jenis Kas</th>
                            <th>Qty</th>
                            <th>Nominal</th>
                            <th>PIC</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <input type="hidden" id="id_data_kas" value="<?= $judul_periode->id_data_kas ?>">
                    <tbody id="data_isi">
                        <tr class="control-group">
                            <td><input type="date" name="tgl_data[]" required></td>
                            <td><input type="text" name="uraian_data[]" required></td>
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

    <div class="card-footer small"><button onclick="form_data()" class="btn btn-info">Simpan</button>
    </div>
</div>
<!-- /.container-fluid -->


<!--  EDIT-->
<div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Data BPJS</h4>

            </div>
            <form method="POST" action="<?= base_url('Bpjs/edit_data/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_data_kas" value="<?= $this->db->escape_str($this->uri->segment(3)) ?>">
                    <input type="hidden" name="id_bpjs" id="id_bpjs">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="tgl_data" id="tgl_data_edit" required>
                    </div>
                    <div class="form-group">
                        <label>Uraian</label>
                        <input type="text" class="form-control" name="deskripsi_data" id="uraian_data_edit" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kas</label>
                        <select class="form-control" id="jenis_kas_edit" name="id_jenis_kas" min="1" required>
                            <option value="1">Keluar</option>
                            <option value="2">Masuk</option>
                        </select>
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