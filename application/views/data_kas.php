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
      Tabel Periode Data Kas <?= get_lokasi() ?>
    </div>
    
    <div class="card-body">
    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addForm"><i class="fa fa-plus"></i> Tambah Periode</a>
    <br><br>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Periode</th>
              <th>Opsi</th>
            </tr>
          </thead>
          
          <tbody>
          <?php 
          $no = 1;
          foreach($data_kas as $v){
              echo '<tr>
                      <td>' . $no . '</td>
                      <td>' . $v->nama_data_kas . '</td>
                      <td>
                      <a href="#" class="btn btn-warning" onclick="get_data(\'' . $v->id_data_kas . '\')"><i class="fa fa-edit"></i> Edit</a>&emsp;
                        <a href="' . base_url('Kas_bulan/detail/' . $v->id_data_kas) . '" class="btn btn-primary"><i class="fa fa-list"></i> Detail</a>&emsp;
                        <a href="' . base_url('Kas/laporan/' . $v->id_data_kas) . '" class="btn btn-info" target="_blank"><i class="fa fa-download"></i> All Kas</a>&emsp;
                        <a href="' . base_url('Kas/laporan2/' . $v->id_data_kas) . '" class="btn btn-warning" target="_blank" style="background-color:khaki"><i class="fa fa-download"></i> Luar RAB</a>&emsp;
                        <a href="' . base_url('Kas_voucher/list/' . $v->id_data_kas) . '" class="btn btn-info" target="_blank" style="background-color:purple"><i class="fa fa-newspaper"></i> Voucher Luar RAB</a>
                      </td>
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
                <h4 class="modal-title" id="myModalLabel">Tambah Periode Data Kas</h4>
            </div>
            <form method="POST" action="<?= base_url('Kas/tambah_data_kas/') ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Periode (misal : Juli 2023)</label>
                    <input type="text" class="form-control" name="nama_data_kas" required>
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
                <h4 class="modal-title" id="myModalLabel">Edit Periode Data Kas</h4>
            </div>
            <form method="POST" action="<?= base_url('Kas/edit_data/') ?>">
            <div class="modal-body">
                <input type="hidden" name="id_data_kas" id="id_data_kas">
                <div class="form-group">
                    <label>Nama Periode (misal : Juli 2023)</label>
                    <input type="text" class="form-control" name="nama_data_kas" id="nama_data_kas" required>
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