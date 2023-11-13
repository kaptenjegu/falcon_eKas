<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
        <a href="<?= base_url('Asset') ?>">Data Aset</a> / <a href="<?= $url ?>"><?= $judul ?></a>
        </li>
    </ol>


    <!-- DataTables Example -->
    <?= $this->session->flashdata('msg') ?>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Detail Aset
        </div>

        <div class="card-body">
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" class="form-control" value="<?= $asset->nama_barang ?>" disabled>
            </div>
            <div class="form-group">
                <label>Quantity Asli</label>
                <input type="text" class="form-control" value="<?= $asset->qty_asli ?>" disabled>
            </div>
            <div class="form-group">
                <label>Quantity Sisa</label>
                <input type="text" class="form-control" value="<?= $asset->qty_sisa ?>" disabled>
            </div>
            <div class="form-group">
                <label>Lokasi Pembelian Barang</label>
                <input type="text" class="form-control" value="<?= $asset->nama_lokasi ?>" disabled>
            </div>
            <div class="form-group">
                <label>Tanggal Pembelian Barang</label>
                <input type="text" class="form-control" value="<?= date('d-m-Y', strtotime($asset->tgl_pembelian)) ?>" disabled>
            </div>
            <div class="form-group">
                <label>Kondisi Barang</label>
                <input type="text" class="form-control" value="<?php if($asset->kondisi_barang == 1){echo 'Baik';}else{echo 'Rusak';} ?>" disabled>
            </div>
        </div>

        <div class="card-body">
            <!--a href="#" class="btn btn-success" data-toggle="modal" data-target="#addForm"><i class="fa fa-plus"></i> Tambah Data Aset</a>
            <br>
            <br-->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama PIC</th>
                            <th>Lokasi Barang Sekarang</th>
                            <th>Qty</th>
                            <th>Kondisi awal</th>
                            <th>Kondisi kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($pinjam as $v) {
                            switch ($v->kondisi_barang_asal) {
                                case 1:
                                    $kondisi = 'Baik';
                                    break;
                                case 2:
                                    $kondisi = 'Rusak';
                                    break;
                                default:
                                    $kondisi = 'tidak terindentifikasi';
                                    break;
                            }

                            switch ($v->kondisi_barang_kembali) {
                                case 1:
                                    $kondisi2 = '<span style="color: green; font-weight: bold;">Baik</span>';
                                    break;
                                case 2:
                                    $kondisi2 = '<span style="color: red; font-weight: bold;">Rusak</span>';
                                    break;
                                default:
                                    $kondisi2 = '-';
                                    break;
                            }

                            switch ($v->status) {
                                case 2:
                                    $status = '<span style="color: red; font-weight: bold;">Dipinjam</span>';
                                    break;
                                case 3:
                                    $status = '<span style="font-weight: bold;">Pending Pengembalian</span>';
                                    break;
                                case 4:
                                    $status = '<span style="color: green; font-weight: bold;">Dikembalikan</span>';
                                    break;
                                default:
                                    $status = 'tidak terindentifikasi';
                                    break;
                            }

                            echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . date('d-m-Y',strtotime($v->tgl_pinjam)) . '</td>
                                    <td>' . $v->nama_user . '</td>
                                    <td>' . $v->nama_lokasi . '</td>
                                    <td>' . $v->qty_pinjam . '</td>
                                    <td>' . $kondisi . '</td>
                                    <td>' . $kondisi2 . '</td>
                                    <td>' . $status . '</td>
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
                <h4 class="modal-title" id="myModalLabel">Tambah Data Aset</h4>
            </div>
            <form method="POST" action="<?= base_url('Asset/tambah_data/') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" maxlength="200" required>
                    </div>
                    <div class="form-group">
                        <label>Quantity Barang</label>
                        <input type="number" class="form-control" name="qty_asli" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Kondisi Barang</label>
                        <select class="form-control" name="kondisi_barang" required>
                            <option value="1">Baik</option>
                            <option value="2">Rusak</option>
                        </select>
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
                <h4 class="modal-title" id="myModalLabel">Edit Data Aset</h4>
            </div>
            <form method="POST" action="<?= base_url('Asset/edit_data/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_barang" id="id_barang">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" id="nama_barang" maxlength="200" required>
                    </div>
                    <div class="form-group">
                        <label>Quantity Barang</label>
                        <input type="number" class="form-control" name="qty_asli" id="qty_asli" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Kondisi Barang</label>
                        <select class="form-control" name="kondisi_barang" id="kondisi_barang" required>
                            <option value="1">Baik</option>
                            <option value="2">Rusak</option>
                        </select>
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