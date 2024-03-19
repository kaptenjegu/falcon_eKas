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
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addForm"><i class="fa fa-plus"></i> Tambah Data Tender</a>
            <br><br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Customer</th>
                            <th>Tipe</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($tender as $v) {
                            if ($v->tipe_tender == 1) {
                                $tipe = "Marketing";
                            } else {
                                $tipe = "Tender";
                            }
                            echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . date('d-m-Y', strtotime($v->tgl_kirim)) . '</td>
                                    <td>' . $v->deskripsi . '</td>
                                    <td>' . $v->cust_name . '</td>
                                    <td>' . $tipe . '</td>                                    
                                    <td>
                                    <button class="btn btn-warning" onclick="get_data(\'' . $v->id_tender . '\')"><i class="fa fa-edit"></i> Edit</button>&emsp;
                                        <a href="' . base_url('Tender/hapus_data/' . $v->id_tender) . '" class="btn btn-danger" onclick="return confirm(\'Apakah anda ingin menghapus data tender ' . $v->deskripsi . ' ?\')"><i class="fa fa-trash"></i> Hapus</a>
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
                <h4 class="modal-title" id="myModalLabel">Tambah <?= $judul ?></h4>
            </div>
            <form method="POST" action="<?= base_url('Tender/tambah_data/') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nomor Penawaran</label>
                        <input type="text" class="form-control" name="no_penawaran" placeholder="Hanya diisi ketika data tersedia">
                    </div>
                    <div class="form-group">
                        <label>Kontak Person</label>
                        <input type="text" class="form-control" name="kontak_person" placeholder="Hanya diisi ketika data tersedia">
                    </div>
                    <div class="form-group">
                        <label>Alamat Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Hanya diisi ketika data tersedia">
                    </div>
                    <div class="form-group">
                        <label>Customer Name</label>
                        <input type="text" class="form-control" name="cust_name" id="cust_name_add" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Hanya diisi ketika data tersedia">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" required>
                    </div>
                    <div class="form-group">
                        <label id="label_add">Nominal</label>
                        <input type="number" class="form-control" name="nominal" onkeyup="nominal_add('n_add','label_add')" id="n_add" placeholder="Hanya diisi ketika data tersedia">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Penawaran dibuat / dikirim</label>
                        <input type="text" class="form-control" name="tgl_kirim" required>
                    </div>
                    <div class="form-group">
                        <label>Tipe Tender</label>
                        <select class="form-control" name="tipe_tender" required>
                            <option value="1">Marketing</option>
                            <option value="2">Tender</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sudah termasuk pajak</label>
                        <select class="form-control" name="pajak" required>
                            <option value="1">Ya</option>
                            <option value="2">Tidak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Term Of Payment</label>
                        <textarea id="tiny" name="top"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah</button>
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
                <h4 class="modal-title" id="myModalLabel">Edit <?= $judul ?></h4>
            </div>


            <div class="modal-body">
                <form method="GET" target="_blank" action="<?= base_url('Tender/download/') ?>">
                    <input type="hidden" name="id_tender" id="id_tender2">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> Download</button><br>
                </form>
                <form method="POST" action="<?= base_url('Tender/edit_data/') ?>" enctype="multipart/form-data">
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
                    <div class="form-group">
                        <label>Lampiran</label>
                        <input type="text" id="lampiran" class="form-control demo demo-textarea" placeholder="Click Here and Paste it">
                    </div>
                    <br>
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


            <div class="modal-body">

            </div>

            <input type="hidden" name="id_tender" id="id_tender_download">
            <div class="modal-footer">
                <button type="submit" id="save_data" class="btn btn-primary">Download</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- DOWNLOAD -->