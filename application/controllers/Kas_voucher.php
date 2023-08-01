<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kas_voucher extends CI_Controller
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
        echo '';
    }

    public function list()
    {
        $id_data_kas = $this->db->escape_str($this->uri->segment(3));
        $data['judul'] = 'Voucher';
        $data['page'] = 'Kas_voucher';
        $data['url'] = base_url('Kas_voucher/detail/' . $id_data_kas);

        $this->db->select('*');
        $this->db->from('fki_data');
        $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
        $this->db->join('fki_data_kas', 'fki_data_kas.id_data_kas = fki_minggu.id_data_kas');
        $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
        $this->db->where('fki_minggu.tgl_delete', null);
        $n = $this->db->get();

        if ($n->num_rows() > 0) {

            $data['judul_periode'] = $n->first_row();

            $this->db->where('tgl_delete', null);
            $data['tipe'] = $this->db->get('fki_tipe')->result();

            $this->db->select('*');
            $this->db->from('fki_data');
            $this->db->join('fki_tipe', 'fki_tipe.id_tipe = fki_data.id_tipe');
            $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
            $this->db->where('fki_data.id_status', 1);
            $this->db->where('fki_data.tgl_delete', null);
            $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
            $this->db->order_by('fki_data.tgl_data', 'desc');
            $data['data_kas'] = $this->db->get()->result();

            $this->load->view('header', $data);
            $this->load->view('kas_voucher', $data);
            $this->load->view('footer');
        } else {
            echo 'ERROR';
        }
    }

    public function cetak_sps()
    {
        $id_data_kas = $this->db->escape_str($this->uri->segment(3));

        //konfirmasi apakah datanya ada?
        $this->db->select('*');
        $this->db->from('fki_data');
        $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
        $this->db->join('fki_data_kas', 'fki_data_kas.id_data_kas = fki_minggu.id_data_kas');
        $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
        $this->db->where('fki_minggu.tgl_delete', null);
        $n = $this->db->get();

        if ($n->num_rows() > 0) {

            $judul = $n->first_row();

            //ambil data
            $this->db->select('*');
            $this->db->from('fki_data');
            $this->db->join('fki_tipe', 'fki_tipe.id_tipe = fki_data.id_tipe');
            $this->db->join('fki_minggu', 'fki_minggu.id_minggu = fki_data.id_minggu');
            $this->db->where('fki_data.id_status', 1);
            $this->db->where('fki_data.tgl_delete', null);
            $this->db->where('fki_minggu.id_data_kas', $id_data_kas);
            $this->db->order_by('fki_data.tgl_data', 'desc');
            $data = $this->db->get()->result();

            $pdf = new PDF_MC_Table('P', 'mm', 'a4'); // h ,w
            //$pdf2 = new AlphaPDF();
            $pdf->SetTitle('Cetak Voucher Luar RAB ' . $judul->nama_data_kas . ' ' . $judul->nama_minggu);
            $brd = 1;
            $brd2 = 0;
            $np = 1;

            $pdf->SetFont('Times', 'B', 10);
            $pdf->SetLineWidth(0.4);
            $pdf->AddPage();

            foreach ($data as $v) {



                $border_color_r = 5;
                $border_color_g = 86;
                $border_color_b = 250;

                //per vocer H - 130
                $pdf->SetTextColor($border_color_r, $border_color_g, $border_color_b);
                $y_logo1 = $pdf->getY();
                $x_logo1 = $pdf->getX();
                $pdf->Cell(190, 5, 'PT. Falcon Prima Tehnik', $brd2, 1, 'R'); //(w,h,txt,border,ln,align) h max 260, w max 190
                $pdf->SetDrawColor($border_color_r, $border_color_g, $border_color_b);
                $pdf->SetFont('Times', '', 8);
                $pdf->Cell(190, 3, 'E-mail. falcon@falcontehnik.com', $brd2, 1, 'R');
                $pdf->Cell(190, 3, 'falcon.tehnik@gmail.com', $brd2, 1, 'R');
                $pdf->Cell(190, 3, 'Website. https://falcontehnik.com', $brd2, 1, 'R');
                $pdf->Cell(190, 3, 'Jl. Klampis Semolo Barat X.71/L.38, Sukolilo, Surabaya, Jawa Timur 60119', $brd2, 1, 'R');

                //gambar
                $pdf->Image('vendor/image/logo.png', $x_logo1 + 2, $y_logo1 + 1, 30, 15, '', '#'); //(x,y,w,h)
                $pdf->Image('vendor/image/logo_2.png', $x_logo1 + 20, $y_logo1 + 33, 150, 65, '', '#'); //watermark

                $pdf->SetFont('Times', 'B', 12);
                $pdf->SetTextColor(0, 0, 0);

                $pdf->Cell(60, 5, 'Dibayarkan kepada : ', $brd2, 0, 'C');
                $pdf->Cell(70, 5, 'BUKTI BANK KELUAR', 0, 0, 'C');
                $pdf->Cell(60, 5, 'Nomor : ', $brd, 1, 'L');
                $pdf->Cell(60, 5, '', 0, 0, 'C');
                $pdf->Cell(70, 5, 'PT FALCON PRIMA TEHNIK', 0, 0, 'C');
                $pdf->Cell(60, 5, 'COA : ', $brd, 1, 'L');

                /*$pdf->Cell(40, 5, 'Tanggal', $brd, 0, 'C');
                $pdf->Cell(100, 5, 'Deskripsi', $brd, 0, 'C');
                $pdf->Cell(50, 5, 'Jumlah', $brd, 1, 'C');*/

                //isi data
                $pdf->SetWidths(array(40, 100, 50));

                $pdf->Row(array('Tanggal', 'Deskripsi', 'Jumlah'));
                //$pdf2->SetAlpha(1);
                //$pdf->SetDrawColor(255, 255, 255);
                //data
                $pdf->Row_custom(array(date('d-m-Y', strtotime($v->tgl_data)), $v->deskripsi_data, number_format($v->nominal_data, 0, ',', '.')));
                for ($n = 1; $n <= 5; $n++) {
                    $pdf->Row_custom(array('', '', ''));
                    /*$x = $pdf->GetX();
                    $y = $pdf->GetY();
                    $pdf->MultiCell(40, 5, '1', 1, 'C', false);

                    $pdf->SetY($y);
                    $pdf->SetX(50);
                    $pdf->MultiCell(100, 5, '2srtjstsjdfdjgfmgm,fgjhm,ghm,hj,jh,gj,hj,hgjh,juh,dty',  1, 'C', false);

                    $pdf->SetY($y);
                    $pdf->SetX(150);
                    $pdf->MultiCell(50, 5, '3', 1, 'C');*/
                }

                //total
                $terbilang = $pdf->getY();
                $pdf->Cell(140, 5, 'Total', $brd, 0, 'R');
                $pdf->Cell(50, 5, 'Rp ' . number_format($v->nominal_data, 0, ',', '.'), $brd, 1, 'C');
                //$pdf->Cell(50, 5, '', $brd, 0, 'R');
                //$pdf->Cell(150, 5, '', $brd, 1, 'R');

                //Terbilang
                //$pdf->SetFont('Times', 'BI', 12);
                $pdf->Cell(190, 5, 'Terbilang : ' . terbilang($v->nominal_data), $brd, 1, 'L');
                // $pdf->SetFont('Times', 'B', 12);
                ////$pdf->Cell(150, 5, '', $brd, 1, 'C');


                //catatan
                $pdf->Cell(190, 5, 'Catatan : ', $brd, 1, 'L');

                $pdf->Cell(60, 5, 'Membuat', $brd, 0, 'C');
                $pdf->Cell(70, 5, 'Mengetahui', $brd, 0, 'C');
                $pdf->Cell(60, 5, 'Menyetujui', $brd, 1, 'C');
                $y_kanan_akhir = $pdf->getY();
                //ttd
                $pdf->Cell(60, 25, '', $brd, 0, 'C');
                $pdf->Cell(70, 25, '', $brd, 0, 'C');
                $pdf->Cell(60, 25, '', $brd, 1, 'C');

                $pdf->Cell(60, 5, '(Admin Finance)', $brd, 0, 'C');
                $pdf->Cell(70, 5, '(Accounting&Tax)', $brd, 0, 'C');
                $pdf->Cell(60, 5, '(Direktur Keuangan)', $brd, 1, 'C');


                //Line
                $pdf->SetDrawColor($border_color_r, $border_color_g, $border_color_b);
                //$pdf->Line(20, 45, 210, 45);    //(float x1, float y1, float x2, float y2)

                //top
                $pdf->Line($x_logo1, $y_logo1, $x_logo1 + 190, $y_logo1);

                //top2
                $pdf->Line($x_logo1, $y_logo1 + 17, $x_logo1 + 190, $y_logo1 + 17);

                //left
                //$pdf->Line(10, 10, 10, $terbilang);
                $pdf->Line($x_logo1, $y_logo1, $x_logo1, $terbilang);


                //left bukti bank
                //$pdf->Line(70, 27, 70, 37);
                $pdf->Line(70, $y_logo1 + 17, 70, $y_logo1 + 27);

                //right data tanggal
                //$pdf->Line(50, 40, 50, $terbilang);
                $pdf->Line(50, $y_logo1 + 30, 50, $terbilang);

                //left data Jumlah
                //$pdf->Line(150, 40, 150, $terbilang);
                $pdf->Line(150, $y_logo1 + 30, 150, $terbilang);

                //right
                //$pdf->Line(200, 10, 200, $terbilang);
                $pdf->Line($x_logo1 + 190, $y_logo1, $x_logo1 + 190, $y_kanan_akhir);

                //$pdf->Cell(190, 5, '', $brd2, 1, 'C'); //(w,h,txt,border,ln,align) h max 260, w max 190
                //$pdf->ln(15);


                if ($np == 2) {
                    $pdf->AddPage();
                    $np = 1;
                } else {
                    $np += 1;
                    $pdf->Cell(190, 15, '', 0, 1, 'C');
                }
            }

            //$pdf->Cell(190, 130, 'vocer 2', $brd, 1, 'C'); //(w,h,txt,border,ln,align) h max 260, w max 190
            //1 vocer - h:130

            $pdf->Output('Voucher Luar RAB ' . $judul->nama_data_kas . ' ' . $judul->nama_minggu . '.pdf', 'I');
        } else {
            echo 'ERROR';
        }
    }

    public function cetak_custom()
    {
        $id_data = $this->input->post('id_data');

        $tgl_data = $this->input->post('tgl_data');
        $uraian_data = $this->input->post('uraian_data');
        $nominal_data = $this->input->post('nominal_data');

        $pdf = new PDF_MC_Table('P', 'mm', 'a4'); // h ,w
        //$pdf2 = new AlphaPDF();
        $pdf->SetTitle('Cetak Voucher Luar RAB ' . $this->input->post('nama_data_kas') . ' ' . get_lokasi());
        $brd = 1;
        $brd2 = 0;
        $np = 1;
        $max_data = 8;

        $pdf->SetFont('Times', 'B', 10);
        $pdf->SetLineWidth(0.4);
        $pdf->AddPage();

        $border_color_r = 5;
        $border_color_g = 86;
        $border_color_b = 250;

        //per vocer H - 130
        $pdf->SetTextColor($border_color_r, $border_color_g, $border_color_b);
        $y_logo1 = $pdf->getY();
        $x_logo1 = $pdf->getX();
        $pdf->Cell(190, 5, 'PT. Falcon Prima Tehnik', $brd2, 1, 'R'); //(w,h,txt,border,ln,align) h max 260, w max 190
        $pdf->SetDrawColor($border_color_r, $border_color_g, $border_color_b);
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(190, 3, 'E-mail. falcon@falcontehnik.com', $brd2, 1, 'R');
        $pdf->Cell(190, 3, 'falcon.tehnik@gmail.com', $brd2, 1, 'R');
        $pdf->Cell(190, 3, 'Website. https://falcontehnik.com', $brd2, 1, 'R');
        $pdf->Cell(190, 3, 'Jl. Klampis Semolo Barat X.71/L.38, Sukolilo, Surabaya, Jawa Timur 60119', $brd2, 1, 'R');

        //gambar
        $pdf->Image('vendor/image/logo.png', $x_logo1 + 2, $y_logo1 + 1, 30, 15, '', '#'); //(x,y,w,h)
        $pdf->Image('vendor/image/logo_2.png', $x_logo1 + 20, $y_logo1 + 33, 150, 65, '', '#'); //watermark

        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->Cell(60, 5, 'Dibayarkan kepada : ', $brd2, 0, 'C');
        $pdf->Cell(70, 5, 'BUKTI BANK KELUAR', 0, 0, 'C');
        $pdf->Cell(60, 5, 'Nomor : ', $brd, 1, 'L');
        $pdf->Cell(60, 5, '', 0, 0, 'C');
        $pdf->Cell(70, 5, 'PT FALCON PRIMA TEHNIK', 0, 0, 'C');
        $pdf->Cell(60, 5, 'COA : ', $brd, 1, 'L');

        //isi data
        $pdf->SetWidths(array(40, 100, 50));

        $pdf->Row(array('Tanggal', 'Deskripsi', 'Jumlah'));

        //data
        $no = 0;
        $ttl = 0;
        //$pdf->Row_custom(array(date('d-m-Y', strtotime($v->tgl_data)), $v->deskripsi_data, number_format($v->nominal_data, 0, ',', '.')));
        for ($n = 0; $n <= count($id_data) - 1; $n++) {
            //echo $id_data[$n] . '<br>';
            $no +=1;
            $this->db->where('id_data', $id_data[$n]);
            $v = $this->db->get('fki_data')->first_row();

            $pdf->Row_custom(array(date('d/m/y', strtotime($v->tgl_data)), $v->deskripsi_data, number_format($v->nominal_data, 0, ',', '.')));
            $ttl += $v->nominal_data;            
        }

        //data penambahan manual
        for ($n = 0; $n <= count($id_data) - 1; $n++) {
            $no +=1;
            
            $pdf->Row_custom(array(date('d/m/y', strtotime($tgl_data[$n])), $uraian_data[$n], number_format($nominal_data[$n], 0, ',', '.')));
            $ttl += $nominal_data[$n];            
        }

        //kosongan
        for($k=1;$k<=$max_data-$no;$k++){
            $pdf->Row_custom(array('', '', ''));
        }

        //total
        $terbilang = $pdf->getY();
        $pdf->Cell(140, 5, 'Total', $brd, 0, 'R');
        $pdf->Cell(50, 5, 'Rp ' . number_format($ttl, 0, ',', '.'), $brd, 1, 'C');
        //$pdf->Cell(50, 5, '', $brd, 0, 'R');
        //$pdf->Cell(150, 5, '', $brd, 1, 'R');

        //Terbilang
        //$pdf->SetFont('Times', 'BI', 12);
        $pdf->Cell(190, 5, 'Terbilang : ' . terbilang($ttl), $brd, 1, 'L');
        // $pdf->SetFont('Times', 'B', 12);
        ////$pdf->Cell(150, 5, '', $brd, 1, 'C');


        //catatan
        $pdf->Cell(190, 5, 'Catatan : ', $brd, 1, 'L');

        $pdf->Cell(60, 5, 'Membuat', $brd, 0, 'C');
        $pdf->Cell(70, 5, 'Mengetahui', $brd, 0, 'C');
        $pdf->Cell(60, 5, 'Menyetujui', $brd, 1, 'C');
        $y_kanan_akhir = $pdf->getY();
        //ttd
        $pdf->Cell(60, 25, '', $brd, 0, 'C');
        $pdf->Cell(70, 25, '', $brd, 0, 'C');
        $pdf->Cell(60, 25, '', $brd, 1, 'C');

        $pdf->Cell(60, 5, '(Admin Finance)', $brd, 0, 'C');
        $pdf->Cell(70, 5, '(Accounting&Tax)', $brd, 0, 'C');
        $pdf->Cell(60, 5, '(Direktur Keuangan)', $brd, 1, 'C');


        //Line
        $pdf->SetDrawColor($border_color_r, $border_color_g, $border_color_b);
        //$pdf->Line(20, 45, 210, 45);    //(float x1, float y1, float x2, float y2)

        //top
        $pdf->Line($x_logo1, $y_logo1, $x_logo1 + 190, $y_logo1);

        //top2
        $pdf->Line($x_logo1, $y_logo1 + 17, $x_logo1 + 190, $y_logo1 + 17);

        //left
        //$pdf->Line(10, 10, 10, $terbilang);
        $pdf->Line($x_logo1, $y_logo1, $x_logo1, $terbilang);


        //left bukti bank
        //$pdf->Line(70, 27, 70, 37);
        $pdf->Line(70, $y_logo1 + 17, 70, $y_logo1 + 27);

        //right data tanggal
        //$pdf->Line(50, 40, 50, $terbilang);
        $pdf->Line(50, $y_logo1 + 30, 50, $terbilang);

        //left data Jumlah
        //$pdf->Line(150, 40, 150, $terbilang);
        $pdf->Line(150, $y_logo1 + 30, 150, $terbilang);

        //right
        //$pdf->Line(200, 10, 200, $terbilang);
        $pdf->Line($x_logo1 + 190, $y_logo1, $x_logo1 + 190, $y_kanan_akhir);

        //$pdf->Cell(190, 5, '', $brd2, 1, 'C'); //(w,h,txt,border,ln,align) h max 260, w max 190
        //$pdf->ln(15);


        //$pdf->Cell(190, 130, 'vocer 2', $brd, 1, 'C'); //(w,h,txt,border,ln,align) h max 260, w max 190
        //1 vocer - h:130

        $pdf->Output('Voucher Luar RAB ' . $this->input->post('nama_data_kas') . ' ' . get_lokasi() . '.pdf', 'I');
    }

    public function get_data()
    {
        try {
            $id = $this->db->escape_str($this->uri->segment(3));

            $this->db->where('id_minggu', $id);
            $data = $this->db->get('fki_minggu')->first_row();

            echo json_encode($data);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

    private function cek_data($id_data_kas, $nama_minggu, $id_lokasi)
    {
        $this->db->where('nama_minggu', $nama_minggu);
        $this->db->where('id_lokasi', $id_lokasi);
        $this->db->where('id_data_kas', $id_data_kas);
        $n = $this->db->get('fki_minggu')->num_rows();
        return $n;
    }
}
