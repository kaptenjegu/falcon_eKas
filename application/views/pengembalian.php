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
            Data Pengembalian Aset <?= get_lokasi() ?>
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
                            <th>User Peminjam / PIC</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($pengembalian as $v) {
                            echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . $v->nama_user . '</td>
                                    <td>
                                        <a href="' . base_url('Pengembalian/detail/' . $v->id_akun) . '" class="btn btn-warning"><i class="fa fa-list"></i> Detail</a>&emsp;
                                    </td>
                                    </tr>';
                            $no += 1;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
