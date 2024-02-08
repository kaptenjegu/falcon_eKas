<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kas extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        //detection();
        cek_login();
    }

    public function index()
    {
        $data['judul'] = 'Data Kas';
        $data['page'] = 'Kas';
        $data['url'] = base_url('Kas');

        $this->db->where('tgl_delete', null);
        $this->db->order_by('nama_data_kas', 'desc');
        $data['data_kas'] = $this->db->get('fki_data_kas')->result();

        $this->load->view('header', $data);

        if (cek_permission($_SESSION['id_akun'], 'kas')) {
            $this->load->view('data_kas', $data);
        }

        $this->load->view('footer');
    }

    public function tambah_data_kas()
    {
        try {
            $this->db->trans_start();
            $nama = $this->input->post('nama_data_kas');

            if ($this->cek_data_kas($nama) == 0) {

                $data = array(
                    'id_data_kas' => randid(),
                    'nama_data_kas' => $this->input->post('nama_data_kas')
                );
                $this->db->insert('fki_data_kas', $data);

                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Periode Data Kas Sudah Disimpan</b></center></div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>!!! Error : Data sudah ada !!!</b></center></div>');
            }

            $this->db->trans_complete();


            //logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));

        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Kas');
    }

    public function edit_data()
    {
        try {
            $this->db->trans_start();

            $id = $this->db->escape_str($this->input->post('id_data_kas'));
            $nama = $this->input->post('nama_data_kas');

            if ($this->cek_data_kas($nama) == 0) {

                $this->db->set('nama_data_kas', $nama);
                $this->db->where('id_data_kas', $id);
                $this->db->update('fki_data_kas');

                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Kas Sudah Diperbarui</b></center></div>');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>!!! Error : Data sudah ada !!!</b></center></div>');
            }

            $this->db->trans_complete();


            //logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));

        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Kas');
    }

    public function get_data_kas()
    {
        try {
            $id = $this->db->escape_str($this->uri->segment(3));

            $this->db->where('id_data_kas', $id);
            $this->db->order_by('nama_data_kas', 'desc');
            $data = $this->db->get('fki_data_kas')->first_row();

            echo json_encode($data);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

    private function cek_data_kas($nama)
    {
        $this->db->where('nama_data_kas', $nama);
        $n = $this->db->get('fki_data_kas')->num_rows();
        return $n;
    }

    public function laporan()
    {
        $this->load->library('pdfgenerator');

        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        //$orientation = "portrait";
        $orientation = "landscape";

        $id_data_kas = $this->db->escape_str($this->uri->segment(3));

        $this->db->select('*');
        $this->db->from('fki_data');
        $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
        $this->db->join('fki_data_kas', 'fki_data_kas.id_data_kas = fki_minggu.id_data_kas');
        $this->db->join('fai_lokasi', 'fai_lokasi.id_lokasi = fki_minggu.id_lokasi');
        $this->db->join('fki_tipe', 'fki_tipe.id_tipe = fki_data.id_tipe');
        $this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
        $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
        $this->db->where('fki_data.tgl_delete', null);
        $this->db->where('fki_data.id_status', 2);  // RAB
        $this->db->order_by('fki_data.tgl_data', 'asc');
        $this->db->order_by('fki_data.id_tipe', 'asc');
        $n = $this->db->get();

        //echo json_encode($data);
        //exit();

        if ($n->num_rows() > 0) {

            $this->db->select('fki_data.id_tipe');
            $this->db->from('fki_data');
            $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
            $this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
            $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
            $this->db->where('fki_data.tgl_delete', null);
            $this->db->where('fki_data.id_status', 2);
            $this->db->where('fki_data.id_tipe <> 1');  //kecuali KAS
            $this->db->group_by('fki_data.id_tipe');
            $tipe = $this->db->get()->result();
            //echo json_encode($tipe);exit();

            $data = $n->result();
            $kas = '';
            $non_kas = '';

            $id_tipe = 1;

            // filename dari pdf ketika didownload
            $file_pdf = 'Laporan Kas ' . $data[0]->nama_lokasi . ' ' . $data[0]->nama_data_kas;

            $ttl_saldo1 = 0;
            $ttl_saldo2 = 0;
            $table = '<title>Laporan Kas ' . $data[0]->nama_lokasi . ' ' . $data[0]->nama_data_kas .  '</title><table border="1" style="width: 100%;"><tr style="background-color: gray;color: white;font-weight: bold;text-align: center;"><td colspan="8">ALL KAS ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_data_kas) .  '</td></tr>';
            $table .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Debet</td><td>Kredit(Rp)</td><td>Saldo</td><td>PIC</td><td>Nomor Kas</td></tr>';
            $table .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="8">UANG MASUK</td></tr>';

            $no = 1;
            foreach ($data as $v) {
                if ($v->id_tipe == 1 and $v->id_jenis_kas == 2) {
                    if ($v->nominal_data == 0) {
                        //$table .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>-</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td></td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                    } else {
                        $table .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td></td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                    }

                    if ($v->nominal_data > 0 or $v->nominal_data < 0) {
                        $ttl_saldo1 +=  $v->nominal_data * $v->qty_data;
                    }

                    if ($v->id_tipe > $id_tipe) {
                        $id_tipe = $v->id_tipe;
                    }

                    $no += 1;
                }
            }

            $table .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL KAS ' . strtoupper($data[0]->nama_lokasi) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table .= '</table>';

            $table2 = '<table border="1" style="width: 100%;">';
            $table2 .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Qty</td><td>Harga(Rp)</td><td>Jumlah(Rp)</td><td>PIC</td><td>Nomor Kas</td></tr>';

            foreach ($tipe as $id) {
                $no = 1;
                $ttl_saldo = 0;
                $ttl_pengajuan = 0;
                $tbl_sisa = '';
                foreach ($data as $v) {
                    if ($id->id_tipe == $v->id_tipe) {
                        if ($v->id_jenis_kas == 1) { //keluar
                            if ($no == 1) {
                                $table2 .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="8">' . $v->nama_tipe . '</td></tr>';
                            }

                            if ($v->nominal_data == 0) {
                                //$table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>-</td><td style="text-align: left;font-weight: normal;">-</td><td>-</td><td style="text-align: right;">' . $v->nominal_data . '</td><td style="text-align: right;">' . $v->nominal_data * $v->qty_data . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                            } else {
                                $table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . (float)$v->qty_data . '</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                            }
                            $ntipe = $v->nama_tipe;

                            if ($v->nominal_data > 0 or $v->nominal_data < 0) {
                                $ttl_saldo += $v->nominal_data * $v->qty_data;
                            }
                            $no += 1;
                        } elseif ($v->id_jenis_kas == 2) {
                            $ttl_pengajuan += $v->nominal_data * $v->qty_data;
                        }
                    }
                }

                $table2 .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                $ttl_saldo2 += $ttl_saldo;
                if ($ttl_pengajuan > 0) {
                    $table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN DANA ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_pengajuan, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                    $table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format(($ttl_pengajuan - $ttl_saldo), 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                }
            }

            $dapeng_asli = get_dana_pengajuan_asli($id_data_kas, $_SESSION['id_lokasi']);

            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN RAB ASLI ' . strtoupper($data[0]->nama_lokasi . '  ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($dapeng_asli, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN RAB ' . strtoupper($data[0]->nama_lokasi . '  ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL PENGELUARAN KAS ' . strtoupper($data[0]->nama_lokasi . '  ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo2, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table2 .= '<tr style="background-color: red;color: white;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO RAB ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format(($ttl_saldo1 - $ttl_saldo2), 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table2 .= '<tr style="background-color: red;color: white;"><td colspan="5" style="text-align: center;font-weight: bold;">SELISIH PENGAJUAN RAB ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format(($dapeng_asli - $ttl_saldo1), 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table2 .= '</table>';

            //echo $table . $table2;
            $this->pdfgenerator->generate($table . $table2, $file_pdf, $paper, $orientation);
        } else {
            echo 'Data kosong';
        }
    }

    //Luar RAB
    public function laporan2()
    {
        $this->load->library('pdfgenerator');

        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        //$orientation = "portrait";
        $orientation = "landscape";

        $id_data_kas = $this->db->escape_str($this->uri->segment(3));

        $this->db->select('*');
        $this->db->from('fki_data');
        $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
        $this->db->join('fki_data_kas', 'fki_data_kas.id_data_kas = fki_minggu.id_data_kas');
        $this->db->join('fai_lokasi', 'fai_lokasi.id_lokasi = fki_minggu.id_lokasi');
        $this->db->join('fki_tipe', 'fki_tipe.id_tipe = fki_data.id_tipe');
        $this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
        $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
        $this->db->where('fki_data.tgl_delete', null);
        $this->db->where('fki_data.id_status', 1);  // Luar RAB
        $this->db->where('fki_data.id_tipe <> 1');  //kecuali KAS
        $this->db->order_by('fki_data.tgl_data', 'asc');
        $this->db->order_by('fki_data.id_tipe', 'asc');
        $n = $this->db->get();

        //echo json_encode($data);
        //exit();

        if ($n->num_rows() > 0) {

            $this->db->select('fki_data.id_tipe');
            $this->db->from('fki_data');
            $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
            $this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
            $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
            $this->db->where('fki_data.tgl_delete', null);
            $this->db->where('fki_data.id_status', 1);  // Luar RAB
            $this->db->where('fki_data.id_tipe <> 1');  //kecuali KAS
            $this->db->group_by('fki_data.id_tipe');
            $tipe = $this->db->get()->result();
            //echo json_encode($tipe);exit();

            $data = $n->result();
            $kas = '';
            $non_kas = '';

            $id_tipe = 1;

            // filename dari pdf ketika didownload
            $file_pdf = 'LUAR RAB ' . $data[0]->nama_lokasi . ' ' . $data[0]->nama_data_kas;

            $ttl_saldo1 = 0;
            $ttl_saldo2 = 0;
            $table2 = '<title>LUAR RAB ' . $data[0]->nama_lokasi . ' ' . $data[0]->nama_data_kas .  '</title>';
            $table2 .= '<table border="1" style="width: 100%;"><tr style="background-color: gray;color: white;font-weight: bold;text-align: center;"><td colspan="8">LUAR RAB ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_data_kas) .  '</td></tr>';
            $table2 .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Qty</td><td>Harga(Rp)</td><td>Jumlah(Rp)</td><td>PIC</td><td>Nomor Kas</td></tr>';

            foreach ($tipe as $id) {
                $no = 1;
                $ttl_saldo = 0;
                $ttl_pengajuan = 0;
                $tbl_sisa = '';
                foreach ($data as $v) {
                    if ($id->id_tipe == $v->id_tipe) {
                        if ($v->id_jenis_kas == 1) { //keluar
                            if ($no == 1) {
                                $table2 .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="8">' . $v->nama_tipe . '</td></tr>';
                            }
                            $table2 .= '<tr style="text-align: center;font-weight: normal;background-color: #F9966B;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . (float)$v->qty_data . '</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td></tr>';
                            $ntipe = $v->nama_tipe;
                            $ttl_saldo += $v->nominal_data * $v->qty_data;
                            $no += 1;
                        } elseif ($v->id_jenis_kas == 2) {
                            $ttl_pengajuan += $v->nominal_data * $v->qty_data;
                        }
                    }
                }

                $table2 .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                $ttl_saldo2 += $ttl_saldo;
                if ($ttl_pengajuan > 0) {
                    $table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN DANA ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . $ttl_pengajuan . '</td><td colspan="3"></td></tr>';
                    $table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format(($ttl_pengajuan - $ttl_saldo), 0, ',', '.') . '</td><td colspan="3"></td></tr>';
                }
            }

            //$table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN RAB ' . strtoupper($data[0]->nama_lokasi . ' ' . $data[0]->nama_minggu . ' ' . $data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . $ttl_saldo1 . '</td><td colspan="3"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL PENGELUARAN</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo2, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">SUDAH DIBAYAR</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo2, 0, ',', '.') . '</td><td colspan="3"></td></tr>';
            $table2 .= '</table>';

            //echo $table2;
            $this->pdfgenerator->generate($table2, $file_pdf, $paper, $orientation);
        } else {
            echo 'Data kosong';
        }
    }

    public function laporan_periode()
    {
        $id_data_kas = $this->db->escape_str($this->uri->segment(3));

        $this->db->select('*');
        $this->db->from('fki_data');
        $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
        $this->db->join('fki_data_kas', 'fki_data_kas.id_data_kas = fki_minggu.id_data_kas');
        $this->db->join('fai_lokasi', 'fai_lokasi.id_lokasi = fki_minggu.id_lokasi');
        $this->db->join('fki_tipe', 'fki_tipe.id_tipe = fki_data.id_tipe');
        //$this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
        $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
        $this->db->where('fki_data.tgl_delete', null);
        //$this->db->where('fki_data.id_status', 2);  // RAB
        $this->db->order_by('fki_minggu.nama_minggu', 'asc');
        $this->db->order_by('fai_lokasi.nama_lokasi', 'asc');
        $this->db->order_by('fki_data.tgl_data', 'asc');
        //$this->db->order_by('fki_data.id_tipe', 'asc');
        $n = $this->db->get();

        //echo json_encode($data);
        //exit();

        if ($n->num_rows() > 0) {

            $this->db->select('fki_data.id_tipe');
            $this->db->from('fki_data');
            $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
            $this->db->join('fai_lokasi', 'fai_lokasi.id_lokasi = fki_minggu.id_lokasi');
            //$this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
            $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
            $this->db->where('fki_data.tgl_delete', null);
            //$this->db->where('fki_data.id_status', 2);
            $this->db->where('fki_data.id_tipe <> 1');  //kecuali KAS
            $this->db->group_by('fki_data.id_tipe');
            $this->db->order_by('fki_minggu.nama_minggu', 'asc');
            $tipe = $this->db->get()->result();
            //echo json_encode($tipe);exit();

            $data = $n->result();
            $kas = '';
            $non_kas = '';

            $id_tipe = 1;

            $ttl_saldo1 = 0;
            $ttl_saldo2 = 0;
            $table = '<title>Laporan Kas Periode ' . $data[0]->nama_data_kas .  '</title><table border="1" style="width: 100%;"><tr style="background-color: gray;color: white;font-weight: bold;text-align: center;"><td colspan="10">KAS PERIODE ' . strtoupper($data[0]->nama_data_kas) .  '</td></tr>';
            $table .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Debet</td><td>Kredit(Rp)</td><td>Saldo</td><td>PIC</td><td>Nomor Kas</td><td>Proyek</td><td>Minggu</td></tr>';
            $table .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="10">UANG MASUK</td></tr>';

            $no = 1;
            //data KAS saja
            foreach ($data as $v) {
                if ($v->id_tipe == 1 and $v->id_jenis_kas == 2) {

                    if ($v->nominal_data == 0) {
                        //$table .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>-</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td></td><td style="text-align: right;">' . $v->nominal_data . '</td><td style="text-align: right;">' . 0 . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td><td>' . $v->nama_lokasi . '</td><td>' . ucwords(strtolower($v->nama_minggu)) . '</td></tr>';
                    } else {
                        $table .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td></td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td><td>' . $v->nama_lokasi . '</td><td>' . ucwords(strtolower($v->nama_minggu)) . '</td></tr>';
                    }

                    if ($v->nominal_data > 0 or $v->nominal_data < 0) {
                        $ttl_saldo1 +=  $v->nominal_data * $v->qty_data;
                    }

                    if ($v->id_tipe > $id_tipe) {
                        $id_tipe = $v->id_tipe;
                    }

                    $no += 1;
                }
            }

            $luar_rab = get_dana_luar_rab($no, $id_data_kas);    //total kas luar rab
            $table .= $luar_rab[0];
            $ttl_saldo1 += $luar_rab[1];

            $table .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL KAS </td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1, 0, ',', '.') . '</td><td colspan="4"></td></tr>';
            $table .= '</table>';

            $table2 = '<table border="1" style="width: 100%;">';
            $table2 .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Qty</td><td>Harga(Rp)</td><td>Jumlah(Rp)</td><td>PIC</td><td>Nomor Kas</td><td>Proyek</td><td>Minggu</td></tr>';

            foreach ($tipe as $id) {
                $no = 1;
                $ttl_saldo = 0;
                $ttl_pengajuan = 0;
                $tbl_sisa = '';
                foreach ($data as $v) {
                    if ($id->id_tipe == $v->id_tipe) {
                        if ($v->id_jenis_kas == 1) { //keluar
                            if ($no == 1) {
                                $table2 .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="10">' . $v->nama_tipe . '</td></tr>';
                            }

                            if ($v->id_status == 2) { //RAB
                                if ($v->nominal_data == 0) {
                                    //$table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>-</td><td style="text-align: left;font-weight: normal;">-</td><td>-</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td><td>' . $v->nama_lokasi . '</td><td>' . ucwords(strtolower($v->nama_minggu)) . '</td></tr>';
                                } else {
                                    $table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . (float)$v->qty_data . '</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td><td>' . $v->nama_lokasi . '</td><td>' . ucwords(strtolower($v->nama_minggu)) . '</td></tr>';
                                }
                            } else { //Luar RAB
                                $table2 .= '<tr style="text-align: center;font-weight: normal;background-color: #7FFFD4;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . (float)$v->qty_data . '</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td><td>' . $v->nama_lokasi . '</td><td>' . ucwords(strtolower($v->nama_minggu)) . '</td></tr>';
                            }

                            $ntipe = $v->nama_tipe;
                            if ($v->nominal_data > 0 or $v->nominal_data < 0) {
                                $ttl_saldo += $v->nominal_data * $v->qty_data;
                            }
                            $no += 1;
                        } elseif ($v->id_jenis_kas == 2) {
                            $ttl_pengajuan += $v->nominal_data * $v->qty_data;
                        }
                    }
                }

                $table2 .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo, 0, ',', '.') . '</td><td colspan="4"></td></tr>';
                $ttl_saldo2 += $ttl_saldo;
                if ($ttl_pengajuan > 0) {
                    //$table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN DANA ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . $ttl_pengajuan . '</td><td colspan="4"></td></tr>';
                    //$table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . ($ttl_pengajuan - $ttl_saldo) . '</td><td colspan="4"></td></tr>';
                }
            }

            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN RAB ' . strtoupper($data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1, 0, ',', '.') . '</td><td colspan="4"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL PENGELUARAN KAS ' . strtoupper($data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo2, 0, ',', '.') . '</td><td colspan="4"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO RAB ' . strtoupper($data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format(($ttl_saldo1 - $ttl_saldo2), 0, ',', '.') . '</td><td colspan="4"></td></tr>';
            $table2 .= '</table>';

            echo $table . $table2 . '<br><br><center><a href="' . base_url('Kas/download_laporan_periode/' . $id_data_kas) . '" style="background-color: blue; width: 250px; border-radius:5px; color: white;">Download</a></center>';
        } else {
            echo 'Data kosong';
        }
    }

    public function download_laporan_periode()
    {
        $id_data_kas = $this->db->escape_str($this->uri->segment(3));

        $this->db->select('*');
        $this->db->from('fki_data');
        $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
        $this->db->join('fki_data_kas', 'fki_data_kas.id_data_kas = fki_minggu.id_data_kas');
        $this->db->join('fai_lokasi', 'fai_lokasi.id_lokasi = fki_minggu.id_lokasi');
        $this->db->join('fki_tipe', 'fki_tipe.id_tipe = fki_data.id_tipe');
        //$this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
        $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
        $this->db->where('fki_data.tgl_delete', null);
        //$this->db->where('fki_data.id_status', 2);  // RAB
        $this->db->order_by('fki_minggu.nama_minggu', 'asc');
        $this->db->order_by('fai_lokasi.nama_lokasi', 'asc');
        $this->db->order_by('fki_data.tgl_data', 'asc');
        //$this->db->order_by('fki_data.id_tipe', 'asc');
        $n = $this->db->get();

        //echo json_encode($data);
        //exit();

        if ($n->num_rows() > 0) {

            $this->db->select('fki_data.id_tipe');
            $this->db->from('fki_data');
            $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
            $this->db->join('fai_lokasi', 'fai_lokasi.id_lokasi = fki_minggu.id_lokasi');
            //$this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
            $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
            $this->db->where('fki_data.tgl_delete', null);
            //$this->db->where('fki_data.id_status', 2);
            $this->db->where('fki_data.id_tipe <> 1');  //kecuali KAS
            $this->db->group_by('fki_data.id_tipe');
            $this->db->order_by('fki_minggu.nama_minggu', 'asc');
            $tipe = $this->db->get()->result();
            //echo json_encode($tipe);exit();

            $data = $n->result();
            $kas = '';
            $non_kas = '';

            $id_tipe = 1;

            $ttl_saldo1 = 0;
            $ttl_saldo2 = 0;
            $table = '<title>Laporan Kas Periode ' . $data[0]->nama_data_kas .  '</title><table border="1" style="width: 100%;"><tr style="background-color: gray;color: white;font-weight: bold;text-align: center;"><td colspan="10">KAS PERIODE ' . strtoupper($data[0]->nama_data_kas) .  '</td></tr>';
            $table .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Debet</td><td>Kredit(Rp)</td><td>Saldo</td><td>PIC</td><td>Nomor Kas</td><td>Proyek</td><td>Minggu</td></tr>';
            $table .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="10">UANG MASUK</td></tr>';

            $no = 1;
            //data KAS saja
            foreach ($data as $v) {
                if ($v->id_tipe == 1 and $v->id_jenis_kas == 2) {

                    if ($v->nominal_data == 0) {
                        //$table .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>-</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td></td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td><td>' . $v->nama_lokasi . '</td><td>' . ucwords(strtolower($v->nama_minggu)) . '</td></tr>';
                    } else {
                        $table .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td></td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td><td>' . $v->nama_lokasi . '</td><td>' . ucwords(strtolower($v->nama_minggu)) . '</td></tr>';
                    }

                    if ($v->nominal_data > 0 or $v->nominal_data < 0) {
                        $ttl_saldo1 +=  $v->nominal_data * $v->qty_data;
                    }

                    if ($v->id_tipe > $id_tipe) {
                        $id_tipe = $v->id_tipe;
                    }

                    $no += 1;
                }
            }

            $luar_rab = get_dana_luar_rab($no, $id_data_kas);    //total kas luar rab
            $table .= $luar_rab[0];
            $ttl_saldo1 += $luar_rab[1];

            $table .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL KAS </td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1, 0, ',', '.') . '</td><td colspan="4"></td></tr>';
            $table .= '</table>';

            $table2 = '<table border="1" style="width: 100%;">';
            $table2 .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Qty</td><td>Harga(Rp)</td><td>Jumlah(Rp)</td><td>PIC</td><td>Nomor Kas</td><td>Proyek</td><td>Minggu</td></tr>';

            foreach ($tipe as $id) {
                $no = 1;
                $ttl_saldo = 0;
                $ttl_pengajuan = 0;
                $tbl_sisa = '';
                foreach ($data as $v) {
                    if ($id->id_tipe == $v->id_tipe) {
                        if ($v->id_jenis_kas == 1) { //keluar
                            if ($no == 1) {
                                $table2 .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="10">' . $v->nama_tipe . '</td></tr>';
                            }

                            if ($v->id_status == 2) { //RAB
                                if ($v->nominal_data == 0) {
                                    //$table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>-</td><td style="text-align: left;font-weight: normal;">-</td><td>-</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td><td>' . $v->nama_lokasi . '</td><td>' . ucwords(strtolower($v->nama_minggu)) . '</td></tr>';
                                } else {
                                    $table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . (float)$v->qty_data . '</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td><td>' . $v->nama_lokasi . '</td><td>' . ucwords(strtolower($v->nama_minggu)) . '</td></tr>';
                                }
                            } else { //Luar RAB
                                $table2 .= '<tr style="text-align: center;font-weight: normal;background-color: #7FFFD4;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . (float)$v->qty_data . '</td><td style="text-align: right;">' . number_format($v->nominal_data, 0, ',', '.') . '</td><td style="text-align: right;">' . number_format($v->nominal_data * $v->qty_data, 0, ',', '.') . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td><td>' . $v->nama_lokasi . '</td><td>' . ucwords(strtolower($v->nama_minggu)) . '</td></tr>';
                            }

                            $ntipe = $v->nama_tipe;

                            if ($v->nominal_data > 0 or $v->nominal_data < 0) {
                                $ttl_saldo += $v->nominal_data * $v->qty_data;
                            }

                            $no += 1;
                        } elseif ($v->id_jenis_kas == 2) {
                            $ttl_pengajuan += $v->nominal_data * $v->qty_data;
                        }
                    }
                }

                $table2 .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo, 0, ',', '.') . '</td><td colspan="4"></td></tr>';
                $ttl_saldo2 += $ttl_saldo;
                if ($ttl_pengajuan > 0) {
                    //$table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN DANA ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . $ttl_pengajuan . '</td><td colspan="4"></td></tr>';
                    //$table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . ($ttl_pengajuan - $ttl_saldo) . '</td><td colspan="4"></td></tr>';
                }
            }

            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN RAB ' . strtoupper($data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo1, 0, ',', '.') . '</td><td colspan="4"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL PENGELUARAN KAS ' . strtoupper($data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format($ttl_saldo2, 0, ',', '.') . '</td><td colspan="4"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO RAB ' . strtoupper($data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . number_format(($ttl_saldo1 - $ttl_saldo2), 0, ',', '.') . '</td><td colspan="4"></td></tr>';
            $table2 .= '</table>';

            //konversi ke excel
            $file = 'Laporan Kas Periode ' . $data[0]->nama_data_kas . '.xls';
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$file");

            echo $table . $table2;
        } else {
            echo 'Data kosong';
        }
    }

    public function Report_kas_periode()
    {
        $data['judul'] = 'Download Laporan Kas Periode';
        $data['page'] = 'Report_kas_periode';
        $data['url'] = base_url('Kas/Report_kas_periode');

        $this->db->select('RIGHT(nama_data_kas,4) as tahun');
        $this->db->where('tgl_delete', null);
        $this->db->group_by('tahun');
        $data['tahun'] = $this->db->get('fki_data_kas')->result();

        $this->load->view('header', $data);
        $this->load->view('report_kas_periode', $data);
        $this->load->view('footer');
    }

    public function download_kas_periode()
    {
        $this->load->library('pdfgenerator');

        $paper = 'A4';
        $orientation = "landscape";

        $tahun = (int)$this->uri->segment(3);
        $list_bulan = array();
        $bulan = '[';
        $tipe = '[';
        $dataset = '[';
        $n = 0;
        $tabel = '<center><table border="1" style="font-size: 13px;text-align: center;"><tr style="background-color: yellow;"><td>PERIODE</td>';

        $this->db->where('tgl_delete', null);
        $this->db->like('nama_data_kas', $tahun);
        $this->db->order_by('tgl_add', 'asc');
        $data_kas = $this->db->get('fki_data_kas')->result();

        $this->db->where('tgl_delete', null);
        $data_tipe = $this->db->get('fki_tipe')->result();

        foreach($this->get_tipe() as $v){
            $tabel .= '<td>' . $v->nama_tipe . '</td>';
            $tipe .= '"' . $v->nama_tipe . '",';
        }

        $tabel .= '</tr>';

        //ektrak per bulan
        foreach ($data_kas as $k) {

            $list_tipe = array();
            $rand_color = randcolor($n);
            $tabel .= '<tr><td style="color : '. $rand_color . ';font-weight: bold;">' . $k->nama_data_kas . '</td>';
            $dataset .= '{data: [';
            //ekstrak per tipe kas
            foreach ($this->get_tipe() as $t) {
                //totalan, all lokasi
                $this->db->select('sum(fki_data.qty_data * fki_data.nominal_data) as total');
                $this->db->from('fki_data');
                $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
                $this->db->where('fki_data.id_tipe', $t->id_tipe);
                $this->db->where('fki_minggu.id_data_kas', $k->id_data_kas);
                $d = $this->db->get()->first_row();
                $nominal_total = $d->total ?? 0;

                $tabel .= '<td style="text-align: right;">' . number_format($nominal_total,0,",",".") . '</td>';
                $dataset .= $nominal_total . ',';
                array_push($list_tipe, array($t->id_tipe => $nominal_total));
            }
            $tabel .= '</tr>';
            $dataset .= '],borderColor: "' . $rand_color . '",fill: false},';
            $bulan .= '"' . $k->nama_data_kas . '",';
            $n += 1;
            array_push($list_bulan, array($k->nama_data_kas => $list_tipe));
        }
        $tabel .= '</table></center>';
        $tipe .= ']';
        $bulan .= ']';
        $dataset .= ']';
        
        $data['tipe'] = $tipe;
        $data['bulan'] = $bulan;
        $data['dataset'] = $dataset;
        $data['tabel'] = $tabel;
        $data['list_bulan'] = $list_bulan;

        $this->load->view('download_kas_periode', $data);
    }

    private function get_tipe()
    {
        $this->db->where('tgl_delete', null);
        $this->db->order_by('nama_tipe', 'asc');
        $data_tipe = $this->db->get('fki_tipe')->result();
        return $data_tipe;
    }
    /*public function download_laporan_periode()
    {
        $id_data_kas = $this->db->escape_str($this->uri->segment(3));

        $this->db->select('*');
        $this->db->from('fki_data');
        $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
        $this->db->join('fki_data_kas', 'fki_data_kas.id_data_kas = fki_minggu.id_data_kas');
        $this->db->join('fai_lokasi', 'fai_lokasi.id_lokasi = fki_minggu.id_lokasi');
        $this->db->join('fki_tipe', 'fki_tipe.id_tipe = fki_data.id_tipe');
        //$this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
        $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
        $this->db->where('fki_data.tgl_delete', null);
        //$this->db->where('fki_data.id_status', 2);  // RAB
        $this->db->order_by('fki_data.tgl_data', 'asc');
        $this->db->order_by('fki_data.id_tipe', 'asc');
        $n = $this->db->get();

        //echo json_encode($data);
        //exit();

        if ($n->num_rows() > 0) {

            $this->db->select('fki_data.id_tipe');
            $this->db->from('fki_data');
            $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
            $this->db->join('fai_lokasi', 'fai_lokasi.id_lokasi = fki_minggu.id_lokasi');
            //$this->db->where('fki_minggu.id_lokasi', $_SESSION['id_lokasi']);
            $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
            $this->db->where('fki_data.tgl_delete', null);
            //$this->db->where('fki_data.id_status', 2);
            $this->db->where('fki_data.id_tipe <> 1');  //kecuali KAS
            $this->db->group_by('fki_data.id_tipe');
            $this->db->order_by('fki_minggu.nama_minggu', 'asc');
            $tipe = $this->db->get()->result();
            //echo json_encode($tipe);exit();

            $data = $n->result();
            $kas = '';
            $non_kas = '';

            $id_tipe = 1;

            $ttl_saldo1 = 0;
            $ttl_saldo2 = 0;
            $table = '<title>Laporan Kas Periode ' . $data[0]->nama_data_kas .  '</title><table border="1" style="width: 100%;"><tr style="background-color: gray;color: white;font-weight: bold;text-align: center;"><td colspan="10">KAS PERIODE ' . strtoupper($data[0]->nama_data_kas) .  '</td></tr>';
            $table .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Debet</td><td>Kredit(Rp)</td><td>Saldo</td><td>PIC</td><td>Nomor Kas</td><td>Proyek</td><td>Minggu</td></tr>';
            $table .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="10">UANG MASUK</td></tr>';

            $no = 1;
            //data KAS saja
            foreach ($data as $v) {
                if ($v->id_tipe == 1 and $v->id_jenis_kas == 2) {
                    if ($v->nominal_data == 0) {
                        $table .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>-</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td></td><td style="text-align: right;">' . $v->nominal_data . '</td><td style="text-align: right;">' . $v->nominal_data * $v->qty_data . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td><td>' . $v->nama_lokasi . '</td><td>' . ucwords(strtolower($v->nama_minggu)) . '</td></tr>';
                    } else {
                        $table .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td></td><td style="text-align: right;">' . $v->nominal_data . '</td><td style="text-align: right;">' . $v->nominal_data * $v->qty_data . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td><td>' . $v->nama_lokasi . '</td><td>' . ucwords(strtolower($v->nama_minggu)) . '</td></tr>';
                    }
                    $ttl_saldo1 +=  $v->nominal_data * $v->qty_data;

                    if ($v->id_tipe > $id_tipe) {
                        $id_tipe = $v->id_tipe;
                    }

                    $no += 1;
                }
            }

            $table .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL KAS </td><td style="text-align: right;font-weight: bold;">' . $ttl_saldo1 . '</td><td colspan="4"></td></tr>';
            $table .= '</table>';

            $table2 = '<table border="1" style="width: 100%;">';
            $table2 .= '<tr style="text-align: center;background-color: #69e842;font-weight: bold;"><td>No</td><td>Tanggal</td><td>Uraian</td><td>Qty</td><td>Harga(Rp)</td><td>Jumlah(Rp)</td><td>PIC</td><td>Nomor Kas</td><td>Proyek</td><td>Minggu</td></tr>';

            foreach ($tipe as $id) {
                $no = 1;
                $ttl_saldo = 0;
                $ttl_pengajuan = 0;
                $tbl_sisa = '';
                foreach ($data as $v) {
                    if ($id->id_tipe == $v->id_tipe) {
                        if ($v->id_jenis_kas == 1) { //keluar
                            if ($no == 1) {
                                $table2 .= '<tr style="background-color: #FFFF00;font-weight: bold;text-align: left;"><td colspan="10">' . $v->nama_tipe . '</td></tr>';
                            }

                            if ($v->id_status == 2) { //RAB
                                if ($v->nominal_data == 0) {
                                    $table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>-</td><td style="text-align: left;font-weight: normal;">-</td><td>-</td><td style="text-align: right;">' . $v->nominal_data . '</td><td style="text-align: right;">' . $v->nominal_data * $v->qty_data . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td><td>' . $v->nama_lokasi . '</td><td>' . ucwords(strtolower($v->nama_minggu)) . '</td></tr>';
                                } else {
                                    $table2 .= '<tr style="text-align: center;font-weight: normal;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . (float)$v->qty_data . '</td><td style="text-align: right;">' . $v->nominal_data . '</td><td style="text-align: right;">' . $v->nominal_data * $v->qty_data . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td><td>' . $v->nama_lokasi . '</td><td>' . ucwords(strtolower($v->nama_minggu)) . '</td></tr>';
                                }
                            } else { //Luar RAB
                                $table2 .= '<tr style="text-align: center;font-weight: normal;background-color: #7FFFD4;"><td style="font-weight: bold;">' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_data)) . '</td><td style="text-align: left;font-weight: normal;">' . $v->deskripsi_data . '</td><td>' . (float)$v->qty_data . '</td><td style="text-align: right;">' . $v->nominal_data . '</td><td style="text-align: right;">' . $v->nominal_data * $v->qty_data . '</td><td>' . $v->pic_data . '</td><td style="font-weight: bold;">00' . date('m', strtotime($v->tgl_data)) . '</td><td>' . $v->nama_lokasi . '</td><td>' . ucwords(strtolower($v->nama_minggu)) . '</td></tr>';
                            }

                            $ntipe = $v->nama_tipe;
                            $ttl_saldo += $v->nominal_data * $v->qty_data;
                            $no += 1;
                        } elseif ($v->id_jenis_kas == 2) {
                            $ttl_pengajuan += $v->nominal_data * $v->qty_data;
                        }
                    }
                }

                $table2 .= '<tr style="background-color: #79BAEC;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . $ttl_saldo . '</td><td colspan="4"></td></tr>';
                $ttl_saldo2 += $ttl_saldo;
                if ($ttl_pengajuan > 0) {
                    //$table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN DANA ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . $ttl_pengajuan . '</td><td colspan="4"></td></tr>';
                    //$table2 .= '<tr style="background-color: orange;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO ' . strtoupper($ntipe) . '</td><td style="text-align: right;font-weight: bold;">' . ($ttl_pengajuan - $ttl_saldo) . '</td><td colspan="4"></td></tr>';
                }
            }

            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">PENGAJUAN RAB ' . strtoupper($data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . $ttl_saldo1 . '</td><td colspan="4"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">TOTAL PENGELUARAN KAS ' . strtoupper($data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . $ttl_saldo2 . '</td><td colspan="4"></td></tr>';
            $table2 .= '<tr style="background-color: #0ebc12;"><td colspan="5" style="text-align: center;font-weight: bold;">SISA SALDO RAB ' . strtoupper($data[0]->nama_data_kas) .  '</td><td style="text-align: right;font-weight: bold;">' . ($ttl_saldo1 - $ttl_saldo2) . '</td><td colspan="4"></td></tr>';
            $table2 .= '</table>';

            //konversi ke excel
            $file = 'Laporan Kas Periode ' . $data[0]->nama_data_kas . '.xls';
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$file");
*/
}
