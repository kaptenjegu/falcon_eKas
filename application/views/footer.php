<!-- Sticky Footer -->
<footer class="sticky-footer">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright © Falcon Prima Tehnik 2023</span>
    </div>
  </div>
</footer>

</div>
<!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="login.html">Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url() ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url() ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugin JavaScript-->
<script src="<?= base_url() ?>vendor/chart.js/Chart.min.js"></script>
<script src="<?= base_url() ?>vendor/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url() ?>vendor/js/sb-admin.min.js"></script>

<script>
  // Call the dataTables jQuery plugin
  $(document).ready(function() {
    $('#dataTable').DataTable();
  });

  <?php if ($page == "Kas") { ?>

    function get_data(id) {
      //console.log(id);
      $.ajax({
        url: "<?= base_url() ?>Kas/get_data_kas/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          document.getElementById('id_data_kas').value = data['id_data_kas'];
          document.getElementById('nama_data_kas').value = data['nama_data_kas'];
          $('#editForm').modal('show');
          console.log(data);
        },
        error: function(data) {
          alert('error')
          console.log(data);
        }
      });
    }
  <?php } ?>

  <?php if ($page == "Kas_bulan") { ?>
    //var lbl_dana = document.getElementById('dana_pengajuan2');
    //var rupiah = document.getElementById('dana_pengajuan');

    function get_data(id) {
      $.ajax({
        url: "<?= base_url() ?>Kas_bulan/get_data/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          document.getElementById('id_minggu').value = data['id_minggu'];
          document.getElementById('nama_minggu').value = data['nama_minggu'];
          //document.getElementById('dana_pengajuan_edit').value = data['dana_pengajuan'];
          $('#editForm').modal('show');
          console.log(data);
        },
        error: function(data) {
          alert('error')
          console.log(data);
        }
      });
    }

    function get_data_dapeng(id) {
      $.ajax({
        url: "<?= base_url() ?>Kas_bulan/get_data_dapeng/" + id,
        type: "GET",
        dataType: "HTML",
        success: function(data) {
          //document.getElementById('id_data_kas').value = data['id_data_kas'];
          document.getElementById('nominal1').value = data;
          $('#DanaPengajuanForm').modal('show');
          console.log(data);
          console.log(id);
        },
        error: function(data) {
          alert('error')
          console.log(data);
        }
      });
    }

    /*rupiah.addEventListener('keyup', function(e) {
      lbl_dana.innerHTML = 'Dana Pengajuan <b>' + formatRupiah(rupiah.value, 'Rp. ') + '</b>';
    });

    function formatRupiah(angka, prefix) {
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }*/

  <?php } ?>

  <?php if ($page == "Kas_voucher") { ?>
    $(document).ready(function() {
      var add_row = document.getElementById("data_isi").innerHTML;

      $(".add-1").click(function() {
        //var tbl = document.getElementsByClassName('data_isi').innerHTML;
        //var add_row = '<tr class="control-group"><td><input type="date" name="tgl_data[]" required></td><td><input type="text" name="uraian_data[]" required></td><td><input type="number" name="qty_data[]" required></td><td><input type="number" name="nominal_data[]" required></td><td><input type="text" name="pic_data[]" required></td><td><button class="btn btn-danger remove"><i class="fa fa-trash"></i></button></td></tr>';

        $("#data_isi").append(add_row);
        console.log('tabel');
      });

      // saat tombol remove dklik control group akan dihapus 
      $("body").on("click", ".remove", function() {
        $(this).parents(".control-group").remove();
      });
    });
  <?php } ?>

  <?php if ($page == "Kas_breakdown") { ?>
    var lbl_dana = document.getElementById('dana_pengajuan2');
    var rupiah = document.getElementById('dana_pengajuan');



    function form_data() {
      var data = document.getElementById('data_isi').innerHTML;
      var tgl = document.getElementsByName('tgl_data[]');
      var uraian = document.getElementsByName('uraian_data[]');
      var qty = document.getElementsByName('qty_data[]');
      var nominal = document.getElementsByName('nominal_data[]');
      var pic = document.getElementsByName('pic_data[]');
      var idt = document.getElementsByName('id_tipe[]');
      var ids = document.getElementsByName('id_status[]');
      var idjk = document.getElementsByName('id_jenis_kas[]');
      var id_minggu = document.getElementById('id_minggu_data').value;
      var t = [];
      var u = [];
      var q = [];
      var n = [];
      var p = [];
      var it = [];
      var is = [];
      var ijk = [];

      //console.log(tgl.length);end;

      for (var i = 0; i < tgl.length; i++) {
        if ((tgl[i].value == null || tgl[i].value == "") || (uraian[i].value == null || uraian[i].value == "")) {
          alert("Ada Data yang belum diisi, mohon diperiksa lagi.");
          console.log(i);
          return false;
        }
        t.push(tgl[i].value);
        u.push(uraian[i].value);
        q.push(qty[i].value);
        n.push(nominal[i].value);
        p.push(pic[i].value);
        it.push(idt[i].value);
        is.push(ids[i].value);
        ijk.push(idjk[i].value);
      }

      $.ajax({
        url: "<?= base_url() ?>Kas_breakdown/tambah_data/",
        type: "POST",
        dataType: "json",
        data: {
          tgl_data: t,
          uraian_data: u,
          id_minggu: id_minggu,
          id_tipe: it,
          id_status: is,
          id_jenis_kas: ijk,
          pic_data: p,
          qty_data: q,
          nominal_data: n
        },
        success: function(data) {
          console.log(data);
          if (data['status'] == '200') {
            document.getElementById('msg').innerHTML = '<div class="alert alert-success alert-dismissable"><center><b>Data sudah disimpan</b></center></div>';
            location.reload();
          } else {
            document.getElementById('msg').innerHTML = '<div class="alert alert-alert alert-dismissable"><center><b>Error : ' + str(data['data']) + '</b></center></div>';
          }
        },
        error: function(data) {
          console.log('error');
          console.log(data);
          document.getElementById('msg').innerHTML = '<div class="alert alert-danger alert-dismissable"><center><b>!!! Error cek log !!!</b></center></div>';
        }
      });

      //alert(data);
    }

    function get_upload_excel() {
      $('#uploadForm').modal('show');
    }

    function get_data(id) {
      $.ajax({
        url: "<?= base_url() ?>Kas_breakdown/get_data/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          document.getElementById('id_data').value = data['id_data'];
          document.getElementById('uraian_data_edit').value = data['deskripsi_data'];

          if (data['id_status'] == 1) {
            document.getElementById('status_data_edit').value = 'Luar RAB';
          } else {
            document.getElementById('status_data_edit').value = 'RAB';
          }

          if (data['id_jenis_kas'] == 1) {
            document.getElementById('jenis_kas_edit').value = 'Keluar';
          } else {
            document.getElementById('jenis_kas_edit').value = 'Masuk';
          }

          document.getElementById('tipe_data_edit').value = data['nama_tipe'];
          document.getElementById('tgl_data_edit').value = data['tgl_data'];
          document.getElementById('qty_data_edit').value = data['qty_data'];
          document.getElementById('nominal_data_edit').value = data['nominal_data'];
          document.getElementById('pic_data_edit').value = data['pic_data'];
          $('#editForm').modal('show');
          console.log(data);
        },
        error: function(data) {
          alert('error')
          console.log(data);
        }
      });
    }

    $(document).ready(function() {
      var add_row = document.getElementById("data_isi").innerHTML;

      $(".add-1").click(function() {
        //var tbl = document.getElementsByClassName('data_isi').innerHTML;
        //var add_row = '<tr class="control-group"><td><input type="date" name="tgl_data[]" required></td><td><input type="text" name="uraian_data[]" required></td><td><input type="number" name="qty_data[]" required></td><td><input type="number" name="nominal_data[]" required></td><td><input type="text" name="pic_data[]" required></td><td><button class="btn btn-danger remove"><i class="fa fa-trash"></i></button></td></tr>';

        $("#data_isi").append(add_row);
        console.log('tabel');
      });

      // saat tombol remove dklik control group akan dihapus 
      $("body").on("click", ".remove", function() {
        $(this).parents(".control-group").remove();
      });
    });


  <?php } ?>
