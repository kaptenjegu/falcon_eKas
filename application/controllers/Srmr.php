<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Srmr extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        cek_login();
    }

    public function index()
    {
        $data['judul'] = 'Data Permintaan';
        $data['page'] = 'Srmr';
        $data['url'] = base_url('Srmr');

        $this->db->where('status_data', 1);

        if ($_SESSION['id_jabatan'] !== '80813326aa9f0dd7e6978e8bde1b3d6b') {
            $this->db->where('id_user', $_SESSION['id_akun']);
        }

        $this->db->where('tgl_delete', null);
        $data['srmr'] = $this->db->get('fsrmr_data')->result();

        $this->load->view('header', $data);
        $this->load->view('srmr', $data);
        $this->load->view('footer');
    }

    public function tambah_data()
    {
        $data['judul'] = 'Data Permintaan';
        $data['page'] = 'srmr_manage';
        $data['url'] = base_url('Srmr');
        $data['data_srmr'] = [];

        /*$this->db->where('tgl_delete', null);
        $data['lokasi'] = $this->db->get('fai_lokasi')->result();

        $this->db->where('id_user', $_SESSION['id_akun']);
        $this->db->where('tgl_delete', null);
        $data['srmr'] = $this->db->get('fsrmr_data')->result();*/

        $this->load->view('header', $data);
        $this->load->view('srmr_tambah', $data);
        $this->load->view('footer');
    }

    public function edit_data()
    {
        $data['judul'] = 'Data Permintaan';
        $data['page'] = 'srmr_manage';
        $data['url'] = base_url('Srmr');
        $id_data = $this->db->escape_str($this->uri->segment(3));

        $this->db->where('id_data', $id_data);
        $this->db->where('tgl_delete', null);
        $data['data_srmr'] = $this->db->get('fsrmr_detail')->result();

        $this->db->where('id_data', $id_data);
        $this->db->where('tgl_delete', null);
        $data['srmr'] = $this->db->get('fsrmr_data')->first_row();

        $this->load->view('header', $data);
        $this->load->view('srmr_edit', $data);
        $this->load->view('footer');
    }

    public function simpan_data()
    {
        try {
            $this->db->trans_start();

            $tgl_data = $this->input->post('tgl_data');
            $proyek_data = $this->input->post('proyek_data');
            $subject_data = $this->input->post('subject_data');
            $customer_data = $this->input->post('customer_data');
            $kode_proyek = $this->input->post('kode_proyek');
            $jenis_data = $this->input->post('jenis_data');
            $id_data = randid();
            $estimasi_data = $this->input->post('estimasi_data');
            $deskripsi_data = $this->input->post('deskripsi_data');
            $spek_data = $this->input->post('spek_data');
            $qty_data = $this->input->post('qty_data');
            $satuan_data = $this->input->post('satuan_data');
            $nominal_data = $this->input->post('nominal_data');
            $remark_data = $this->input->post('remark_data');

            $data = array(
                'id_data' => $id_data,
                'jenis_data' => $jenis_data,
                'nomor_data' => $this->penomoran($jenis_data, $kode_proyek),
                'tgl_data' => $tgl_data,
                'proyek_data' => $proyek_data,
                'subject_data' => $subject_data,
                'customer_data' => $customer_data,
                'kode_proyek' => $kode_proyek,
                'status_data' => 1, //1 - dibuat
                'id_user' => $_SESSION['id_akun']
            );
            $this->db->insert('fsrmr_data', $data);

            $data = array();

            for ($n = 0; $n <= count($deskripsi_data) - 1; $n++) {
                if ((int)$nominal_data[$n] > 0) {
                    array_push($data, array(
                        'id_detail' => randid(),
                        'id_data' => $id_data,
                        'deskripsi_data' => $deskripsi_data[$n],
                        'estimasi_data' => $estimasi_data[$n] ?? null,
                        'spek_data' => $spek_data[$n],
                        'qty_data' => $qty_data[$n],
                        'satuan_data' => $satuan_data[$n],
                        'nominal_data' => $nominal_data[$n],
                        'remark_data' => $remark_data[$n]
                    ));
                }
            }
            $this->db->insert_batch('fsrmr_detail', $data);

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Sudah Disimpan</b></center></div>');

            $this->db->trans_complete();

            //logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));

        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Srmr');
    }

    public function simpan_edit_data()
    {
        try {
            $this->db->trans_start();

            $tgl_data = $this->input->post('tgl_data');
            $proyek_data = $this->input->post('proyek_data');
            $subject_data = $this->input->post('subject_data');
            $customer_data = $this->input->post('customer_data');
            $kode_proyek = $this->input->post('kode_proyek');
            $jenis_data = $this->input->post('jenis_data');
            $id_data = $this->db->escape_str($this->input->post('id_data'));

            $this->db->set('tgl_data', $tgl_data);
            $this->db->set('proyek_data', $proyek_data);
            $this->db->set('subject_data', $subject_data);
            $this->db->set('customer_data', $customer_data);
            $this->db->set('kode_proyek', $kode_proyek);
            $this->db->set('jenis_data', $jenis_data);
            $this->db->where('id_data', $id_data);
            $this->db->update('fsrmr_data');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Sudah Diperbarui</b></center></div>');

            $this->db->trans_complete();

            //logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));

        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Srmr');
    }

    public function simpan_edit_detail()
    {
        try {
            $this->db->trans_start();

            $estimasi_data = $this->input->post('estimasi_data');
            $deskripsi_data = $this->input->post('deskripsi_data');
            $qty_data = $this->input->post('qty_data');
            $satuan_data = $this->input->post('satuan_data');
            $nominal_data = $this->input->post('nominal_data');
            $remark_data = $this->input->post('remark_data');
            $id_data = $this->db->escape_str($this->input->post('id_data'));
            $id_detail = $this->db->escape_str($this->input->post('id_detail'));

            $this->db->set('estimasi_data', $estimasi_data);
            $this->db->set('deskripsi_data', $deskripsi_data);
            $this->db->set('qty_data', $qty_data);
            $this->db->set('satuan_data', $satuan_data);
            $this->db->set('nominal_data', $nominal_data);
            $this->db->set('remark_data', $remark_data);
            $this->db->where('id_detail', $id_detail);
            $this->db->update('fsrmr_detail');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Item Sudah Diperbarui</b></center></div>');

            $this->db->trans_complete();

            //logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));

        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Srmr/edit_data/' . $id_data);
    }

    public function hapus_data()
    {
        try {
            $this->db->trans_start();

            $id_data = $this->db->escape_str($this->uri->segment(3));

            $this->db->set('tgl_delete', date('Y-m-d H:i:s'));
            $this->db->where('id_data', $id_data);
            $this->db->update('fsrmr_data');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Permintaan Berhasil Dihapus</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Error :' . $e->getMessage() . '</b></center></div>');
        }
        redirect('Srmr');
    }

    public function hapus_detail()
    {
        try {
            $this->db->trans_start();

            $id_data = $this->db->escape_str($this->uri->segment(3));
            $id_detail = $this->db->escape_str($this->uri->segment(4));

            $this->db->set('tgl_delete', date('Y-m-d H:i:s'));
            $this->db->where('id_detail', $id_detail);
            $this->db->update('fsrmr_detail');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Permintaan Berhasil Dihapus</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Error :' . $e->getMessage() . '</b></center></div>');
        }
        redirect('Srmr/edit_data/' . $id_data);
    }

    public function get_data()
    {
        try {
            $id = $this->db->escape_str($this->uri->segment(3));

            $this->db->where('id_detail', $id);
            $data = $this->db->get('fsrmr_detail')->first_row();

            echo json_encode($data);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

    private function penomoran($jenis_data, $kode)
    {
        $this->db->where('kode_proyek', $kode);
        $this->db->where('jenis_data', $jenis_data);
        $n = $this->db->get('fsrmr_data');

        if ($n->num_rows() > 0) {
            $data = $n->first_row();
            $nomor = $data->nomor_data + 1;
        } else {
            $nomor = 1;
        }

        return $nomor;
    }

    public function download_dokumen()
    {
        //LOAD DATA
        $id_data = $this->db->escape_str($this->uri->segment(3));

        $this->db->select('*');
        $this->db->from('fsrmr_data');
        //$this->db->join('fai_lokasi', 'fsrmr_data.id_lokasi = fai_lokasi.id_lokasi');
        $this->db->join('fai_akun', 'fsrmr_data.id_user = fai_akun.id_akun');
        $this->db->where('fsrmr_data.id_data', $id_data);
        $this->db->where('fsrmr_data.tgl_delete', null);
        $n = $this->db->get();

        if ($n->num_rows() > 0) {
            $data = $n->first_row();
            $nomor = format_nomor_dokumen($data->kode_proyek, $data->nomor_data, $data->jenis_data);


            if ($data->jenis_data == 1) {
                $jd = 'SR';
                $jh = 'JASA';
                $judul_head = 'SERVICE REQUEST (SR)';
            } else {
                $jd = 'MR';
                $jh = 'BARANG';
                $judul_head = 'MATERIAL REQUEST (MR)';
            }

            //LOAD DETAIL ITEM
            $this->db->where('id_data', $id_data);
            $this->db->where('tgl_delete', null);
            $detail = $this->db->get('fsrmr_detail')->result();

            $ttl_saldo1 = 0;

            //LOAD PDF
            $pdf = new PDF_MC_Table('L', 'mm', 'a4'); // h ,w

            $brd = 1;
            $brd2 = 0;
            $np = 1;
            $max_data = 8;
            $pdf->SetTitle($nomor);

            $pdf->SetFont('Times', 'B', 10);
            $pdf->SetLineWidth(0.4);
            $pdf->AddPage();

            $y_logo1 = $pdf->getY();
            $x_logo1 = $pdf->getX();

            $pdf->SetTextColor(5, 86, 250);
            $pdf->Cell(270, 5, 'PT. Falcon Prima Tehnik', $brd2, 1, 'R'); //(w,h,txt,border,ln,align) h max 260, w max 190
            $pdf->SetFont('Times', '', 8);
            $pdf->Cell(270, 3, 'E-mail. falcon@falcontehnik.com', $brd2, 1, 'R');
            $pdf->Cell(270, 3, 'falcon.tehnik@gmail.com', $brd2, 1, 'R');
            $pdf->Cell(270, 3, 'Website. https://falcontehnik.com', $brd2, 1, 'R');
            $pdf->Cell(270, 3, 'Jl. Klampis Semolo Barat X.71/L.38, Sukolilo, Surabaya, Jawa Timur 60119', $brd2, 1, 'R');
            $y_kanan_akhir = $pdf->getY();
            $pdf->SetTextColor(0, 0, 0);

            //gambar
            $pdf->Image('vendor/image/logo_falcon.png', $x_logo1 + 2, $y_logo1 + 1, 30, 15, '', '#'); //(x,y,w,h)
            //$pdf->Image('vendor/image/logo_2.png', $x_logo1 + 20, $y_logo1 + 33, 150, 65, '', '#'); //watermark

            $pdf->SetFont('Times', 'B', 12);
            $pdf->SetTextColor(0, 0, 0);

            //top
            $pdf->Line($x_logo1, $y_logo1, $x_logo1 + 270, $y_logo1);

            //top2
            $pdf->Line($x_logo1, $y_logo1 + 17, $x_logo1 + 270, $y_logo1 + 17);

            //left
            $pdf->Line($x_logo1, $y_logo1, $x_logo1, $y_kanan_akhir);

            //right
            $pdf->Line($x_logo1 + 270, $y_logo1, $x_logo1 + 270, $y_kanan_akhir);

            $pdf->SetFont('Times', 'BU', 10);
            $pdf->Cell(270, 5, 'PERMINTAAN PENGADAAN ' . $jh, $brd2, 1, 'C');
            $pdf->SetFont('Times', 'B', 10);
            $pdf->Cell(270, 5, $judul_head, $brd2, 1, 'C');

            $xhead = $pdf->getX();
            $yhead = $pdf->getY();

            $pdf->Cell(35, 5, 'Project', $brd2, 0, 'L');
            $pdf->Cell(5, 5, ':', $brd2, 0, 'C');
            $pdf->Cell(80, 5, $data->proyek_data, $brd2, 0, 'L');
            $pdf->Cell(40, 5, 'Subject : ' . $data->subject_data, $brd2, 0, 'L');
            $pdf->Cell(6, 5, '', $brd2, 0, 'C');
            $pdf->Cell(10, 5, '', $brd2, 0, 'C');
            $pdf->Cell(35, 5, 'Number', $brd2, 0, 'L');
            $pdf->Cell(5, 5, ':', $brd2, 0, 'C');
            $pdf->Cell(54, 5, $nomor, $brd2, 1, 'L');

            $pdf->Cell(35, 5, 'Customer', $brd2, 0, 'L');
            $pdf->Cell(5, 5, ':', $brd2, 0, 'C');
            $pdf->Cell(80, 5, $data->customer_data, $brd2, 0, 'L');
            $pdf->Cell(40, 5, '', $brd2, 0, 'L');
            $pdf->Cell(6, 5, '', $brd2, 0, 'C');
            $pdf->Cell(10, 5, '', $brd2, 0, 'C');
            $pdf->Cell(35, 5, 'Date', $brd2, 0, 'L');
            $pdf->Cell(5, 5, ':', $brd2, 0, 'C');
            $pdf->Cell(54, 5, date('d-M-y', strtotime($data->tgl_data)), $brd2, 1, 'L');

            $pdf->Cell(35, 5, 'PO/ SPK No.', $brd2, 0, 'L');
            $pdf->Cell(5, 5, ':', $brd2, 0, 'C');
            $pdf->Cell(80, 5, '', $brd2, 0, 'L');
            $pdf->Cell(40, 5, 'Proses Pengadaan : ', 0, 'L');
            $pdf->Cell(6, 5, '', $brd2, 0, 'C');
            $pdf->Cell(10, 5, '', $brd2, 0, 'C');
            $pdf->Cell(35, 5, 'Schedule Expect', $brd2, 0, 'L');
            $pdf->Cell(5, 5, ':', $brd2, 0, 'C');
            $pdf->Cell(54, 5, '', $brd2, 1, 'L');

            $pdf->Cell(35, 5, 'BQ/ Dwg No.', $brd2, 0, 'L');
            $pdf->Cell(5, 5, ':', $brd2, 0, 'C');
            $pdf->Cell(80, 5, '', $brd2, 0, 'L');
            $pdf->Cell(40, 5, 'Pembelian Cash', $brd2, 0, 'L');
            $pdf->Cell(6, 5, '(  )', $brd2, 0, 'C');
            $pdf->Cell(10, 5, '', $brd2, 0, 'C');
            $pdf->Cell(35, 5, 'Revision', $brd2, 0, 'L');
            $pdf->Cell(5, 5, ':', $brd2, 0, 'C');
            $pdf->Cell(54, 5, '', $brd2, 1, 'L');

            $pdf->Cell(35, 5, 'Approve Budget', $brd2, 0, 'L');
            $pdf->Cell(5, 5, ':', $brd2, 0, 'C');
            $pdf->Cell(80, 5, '', $brd2, 0, 'L');
            $pdf->Cell(40, 5, 'Penunjukan Langsung', $brd2, 0, 'L');
            $pdf->Cell(6, 5, '(  )', $brd2, 0, 'C');
            $pdf->Cell(10, 5, '', $brd2, 0, 'C');
            $pdf->Cell(35, 5, 'Page', $brd2, 0, 'L');
            $pdf->Cell(5, 5, ':', $brd2, 0, 'C');
            $pdf->Cell(54, 5, '', $brd2, 1, 'L');

            $pdf->Cell(35, 5, '(Harga sesuai RAB)', $brd2, 0, 'L');
            $pdf->Cell(5, 5, ':', $brd2, 0, 'C');
            $pdf->Cell(80, 5, '', $brd2, 0, 'L');
            $pdf->Cell(40, 5, 'Pemilihan Langsung : ', $brd2, 0, 'L');
            $pdf->Cell(6, 5, '(  )', $brd2, 0, 'C');
            $pdf->Cell(10, 5, '', $brd2, 0, 'C');
            $pdf->Cell(35, 5, '', $brd2, 0, 'L');
            $pdf->Cell(5, 5, '', $brd2, 0, 'C');
            $pdf->Cell(54, 5, '', $brd2, 1, 'L');

            $pdf->Cell(270, 5, '', $brd, 1, 'L');

            //header tabel
            $pdf->Cell(10, 10, 'No.', $brd, 0, 'C');
            $pdf->Cell(55, 10, 'Item Description', $brd, 0, 'C');
            $pdf->Cell(55, 10, 'Specification', $brd, 0, 'C');
            $pdf->Cell(15, 10, 'Qty', $brd, 0, 'C');
            $pdf->Cell(20, 10, 'Satuan', $brd, 0, 'C');
            $pdf->Cell(30, 10, 'Estimated Date', $brd, 0, 'C');
            $pdf->Cell(55, 5, 'Owner Estimate/HEP', $brd, 0, 'C');
            $pdf->Cell(30, 10, 'Remark', $brd, 1, 'C');
            //sub header
            $pdf->setY(77);
            $pdf->setX(195);
            $pdf->Cell(27.5, 5, 'Unit Price (Rp)', $brd, 0, 'C');
            $pdf->Cell(27.5, 5, 'Total Price (Rp)', $brd, 1, 'C');

            //isi data
            $pdf->SetWidths(array(10, 55, 55, 15, 20, 30, 27.5, 27.5, 30));
            $no = 1;
            $pdf->SetFont('Times', '', 10);
            foreach ($detail as $v) {
                if ($v->estimasi_data !== '0000-00-00') {
                    $estimasi = date('d-M-y', strtotime($v->estimasi_data));
                } else {
                    $estimasi = '-';
                }

                $pdf->Rowsrmr(array($no, $v->deskripsi_data, $v->spek_data, (float)$v->qty_data, $v->satuan_data, $estimasi, number_format($v->nominal_data, 0, ',', '.'), number_format($v->qty_data * $v->nominal_data, 0, ',', '.'), $v->remark_data));
                $ttl_saldo1 += ($v->qty_data * $v->nominal_data);
                $no += 1;
            }

            if ($no - 1 < 10) {
                for ($x = $no; $x <= 10; $x++) {
                    $pdf->Rowsrmr(array('', '', '', '', '', '', '', '', ''));
                    //$no += 1;
                }
            }

            $pdf->SetFont('Times', 'B', 10);
            $pdf->Cell(212.5, 5, 'TOTAL BIAYA (Rp)', $brd, 0, 'C');
            $pdf->Cell(27.5, 5, number_format($ttl_saldo1, 0, ',', '.'), $brd, 0, 'R');
            $pdf->Cell(30, 5, '', $brd, 1, 'C');

            $xttd = $pdf->getx();
            $yttd = $pdf->gety();
            //TTD - h = 35; w = 50
            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(50, 5, 'Prepared by,', $brd2, 0, 'C');
            $pdf->Cell(50, 5, '', $brd2, 0, 'C');
            $pdf->Cell(70, 5, 'Reviewed by,', $brd2, 0, 'C');
            $pdf->Cell(50, 5, '', $brd2, 0, 'C');
            $pdf->Cell(50, 5, 'Approved by,', $brd2, 1, 'C');
            $pdf->SetFont('Times', 'B', 10);

            $pdf->Cell(50, 5, '', $brd2, 0, 'C');
            $pdf->Cell(50, 5, '', $brd2, 0, 'C');
            $pdf->Cell(70, 5, '', $brd2, 0, 'C');
            $pdf->Cell(50, 5, '', $brd2, 0, 'C');
            $pdf->Cell(50, 5, '', $brd2, 1, 'C');

            $pdf->Cell(50, 5, '', $brd2, 0, 'C');
            $pdf->Cell(50, 5, '', $brd2, 0, 'C');
            $pdf->Cell(70, 5, '', $brd2, 0, 'C');
            $pdf->Cell(50, 5, '', $brd2, 0, 'C');
            $pdf->Cell(50, 5, '', $brd2, 1, 'C');

            $pdf->Cell(50, 5, '', $brd2, 0, 'C');
            $pdf->Cell(50, 5, '', $brd2, 0, 'C');
            $pdf->Cell(70, 5, '', $brd2, 0, 'C');
            $pdf->Cell(50, 5, '', $brd2, 0, 'C');
            $pdf->Cell(50, 5, '', $brd2, 1, 'C');

            $pdf->Cell(50, 5, $data->nama_user, $brd2, 0, 'C');
            $pdf->Cell(50, 5, 'Feby Oktavia', $brd2, 0, 'C');
            $pdf->Cell(70, 5, 'M. Rohman Majid', $brd2, 0, 'C');
            $pdf->Cell(50, 5, 'Kurnia Dwi Aprilina', $brd2, 0, 'C');
            $pdf->Cell(50, 5, 'Ike Wahyu Setiyowati', $brd2, 1, 'C');

            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(50, 5, 'Procurement', $brd2, 0, 'C');
            $pdf->Cell(50, 5, 'Cost Control', $brd2, 0, 'C');
            $pdf->Cell(70, 5, 'Manager Ops & Engineering', $brd2, 0, 'C');
            $pdf->Cell(50, 5, 'Accounting & Tax', $brd2, 0, 'C');
            $pdf->Cell(50, 5, 'Direktur Operasional', $brd2, 1, 'C');

            $pdf->Cell(50, 5, 'Date : ', $brd2, 0, 'L');
            $pdf->Cell(50, 5, 'Date : ', $brd2, 0, 'L');
            $pdf->Cell(70, 5, '', $brd2, 0, 'C');
            $pdf->Cell(50, 5, 'Date : ', $brd2, 0, 'L');
            $pdf->Cell(50, 5, 'Date : ', $brd2, 1, 'L');

            //header kotak
            $pdf->setx($xhead);
            $pdf->sety($yhead);
            $pdf->Cell(120, 30, '', $brd, 0, 'C');
            $pdf->Cell(56, 30, '', $brd, 0, 'C');
            $pdf->Cell(94, 30, '', $brd, 0, 'C');

            //Kotak ttd
            $pdf->setx($xttd);
            $pdf->sety($yttd);
            $pdf->Cell(50, 35, '', $brd, 0, 'C');
            $pdf->Cell(170, 35, '', $brd, 0, 'C');
            $pdf->Cell(50, 35, '', $brd, 0, 'C');

            //ttd mas Majid
            $pdf->Image('vendor/image2/ttd1.png', 129, 143, 30, 15, '', '#'); //(x,y,w,h)

            //ttd pembuat
            $pdf->Image('vendor/image2/' . $data->id_user . '.png', 20, 143, 30, 15, '', '#'); //(x,y,w,h)


            $pdf->Output($nomor . '.pdf', 'I');
        } else {
            echo 'Data kosong';
        }
    }

    public function acc_data()
    {
        try {
            $this->db->trans_start();
            $id_data = $this->db->escape_str($this->uri->segment(3));

            $this->db->set('status_data', 2);   //disetujui
            $this->db->where('id_data', $id_data);
            $this->db->update('fsrmr_data');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
            <center><b>Data Permintaan Sudah Diproses</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Srmr');
    }

    public function nacc_data()
    {
        try {
            $this->db->trans_start();
            $id_data = $this->db->escape_str($this->uri->segment(3));

            $this->db->set('status_data', 3);   //ditolak
            $this->db->where('id_data', $id_data);
            $this->db->update('fsrmr_data');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
            <center><b>Data Permintaan Sudah Diproses</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Srmr');
    }
}
