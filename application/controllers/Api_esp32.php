<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api_esp32 extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        //cek_login();
    }

    //fungsi untuk menerima data yg dikirim oleh ESP32 dan ditulis ke DB Server
    public function esp2server()
    {
        $kode_esp = $this->uri->segment(3);
        $key = $this->uri->segment(4);
        $result = array();
        $key_server = md5(date('Y-m-d H:i:s') . '@_Api@_FPT@_122023');

        if(($key == $key_server) AND ($this->cek_esp($kode_esp) == 1)){
            $this->db->where('tgl_delete', null);
            $this->db->order_by('tgl_add', 'desc');
            $data = $this->db->get('fki_tipe')->result();
        }        

        echo json_encode($result);
    }

    private function cek_esp($kode_esp){
        $this->db->where('kode_esp', $kode_esp);
        $this->db->where('tgl_delete', null);
        $n = $this->db->get('fesp32_esp')->num_rows();
        return $n;
    }
}
