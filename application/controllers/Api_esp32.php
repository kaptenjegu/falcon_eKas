<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
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
        //$key_server = md5(date('Y-m-d') . '@_Api@_FPT@_122023');
        $key_server = '8e470a6910a6b346d414dcea384b017f';
        $cek = $this->cek_esp($kode_esp);

        try {
            $this->db->trans_start();

            if (($key == $key_server) and ($cek->num_rows() == 1)) {
                $data_cek = $cek->first_row();
                $id_esp = $data_cek->id_esp;

                //data
                $this->db->where('id_esp', $id_esp);
                $this->db->where('tgl_delete', null);
                $esp = $this->db->get('fesp32_data_esp')->result();

                //command
                $this->db->where('id_esp', $id_esp);
                $this->db->where('tgl_delete', null);
                $cmd_esp = $this->db->get('fesp32_cmd_esp')->result();

                foreach ($esp as $v) {
                    $value_data_esp = $_GET[$v->nama_data_esp];
                    $this->db->set('value_data_esp', $value_data_esp);
                    $this->db->where('nama_data_esp', $v->nama_data_esp);
                    $this->db->update('fesp32_data_esp');
                }
                $status = 200;
                $msg = 'Success';
                $data = $cmd_esp;
            }else{
                $status = 404;
                $msg = 'Invalid';
                $data = '';
            }

            $this->db->trans_complete();            
        } catch (\Throwable $e) {
            $status = 400;
            $msg = $e->getMessage();
        }
        $result = array('status' => $status,'message' => $msg, 'data' => $data);
        echo json_encode($result);
    }

    private function cek_esp($kode_esp)
    {
        $this->db->where('kode_esp', $kode_esp);
        $this->db->where('tgl_delete', null);
        $n = $this->db->get('fesp32_esp');
        return $n;
    }
}
