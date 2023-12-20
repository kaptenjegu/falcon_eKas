<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Esp32 extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        cek_login();
    }

    public function index()
    {
        $data['judul'] = 'Data ESP';
        $data['page'] = 'Esp32';
        $data['url'] = base_url('Esp32');

        $this->db->where('tgl_delete', null);
        $data['esp32'] = $this->db->get('fesp32_esp')->result();

        $this->load->view('header', $data);

        //if(cek_permission($_SESSION['id_akun'], 'esp32')){
        $this->load->view('esp32', $data);
        //}

        $this->load->view('footer');
    }

    public function user()
    {
        $id_esp = $this->db->escape_str($this->uri->segment(3));

        $this->db->where('id_esp', $id_esp);
        $this->db->where('tgl_delete', null);
        $esp = $this->db->get('fesp32_esp')->first_row();

        $data['judul'] = 'Data Pengguna ESP ' . $esp->kode_esp;
        $data['page'] = 'Esp32';
        $data['url'] = base_url('Esp32/user/' . $id_esp);

        $this->db->where('id_esp', $id_esp);
        $this->db->where('tgl_delete', null);
        $data['user'] = $this->db->get('fesp32_user')->result();

        $data['kode_esp'] = $esp->kode_esp;

        $this->load->view('header', $data);
        $this->load->view('esp32_user', $data);
        $this->load->view('footer');
    }

    public function variabel()
    {
        $id_esp = $this->db->escape_str($this->uri->segment(3));

        $this->db->where('id_esp', $id_esp);
        $this->db->where('tgl_delete', null);
        $esp = $this->db->get('fesp32_esp')->first_row();

        $data['judul'] = 'Data Variabel ESP ' . $esp->kode_esp;
        $data['page'] = 'Esp32';
        $data['url'] = base_url('Esp32/variabel/' . $id_esp);

        $this->db->where('id_esp', $id_esp);
        $this->db->where('tgl_delete', null);
        $data['variabel'] = $this->db->get('fesp32_data_esp')->result();

        $data['kode_esp'] = $esp->kode_esp;

        $this->load->view('header', $data);
        $this->load->view('esp32_variabel', $data);
        $this->load->view('footer');
    }

    public function tambah_data()
    {
        try {
            $this->db->trans_start();

            $kode_esp = $this->input->post('kode_esp');
            $deskripsi_esp = $this->input->post('deskripsi_esp');

            if ($this->cek_data($kode_esp) == 0) {

                $data = array(
                    'id_esp' => randid(),
                    'kode_esp' => $kode_esp,
                    'deskripsi_esp' => $deskripsi_esp
                );
                $this->db->insert('fesp32_esp', $data);

                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data ESP Disimpan</b></center></div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>!!! Error : Data sudah ada !!!</b></center></div>');
            }

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Esp32');
    }

    public function tambah_data_user()
    {
        try {
            $this->db->trans_start();

            $id_esp = $this->input->post('id_esp');
            $username = $this->input->post('username');

            if ($this->cek_data_user($username) == 0) {

                $data = array(
                    'id_user' => randid(),
                    'id_esp' => $id_esp,
                    'username' => $username,
                    'password' => md5('123456789'),
                    'role' => 1
                );
                $this->db->insert('fesp32_user', $data);

                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Pengguna ESP Disimpan</b></center></div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>!!! Error : Data Pengguna sudah ada !!!</b></center></div>');
            }

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Esp32/user/' . $id_esp);
    }

    public function tambah_data_variabel()
    {
        try {
            $this->db->trans_start();

            $id_esp = $this->input->post('id_esp');
            $nama_data_esp = $this->input->post('nama_data_esp');
            $satuan_data_esp = $this->input->post('satuan_data_esp');

            if ($this->cek_data_variabel($nama_data_esp,$id_esp) == 0) {

                $data = array(
                    'id_data_esp' => randid(),
                    'id_esp' => $id_esp,
                    'nama_data_esp' => $nama_data_esp,
                    'satuan_data_esp' => $satuan_data_esp,
                    'value_data_esp' => '0'
                );
                $this->db->insert('fesp32_data_esp', $data);

                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Variabel Disimpan</b></center></div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>!!! Error : Data Variabel sudah ada !!!</b></center></div>');
            }

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Esp32/variabel/' . $id_esp);
    }

    public function edit_data()
    {
        try {
            $this->db->trans_start();

            $id_esp = $this->db->escape_str($this->input->post('id_esp'));
            $kode_esp = $this->input->post('kode_esp');
            $deskripsi_esp = $this->input->post('deskripsi_esp');

            $this->db->set('kode_esp', $kode_esp);
            $this->db->set('deskripsi_esp', $deskripsi_esp);
            $this->db->where('id_esp', $id_esp);
            $this->db->update('fesp32_esp');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data ESP Diperbarui</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Esp32');
    }

    public function edit_data_user()
    {
        try {
            $this->db->trans_start();

            $id_esp = $this->db->escape_str($this->input->post('id_esp'));
            $id_user = $this->input->post('id_user');
            $username = $this->input->post('username');


            if ($this->input->post('reset')) {
                $this->db->set('password', md5('123456789'));
            }
            if ($this->cek_data_user($username) == 0) {
                $this->db->set('username', $username);
            }
            $this->db->where('id_user', $id_user);
            $this->db->update('fesp32_user');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Pengguna Berhasil Diperbarui</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Esp32/user/' . $id_esp);
    }

    public function edit_data_variabel()
    {
        try {
            $this->db->trans_start();

            $id_esp = $this->db->escape_str($this->input->post('id_esp'));
            $id_data_esp = $this->input->post('id_data_esp');
            $nama_data_esp = $this->input->post('nama_data_esp');
            $satuan_data_esp = $this->input->post('satuan_data_esp');

            $this->db->set('satuan_data_esp', $satuan_data_esp);
            $this->db->set('nama_data_esp', $nama_data_esp);
            $this->db->where('id_data_esp', $id_data_esp);
            $this->db->update('fesp32_data_esp');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Variabel Berhasil Diperbarui</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Esp32/variabel/' . $id_esp);
    }

    public function hapus_data()
    {
        try {
            $this->db->trans_start();

            $id_esp = $this->db->escape_str($this->uri->segment(3));

            $this->db->set('tgl_delete', date('Y-m-d H:i:s'));
            $this->db->where('id_esp', $id_esp);
            $this->db->update('fesp32_esp');

            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Data ESP Dihapus</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Esp32');
    }

    public function hapus_data_user()
    {
        try {
            $this->db->trans_start();

            $id_user = $this->db->escape_str($this->uri->segment(3));
            $id_esp = $this->db->escape_str($this->uri->segment(4));

            $this->db->set('tgl_delete', date('Y-m-d H:i:s'));
            $this->db->where('id_user', $id_user);
            $this->db->update('fesp32_user');

            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Data Pengguna Dihapus</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Esp32/user/' . $id_esp);
    }

    public function hapus_data_variabel()
    {
        try {
            $this->db->trans_start();

            $id_data_esp = $this->db->escape_str($this->uri->segment(3));
            $id_esp = $this->db->escape_str($this->uri->segment(4));

            $this->db->set('tgl_delete', date('Y-m-d H:i:s'));
            $this->db->where('id_data_esp', $id_data_esp);
            $this->db->update('fesp32_data_esp');

            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Data Variabel Berhasil Dihapus</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Esp32/variabel/' . $id_esp);
    }

    private function cek_data($kode_esp)
    {
        $this->db->where('kode_esp', $kode_esp);
        $n = $this->db->get('fesp32_esp')->num_rows();
        return $n;
    }

    private function cek_data_user($username)
    {
        $this->db->where('username', $username);
        $n = $this->db->get('fesp32_user')->num_rows();
        return $n;
    }

    private function cek_data_variabel($nama_data_esp, $id_esp)
    {
        $this->db->where('nama_data_esp', $nama_data_esp);
        $this->db->where('id_esp', $id_esp);
        $n = $this->db->get('fesp32_data_esp')->num_rows();
        return $n;
    }

    public function get_data()
    {
        try {
            $id_esp = $this->db->escape_str($this->uri->segment(3));

            $this->db->where('id_esp', $id_esp);
            $this->db->where('tgl_delete', null);
            $data = $this->db->get('fesp32_esp')->first_row();

            echo json_encode($data);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

    public function get_data_user()
    {
        try {
            $id_user = $this->db->escape_str($this->uri->segment(3));

            $this->db->where('id_user', $id_user);
            $this->db->where('tgl_delete', null);
            $data = $this->db->get('fesp32_user')->first_row();

            echo json_encode($data);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

    public function get_data_variabel()
    {
        try {
            $id_data_esp = $this->db->escape_str($this->uri->segment(3));

            $this->db->where('id_data_esp', $id_data_esp);
            $this->db->where('tgl_delete', null);
            $data = $this->db->get('fesp32_data_esp')->first_row();

            echo json_encode($data);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }
}
