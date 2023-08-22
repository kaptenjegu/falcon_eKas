<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_srmr extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        cek_login();
    }

    public function index()
    {
        $data['judul'] = 'Data Riwayat Permintaan';
        $data['page'] = 'Riwayat_srmr';
        $data['url'] = base_url('Riwayat_srmr');

        $this->db->where('status_data = 2 OR status_data = 3');

        if ($_SESSION['id_jabatan'] !== '80813326aa9f0dd7e6978e8bde1b3d6b') {
            $this->db->where('id_user', $_SESSION['id_akun']);
        }
        
        $this->db->where('tgl_delete', null);
        $data['srmr'] = $this->db->get('fsrmr_data')->result();

        $this->load->view('header', $data);
        $this->load->view('riwayat_srmr', $data);
        $this->load->view('footer');
    }
}