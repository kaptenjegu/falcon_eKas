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

        foreach($cust as $v){
            array_push($list_cust, array('value' => $v->cust_name,'data' => $v->cust_name));
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

        $this->db->where('status = 2 OR status = 3');
        $this->db->where('tgl_delete', null);
        $this->db->order_by('tgl_add', 'desc');
        $data['tender'] = $this->db->get('fmp_tender')->result();

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
            $nominal = $this->input->post('nominal');
            $tgl_kirim = $this->input->post('tgl_kirim');
            $pajak = $this->input->post('pajak');
            $deskripsi = $this->input->post('deskripsi');
            $tipe_tender = $this->input->post('tipe_tender');

            $data = array(
                'id_tender' => randid(),
                'no_penawaran' => $no_penawaran,
                'kontak_person' => $kontak_person,
                'email' => $email,
                'cust_name' => $cust_name,
                'nominal' => $nominal,
                'tgl_kirim' => $tgl_kirim,
                'pajak' => $pajak,
                'deskripsi' => $deskripsi,
                'tipe_tender' => $tipe_tender,
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
}
