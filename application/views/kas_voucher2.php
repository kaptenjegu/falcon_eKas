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
            Voucher Data Kas <?= $judul_periode->nama_data_kas . ' ' . $judul_periode->nama_minggu . ' <b>' . get_lokasi() ?></b>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                 <form method="POST" action="<?= base_url('Kas_voucher/cetak_custom_kas/') ?>" target="_blank">
                    <input type="hidden" name="nama_data_kas" value="<?= $judul_periode->nama_data_kas ?>">
                    <input type="hidden" name="judul" value="<?= 'Voucher Data Kas ' . $judul_periode->nama_data_kas . ' ' . $judul_periode->nama_minggu . ' ' . get_lokasi() ?>">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Uraian</th>
                                <th>Nominal</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            
                            $no = 1;
                            foreach ($hasil as $v) {
                                echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . $v['tgl'] . '</td>
                                    <td>' . $v['deskripsi'] . '</td>
                                    <td>Rp. ' . number_format($v['total'], 0, ',', '.') . '</td>
                                    <td><input type="checkbox" name="all_data[]"  value="' . $v['tgl'] . '|@|' . $v['deskripsi'] . '|@|' . $v['total'] . '"</td>
                                    </tr>';
                                $no += 1;
                            }
                            ?>
                        </tbody>
                    </table>

            </div>
        </div>
    </div>

    <span id="msg"></span>
    <div class="card mb-3" style="height: 500px;">
        <div class="card-header">
            <center><b>Form Tambah Data</b></center>
        </div>

        <div class="card-body">
            <!--button type="button" class="btn btn-success add-1" id=""><i class="fa fa-plus"></i> Tambah Data Kas</button>
            <br><br-->
            <div class="form-group">
                <label><b>Pilih Jenis Voucher</b></label>
                <select class="form-control" name="jenis_vocer">
                    <option value="1">Kas Keluar</option>
                    <option value="2">Bank Keluar</option>
                </select>
            </div>
            <div class="table-responsive" style="width: 100% important;">
                <table class="table" style="overflow-y: scroll;height: 350px;display:block;" width="100%">
                    <thead>
                        <tr>
                            <th style="width:25%;">Tanggal</th>
                            <th style="width:25%;">Deskripsi</th>
                            <th style="width:25%;">Nominal</th>
                            <!--th style="width:25%;">Opsi</th-->
                        </tr>
                    </thead>
                    <!--input type="hidden" id="id_minggu_data" value="<? //= $judul_periode->id_minggu 
                                                                        ?>"-->
                    <tbody id="data_isi">
                        <tr class="control-group">
                            <td><input type="date" name="tgl_data[]"></td>
                            <td><input type="text" name="uraian_data[]"></td>
                            <td><input type="number" name="nominal_data[]"></td>
                            <!--td><button class="btn btn-danger remove"><i class="fa fa-trash"></i></button></td-->
                        </tr>
                        <tr class="control-group">
                            <td><input type="date" name="tgl_data[]"></td>
                            <td><input type="text" name="uraian_data[]"></td>
                            <td><input type="number" name="nominal_data[]"></td>
                            <!--td><button class="btn btn-danger remove"><i class="fa fa-trash"></i></button></td-->
                        </tr>
                        <tr class="control-group">
                            <td><input type="date" name="tgl_data[]"></td>
                            <td><input type="text" name="uraian_data[]"></td>
                            <td><input type="number" name="nominal_data[]"></td>
                            <!--td><button class="btn btn-danger remove"><i class="fa fa-trash"></i></button></td-->
                        </tr>
                        <tr class="control-group">
                            <td><input type="date" name="tgl_data[]"></td>
                            <td><input type="text" name="uraian_data[]"></td>
                            <td><input type="number" name="nominal_data[]"></td>
                            <!--td><button class="btn btn-danger remove"><i class="fa fa-trash"></i></button></td-->
                        </tr>
                        <tr class="control-group">
                            <td><input type="date" name="tgl_data[]"></td>
                            <td><input type="text" name="uraian_data[]"></td>
                            <td><input type="number" name="nominal_data[]"></td>
                            <!--td><button class="btn btn-danger remove"><i class="fa fa-trash"></i></button></td-->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card-footer small">
        <button type="submit" class="btn btn-info"><i class="fa fa-download"></i> Download</button>
        </form>
    </div>

</div>
<!-- /.container-fluid -->