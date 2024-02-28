<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tender extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        cek_login();
    }

    public function index()
    {
        $data['judul'] = 'Data Tender dan Marketing';
        $data['page'] = 'Tender';
        $data['url'] = base_url('Tender');
        $list_cust = array();

        $this->db->where('status', 1);
        $this->db->where('tgl_delete', null);
        $this->db->order_by('tgl_add', 'desc');
        $data['tender'] = $this->db->get('fmp_tender')->result();

        $this->db->select('cust_name');
        $cust = $this->db->get('fmp_tender')->result();

        foreach ($cust as $v) {
            array_push($list_cust, array('value' => $v->cust_name, 'data' => $v->cust_name));
        }
        $data['list_cust'] = json_encode($list_cust);
        //echo json_encode($list_cust);exit();

        $this->load->view('header', $data);

        if (cek_permission($_SESSION['id_akun'], 'tender')) {
            $this->load->view('tender', $data);
        }

        $this->load->view('footer');
    }

    public function riwayat()
    {
        $data['judul'] = 'Data Riwayat Tender dan Marketing';
        $data['page'] = 'Riwayat_tender';
        $data['url'] = base_url('Tender/riwayat/');
        $list_cust = array();

        $this->db->where('status = 2 OR status = 3');
        $this->db->where('tgl_delete', null);
        $this->db->order_by('tgl_add', 'desc');
        $data['tender'] = $this->db->get('fmp_tender')->result();

        $this->db->select('cust_name');
        $cust = $this->db->get('fmp_tender')->result();

        foreach ($cust as $v) {
            array_push($list_cust, array('value' => $v->cust_name, 'data' => $v->cust_name));
        }
        $data['list_cust'] = json_encode($list_cust);

        $this->load->view('header', $data);

        if (cek_permission($_SESSION['id_akun'], $data['page'])) {
            $this->load->view('riwayat_tender', $data);
        }

        $this->load->view('footer');
    }

    public function tambah_data()
    {
        try {
            $this->db->trans_start();

            $no_penawaran = $this->input->post('no_penawaran');
            $kontak_person = $this->input->post('kontak_person');
            $email = $this->input->post('email');
            $cust_name = $this->input->post('cust_name');
            $alamat = $this->input->post('alamat');
            $nominal = $this->input->post('nominal');
            $tgl_kirim = $this->input->post('tgl_kirim');
            $pajak = $this->input->post('pajak');
            $deskripsi = $this->input->post('deskripsi');
            $tipe_tender = $this->input->post('tipe_tender');
            $top = $this->input->post('top');

            $data = array(
                'id_tender' => randid(),
                'no_penawaran' => $no_penawaran,
                'kontak_person' => $kontak_person,
                'email' => $email,
                'cust_name' => $cust_name,
                'alamat' => $alamat,
                'nominal' => $nominal,
                'tgl_kirim' => $tgl_kirim,
                'pajak' => $pajak,
                'deskripsi' => $deskripsi,
                'tipe_tender' => $tipe_tender,
                'top' => $top,
                'status' => 1  //menunggu
            );
            $this->db->insert('fmp_tender', $data);

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Tender Sudah Disimpan</b></center></div>');


            $this->db->trans_complete();

            //logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));

        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Tender');
    }

    public function edit_data()
    {
        try {
            $this->db->trans_start();

            $id_tender = $this->db->escape_str($this->input->post('id_tender'));
            $no_penawaran = $this->input->post('no_penawaran');
            $kontak_person = $this->input->post('kontak_person');
            $email = $this->input->post('email');
            $cust_name = $this->input->post('cust_name');
            $alamat = $this->input->post('alamat');
            $deskripsi = $this->input->post('deskripsi');
            $nominal = $this->input->post('nominal');
            $tgl_kirim = $this->input->post('tgl_kirim');
            $tipe_tender = $this->input->post('tipe_tender');
            $pajak = $this->input->post('pajak');
            $status = $this->input->post('status');
            $alasan_status = $this->input->post('alasan_status');
            $top = $this->input->post('top');

            $this->db->set('no_penawaran', $no_penawaran);
            $this->db->set('kontak_person', $kontak_person);
            $this->db->set('email', $email);
            $this->db->set('cust_name', $cust_name);
            $this->db->set('alamat', $alamat);
            $this->db->set('deskripsi', $deskripsi);
            $this->db->set('nominal', $nominal);
            $this->db->set('tgl_kirim', $tgl_kirim);
            $this->db->set('tipe_tender', $tipe_tender);
            $this->db->set('pajak', $pajak);
            $this->db->set('status', $status);
            $this->db->set('alasan_status', $alasan_status);
            $this->db->set('top', $top);
            $this->db->where('id_tender', $id_tender);
            $this->db->update('fmp_tender');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Tender Sudah Diperbarui</b></center></div>');

            $this->db->trans_complete();

            //logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));

        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Tender');
    }

    public function edit_data_riwayat()
    {
        try {
            $this->db->trans_start();

            $id_tender = $this->db->escape_str($this->input->post('id_tender'));
            $no_penawaran = $this->input->post('no_penawaran');
            $kontak_person = $this->input->post('kontak_person');
            $email = $this->input->post('email');
            $cust_name = $this->input->post('cust_name');
            $alamat = $this->input->post('alamat');
            $deskripsi = $this->input->post('deskripsi');
            $nominal = $this->input->post('nominal');
            $tgl_kirim = $this->input->post('tgl_kirim');
            $tipe_tender = $this->input->post('tipe_tender');
            $pajak = $this->input->post('pajak');
            $status = $this->input->post('status');
            $alasan_status = $this->input->post('alasan_status');

            $this->db->set('no_penawaran', $no_penawaran);
            $this->db->set('kontak_person', $kontak_person);
            $this->db->set('email', $email);
            $this->db->set('cust_name', $cust_name);
            $this->db->set('alamat', $alamat);
            $this->db->set('deskripsi', $deskripsi);
            $this->db->set('nominal', $nominal);
            $this->db->set('tgl_kirim', $tgl_kirim);
            $this->db->set('tipe_tender', $tipe_tender);
            $this->db->set('pajak', $pajak);
            $this->db->set('status', $status);
            $this->db->set('alasan_status', $alasan_status);
            $this->db->where('id_tender', $id_tender);
            $this->db->update('fmp_tender');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Tender Sudah Diperbarui</b></center></div>');

            $this->db->trans_complete();

            //logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));

        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Tender/riwayat/');
    }

    public function hapus_data()
    {
        try {
            $this->db->trans_start();

            $id_tender = $this->db->escape_str($this->uri->segment(3));

            $this->db->set('tgl_delete', date('Y-m-d H:i:s'));
            $this->db->where('id_tender', $id_tender);
            $this->db->update('fmp_tender');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Tender Sudah Dihapus</b></center></div>');

            $this->db->trans_complete();

            //logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));

        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Tender');
    }

    public function get_data()
    {
        try {
            $id = $this->db->escape_str($this->uri->segment(3));

            $this->db->where('id_tender', $id);
            $this->db->where('tgl_delete', null);
            $data = $this->db->get('fmp_tender')->first_row();

            echo json_encode($data);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

    public function download()
    {
        try {
            $pdf = new PDF_MC_Table('P', 'mm', 'a4'); // h ,w

            //$id = $this->db->escape_str($this->uri->segment(3));
            $id = $this->db->escape_str($_GET['id_tender']);
            $lampiran = (int)$_GET['lampiran'];

            $this->db->where('id_tender', $id);
            $this->db->where('tgl_delete', null);
            $data = $this->db->get('fmp_tender')->first_row();

            $file_pdf = 'PENAWARAN ' . strtoupper($data->deskripsi);
            $pdf->SetTitle($file_pdf);
            $brd = 0;
            $brd2 = 0;

            $pdf->SetTextColor(22, 134, 183);
            $pdf->SetLineWidth(0.4);
            $pdf->AddPage();
            //$pdf->SetMargins(2, 2, 2);

            $y_logo1 = $pdf->getY();
            $x_logo1 = $pdf->getX();
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(190, 5, 'PT. Falcon Prima Tehnik', $brd2, 1, 'R'); //(w,h,txt,border,ln,align) h max 260, w max 190
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(190, 4, 'Telp. 031-59178698', $brd2, 1, 'R');
            $pdf->Cell(190, 4, 'E-mail. falcon@falcontehnik.com', $brd2, 1, 'R');
            $pdf->Cell(190, 4, 'falcon.tehnik@gmail.com', $brd2, 1, 'R');
            $pdf->Cell(190, 4, 'Website. https://falcontehnik.com', $brd2, 1, 'R');
            $pdf->Cell(190, 4, 'Jl. Klampis Semolo Barat X.71/L.38, Sukolilo, Surabaya, Jawa Timur 60119', $brd2, 1, 'R');

            //gambar
            $pdf->Image('vendor/image/logo_falcon.png', $x_logo1 + 2, $y_logo1 + 1, 45, 25, '', '#'); //(x,y,w,h) w = h + 20
            //$pdf->Image('vendor/image/logo_2.png', $x_logo1 + 20, $y_logo1 + 33, 150, 65, '', '#'); //watermark

            $pdf->SetDrawColor(255, 0, 0);
            $pdf->Line($x_logo1, $y_logo1 + 27, $x_logo1 + 190, $y_logo1 + 27);
            $pdf->Line($x_logo1, $y_logo1 + 27.5, $x_logo1 + 190, $y_logo1 + 27.5);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Times', '', 12);

            $pdf->Cell(190, 5, '', 0, 1, 'L');
            $pdf->Cell(190, 5, '', 0, 1, 'L');

            $pdf->Cell(10, 5, '', $brd, 0, 'R');
            $pdf->Cell(170, 5, 'Surabaya, ' . date('d M Y', strtotime($data->tgl_kirim)), $brd, 0, 'R');
            $pdf->Cell(10, 5, '', $brd, 1, 'R');

            $pdf->Cell(190, 5, '', $brd, 1, 'R');

            $pdf->Cell(10, 5, '', $brd, 0, 'R');
            $pdf->Cell(30, 5, 'Nomor Surat', $brd, 0, 'L');
            $pdf->Cell(5, 5, ':', $brd, 0, 'C');
            $pdf->Cell(135, 5, $data->no_penawaran, $brd, 0, 'L');
            $pdf->Cell(10, 5, '', $brd, 1, 'R');

            $pdf->SetWidths(array(10, 30, 5, 135, 10));
            $pdf->Row_tender(array('', 'Hal', ':', 'Surat Penawaran Pekerjaan ' . $data->deskripsi, ''));

            $pdf->Cell(10, 5, '', $brd, 0, 'R');
            $pdf->Cell(30, 5, 'Lampiran', $brd, 0, 'L');
            $pdf->Cell(5, 5, ':', $brd, 0, 'C');
            $pdf->Cell(135, 5,$lampiran ?? 0, $brd, 0, 'L');
            $pdf->Cell(10, 5, '', $brd, 1, 'R');

            $pdf->Cell(190, 5, '', $brd, 1, 'R');

            $pdf->Cell(10, 5, '', $brd, 0, 'R');
            $pdf->Cell(180, 5, 'Kepada Yth.', $brd, 1, 'L');

            $pdf->SetFont('Times', 'B', 12);
            //$pdf->Cell(10, 5, '', $brd, 0, 'R');
            //$pdf->Cell(180, 5, $data->cust_name, $brd, 1, 'L');
            $pdf->SetWidths(array(10, 170, 10));
            $pdf->Row_tender(array('',$data->cust_name,''));

            //$pdf->Cell(10, 5, '', $brd, 0, 'R');
            //$pdf->Cell(180, 5, $data->alamat, $brd, 1, 'L');
            $pdf->SetWidths(array(10, 170, 10));
            $pdf->Row_tender(array('',$data->alamat,''));
            $pdf->SetFont('Times', '', 12);

            $pdf->Cell(190, 5, '', $brd, 1, 'R');
            $pdf->Cell(190, 5, '', $brd, 1, 'R');

            $pdf->SetWidths(array(10, 170, 10));
            $pdf->Row_tender(array('', 'Berdasarkan Permintaan Penawaran Harga dari ' . $data->cust_name . '. Untuk Pekerjaan ' . $data->deskripsi . '. Bersama Surat Penawaran ini harga yang kami tawarkan adalah sebagai berikut :', ''));

            $pdf->SetFont('Times', 'B', 13);
            $pdf->Cell(190, 3, '', $brd, 1, 'R');
            $pdf->Cell(190, 7, 'Rp. ' . number_format($data->nominal, 0, '', ',') . ',-', $brd, 1, 'C');
            $pdf->Cell(190, 2, '', $brd, 1, 'R');

            $pdf->SetFont('Times', 'I', 13);
            //$pdf->Cell(10, 5, '', $brd, 0, 'R');
            //$pdf->Cell(170, 5, '(' . ucwords(terbilang($data->nominal)) . ' Rupiah)', $brd, 0, 'C');
            //$pdf->Cell(10, 5, '', $brd, 1, 'R');
            $pdf->SetWidths(array(5,5, 170, 10));
            $pdf->Row_tender(array('','','(' . ucwords(terbilang($data->nominal)) . ' Rupiah)',''));

            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(10, 5, '', $brd, 1, 'R');

            $pdf->Cell(10, 5, '', $brd, 0, 'L');
            $pdf->Cell(170, 5, 'Notes:', $brd, 0, 'L');
            $pdf->Cell(10, 5, '', $brd, 1, 'L');

            //filter pajak
            if($data->pajak == 1){
                $ket_pajak = 'sudah';
            }else{
                $ket_pajak = 'belum';
            }

            $pdf->Cell(11, 5, '', $brd, 0, 'L');
            $pdf->Cell(169, 5, '1. Rincian harga ada di lampiran.', $brd, 0, 'L');
            $pdf->Cell(10, 5, '', $brd, 1, 'L');
            $pdf->Cell(11, 5, '', $brd, 0, 'L');
            $pdf->Cell(169, 5, '2. Harga tersebut ' . $ket_pajak . ' termasuk pajak.', $brd, 0, 'L');
            $pdf->Cell(10, 5, '', $brd, 1, 'L');
            $pdf->Cell(11, 5, '', $brd, 0, 'L');
            $pdf->Cell(169, 5, '3. Masa berlaku Penawaran adalah 30 hari.', $brd, 0, 'L');
            $pdf->Cell(10, 5, '', $brd, 1, 'L');
            $pdf->Cell(11, 5, '', $brd, 0, 'L');
            $pdf->Cell(169, 5, '4. Term Of Payment : ', $brd, 0, 'L');
            $pdf->Cell(10, 5, '', $brd, 1, 'L');


            //$top = str_replace(PHP_EOL, '', $data->top);
            $top = trim(preg_replace('/\s+/', '',  $data->top));
            $top = explode('</li><li>', $top);

            for ($t = 0; $t < count($top); $t++) {                
                $pdf->Cell(20, 5, '', $brd, 0, 'L');                
                $y_top = $pdf->getY();
                $x_top = $pdf->getX();
                $pdf->RoundedRect($x_top + 0.5, $y_top + 2, 1, 1, 0.5, 'DF'); //x,y,w,h,radius
                $pdf->Cell(2, 5, '', $brd, 0, 'L');
                $pdf->Cell(158, 5, str_replace(array('<ul>', '</ul>', '<li>', '</li>'), '', $top[$t]), $brd, 0, 'L');
                $pdf->Cell(10, 5, '', $brd, 1, 'L');
            }

            $pdf->Cell(10, 5, '', $brd, 1, 'L');

            $pdf->SetWidths(array(10, 170, 10));
            $pdf->Row_tender(array('','Demikian Surat Penawaran dari kami, atas kesempatan yang diberikan dan kerjasamanya kami sampaikan terimakasih.',''));

            $pdf->Cell(10, 5, '', $brd, 1, 'L');

            $pdf->Cell(10, 5, '', $brd, 0, 'L');
            $pdf->Cell(130, 5, '', $brd, 0, 'L');
            $pdf->Cell(40, 5, 'PT. Falcon Prima Tehnik,', $brd, 0, 'C');
            $pdf->Cell(10, 5, '', $brd, 1, 'L');

            $pdf->Cell(10, 5, '', $brd, 1, 'L');
            $pdf->Cell(10, 5, '', $brd, 1, 'L');
            $pdf->Cell(10, 5, '', $brd, 1, 'L');
            $pdf->Cell(10, 5, '', $brd, 1, 'L');
            $pdf->Cell(10, 5, '', $brd, 1, 'L');

            $pdf->Cell(10, 5, '', $brd, 0, 'L');
            $pdf->Cell(130, 5, '', $brd, 0, 'L');
            $pdf->SetFont('Times', 'BU', 12);
            $pdf->Cell(40, 5, 'Mochammad Riz Attanto', $brd, 0, 'C');
            $pdf->Cell(10, 5, '', $brd, 1, 'L');

            $pdf->Cell(10, 5, '', $brd, 0, 'L');
            $pdf->Cell(130, 5, '', $brd, 0, 'L');
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(40, 5, 'Direktur Utama', $brd, 0, 'C');
            $pdf->Cell(10, 5, '', $brd, 1, 'L');

            $pdf->Output($file_pdf . '.pdf', 'I');
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }
}
