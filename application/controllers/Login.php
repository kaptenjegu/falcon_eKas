<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        detection();
    }

    public function index()
    {
        session_destroy();
        $this->load->view('login');
    }

    public function cek_akun()
    {
        $email = $this->db->escape_str($this->input->post('email'));
        $password = $this->input->post('password');
        
        $this->db->where('email', $email);
        $this->db->where('password', md5($password));
        $this->db->where('(role_user = 2 OR role_user = 3)');
        $this->db->where('tgl_delete', null);
        $user = $this->db->get('fai_akun');

        if ($user->num_rows() == 1) {
            $data = $user->first_row();

            $_SESSION['id_akun'] = $data->id_akun;
            $_SESSION['nama_user'] = $data->nama_user;
            $_SESSION['id_jabatan'] = $data->id_jabatan;
            $_SESSION['role_user'] = $data->role_user;
            $_SESSION['role_shift'] = $data->role_shift;
            $_SESSION['id_lokasi'] = $data->id_lokasi;
            $_SESSION['nama_lokasi'] = $data->nama_lokasi;
            $_SESSION['long_lokasi'] = $data->long_lokasi;
            $_SESSION['lat_lokasi'] = $data->lat_lokasi;
            $_SESSION['batas_lokasi'] = $data->batas_lokasi;
            $_SESSION['kunci'] = 'Login@Absen';

            logdb($_SESSION['id_akun'], 'Login', 'cek_akun', 'fai_akun', 'berhasil login');

            redirect('Kas');
        } else {
            logdb($email, 'Login', 'cek_akun', 'fai_akun', 'gagal login');
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>!!! Akun belum terdaftar !!!</b></center></div>');
            redirect('Login');
        }
    }

    public function keluar()
    {
        logdb($_SESSION['id_akun'], 'Login', 'keluar', '', 'logout');
        session_destroy();
        $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>User Logout</b></center></div>');
        redirect('Login');
    }
}
