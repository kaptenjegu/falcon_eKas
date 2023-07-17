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
                            if($v->id_status == 1){
                                $kkas = 'background-color: aqua;';
                            }else{
                                $kkas = '';
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
                                    <a href="#" class="btn btn-warning" onclick="get_data(\'' . $v->id_data . '\')"><i class="fa fa-list"></i> Detail</a>
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
                    <div class="form-group">
                        <label>Dana Pengajuan</label>
                        <input type="text" class="form-control" name="dana_pengajuan" id="dana_pengajuan_edit" required>
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
