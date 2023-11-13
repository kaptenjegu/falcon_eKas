<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pinjam extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        cek_login();
    }

    public function index()
    {
        $data['judul'] = 'Data Pinjam';
        $data['page'] = 'Pinjam';
        $data['url'] = base_url('Pinjam');

        $this->db->select('*');
        $this->db->from('fma_pinjam');
        $this->db->join('fai_akun', 'fai_akun.id_akun = fma_pinjam.id_user');
        $this->db->where('fma_pinjam.id_lokasi', $_SESSION['id_lokasi']);
        $this->db->where('(fma_pinjam.status = 1 OR fma_pinjam.status = 3)');
        //$this->db->where('fma_pinjam.status', '3');
        $this->db->where('fma_pinjam.tgl_delete', null);
        $this->db->group_by('fma_pinjam.id_user');
        $data['pinjam'] = $this->db->get()->result();

        //echo json_encode($data['pinjam']);exit();

        $this->load->view('header', $data);
        $this->load->view('pinjam', $data);
        $this->load->view('footer');
    }

    public function detail()
    {
        $data['judul'] = 'Detail Data Pinjam';
        $data['page'] = 'Pinjam';
        $data['url'] = base_url('Pinjam/detail/' . $this->db->escape_str($this->uri->segment(3)));

        $id_akun = $this->db->escape_str($this->uri->segment(3));
        $data['id_akun'] = $id_akun;

        $this->db->where('id_akun', $id_akun);
        $data['data_user'] = $this->db->get('fai_akun')->first_row();

        $this->db->select('*');
        $this->db->from('fma_pinjam');
        $this->db->join('fma_barang', 'fma_barang.id_barang = fma_pinjam.id_barang');
        $this->db->where('fma_pinjam.id_user', $id_akun);
        $this->db->where('(fma_pinjam.status = 1)');
        $this->db->where('fma_pinjam.tgl_delete', null);
        $data['data_pinjam'] = $this->db->get()->result();

        //echo json_encode($data['pinjam']);exit();

        $this->load->view('header', $data);
        $this->load->view('pinjam_detail', $data);
        $this->load->view('footer');
    }

    public function detail_acc_data()
    {
        try {
            $this->db->trans_start();

            $id_pinjam = $this->db->escape_str($this->uri->segment(4));
            $id_akun = $this->db->escape_str($this->uri->segment(3));

            //get data pinjam
            $this->db->where('id_pinjam', $id_pinjam);
            $v = $this->db->get('fma_pinjam')->first_row();

            if ($this->cek_qty($v->id_barang, $v->qty_pinjam) >= 0) {

                $this->db->set('status', 2);    //disetujui
                $this->db->set('id_admin', $_SESSION['id_akun']);    //yg menyetujui
                $this->db->where('id_pinjam', $id_pinjam);
                $this->db->update('fma_pinjam');

                $this->kurangi_qty($v->id_barang, $v->qty_pinjam); //kurangi qty sisa barang real

                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
                        <center><b>Peminjaman berhasil disetujui</b></center></div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissable">
                        <center><b>Peminjaman gagal disetujui, karena Qty tidak tersedia</b></center></div>');
            }

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Pinjam/detail/' . $id_akun);
    }

    public function detail_acc_data_semua()
    {
        try {
            $this->db->trans_start();

            //$id_pinjam = $this->db->escape_str($this->uri->segment(4));
            $id_akun = $this->db->escape_str($this->uri->segment(3));

            //get data pinjam
            $this->db->where('id_user', $id_akun);
            $this->db->where('(status = 1 OR status = 3)');
            $this->db->where('tgl_delete', null);
            $data = $this->db->get('fma_pinjam')->result();

            foreach($data as $v){
                if ($this->cek_qty($v->id_barang, $v->qty_pinjam) >= 0) {

                    $this->db->set('id_admin', $_SESSION['id_akun']);    //yg menyetujui
                    $this->db->set('status', 2);    //disetujui
                    $this->db->where('id_pinjam', $id_pinjam);
                    $this->db->update('fma_pinjam');

                    $this->kurangi_qty($v->id_barang, $v->qty_pinjam); //kurangi qty sisa barang real

                    $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
                            <center><b>Peminjaman berhasil disetujui</b></center></div>');
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissable">
                            <center><b>Peminjaman gagal disetujui, karena ada Qty tidak tersedia</b></center></div>');
                    redirect('Pinjam/detail/' . $id_akun);
                }
            }

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Pinjam/detail/' . $id_akun);
    }

    //fungsi kurangi qty barang saat ini
    private function kurangi_qty($id_barang, $qr)
    {
        $this->db->where('id_barang', $id_barang);
        $data = $this->db->get('fma_barang')->first_row();

        $qty_sisa = $data->qty_sisa - $qr;

        $this->db->set('qty_sisa', $qty_sisa);
        $this->db->where('id_barang', $id_barang);
        $this->db->update('fma_barang');
    }

    //fungsi cek qty setelah dikurangi
    private function cek_qty($id_barang, $qr)
    {
        $this->db->where('id_barang', $id_barang);
        $data = $this->db->get('fma_barang')->first_row();

        $qty_sisa = $data->qty_asli - $qr;

        return $qty_sisa;
    }

    public function detail_hapus_data()
    {
        try {
            $this->db->trans_start();

            $id_pinjam = $this->db->escape_str($this->uri->segment(4));
            $id_akun = $this->db->escape_str($this->uri->segment(3));

            $this->db->set('tgl_delete', date('Y-m-d H:i:s'));
            $this->db->set('id_admin', $_SESSION['id_akun']);    //yg mengeksekusi
            $this->db->where('id_pinjam', $id_pinjam);
            $this->db->update('fma_pinjam');

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Aset berhasil dihapus</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Pinjam/detail/' . $id_akun);
    }
/*
    public function hapus_data()
    {
        try {
            $this->db->trans_start();

            $id_barang = $this->db->escape_str($this->uri->segment(3));

            $this->db->set('tgl_delete', date('Y-m-d H:i:s'));
            $this->db->where('id_barang', $id_barang);
            $this->db->update('fma_barang');

            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Data Aset Dihapus</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Asset');
    }

    private function cek_data($nama_barang)
    {
        $this->db->where('nama_barang', $nama_barang);
        $this->db->where('id_lokasi', $_SESSION['id_lokasi']);
        $n = $this->db->get('fma_barang')->num_rows();
        return $n;
    }

    public function get_data()
    {
        try {
            $id_barang = $this->db->escape_str($this->uri->segment(3));

            $this->db->where('id_barang', $id_barang);
            $this->db->where('tgl_delete', null);
            $data = $this->db->get('fma_barang')->first_row();

            echo json_encode($data);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }*/
}
