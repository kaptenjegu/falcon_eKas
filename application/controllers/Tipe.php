<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tipe extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        cek_login();
    }

    public function index()
    {
        $data['judul'] = 'Data Tipe';
        $data['page'] = 'Tipe';
        $data['url'] = base_url('Tipe');

        $this->db->where('tgl_delete', null);
        $this->db->order_by('tgl_add', 'desc');
        $data['tipe'] = $this->db->get('fki_tipe')->result();

        $this->load->view('header', $data);

        if(cek_permission($_SESSION['id_akun'], 'kas_tipe')){
            $this->load->view('tipe', $data);
        }

        $this->load->view('footer');
    }

    public function tambah_data()
    {
        try {
            $this->db->trans_start();

            $nama_tipe = $this->input->post('nama_tipe');

            if ($this->cek_data($nama_tipe) == 0) {

                $data = array(
                    'id_tipe' => '',
                    'nama_tipe' => $nama_tipe
                );
                $this->db->insert('fki_tipe', $data);

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
        redirect('Tipe');
    }

    public function edit_data()
    {
        try {
            $this->db->trans_start();

            $id_tipe = (int)$this->input->post('id_tipe');
            $nama_tipe = $this->input->post('nama_tipe');

            if ($this->cek_data($nama_tipe) == 0) {

                $this->db->set('nama_tipe', $nama_tipe);
                $this->db->where('id_tipe', $id_tipe);
                $this->db->update('fki_tipe');

                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Kas Sudah Diperbarui</b></center></div>');
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
        redirect('Tipe');
    }

    public function hapus_data()
    {
        try {
            $this->db->trans_start();

            $id_tipe = (int)$this->uri->segment(3);

            $this->db->set('tgl_delete', date('Y-m-d H:i:s'));
            $this->db->where('id_tipe', $id_tipe);
            $this->db->update('fki_tipe');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Tipe Sudah Dihapus</b></center></div>');

            $this->db->trans_complete();

            //logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));

        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Tipe');
    }

    public function get_data()
    {
        try {
            $id = $this->db->escape_str($this->uri->segment(3));

            $this->db->where('id_tipe', $id);
            $data = $this->db->get('fki_tipe')->first_row();

            echo json_encode($data);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

    private function cek_data($nama_tipe)
    {
        $this->db->where('nama_tipe', $nama_tipe);
        $n = $this->db->get('fki_tipe')->num_rows();
        return $n;
    }
}
