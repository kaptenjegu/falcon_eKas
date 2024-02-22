<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= $url ?>"><?= $judul ?></a>
        </li>
    </ol>
    <span id="link" style="display: none;"><?= $url ?></span>


    <!-- DataTables Example -->
    <?= $this->session->flashdata('msg') ?>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            <?= $judul ?>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Alasan</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($tender as $v) {
                            if ($v->status == 2) {
                                $status = "Goal";
                                $color = "green";
                            } elseif ($v->status == 3) {
                                $status = "Gagal";
                                $color = "red";
                            }
                            echo '<tr style="color:' . $color . '">
                                    <td>' . $no . '</td>
                                    <td>' . date('d-m-Y', strtotime($v->tgl_kirim)) . '</td>
                                    <td onclick="get_download(\'' . $v->id_tender . '\')">' . $v->deskripsi . '</td>
                                    <td>' . $status . '</td>
                                    <td>' . $v->alasan_status . '</td>                                    
                                    <td>
                                    <button class="btn btn-warning" onclick="get_data(\'' . $v->id_tender . '\')"><i class="fa fa-edit"></i> Edit</button>&emsp;
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


<!--  EDIT-->
<div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit <?= $judul ?></h4>
            </div>
            <form method="POST" action="<?= base_url('Tender/edit_data_riwayat/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_tender" id="id_tender">
                    <div class="form-group">
                        <label>Nomor Penawaran</label>
                        <input type="text" class="form-control" name="no_penawaran" id="no_penawaran" placeholder="Hanya diisi ketika data tersedia">
                    </div>
                    <div class="form-group">
                        <label>Kontak Person</label>
                        <input type="text" class="form-control" name="kontak_person" id="kontak_person" placeholder="Hanya diisi ketika data tersedia">
                    </div>
                    <div class="form-group">
                        <label>Alamat Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Hanya diisi ketika data tersedia">
                    </div>
                    <div class="form-group">
                        <label>Customer Name</label>
                        <input type="text" class="form-control" name="cust_name" id="cust_name" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Hanya diisi ketika data tersedia">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" id="deskripsi" required>
                    </div>
                    <div class="form-group">
                        <label id="label_edit">Nominal</label>
                        <input type="number" class="form-control" name="nominal" onkeyup="nominal_add('nominal','label_edit')" onfocus="nominal_add('nominal','label_edit')" id="nominal" placeholder="Hanya diisi ketika data tersedia">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Penawaran dibuat / dikirim</label>
                        <input type="text" class="form-control" name="tgl_kirim" id="tgl_kirim" required>
                    </div>
                    <div class="form-group">
                        <label>Tipe Tender</label>
                        <select class="form-control" name="tipe_tender" id="tipe_tender" required>
                            <option value="1">Marketing</option>
                            <option value="2">Tender</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sudah termasuk pajak</label>
                        <select class="form-control" name="pajak" id="pajak" required>
                            <option value="1">Ya</option>
                            <option value="2">Tidak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ubah Status</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="1">Menunggu</option>
                            <option value="2">Goal</option>
                            <option value="3">Gagal</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Alasan Status</label>
                        <input type="text" class="form-control" name="alasan_status" id="alasan_status" maxlength="200">
                    </div>
                    <div class="form-group">
                        <label>Term Of Payment</label>
                        <textarea id="top_edit" name="top"></textarea>
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

<!-- DOWNLOAD -->
<div class="modal fade" id="downloadForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Download File</h4>
            </div>
            <form method="GET" target="_blank" action="<?= base_url('Tender/download/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_tender" id="id_tender_download">
                    <div class="form-group">
                        <label>Jumlah Lampiran</label>
                        <input type="number" class="form-control" name="lampiran" value="1" placeholder="wajib isi jumlah lampiran" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Download</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- DOWNLOAD -->