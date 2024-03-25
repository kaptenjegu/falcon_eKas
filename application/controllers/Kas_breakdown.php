<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Kas_breakdown extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        cek_login();
    }

    public function index()
    {
        echo '';
    }

    public function detail()
    {
        $id_data_kas = $this->db->escape_str($this->uri->segment(3));
        $id_minggu = $this->db->escape_str($this->uri->segment(4));
        $data['judul'] = '';
        $data['page'] = 'Kas_breakdown';
        $data['url'] = base_url('Kas_breakdown/detail/' . $id_data_kas . '/' . $id_minggu);

        $this->db->select('*');
        $this->db->from('fki_minggu');
        $this->db->join('fki_data_kas', 'fki_data_kas.id_data_kas = fki_minggu.id_data_kas');
        $this->db->where('fki_minggu.id_minggu', $id_minggu);
        $this->db->where('fki_minggu.tgl_delete', null);
        $n = $this->db->get();

        if ($n->num_rows() > 0) {

            $data['judul_periode'] = $n->first_row();

            $this->db->where('tgl_delete', null);
            $this->db->order_by('id_tipe', 'asc');
            $data['tipe'] = $this->db->get('fki_tipe')->result();

            $this->db->select('*');
            $this->db->from('fki_data');
            $this->db->join('fki_tipe', 'fki_tipe.id_tipe = fki_data.id_tipe');
            $this->db->where('fki_data.tgl_delete', null);
            $this->db->where('fki_data.id_minggu', $id_minggu);
            $this->db->order_by('fki_data.tgl_data', 'desc');
            $data['data_kas'] = $this->db->get()->result();

            $this->db->select('*');
            $this->db->from('fki_nota');
            $this->db->join('fki_tipe', 'fki_tipe.id_tipe = fki_nota.id_tipe');
            $this->db->where('fki_nota.tgl_delete', null);
            $this->db->where('fki_nota.id_minggu', $id_minggu);
            $data['data_nota'] = $this->db->get()->result();

            $this->load->view('header', $data);
            $this->load->view('kas_breakdown', $data);
            $this->load->view('footer');
        } else {
            echo 'ERROR';
        }
    }

    public function tambah_data()
    {
        try {
            $this->db->trans_start();

            $id_minggu = $this->input->post('id_minggu');
            $id_tipe = $this->input->post('id_tipe');
            $id_status = $this->input->post('id_status');
            $id_jenis_kas = $this->input->post('id_jenis_kas');
            $deskripsi_data = $this->input->post('uraian_data');
            $tgl_data = $this->input->post('tgl_data');
            $pic_data = $this->input->post('pic_data');
            $qty_data = $this->input->post('qty_data');
            $nominal_data = $this->input->post('nominal_data');
            $data = array();
            $hasil = array();

            for ($n = 0; $n <= count($tgl_data) - 1; $n++) {
                array_push($data, array(
                    'id_data' => randid(),
                    'deskripsi_data' => $deskripsi_data[$n],
                    'tgl_data' => $tgl_data[$n],
                    'id_minggu' => $id_minggu,
                    'id_tipe' => $id_tipe[$n],
                    'id_status' => $id_status[$n],
                    'id_jenis_kas' => $id_jenis_kas[$n],
                    'pic_data' => $pic_data[$n],
                    'qty_data' => $qty_data[$n],
                    'nominal_data' => $nominal_data[$n]
                ));
            }
            $this->db->insert_batch('fki_data', $data);

            $status = '200';
            $msg = 'Data Sudah Disimpan';
            $data = json_encode($data);

            $this->db->trans_complete();

            //logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));
        } catch (\Throwable $e) {
            $status = '500';
            $msg = 'Caught exception: ' .  $e->getMessage();
            $data = '';
        }

        $hasil = array(
            'status' => $status,
            'message' => $msg,
            'data' => $data,
        );
        echo json_encode($hasil);
    }

    public function tambah_nota()
    {
        try {
            $this->db->trans_start();
            $id_minggu = $this->db->escape_str($this->input->post('id_minggu'));
            $id_tipe = $this->db->escape_str($this->input->post('id_tipe'));
            $id_data_kas = $this->db->escape_str($this->input->post('id_data_kas'));
            $id = randid();

            $data = array(
                'id_nota' => $id,
                'id_minggu' => $id_minggu,
                'id_tipe' => $id_tipe
            );
            $this->db->insert('fki_nota', $data);

            if (!empty($_FILES['nota']['name'])) {

                // Define new $_FILES array - $_FILES['file']
                $_FILES['file']['name'] = $_FILES['nota']['name'];
                $_FILES['file']['type'] = $_FILES['nota']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['nota']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['nota']['error'];
                $_FILES['file']['size'] = $_FILES['nota']['size'];
                // Set preference
                $config['upload_path'] = 'vendor/nota/';
                $config['allowed_types'] = 'jpg';
                $config['max_size'] = '5000'; // max_size in kb
                $config['file_name'] = $id;

                //Load upload library
                $this->load->library('upload', $config);

                // File upload
                if ($this->upload->do_upload('file')) {
                    $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Nota Sudah Disimpan</b></center></div>');
                    $this->db->trans_complete();
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Error Upload gambar + tambah data</b></center></div>');
                }
            }
        } catch (Exception $e) {
            //echo 'Caught exception: ',  $e->getMessage(), "\n";
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Error :' . $e->getMessage() . '</b></center></div>');
        }
        redirect('Kas_breakdown/detail/' . $id_data_kas . '/' . $id_minggu);
    }

    public function hapus_nota()
    {
        try {
            $this->db->trans_start();

            $id_minggu = $this->db->escape_str($this->uri->segment(5));
            $id_data_kas = $this->db->escape_str($this->uri->segment(4));
            $id_nota = $this->db->escape_str($this->uri->segment(3));

            $this->db->set('tgl_delete', date('Y-m-d H:i:s'));
            $this->db->where('id_nota', $id_nota);
            $this->db->update('fki_nota');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Nota Berhasil Dihapus</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Error :' . $e->getMessage() . '</b></center></div>');
        }
        redirect('Kas_breakdown/detail/' . $id_data_kas . '/' . $id_minggu);
    }

    public function edit_data()
    {
        try {
            $this->db->trans_start();

            $id_minggu = $this->db->escape_str($this->input->post('id_minggu'));
            $id_data_kas = $this->db->escape_str($this->input->post('id_data_kas'));
            $id_data = $this->db->escape_str($this->input->post('id_data'));
            $tgl_data = $this->input->post('tgl_data');
            $deskripsi_data = $this->input->post('uraian_data');
            $qty_data = $this->input->post('qty_data');
            $nominal_data = $this->input->post('nominal_data');
            $pic_data = $this->input->post('pic_data');
            $id_jenis_kas = $this->input->post('jenis_kas_edit');
            $id_status = $this->input->post('status_data_edit');
            $id_tipe = $this->input->post('tipe_data_edit');

            $this->db->set('tgl_data', $tgl_data);
            $this->db->set('deskripsi_data', $deskripsi_data);
            $this->db->set('qty_data', $qty_data);
            $this->db->set('nominal_data', $nominal_data);
            $this->db->set('pic_data', $pic_data);
            $this->db->set('id_jenis_kas', $id_jenis_kas);
            $this->db->set('id_status', $id_status);
            $this->db->set('id_tipe', $id_tipe);
            $this->db->where('id_data', $id_data);
            $this->db->update('fki_data');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Kas Sudah Diperbarui</b></center></div>');

            $this->db->trans_complete();

            //logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));

        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Kas_breakdown/detail/' . $id_data_kas . '/' . $id_minggu);
    }

    public function get_data()
    {
        try {
            $id = $this->db->escape_str($this->uri->segment(3));

            $this->db->select('*');
            $this->db->from('fki_data');
            $this->db->join('fki_tipe', 'fki_tipe.id_tipe = fki_data.id_tipe');
            $this->db->where('fki_data.tgl_delete', null);
            $this->db->where('fki_data.id_data', $id);
            $this->db->order_by('fki_data.tgl_data', 'desc');
            $data = $this->db->get()->first_row();

            echo json_encode($data);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

    public function hapus_data()
    {
        try {
            $this->db->trans_start();

            $id_data_kas = $this->db->escape_str($this->uri->segment(3));
            $id_minggu = $this->db->escape_str($this->uri->segment(4));
            $id_data = $this->db->escape_str($this->uri->segment(5));

            $this->db->set('tgl_delete', date('Y-m-d H:i:s'));
            $this->db->where('id_data', $id_data);
            $this->db->update('fki_data');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Kas Sudah Dihapus</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Kas_breakdown/detail/' . $id_data_kas . '/' . $id_minggu);
    }

    private function cek_data($id_data_kas, $nama_minggu, $id_lokasi)
    {
        $this->db->where('nama_minggu', $nama_minggu);
        $this->db->where('id_lokasi', $id_lokasi);
        $this->db->where('id_data_kas', $id_data_kas);
        $n = $this->db->get('fki_minggu')->num_rows();
        return $n;
    }

    public function laporan()
    {
        $this->load->library('pdfgenerator');

        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        //$orientation = "portrait";
        $orientation = "landscape";

        $id_minggu = $this->db->escape_str($this->uri->segment(3));

        $this->db->select('*');
        $this->db->from('fki_data');
        $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
        $this->db->join('fki_data_kas', 'fki_data_kas.id_data_kas = fki_minggu.id_data_kas');
        $this->db->join('fai_lokasi', 'fai_lokasi.id_lokasi = fki_minggu.id_lokasi');
        $this->db->join('fki_tipe', 'fki_tipe.id_tipe = fki_data.id_tipe');
        $this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
        $this->db->where('fki_data.id_minggu', $id_minggu);
        $this->db->where('fki_data.tgl_delete', null);
        $this->db->where('fki_data.id_status', 2);  // RAB
        $this->db->order_by('fki_data.tgl_data', 'asc');
        $this->db->order_by('fki_data.id_tipe', 'asc');
        $n = $this->db->get();

        //echo json_encode($data);
        //exit();

        if ($n->num_rows() > 0) {

            $this->db->select('fki_data.id_tipe');
            $this->db->from('fki_data');
            $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
            $this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
            $this->db->where('fki_data.id_minggu', $id_minggu);
            $this->db->where('fki_data.tgl_delete', null);
            $this->db->where('fki_data.id_status', 2);
            $this->db->where('fki_data.id_tipe <> 1');  //kecuali KAS
            $this->db->group_by('fki_data.id_tipe');
            $tipe = $this->db->get()->result();
            //echo json_encode($tipe);exit();

            $data = $n->result();
            $kas = '';
            $non_kas = '';

            $id_tipe = 1;

            // filename dari pdf ketika didownload
            $file_pdf = 'KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas);

            $ttl_saldo1 = 0;
            $ttl_saldo2 = 0;
            $table = '<title>KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</title><table border="1" style="width: 100%;"><tr style="background-color: gray;color: white;font-weight: bold;text-align: center;"><td colspan="8">KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td></tr>';
            $table .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Debet</td><td>Kredit(Rp)</td><td>Saldo</td><td>PIC</td><td>Nomor Kas</td></tr>';
            $table .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="8">UANG MASUK</td></tr>';

            $no = 1;
            foreach ($data as $v) {
                if ($v->id_tipe == 1) {
                    $table .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td></td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                    $ttl_saldo1 +=  $v->nominal_data * $v->qty_data;

                    if ($v->id_tipe > $id_tipe) {
                        $id_tipe = $v->id_tipe;
                    }

                    $no += 1;
                }
            }

            $table .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL KAS ' . strtoupper($data[0]->nama_lokasi) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table .= '</table>';

            $table2 = '<table border="1" style="width: 100%;">';
            $table2 .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Qty</td><td>Harga(Rp)</td><td>Jumlah(Rp)</td><td>PIC</td><td>Nomor Kas</td></tr>';

            foreach ($tipe as $id) {
                $no = 1;
                $ttl_saldo = 0;
                $ttl_pengajuan = 0;
                $tbl_sisa = '';
                foreach ($data as $v) {
                    if ($id->id_tipe == $v->id_tipe) {
                        if ($v->id_jenis_kas == 1) { //keluar
                            if ($no == 1) {
                                $table2 .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="8">' . $v->nama_tipe . '</td></tr>';
                            }

                            if ($v->nominal_data == 0) {
                                $table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>-</td><td style="text-align: left;font-weight: normal;">-</td><td>-</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                            } else {
                                $table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . (float)$v->qty_data . '</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                            }
                            //$table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . $v->qty_data . '</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                            $ntipe = $v->nama_tipe;
                            $ttl_saldo += $v->nominal_data * $v->qty_data;
                            $no += 1;
                        } elseif ($v->id_jenis_kas == 2) {
                            $ttl_pengajuan += $v->nominal_data * $v->qty_data;
                        }
                    }
                }

                $table2 .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                $ttl_saldo2 += $ttl_saldo;
                if ($ttl_pengajuan > 0) {
                    $table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN DANA ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_pengajuan, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                    $table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_pengajuan - $ttl_saldo, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                }
            }



            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN RAB ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL PENGELUARAN KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo2, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO RAB ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1 - $ttl_saldo2, 0, ',', '.') . '</td><td colspan="3"></td></tr>';

            $data_next = get_dana_kas_pengajuan_minggu($data[0]->id_minggu);
            if ($data[0]->nama_minggu !== 'Minggu 4') {
                $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN RAB ' . strtoupper($data_next->nama_minggu . ' ' . $data[0]->nama_lokasi) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($data_next->nominal_data + ($ttl_saldo1 - $ttl_saldo2) + get_data_penutupan($data[0]->id_minggu), 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA PENGAJUAN RAB ' . strtoupper($data_next->nama_minggu . ' ' . $data[0]->nama_lokasi) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($data_next->nominal_data + get_data_penutupan($data[0]->id_minggu), 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            }


            $table2 .= '</table>';

            echo $table . $table2;
            //$this->pdfgenerator->generate($table . $table2, $file_pdf, $paper, $orientation);
        } else {
            echo 'Data kosong';
        }
    }

    public function laporan_pdf()
    {
        $this->load->library('pdfgenerator');

        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        //$orientation = "portrait";
        $orientation = "landscape";

        $id_minggu = $this->db->escape_str($this->uri->segment(3));

        $this->db->select('*');
        $this->db->from('fki_data');
        $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
        $this->db->join('fki_data_kas', 'fki_data_kas.id_data_kas = fki_minggu.id_data_kas');
        $this->db->join('fai_lokasi', 'fai_lokasi.id_lokasi = fki_minggu.id_lokasi');
        $this->db->join('fki_tipe', 'fki_tipe.id_tipe = fki_data.id_tipe');
        $this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
        $this->db->where('fki_data.id_minggu', $id_minggu);
        $this->db->where('fki_data.tgl_delete', null);
        $this->db->where('fki_data.id_status', 2);  // RAB
        $this->db->order_by('fki_data.tgl_data', 'asc');
        $this->db->order_by('fki_data.id_tipe', 'asc');
        $n = $this->db->get();

        //echo json_encode($data);
        //exit();

        if ($n->num_rows() > 0) {

            $this->db->select('fki_data.id_tipe');
            $this->db->from('fki_data');
            $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
            $this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
            $this->db->where('fki_data.id_minggu', $id_minggu);
            $this->db->where('fki_data.tgl_delete', null);
            $this->db->where('fki_data.id_status', 2);
            $this->db->where('fki_data.id_tipe <> 1');  //kecuali KAS
            $this->db->group_by('fki_data.id_tipe');
            $tipe = $this->db->get()->result();
            //echo json_encode($tipe);exit();

            $data = $n->result();
            $kas = '';
            $non_kas = '';

            $id_tipe = 1;

            // filename dari pdf ketika didownload
            $file_pdf = 'MONITORING KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas);

            $ttl_saldo1 = 0;
            $ttl_saldo2 = 0;
            $table = '<title>KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</title><table border="1" style="width: 100%;"><tr style="background-color: gray;color: white;font-weight: bold;text-align: center;"><td colspan="8">KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td></tr>';
            $table .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Debet</td><td>Kredit(Rp)</td><td>Saldo</td><td>PIC</td><td>Nomor Kas</td></tr>';
            $table .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="8">UANG MASUK</td></tr>';

            $no = 1;
            foreach ($data as $v) {
                if ($v->id_tipe == 1) {
                    $table .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td></td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                    $ttl_saldo1 +=  $v->nominal_data * $v->qty_data;

                    if ($v->id_tipe > $id_tipe) {
                        $id_tipe = $v->id_tipe;
                    }

                    $no += 1;
                }
            }

            $table .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL KAS ' . strtoupper($data[0]->nama_lokasi) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table .= '</table>';

            $table2 = '<table border="1" style="width: 100%;">';
            $table2 .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Qty</td><td>Harga(Rp)</td><td>Jumlah(Rp)</td><td>PIC</td><td>Nomor Kas</td></tr>';

            foreach ($tipe as $id) {
                $no = 1;
                $ttl_saldo = 0;
                $ttl_pengajuan = 0;
                $tbl_sisa = '';
                foreach ($data as $v) {
                    if ($id->id_tipe == $v->id_tipe) {
                        if ($v->id_jenis_kas == 1) { //keluar
                            if ($no == 1) {
                                $table2 .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="8">' . $v->nama_tipe . '</td></tr>';
                            }

                            if ($v->nominal_data == 0) {
                                $table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>-</td><td style="text-align: left;font-weight: normal;">-</td><td>-</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                            } else {
                                $table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . (float)$v->qty_data . '</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                            }
                            //$table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . $v->qty_data . '</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                            $ntipe = $v->nama_tipe;
                            $ttl_saldo += $v->nominal_data * $v->qty_data;
                            $no += 1;
                        } elseif ($v->id_jenis_kas == 2) {
                            $ttl_pengajuan += $v->nominal_data * $v->qty_data;
                        }
                    }
                }

                $table2 .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                $ttl_saldo2 += $ttl_saldo;
                if ($ttl_pengajuan > 0) {
                    $table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN DANA ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_pengajuan, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                    $table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_pengajuan - $ttl_saldo, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                }
            }



            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN RAB ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL PENGELUARAN KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo2, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO RAB ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1 - $ttl_saldo2, 0, ',', '.') . '</td><td colspan="3"></td></tr>';

            $data_next = get_dana_kas_pengajuan_minggu($data[0]->id_minggu);
            if ($data[0]->nama_minggu !== 'Minggu 4') {
                $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN RAB ' . strtoupper($data_next->nama_minggu . ' ' . $data[0]->nama_lokasi) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($data_next->nominal_data + ($ttl_saldo1 - $ttl_saldo2) + get_data_penutupan($data[0]->id_minggu), 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA PENGAJUAN RAB ' . strtoupper($data_next->nama_minggu . ' ' . $data[0]->nama_lokasi) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($data_next->nominal_data + get_data_penutupan($data[0]->id_minggu), 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            }


            $table2 .= '</table>';


            $this->pdfgenerator->generate($table . $table2, $file_pdf, $paper, $orientation);
            echo $table . $table2;
        } else {
            echo 'Data kosong';
        }
    }

    public function laporan_xls()
    {
        $id_minggu = $this->db->escape_str($this->uri->segment(3));

        $this->db->select('*');
        $this->db->from('fki_data');
        $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
        $this->db->join('fki_data_kas', 'fki_data_kas.id_data_kas = fki_minggu.id_data_kas');
        $this->db->join('fai_lokasi', 'fai_lokasi.id_lokasi = fki_minggu.id_lokasi');
        $this->db->join('fki_tipe', 'fki_tipe.id_tipe = fki_data.id_tipe');
        $this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
        $this->db->where('fki_data.id_minggu', $id_minggu);
        $this->db->where('fki_data.tgl_delete', null);
        $this->db->where('fki_data.id_status', 2);  // RAB
        $this->db->order_by('fki_data.tgl_data', 'asc');
        $this->db->order_by('fki_data.id_tipe', 'asc');
        $n = $this->db->get();

        //echo json_encode($data);
        //exit();

        if ($n->num_rows() > 0) {

            $this->db->select('fki_data.id_tipe');
            $this->db->from('fki_data');
            $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
            $this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
            $this->db->where('fki_data.id_minggu', $id_minggu);
            $this->db->where('fki_data.tgl_delete', null);
            $this->db->where('fki_data.id_status', 2);
            $this->db->where('fki_data.id_tipe <> 1');  //kecuali KAS
            $this->db->group_by('fki_data.id_tipe');
            $tipe = $this->db->get()->result();
            //echo json_encode($tipe);exit();

            $data = $n->result();
            $kas = '';
            $non_kas = '';

            $id_tipe = 1;

            // filename dari pdf ketika didownload
            $file_pdf = 'Laporan Kas ' . $data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas;

            $ttl_saldo1 = 0;
            $ttl_saldo2 = 0;
            $table = '<title>KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</title><table border="1" style="width: 100%;"><tr style="background-color: gray;color: white;font-weight: bold;text-align: center;"><td colspan="8">KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td></tr>';
            $table .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Debet</td><td>Kredit(Rp)</td><td>Saldo</td><td>PIC</td><td>Nomor Kas</td></tr>';
            $table .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="8">UANG MASUK</td></tr>';

            $no = 1;
            foreach ($data as $v) {
                if ($v->id_tipe == 1) {
                    $table .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td></td><td style="text-align: right;">' . $v->nominal_data . '</td><td style="text-align: right;">' . $v->nominal_data * $v->qty_data . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                    $ttl_saldo1 +=  $v->nominal_data * $v->qty_data;

                    if ($v->id_tipe > $id_tipe) {
                        $id_tipe = $v->id_tipe;
                    }

                    $no += 1;
                }
            }

            $table .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL KAS ' . strtoupper($data[0]->nama_lokasi) . '</td><td style="text-align: right;font-weight: bold;">' . $ttl_saldo1 . '</td><td colspan="2"></td></tr>';
            $table .= '</table>';

            $table2 = '<table border="1" style="width: 100%;">';
            $table2 .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Qty</td><td>Harga(Rp)</td><td>Jumlah(Rp)</td><td>PIC</td><td>Nomor Kas</td></tr>';

            foreach ($tipe as $id) {
                $no = 1;
                $ttl_saldo = 0;
                $ttl_pengajuan = 0;
                $tbl_sisa = '';
                foreach ($data as $v) {
                    if ($id->id_tipe == $v->id_tipe) {
                        if ($v->id_jenis_kas == 1) { //keluar
                            if ($no == 1) {
                                $table2 .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="8">' . $v->nama_tipe . '</td></tr>';
                            }

                            if ($v->nominal_data == 0) {
                                $table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>-</td><td style="text-align: left;font-weight: normal;">-</td><td>-</td><td style="text-align: right;">' . $v->nominal_data . '</td><td style="text-align: right;">' . $v->nominal_data * $v->qty_data . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                            } else {
                                $table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . (float)$v->qty_data . '</td><td style="text-align: right;">' . $v->nominal_data . '</td><td style="text-align: right;">' . $v->nominal_data * $v->qty_data . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                            }
                            //$table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . $v->qty_data . '</td><td style="text-align: right;">' . $v->nominal_data . '</td><td style="text-align: right;">' . $v->nominal_data * $v->qty_data . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                            $ntipe = $v->nama_tipe;
                            $ttl_saldo += $v->nominal_data * $v->qty_data;
                            $no += 1;
                        } elseif ($v->id_jenis_kas == 2) {
                            $ttl_pengajuan += $v->nominal_data * $v->qty_data;
                        }
                    }
                }

                $table2 .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . $ttl_saldo . '</td><td colspan="2"></td></tr>';
                $ttl_saldo2 += $ttl_saldo;
                if ($ttl_pengajuan > 0) {
                    $table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN DANA ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . $ttl_pengajuan . '</td><td colspan="2"></td></tr>';
                    $table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . ($ttl_pengajuan - $ttl_saldo) . '</td><td colspan="2"></td></tr>';
                }
            }

            $data_next = get_dana_kas_pengajuan_minggu($data[0]->id_minggu);

            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN RAB ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . $ttl_saldo1 . '</td><td colspan="2"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL PENGELUARAN KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . $ttl_saldo2 . '</td><td colspan="2"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO RAB ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . ($ttl_saldo1 - $ttl_saldo2) . '</td><td colspan="2"></td></tr>';

            if ($data[0]->nama_minggu !== 'Minggu 4') {
                $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN RAB ' . strtoupper($data_next->nama_minggu . ' ' . $data[0]->nama_lokasi) .  '</td><td style="text-align: right;font-weight: bold;">' . ($data_next->nominal_data + ($ttl_saldo1 - $ttl_saldo2) + get_data_penutupan($data[0]->id_minggu)) . '</td><td colspan="2"></td></tr>';
                $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA PENGAJUAN RAB ' . strtoupper($data_next->nama_minggu . ' ' . $data[0]->nama_lokasi) .  '</td><td style="text-align: right;font-weight: bold;">' . ($data_next->nominal_data + get_data_penutupan($data[0]->id_minggu)) . '</td><td colspan="2"></td></tr>';
            }

            $table2 .= '</table>';

            //konversi ke excel
            $file = 'KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) . '.xls';
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$file");
            echo $table . $table2;
            //$this->pdfgenerator->generate($table . $table2, $file_pdf, $paper, $orientation);
        } else {
            echo 'Data kosong';
        }
    }

    public function upload_excel()
    {
        require_once 'excel_reader2.php';

        $id_data_kas = $this->db->escape_str($this->input->post('id_data_kas'));
        $id_minggu = $this->db->escape_str($this->input->post('id_minggu'));
        $id_tipe = $this->db->escape_str($this->input->post('id_tipe'));
        $id_status = $this->input->post('id_status');
        $id_jenis_kas = $this->input->post('id_jenis_kas');
        $n = 1;

        try {
            if ($_FILES["file_excel"]['type'] == "application/vnd.ms-excel") {
                if (move_uploaded_file($_FILES["file_excel"]["tmp_name"], "application/controllers/upload.xls")) {

                    $data = new Spreadsheet_Excel_Reader("application/controllers/upload.xls");
                    $baris = $data->rowcount();
                    $q = "INSERT INTO fki_data(id_data, deskripsi_data, tgl_data, id_minggu, id_tipe, id_status, id_jenis_kas, pic_data, qty_data, nominal_data, tgl_add, tgl_update, tgl_delete) VALUES";

                    for ($i = 2; $i <= $baris; $i++) {
                        if ($data->val($i, 1) > 0) {
                            /*echo $data->val($i, 1) . ' || ';
                            echo date('Y-m-d' , strtotime($data->val($i, 2))) . ' || ';
                            echo $data->val($i, 3) . ' || ';
                            echo $data->val($i, 4) . ' || ';
                            
                            echo str_replace("-Rp*", "", str_replace("Rp*", "", str_replace(",", "", $data->val($i, 5)))) . ' || ';
                            //echo $data->val($i, 5) . ' - ';
                            
                            echo str_replace("-Rp*", "", str_replace("Rp*", "", str_replace(",", "", $data->val($i, 6)))) . ' || ';
                            //echo $data->val($i, 6) . ' - ';
                            
                            echo $data->val($i, 7) . '<br>';*/
                            if ($n > 1) {
                                $q .= ",";
                            }

                            $q .= "('" . randid() . "','" . $data->val($i, 3) . "','" . date('Y-m-d', strtotime($data->val($i, 2))) . "','" . $id_minggu . "','" . $id_tipe . "','" . $id_status . "','" . $id_jenis_kas . "','" . $data->val($i, 7) . "'," . $data->val($i, 4) . ",'" . str_replace("-Rp*", "", str_replace("Rp*", "", str_replace(",", "", str_replace("-", "0", str_replace(" ", "", $data->val($i, 5)))))) . "','',null,null)";
                            $n += 1;
                        } else {
                            //echo '<br>';
                        }
                    }
                    //$q .= ")";
                    //echo $q;
                    //exit();

                    $this->db->query($q);

                    $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
                            <center><b>File XLS berhasil diupload</b></center></div>');
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
                            <center><b>Error tidak bisa diupload</b></center></div>');
                }
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
                        <center><b>Format file salah</b></center></div>');
            }
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }

        redirect('Kas_breakdown/detail/' . $id_data_kas . '/' . $id_minggu);
    }

    public function laporan_pdf_non_bpjs()
    {
        $this->load->library('pdfgenerator');

        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        //$orientation = "portrait";
        $orientation = "landscape";

        $id_minggu = $this->db->escape_str($this->uri->segment(3));

        $this->db->select('*');
        $this->db->from('fki_data');
        $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
        $this->db->join('fki_data_kas', 'fki_data_kas.id_data_kas = fki_minggu.id_data_kas');
        $this->db->join('fai_lokasi', 'fai_lokasi.id_lokasi = fki_minggu.id_lokasi');
        $this->db->join('fki_tipe', 'fki_tipe.id_tipe = fki_data.id_tipe');
        $this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
        $this->db->where('fki_data.id_minggu', $id_minggu);
        $this->db->where('fki_data.tgl_delete', null);
        $this->db->where('fki_data.id_status', 2);  // RAB
        $this->db->where('fki_data.id_tipe <> 8');  // Non bpjs
        $this->db->order_by('fki_data.tgl_data', 'asc');
        $this->db->order_by('fki_data.id_tipe', 'asc');
        $n = $this->db->get();

        //echo json_encode($data);
        //exit();

        if ($n->num_rows() > 0) {

            $this->db->select('fki_data.id_tipe');
            $this->db->from('fki_data');
            $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
            $this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
            $this->db->where('fki_data.id_minggu', $id_minggu);
            $this->db->where('fki_data.tgl_delete', null);
            $this->db->where('fki_data.id_status', 2);
            $this->db->where('fki_data.id_tipe <> 1');  //kecuali KAS
            $this->db->group_by('fki_data.id_tipe');
            $tipe = $this->db->get()->result();

            $data = $n->result();
            $kas = '';
            $non_kas = '';

            $id_tipe = 1;

            // filename dari pdf ketika didownload
            $file_pdf = 'MONITORING KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas);

            $ttl_saldo1 = 0;
            $ttl_saldo2 = 0;
            $table = '<title>KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</title><table border="1" style="width: 100%;"><tr style="background-color: gray;color: white;font-weight: bold;text-align: center;"><td colspan="8">KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td></tr>';
            $table .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Debet</td><td>Kredit(Rp)</td><td>Saldo</td><td>PIC</td><td>Nomor Kas</td></tr>';
            $table .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="8">UANG MASUK</td></tr>';

            $no = 1;
            foreach ($data as $v) {
                if (substr($v->deskripsi_data,0,4) !== 'BPJS') {// filter bpjs uangmasuk
                    if ($v->id_tipe == 1) {
                        $table .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td></td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                        $ttl_saldo1 +=  $v->nominal_data * $v->qty_data;

                        if ($v->id_tipe > $id_tipe) {
                            $id_tipe = $v->id_tipe;
                        }

                        $no += 1;
                    }
                }
            }

            $table .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL KAS ' . strtoupper($data[0]->nama_lokasi) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table .= '</table>';

            $table2 = '<table border="1" style="width: 100%;">';
            $table2 .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Qty</td><td>Harga(Rp)</td><td>Jumlah(Rp)</td><td>PIC</td><td>Nomor Kas</td></tr>';

            foreach ($tipe as $id) {
                $no = 1;
                $ttl_saldo = 0;
                $ttl_pengajuan = 0;
                $tbl_sisa = '';
                foreach ($data as $v) {
                    if ($id->id_tipe == $v->id_tipe) {
                        if ($v->id_jenis_kas == 1) { //keluar
                            if ($no == 1) {
                                $table2 .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="8">' . $v->nama_tipe . '</td></tr>';
                            }

                            if ($v->nominal_data == 0) {
                                $table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>-</td><td style="text-align: left;font-weight: normal;">-</td><td>-</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                            } else {
                                $table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . (float)$v->qty_data . '</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                            }
                            //$table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . $v->qty_data . '</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                            $ntipe = $v->nama_tipe;
                            $ttl_saldo += $v->nominal_data * $v->qty_data;
                            $no += 1;
                        } elseif ($v->id_jenis_kas == 2) {
                            $ttl_pengajuan += $v->nominal_data * $v->qty_data;
                        }
                    }
                }

                $table2 .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                $ttl_saldo2 += $ttl_saldo;
                if ($ttl_pengajuan > 0) {
                    $table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN DANA ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_pengajuan, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                    $table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_pengajuan - $ttl_saldo, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                }
            }



            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN RAB ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL PENGELUARAN KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo2, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO RAB ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1 - $ttl_saldo2, 0, ',', '.') . '</td><td colspan="3"></td></tr>';

            $data_next = get_dana_kas_pengajuan_minggu($data[0]->id_minggu);
            if ($data[0]->nama_minggu !== 'Minggu 4') {
                $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN RAB ' . strtoupper($data_next->nama_minggu . ' ' . $data[0]->nama_lokasi) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($data_next->nominal_data + ($ttl_saldo1 - $ttl_saldo2) + get_data_penutupan($data[0]->id_minggu), 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA PENGAJUAN RAB ' . strtoupper($data_next->nama_minggu . ' ' . $data[0]->nama_lokasi) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($data_next->nominal_data + get_data_penutupan($data[0]->id_minggu), 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            }


            $table2 .= '</table>';


            $this->pdfgenerator->generate($table . $table2, $file_pdf, $paper, $orientation);
            echo $table . $table2;
        } else {
            echo 'Data kosong';
        }
    }
}
