<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= $url ?>"><?= $judul ?></a>
        </li>
    </ol>


    <!-- DataTables Example -->
    <?= $this->session->flashdata('msg') ?>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Detail Data Pinjam Aset <?= get_lokasi() ?>
        </div>

        <div class="card-body">
            <div class="form-group">
                <label>Nama PIC</label>
                <input type="text" class="form-control" value="<?= $data_user->nama_user ?>" disabled>
            </div>
            <div class="form-group">
                <label>No Telp</label>
                <input type="text" class="form-control" value="<?= $data_user->no_telp ?>" disabled>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow-y: auto;height: 450px;">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Barang</th>
                            <th>Qty Barang</th>
                            <th>Qty Pinjam</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data_pinjam as $v) {
                            echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . date('d-m-Y', strtotime($v->tgl_pinjam)) . '</td>
                                    <td>' . $v->nama_barang . '</td>
                                    <td>' . $v->qty_sisa . '</td>
                                    <td>' . $v->qty_pinjam . '</td>
                                    <td>
                                        <a href="' . base_url('Pinjam/detail_acc_data/' .$id_akun . '/' . $v->id_pinjam) . '" class="btn btn-success" onclick="return confirm(\'Apakah anda ingin mennyetujui data ' . $v->nama_barang . ' ?\')"><i class="fa fa-check"></i> Setujui</a>&emsp;
                                        <a href="' . base_url('Pinjam/detail_hapus_data/' .$id_akun . '/' . $v->id_pinjam) . '" class="btn btn-danger" onclick="return confirm(\'Apakah anda ingin menghapus data ' . $v->nama_barang . ' ?\')"><i class="fa fa-ban"></i> Hapus</a>&emsp;
                                    </td>
                                    </tr>';
                            $no += 1;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <a href="<?= base_url('Pinjam/detail_acc_data_semua/' . $id_akun ) ?>" class="btn btn-success"><i class="fa fa-check"></i> Setujui Semua</a>
        </div>

    </div>

</div>
<!-- /.container-fluid -->
