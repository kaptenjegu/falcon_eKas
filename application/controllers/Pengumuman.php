<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pengumuman extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		detection();
		cek_login();
	}

	public function index()
	{		
		$data['judul'] = 'Notifikasi';
		$data['page'] = 'Pengumuman';
		$data['url'] = base_url('Pengumuman');

		$data['notif'] = get_notif()->result();
		$this->clear_notif();

		$this->load->view('header', $data);
		$this->load->view('pengumuman', $data);
		$this->load->view('footer');
	}

	private function clear_notif()
	{
		$this->db->set('status_baca', 1);
		$this->db->where('id_user', $_SESSION['id_akun']);
		$this->db->update('fai_notif');
	}

}
