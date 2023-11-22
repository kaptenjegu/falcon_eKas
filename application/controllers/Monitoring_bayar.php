<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Monitoring_bayar extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        cek_login();
    }

    public function index()
    {
        $data['judul'] = 'Data PO / SO';
        $data['page'] = 'Monitoring_bayar';
        $data['url'] = base_url('Monitoring_bayar');

        if($_SESSION['id_jabatan'] == '6e5dfcdab3ed5991d49692be6442f415'){  //tax,sdm,akunting - mbak Lina
            $this->db->where('status_project', 2);  //lanjut pembayaran
            $data['step1'] = false;
        }else{
            $this->db->where('status_project', 1);  //procurement - po/so rilis
            $data['step1'] = true;
        }
        
        $this->db->where('tgl_delete', null);
        $data['data_sopo'] = $this->db->get('fmp_project')->result();

        $this->db->where('tgl_delete', null);
        $data['lokasi'] = $this->db->get('fai_lokasi')->result();

        $this->load->view('header', $data);

        if(cek_permission($_SESSION['id_akun'], 'monitoring_bayar')){
            $this->load->view('data_sopo', $data);
        }

        $this->load->view('footer');
    }

    public function riwayat()
    {
        $data['judul'] = 'Data Riwayat PO / SO';
        $data['page'] = 'Monitoring_riwayat_bayar';
        $data['url'] = base_url('Monitoring_bayar/riwayat/');

        /*if($_SESSION['id_jabatan'] == '6e5dfcdab3ed5991d49692be6442f415'){  //tax,sdm,akunting - mbak Lina
            $this->db->where('status_project', 2);  //lanjut pembayaran
        }else{
            $this->db->where('status_project', 1);  //procurement - po/so rilis
        }*/
        
        $this->db->where('tgl_delete', null);
        $data['data_sopo'] = $this->db->get('fmp_project')->result();

        $this->load->view('header', $data);

        if(cek_permission($_SESSION['id_akun'], 'monitoring_riwayat_bayar')){
            $this->load->view('data_sopo_riwayat', $data);
        }
        
        $this->load->view('footer');
    }

    public function tambah_data()
    {
        try {
            $this->db->trans_start();

            $nama_project = $this->input->post('nama_project');
            $nomor_project = $this->input->post('nomor_project');
            $tgl_mulai = $this->input->post('tgl_mulai');
            $durasi_project = $this->input->post('durasi_project');
            $nama_vendor = $this->input->post('nama_vendor');
            $nominal_project = $this->input->post('nominal_project');
            $jenis_project = $this->input->post('jenis_project');
            $lokasi_project = $this->input->post('lokasi_project');
            //$status_project = $this->input->post('status_project');

            if ($this->cek_data($nomor_project) == 0) {

                $data = array(
                    'id_project' => randid(),
                    'nama_project' => $nama_project,
                    'nomor_project' => $nomor_project,
                    'jenis_project' => $jenis_project,
                    'lokasi_project' => $lokasi_project,
                    'nama_vendor' => $nama_vendor,
                    'tgl_mulai' => $tgl_mulai,
                    'durasi_project' => $durasi_project,
                    'nominal_project' => $nominal_project,
                    'status_project' => 1,
                    'id_procurement' => $_SESSION['id_akun']
                );
                $this->db->insert('fmp_project', $data);

                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data PO/SO Disimpan</b></center></div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>!!! Error : Data PO/SOsudah ada !!!</b></center></div>');
            }

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Monitoring_bayar');
    }

    public function edit_data()
    {
        try {
            $this->db->trans_start();

            $id_project = $this->db->escape_str($this->input->post('id_project'));
            $nama_project = $this->input->post('nama_project');
            $nomor_project = $this->input->post('nomor_project');
            $tgl_mulai = $this->input->post('tgl_mulai');
            $durasi_project = $this->input->post('durasi_project');
            $nama_vendor = $this->input->post('nama_vendor');
            $nominal_project = $this->input->post('nominal_project');
            $jenis_project = $this->input->post('jenis_project');
            $lokasi_project = $this->input->post('lokasi_project');
            
            $this->db->set('nama_project', $nama_project);
            $this->db->set('nomor_project', $nomor_project);
            $this->db->set('tgl_mulai', $tgl_mulai);
            $this->db->set('durasi_project', $durasi_project);
            $this->db->set('nama_vendor', $nama_vendor);
            $this->db->set('nominal_project', $nominal_project);
            $this->db->set('jenis_project', $jenis_project);
            $this->db->set('lokasi_project', $lokasi_project);
            $this->db->where('id_project', $id_project);
            $this->db->update('fmp_project');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data PO/SO Diperbarui</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Monitoring_bayar');
    }

    public function hapus_data()
    {
        try {
            $this->db->trans_start();

            $id_project = $this->db->escape_str($this->uri->segment(3));

            $this->db->set('tgl_delete', date('Y-m-d H:i:s'));
            $this->db->where('id_project', $id_project);
            $this->db->update('fmp_project');

            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Data PO/SO Dihapus</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Monitoring_bayar');
    }

    public function setor_data()
    {
        try {
            $this->db->trans_start();

            $id_project = $this->db->escape_str($this->uri->segment(3));
            $id_setor = (int)$this->uri->segment(4);

            if($id_setor == 3){
                $this->db->set('id_keu', $_SESSION['id_akun']);
            }

            $this->db->set('status_project', $id_setor);
            $this->db->where('id_project', $id_project);
            $this->db->update('fmp_project');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data PO/SO berhasil diselesaikan</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Monitoring_bayar');
    }

    private function cek_data($nomor_project)
    {
        $this->db->where('nomor_project', $nomor_project);
        $this->db->where('tgl_delete', null);
        $n = $this->db->get('fmp_project')->num_rows();
        return $n;
    }

    public function get_data()
    {
        try {
            $id_project = $this->db->escape_str($this->uri->segment(3));

            $this->db->where('id_project', $id_project);
            $this->db->where('tgl_delete', null);
            $data = $this->db->get('fmp_project')->first_row();

            echo json_encode($data);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }
}
