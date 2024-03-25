<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bpjs extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        cek_login();
    }

    public function index()
    {
        $data['judul'] = 'Data Periode Bpjs';
        $data['page'] = 'Bpjs';
        $data['url'] = base_url('Bpjs');

        $this->db->where('tgl_delete', null);
        $this->db->order_by('nama_data_kas', 'desc');
        $data['data_kas'] = $this->db->get('fki_data_kas')->result();

        $this->load->view('header', $data);

        if (cek_permission($_SESSION['id_akun'], 'bpjs')) {
            $this->load->view('periode_bpjs', $data);
        }

        $this->load->view('footer');
    }

    public function detail()
    {
        $id_data_kas = $this->db->escape_str($this->uri->segment(3));
        $data['judul'] = 'Data Bpjs';
        $data['page'] = 'Bpjs';
        $data['url'] = base_url('Bpjs/detail/' . $id_data_kas);

        $this->db->where('fki_data_kas.tgl_delete', null);
        $this->db->where('fki_data_kas.id_data_kas', $id_data_kas);
        $data['judul_periode'] = $this->db->get('fki_data_kas')->first_row();

        $this->db->select('*');
        $this->db->from('fki_bpjs');
        $this->db->join('fki_data_kas', 'fki_bpjs.id_data_kas = fki_data_kas.id_data_kas');
        $this->db->where('fki_bpjs.id_data_kas', $id_data_kas);
        $this->db->where('fki_bpjs.tgl_delete', null);
        $data['bpjs'] = $this->db->get()->result();

        $this->load->view('header', $data);

        if (cek_permission($_SESSION['id_akun'], 'bpjs')) {
            $this->load->view('bpjs', $data);
        }

        $this->load->view('footer');
    }

    public function tambah_data()
    {
        try {
            $this->db->trans_start();

            $id_data_kas = $this->input->post('id_minggu');
            //$id_tipe = $this->input->post('id_tipe');
            //$id_status = $this->input->post('id_status');
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
                    'id_bpjs' => randid(),
                    'deskripsi_data' => $deskripsi_data[$n],
                    'tgl_data' => $tgl_data[$n],
                    'id_data_kas' => $id_data_kas,
                    //'id_tipe' => $id_tipe[$n],
                    //'id_status' => $id_status[$n],
                    'id_jenis_kas' => $id_jenis_kas[$n],
                    'pic_data' => $pic_data[$n],
                    'qty_data' => $qty_data[$n],
                    'nominal_data' => $nominal_data[$n]
                ));
            }
            $this->db->insert_batch('fki_bpjs', $data);

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

    public function edit_data()
    {
        try {
            $this->db->trans_start();

            $id_data_kas = $this->db->escape_str($this->input->post('id_data_kas'));
            $id_bpjs = $this->db->escape_str($this->input->post('id_bpjs'));
            $tgl_data = $this->input->post('tgl_data');
            $deskripsi_data = $this->input->post('deskripsi_data');
            $qty_data = $this->input->post('qty_data');
            $nominal_data = $this->input->post('nominal_data');
            $pic_data = $this->input->post('pic_data');
            $id_jenis_kas = $this->input->post('id_jenis_kas');

            $this->db->set('tgl_data', $tgl_data);
            $this->db->set('deskripsi_data', $deskripsi_data);
            $this->db->set('qty_data', $qty_data);
            $this->db->set('nominal_data', $nominal_data);
            $this->db->set('pic_data', $pic_data);
            $this->db->set('id_jenis_kas', $id_jenis_kas);
            $this->db->where('id_bpjs', $id_bpjs);
            $this->db->update('fki_bpjs');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data BPJS Sudah Diperbarui</b></center></div>');

            $this->db->trans_complete();

            //logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));

        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Bpjs/detail/' . $id_data_kas);
    }

    public function hapus_data()
    {
        try {
            $this->db->trans_start();

            $id_bpjs = $this->db->escape_str($this->uri->segment(3));
            $id_data_kas = $this->db->escape_str($this->uri->segment(4));

            $this->db->set('tgl_delete', date('Y-m-d H:i:s'));
            $this->db->where('id_bpjs', $id_bpjs);
            $this->db->update('fki_bpjs');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data BPJS Sudah Dihapus</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Bpjs/detail/' . $id_data_kas);
    }

    public function get_data()
    {
        try {
            $id_bpjs = $this->db->escape_str($this->uri->segment(3));

            $this->db->where('tgl_delete', null);
            $this->db->where('id_bpjs', $id_bpjs);
            $data = $this->db->get('fki_bpjs')->first_row();

            echo json_encode($data);
        } catch (\Throwable $e) {
            echo $e->getMessage();
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

        $id_data_kas = $this->db->escape_str($this->uri->segment(3));

        $this->db->select('*');
        $this->db->from('fki_data');
        $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
        $this->db->join('fki_data_kas', 'fki_data_kas.id_data_kas = fki_minggu.id_data_kas');
        $this->db->join('fai_lokasi', 'fai_lokasi.id_lokasi = fki_minggu.id_lokasi');
        $this->db->join('fki_tipe', 'fki_tipe.id_tipe = fki_data.id_tipe');
        $this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
        $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
        $this->db->where('fki_data.tgl_delete', null);
        $this->db->where('fki_data.id_status', 2);  // RAB
        //$this->db->where('fki_data.id_tipe = 8 OR (fki_data.id_tipe = 8 AND fki_data.deskripsi_data)');  // bpjs
        $this->db->where('substr(fki_data.deskripsi_data,1,4) = "BPJS"');  // bpjs
        $this->db->order_by('fki_data.tgl_data', 'asc');
        $this->db->order_by('fki_data.id_tipe', 'asc');
        $n = $this->db->get();

        //echo json_encode($data);
        //exit();

        if ($n->num_rows() > 0) {

            $data = $n->result();
            $id_tipe = 1;

            // filename dari pdf ketika didownload
            $file_pdf = 'LAPORAN BPJS BULAN ' . strtoupper($data[0]->nama_data_kas);

            $ttl_saldo1 = 0;
            $ttl_saldo2 = 0;
            $table = '<title>LAPORAN BPJS BULAN ' . strtoupper($data[0]->nama_data_kas) .  '</title><table border="1" style="width: 100%;"><tr style="background-color: gray;color: white;font-weight: bold;text-align: center;"><td colspan="8">LAPORAN BPJS BULAN ' . strtoupper($data[0]->nama_data_kas) .  '</td></tr>';
            //masuk
            $table .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Debet</td><td>Kredit(Rp)</td><td>Saldo</td><td>PIC</td><td>Nomor Kas</td></tr>';
            $table .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="8">UANG MASUK</td></tr>';

            //KELUAR
            $table2 = '<table border="1" style="width: 100%;">';
            $table2 .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Qty</td><td>Nominal(Rp)</td><td>Jumlah(Rp)</td><td>PIC</td><td>Nomor Kas</td></tr>';

            //load data
            $no1 = 1;
            $no2 = 1;
            foreach ($data as $v) {
                if ($v->id_jenis_kas == 2) {//masuk
                    $table .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no1 . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td></td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                    $ttl_saldo1 +=  $v->nominal_data * $v->qty_data;
                    $no1 += 1;
                }else{//keluar
                    $table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no2 . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td></td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                    $ttl_saldo2 +=  $v->nominal_data * $v->qty_data;
                    $no2 += 1;
                }
            }

            $table .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL </td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table .= '</table>';

            $table2 .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL </td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo2, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN BPJS OFFICE ' . strtoupper($data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL PENGELUARAN BPJS OFFICE ' . strtoupper($data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo2, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO BPJS OFFICE ' . strtoupper($data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1 - $ttl_saldo2, 0, ',', '.') . '</td><td colspan="3"></td></tr>';

           // $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN BPJS</td><td style="text-align: right;font-weight: bold;">0</td><td colspan="3"></td></tr>';
            //$table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA PENGAJUAN RAB ' . strtoupper($data_next->nama_minggu . ' ' . $data[0]->nama_lokasi) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($data_next->nominal_data + get_data_penutupan($data[0]->id_minggu), 0, ',', '.') . '</td><td colspan="3"></td></tr>';

            $table2 .= '</table>';

            $this->pdfgenerator->generate($table . $table2, $file_pdf, $paper, $orientation);
            echo $table . $table2;
        } else {
            echo 'Data kosong';
        }
    }
}
