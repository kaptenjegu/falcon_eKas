<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Asset extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        cek_login();
    }

    public function index()
    {
        $data['judul'] = 'Data Aset';
        $data['page'] = 'Asset';
        $data['url'] = base_url('Asset');

        $this->db->where('id_lokasi', $_SESSION['id_lokasi']);
        $this->db->where('tgl_delete', null);
        $data['asset'] = $this->db->get('fma_barang')->result();

        $this->load->view('header', $data);
        $this->load->view('asset', $data);
        $this->load->view('footer');
    }

    public function detail()
    {
        $id_barang = $this->db->escape_str($this->uri->segment(3));

        $data['judul'] = 'Detail';
        $data['page'] = 'Asset';
        $data['url'] = base_url('Asset/detail/' . $id_barang);

        $this->db->select('*');
        $this->db->from('fma_barang');
        $this->db->join('fai_lokasi', 'fma_barang.id_lokasi = fai_lokasi.id_lokasi');
        $this->db->where('fma_barang.id_barang', $id_barang);
        //$this->db->where('tgl_delete', null);
        $data['asset'] = $this->db->get()->first_row();

        $this->db->select('*');
        $this->db->from('fma_pinjam');
        $this->db->join('fai_akun', 'fma_pinjam.id_user = fai_akun.id_akun');
        $this->db->join('fai_lokasi', 'fma_pinjam.id_lokasi = fai_lokasi.id_lokasi');
        $this->db->where('fma_pinjam.id_barang', $id_barang);
        $this->db->where('(fma_pinjam.status = 2 OR fma_pinjam.status = 3 OR fma_pinjam.status = 4)');  //sedang dipinjam dan selesai pinjam
        $this->db->where('fma_pinjam.tgl_delete', null);
        $data['pinjam'] = $this->db->get()->result();

        $this->load->view('header', $data);
        $this->load->view('asset_detail', $data);
        $this->load->view('footer');
    }

    public function tambah_data()
    {
        try {
            $this->db->trans_start();

            $nama_barang = $this->input->post('nama_barang');
            $qty_asli = $this->input->post('qty_asli');
            $kondisi_barang = $this->input->post('kondisi_barang');
            $tgl_pembelian = $this->input->post('tgl_pembelian');

            if ($this->cek_data($nama_barang) == 0) {

                $data = array(
                    'id_barang' => randid(),
                    'nama_barang' => $nama_barang,
                    'tgl_pembelian' => $tgl_pembelian,
                    'qty_asli' => $qty_asli,
                    'qty_sisa' => $qty_asli,
                    'id_lokasi' => $_SESSION['id_lokasi'],
                    'id_user' => $_SESSION['id_akun'],
                    'kondisi_barang' => $kondisi_barang
                );
                $this->db->insert('fma_barang', $data);

                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Aset Disimpan</b></center></div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>!!! Error : Data sudah ada !!!</b></center></div>');
            }

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Asset');
    }

    public function edit_data()
    {
        try {
            $this->db->trans_start();

            $id_barang = $this->db->escape_str($this->input->post('id_barang'));
            $nama_barang = $this->input->post('nama_barang');
            $qty_baru = $this->input->post('qty_asli');
            $kondisi_barang = $this->input->post('kondisi_barang');

            $this->db->where('id_barang', $id_barang);
            $asli = $this->db->get('fma_barang')->first_row();

            $qty = $qty_baru - $asli->qty_asli;
            $qty_sisa = $asli->qty_sisa + $qty;

            if ($qty_sisa >= 0) {

                $this->db->set('nama_barang', $nama_barang);
                $this->db->set('qty_asli', $qty_baru);
                $this->db->set('qty_sisa', $qty_sisa);
                $this->db->set('kondisi_barang', $kondisi_barang);
                $this->db->where('id_barang', $id_barang);
                $this->db->update('fma_barang');

                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Aset Diperbarui</b></center></div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>!!! Error : Data sudah ada atau Quantity salah !!!</b></center></div>');
            }

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Asset');
    }

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
    }
}
