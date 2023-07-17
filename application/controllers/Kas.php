<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kas extends CI_Controller
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
        $data['judul'] = 'Data Kas';
        $data['page'] = 'Kas';
        $data['url'] = base_url('Kas');

        $this->db->where('tgl_delete', null);
        $this->db->order_by('nama_data_kas', 'desc');
        $data['data_kas'] = $this->db->get('fki_data_kas')->result();

        $this->load->view('header', $data);
        $this->load->view('data_kas', $data);
        $this->load->view('footer');
    }

    public function tambah_data_kas()
    {
        try {
            $this->db->trans_start();
            $nama = $this->input->post('nama_data_kas');

            if ($this->cek_data_kas($nama) == 0) {

                $data = array(
                    'id_data_kas' => randid(),
                    'nama_data_kas' => $this->input->post('nama_data_kas')
                );
                $this->db->insert('fki_data_kas', $data);

                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Periode Data Kas Sudah Disimpan</b></center></div>');
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
        redirect('Kas');
    }

    public function edit_data()
    {
        try {
            $this->db->trans_start();

            $id = $this->db->escape_str($this->input->post('id_data_kas'));
            $nama = $this->input->post('nama_data_kas');

            if ($this->cek_data_kas($nama) == 0) {

                $this->db->set('nama_data_kas', $nama);
                $this->db->where('id_data_kas', $id);
                $this->db->update('fki_data_kas');

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
        redirect('Kas');
    }

    public function get_data_kas()
    {
        try {
            $id = $this->db->escape_str($this->uri->segment(3));

            $this->db->where('id_data_kas', $id);
            $this->db->order_by('nama_data_kas', 'desc');
            $data = $this->db->get('fki_data_kas')->first_row();

            echo json_encode($data);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

    private function cek_data_kas($nama)
    {
        $this->db->where('nama_data_kas', $nama);
        $n = $this->db->get('fki_data_kas')->num_rows();
        return $n;
    }
}
