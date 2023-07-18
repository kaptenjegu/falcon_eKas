<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kas_bulan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        //detection();
        //cek_login();
    }

    public function index()
    {
        echo '';
    }

    public function detail()
    {
        $id_data_kas = $this->db->escape_str($this->uri->segment(3));
        $data['judul'] = 'Data Kas Bulan ';
        $data['page'] = 'Kas_bulan';
        $data['url'] = base_url('Kas_bulan/detail/' . $id_data_kas);

        $this->db->where('id_data_kas', $id_data_kas);
        $n = $this->db->get('fki_data_kas');

        if ($n->num_rows() > 0) {

            $data['judul_periode'] = $n->first_row();

            $this->db->select('*');
            $this->db->from('fki_minggu');
            $this->db->join('fki_data_kas', 'fki_data_kas.id_data_kas = fki_minggu.id_data_kas');

            //if ($_SESSION['role_user'] == 2) {
                $this->db->where('id_lokasi', $_SESSION['id_lokasi']);
            //}

            $this->db->where('fki_minggu.tgl_delete', null);
            $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
            $this->db->order_by('fki_minggu.nama_minggu', 'desc');
            $data['data_minggu'] = $this->db->get()->result();

            $this->db->where('tgl_delete', null);
            $data['lokasi'] = $this->db->get('fai_lokasi')->result();

            $this->load->view('header', $data);
            $this->load->view('kas_bulan', $data);
            $this->load->view('footer');
        } else {
            echo 'ERROR';
        }
    }

    public function tambah_data()
    {
        try {
            $this->db->trans_start();

            $id_data_kas = $this->input->post('id_data_kas');
            $nama_minggu = $this->input->post('nama_minggu');
            $id_lokasi = $this->input->post('id_lokasi');
            $dana_pengajuan = $this->input->post('dana_pengajuan');

            if ($this->cek_data($id_data_kas, $nama_minggu, $id_lokasi) == 0) {

                $data = array(
                    'id_minggu' => randid(),
                    'nama_minggu' => $nama_minggu,
                    'id_lokasi' => $id_lokasi,
                    'id_data_kas' => $id_data_kas,
                    //'dana_pengajuan' => $dana_pengajuan
                );
                $this->db->insert('fki_minggu', $data);

                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Sudah Disimpan</b></center></div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>!!! Error : Data sudah ada !!!</b></center></div>');
            }

            $this->db->trans_complete();

            //logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));

        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Kas_bulan/detail/' . $id_data_kas);
    }

    public function edit_data()
    {
        try {
            $this->db->trans_start();

            $id_minggu = $this->db->escape_str($this->input->post('id_minggu'));
            $id_data_kas = $this->db->escape_str($this->input->post('id_data_kas'));
            $id_lokasi = $this->db->escape_str($this->input->post('id_lokasi'));
            $nama_minggu = $this->input->post('nama_minggu');
            $dana_pengajuan = $this->input->post('dana_pengajuan');

            //if ($this->cek_data($id_data_kas, $nama_minggu, $id_lokasi) == 0) {

            $this->db->set('nama_minggu', $nama_minggu);
            //$this->db->set('dana_pengajuan', $dana_pengajuan);
            $this->db->where('id_minggu', $id_minggu);
            $this->db->update('fki_minggu');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Kas Sudah Diperbarui</b></center></div>');
            //} else {
            //    $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
            //		<center><b>!!! Error : Data sudah ada !!!</b></center></div>');
            //}

            $this->db->trans_complete();

            //logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));

        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Kas_bulan/detail/' . $id_data_kas);
    }

    public function get_data()
    {
        try {
            $id = $this->db->escape_str($this->uri->segment(3));

            $this->db->where('id_minggu', $id);
            $data = $this->db->get('fki_minggu')->first_row();

            echo json_encode($data);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

    private function cek_data($id_data_kas, $nama_minggu, $id_lokasi)
    {
        $this->db->where('nama_minggu', $nama_minggu);
        $this->db->where('id_lokasi', $id_lokasi);
        $this->db->where('id_data_kas', $id_data_kas);
        $n = $this->db->get('fki_minggu')->num_rows();
        return $n;
    }
}