</script>

<?php if ($page == "Tipe") { ?>
  <script>
    function get_data(id) {
      $.ajax({
        url: "<?= base_url() ?>Tipe/get_data/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          document.getElementById('id_tipe').value = data['id_tipe'];
          document.getElementById('nama_tipe').value = data['nama_tipe'];
          $('#editForm').modal('show');
          console.log(data);
        },
        error: function(data) {
          alert('error')
          console.log(data);
        }
      });
    }
  </script>
<?php } ?>


<?php if ($page == "srmr_manage") { ?>
  <script>
    function get_data(id) {
      $.ajax({
        url: "<?= base_url() ?>Srmr/get_data/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          document.getElementById('id_detail').value = data['id_detail'];
          document.getElementById('estimasi_data').value = data['estimasi_data'];
          document.getElementById('deskripsi_data').value = data['deskripsi_data'];
          document.getElementById('qty_data').value = data['qty_data'];
          document.getElementById('satuan_data').value = data['satuan_data'];
          document.getElementById('nominal_data').value = data['nominal_data'];
          document.getElementById('remark_data').value = data['remark_data'];
          $('#editForm').modal('show');
          console.log(data);
        },
        error: function(data) {
          alert('error')
          console.log(data);
        }
      });
    }

    function get_nomor_data(){
      var kode_proyek = document.getElementById('kode_proyek').value;
      var jenis_data = document.getElementById('jenis_data').value;

      $.ajax({
        url: "<?= base_url() ?>Srmr/get_nomor_data/" + kode_proyek + "/" + jenis_data,
        type: "GET",
        dataType: "HTML",
        success: function(data) {
          document.getElementById('nomor_data').value = data;
          console.log("get_nomor_data = " + data);
        },
        error: function(data) {
          alert('error')
          console.log(data);
        }
      });
    }
  </script>
<?php } ?>

<?php if ($page == "Dashboard") { ?>
  <script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';

    // Area Chart Example
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 13"],
        datasets: [{
          label: "Sessions",
          lineTension: 0.3,
          backgroundColor: "rgba(2,117,216,0.2)",
          borderColor: "rgba(2,117,216,1)",
          pointRadius: 5,
          pointBackgroundColor: "rgba(2,117,216,1)",
          pointBorderColor: "rgba(255,255,255,0.8)",
          pointHoverRadius: 5,
          pointHoverBackgroundColor: "rgba(2,117,216,1)",
          pointHitRadius: 50,
          pointBorderWidth: 2,
          data: [10000, 30162, 26263, 18394, 18287, 28682, 31274, 33259, 25849, 24159, 32651, 31984, 38451],
        }],
      },
      options: {
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              max: 40000,
              maxTicksLimit: 5
            },
            gridLines: {
              color: "rgba(0, 0, 0, .125)",
            }
          }],
        },
        legend: {
          display: false
        }
      }
    });
  </script>
<?php } ?>

</body>

</html>