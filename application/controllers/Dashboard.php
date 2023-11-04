<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		//cek_login();
	}

	public function index()
	{
		/*$data['judul'] = 'Dashboard';
		$data['page'] = 'Dashboard';
		$data['url'] = base_url('Dashboard');

		//$this->db->where('id_user', $_SESSION['id_akun']);
		//$this->db->where('tgl_absen', date('Y-m-d'));
		//$data['absen'] = $this->db->get('fai_absen')->first_row();

		$this->load->view('header', $data);
		$this->load->view('dashboard', $data);
		$this->load->view('footer');*/
		redirect('Kas');
	}
	
}
