<?php

function cek_login()
{
	$ci = get_instance();
	if (!$_SESSION['nama_user']) {
		//$ci->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
		//			<center><b>Mohon untuk login ulang</b></center></div>');
		$ci->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Mohon untuk login ulang</b></center></div>');
		redirect('login');
	}
}

function randid()
{
	date_default_timezone_set('Asia/Jakarta');
	$length = 7;
	$rand = substr(str_shuffle(str_repeat($x = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
	$rand2 = substr(str_shuffle(str_repeat($x = '0123456789', ceil($length / strlen($x)))), 1, $length);
	$time = date('Y-m-d h-i-s');
	$id = md5($time . $rand . 'PTFPT' . $rand2);
	return $id;
}

function get_lokasi()
{
	date_default_timezone_set('Asia/Jakarta');
	$ci = get_instance();

	$ci->db->where('id_lokasi', $_SESSION['id_lokasi']);
	$lok = $ci->db->get('fai_lokasi')->first_row();

	return $lok->nama_lokasi;
}

function detection()
{
	$device = "";
	$useragent = $_SERVER["HTTP_USER_AGENT"];
	if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
		$device = "Mobile";
	} else {
		$device = "PC/Laptop";
		//echo 'Mohon Maaf, website ini hanya bisa diakses dari Smartphone';exit();
	}
}

function logdb($id_user, $page, $function, $table, $txt)
{
	date_default_timezone_set('Asia/Jakarta');
	$ci = get_instance();
	$ci->db->trans_start();

	$log = array(
		'id_user' => $id_user,
		'page' => $page,
		'function' => $function,
		'table' => $table,
		'txt' => $txt,
		'waktu' => date('d-m-Y H:i:s')
	);

	$data = array(
		'id_log' => randid(),
		'data_log' => json_encode($log)
	);
	$ci->db->insert('fai_log', $data);

	$ci->db->trans_complete();
}
