<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Adm extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->db->query("SET time_zone='+7:00'");
		$waktu_sql = $this->db->query("SELECT NOW() AS waktu")->row_array();
		$this->waktu_sql = $waktu_sql['waktu'];
		$this->opsi = array("a", "b", "c", "d", "e");
		$this->load->library(array('session', 'pdflibrary'));
	}

	public function get_servertime()
	{
		$now = new DateTime();
		$dt = $now->format("M j, Y H:i:s O");

		j($dt);
	}

	public function cek_aktif()
	{
		if ($this->session->userdata('admin_valid') == false && $this->session->userdata('admin_id') == "") {
			redirect('adm/login');
		}
	}

	public function index()
	{
		$this->cek_aktif();

		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$a['p']			= "v_main";

		$this->load->view('aaa', $a);
	}

	public function upload_image()
	{
		if ($_FILES['file']['name']) {
			if (!$_FILES['file']['error']) {
				$dateTime = date('Y-m-d_H-i-s'); // Format: YYYY-MM-DD_HH-MM-SS
				$ext = explode('.', $_FILES['file']['name']);
				$filename = $dateTime . '.' . end($ext); // Use formatted dateTime for the file name
				$destination = './upload/gambar/' . $filename;
				$imgSrc = base_url('upload/gambar/' . $filename); // Use base_url to generate the full URL
				$location = $_FILES['file']['tmp_name'];
				move_uploaded_file($location, $destination);
				echo json_encode(['location' => $imgSrc]);
			} else {
				echo 'Oops! Your upload triggered the following error: ' . $_FILES['file']['error'];
			}
		}
	}

	public function delete_image()
	{
		$input = json_decode(file_get_contents('php://input'), true);

		if (isset($input['imgSrc'])) {
			$filePath = str_replace(base_url(), './', $input['imgSrc']);

			if (file_exists($filePath)) {
				if (unlink($filePath)) {
					echo json_encode(['status' => 'success', 'message' => 'File deleted successfully']);
				} else {
					echo json_encode(['status' => 'error', 'message' => 'Unable to delete file']);
				}
			} else {
				echo json_encode(['status' => 'error', 'message' => 'File does not exist']);
			}
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No image source provided']);
		}
	}

	/* == CETAK KARTU == */
	public function m_cetak_kartu()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		$data = $this->db->query("SELECT * FROM m_siswa")->result_array();
		$nama_sekolah = $this->config->item('nama_sekolah');
		$nama_ujian = $this->config->item('nama_ujian');
		$tgl_ujian = $this->config->item('tgl');
		$nama_kepala = $this->config->item('nama_kepala');
		$nip_kepala = $this->config->item('nip_kepala');

		$pdf = new FPDF('P', 'mm', 'A4');
		$pdf->AddPage();
		foreach ($data as $load) {
			//kop kartu
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->Cell(90, 0.1, '', 1, 1, 'C');

			$pdf->Cell(0.1, 2, '', 1, 0);
			$pdf->Cell(89.8, 2, '', 0, 0);
			$pdf->Cell(0.1, 2, '', 1, 1);

			$pdf->SetFont('Arial', 'B', 10);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(89.8, 3, 'KARTU PESERTA UJIAN', 0, 0, 'C');
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(89.8, 3, $nama_sekolah, 0, 0, 'C');
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(89.8, 3, $nama_ujian, 0, 0, 'C');
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 2, '', 1, 0);
			$pdf->Cell(89.8, 2, '', 0, 0);
			$pdf->Cell(0.1, 2, '', 1, 1);

			$pdf->Cell(90, 0.1, '', 1, 1, 'C');

			$pdf->Cell(0.1, 2, '', 1, 0);
			$pdf->Cell(89.8, 2, '', 0, 0);
			$pdf->Cell(0.1, 2, '', 1, 1);
			// $pdf->HeaderKartu();
			//konten kartu
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(2.8, 3, '', 0, 0);
			$pdf->Cell(20, 3, 'NAMA', 0, 0);
			$pdf->Cell(67, 3, ': ' . $load['nama'], 0, 0, 'L');
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(2.8, 3, '', 0, 0);
			$pdf->Cell(20, 3, 'KELAS', 0, 0);
			$pdf->Cell(67, 3, ': ' . $load['jurusan'] . ' ' . $load['id_jurusan'], 0, 0, 'L');
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 2, '', 1, 0);
			$pdf->Cell(89.8, 2, '', 0, 0);
			$pdf->Cell(0.1, 2, '', 1, 1);

			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(2.8, 3, '', 0, 0);
			$pdf->Cell(20, 3, 'USERNAME', 0, 0);
			$pdf->Cell(67, 3, ': ' . $load['nim'], 0, 0, 'L');
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(2.8, 3, '', 0, 0);
			$pdf->Cell(20, 3, 'PASSWORD', 0, 0);
			$pdf->Cell(67, 3, ': ' . $load['nim'], 0, 0, 'L');
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 2, '', 1, 0);
			$pdf->Cell(89.8, 2, '', 0, 0);
			$pdf->Cell(0.1, 2, '', 1, 1);

			//footer kartu
			// $pdf->FooterKartu();
			$pdf->Cell(10, 0, '', 0, 0);
			$pdf->Cell(17, 0, '', 1, 0);
			$pdf->Cell(63, 0, '', 0, 1);

			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(9.8, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(16.9, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(13.9, 3, '', 0, 0);
			$pdf->Cell(49, 3, $tgl_ujian, 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(9.8, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(16.9, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(13.9, 3, '', 0, 0);
			$pdf->Cell(49, 3, 'Kepala ' . $nama_sekolah, 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(9.8, 2.5, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(16.9, 2.5, '', 0, 0, 'C');
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(13.9, 2.5, '', 0, 0);
			$pdf->Cell(49, 2.5, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 1);

			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(9.8, 2.5, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(16.9, 2.5, 'FOTO', 0, 0, 'C');
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(13.9, 2.5, '', 0, 0);
			$pdf->Cell(49, 2.5, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 1);

			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(9.8, 2.53, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(16.9, 2.5, '2 x 3', 0, 0, 'C');
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(13.9, 2.5, '', 0, 0);
			$pdf->Cell(49, 2.5, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 1);

			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(9.8, 2.5, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(16.9, 2.5, '', 0, 0, 'C');
			$pdf->Cell(0.1, 2.5, '', 1, 0);
			$pdf->Cell(13.9, 2.5, '', 0, 0);
			$pdf->Cell(49, 2.5, '', 0, 0);
			$pdf->Cell(0.1, 2.5, '', 1, 1);

			$pdf->SetFont('Arial', 'BU', 7);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(9.8, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(16.9, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(13.9, 3, '', 0, 0);
			$pdf->Cell(49, 3, $nama_kepala, 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(9.8, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(16.9, 3, '', 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 0);
			$pdf->Cell(13.9, 3, '', 0, 0);
			$pdf->Cell(49, 3, 'NIP. ' . $nip_kepala, 0, 0);
			$pdf->Cell(0.1, 3, '', 1, 1);

			$pdf->Cell(10, 0, '', 0, 0);
			$pdf->Cell(17, 0, '', 1, 0);
			$pdf->Cell(63, 0, '', 0, 1);

			$pdf->Cell(0.1, 2, '', 1, 0);
			$pdf->Cell(89.8, 2, '', 0, 0);
			$pdf->Cell(0.1, 2, '', 1, 1);

			$pdf->SetFont('Arial', '', 10);
			$pdf->Cell(90, 0, '', 1, 1);
			$pdf->Ln(13);
		}
		$pdf->Output();
	}
	/* == ADMIN == */
	public function m_siswa()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);

		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		//$a['data'] = $this->db->query("")->result();
		$a['kelas'] = $this->db->query("SELECT m_kelas.* FROM m_kelas ORDER BY kelas ASC")->result();
		$a['jurusan'] = $this->db->query("SELECT m_jurusan.* FROM m_jurusan ORDER BY jurusan ASC")->result();
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_siswa WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_siswa SET nama = '" . bersih($p, "nama") . "', nim = '" . bersih($p, "nim") . "', jurusan = 'mau dihapus', id_jurusan = 'mau dihapus' WHERE id = '" . bersih($p, "id") . "'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_siswa VALUES (null, '" . bersih($p, "nama") . "', '" . bersih($p, "nim") . "', 'mau dihapus', 'mau dihapus')");
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket . " sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_siswa WHERE id = '" . $uri4 . "'");
			$this->db->query("DELETE FROM m_admin WHERE level = 'siswa' AND kon_id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapussemua") {
			$this->db->query("DELETE FROM m_siswa");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "non_aktifkan") {
			$this->db->query("DELETE FROM m_admin WHERE level = 'siswa' AND kon_id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "disable sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "user") {
			$det_user = $this->db->query("SELECT id, nim FROM m_siswa WHERE id = '$uri4'")->row();

			if (!empty($det_user)) {
				$q_cek_username = $this->db->query("SELECT id FROM m_admin WHERE username = '" . $det_user->nim . "' AND level = 'siswa'")->num_rows();

				if ($q_cek_username < 1) {

					$this->db->query("INSERT INTO m_admin VALUES (null, '" . $det_user->nim . "', md5('" . $det_user->nim . "'), 'siswa', '" . $det_user->id . "')");
					$ret_arr['status'] 	= "ok";
					$ret_arr['caption']	= "tambah user sukses";
					j($ret_arr);
				} else {
					$ret_arr['status'] 	= "gagal";
					$ret_arr['caption']	= "Username telah digunakan";
					j($ret_arr);
				}
			} else {
				$ret_arr['status'] 	= "gagal";
				$ret_arr['caption']	= "tambah user gagal";
				j($ret_arr);
			}
			exit();
		} else if ($uri3 == "user_reset") {
			$det_user = $this->db->query("SELECT id, nim FROM m_siswa WHERE id = '$uri4'")->row();

			$this->db->query("UPDATE m_admin SET password = md5('" . $det_user->nim . "') WHERE level = 'siswa' AND kon_id = '" . $det_user->id . "'");

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "Update password sukses";
			j($ret_arr);

			exit();
		} else if ($uri3 == "ambil_matkul") {
			$matkul = $this->db->query("SELECT m_mapel.*,
										(SELECT COUNT(id) FROM tr_siswa_mapel WHERE id_siswa = " . $uri4 . " AND id_mapel = m_mapel.id) AS ok
										FROM m_mapel
										")->result();
			$ret_arr['status'] = "ok";
			$ret_arr['data'] = $matkul;
			j($ret_arr);
			exit;
		} else if ($uri3 == "simpan_matkul") {
			$ket 	= "";
			//echo var_dump($p);
			$ambil_matkul = $this->db->query("SELECT id FROM m_mapel ORDER BY id ASC")->result();
			if (!empty($ambil_matkul)) {
				foreach ($ambil_matkul as $a) {
					$p_sub = "id_mapel_" . $a->id;
					if (!empty($p->$p_sub)) {

						$cek_sudah_ada = $this->db->query("SELECT id FROM tr_siswa_mapel WHERE  id_siswa = '" . $p->id_mhs . "' AND id_mapel = '" . $a->id . "'")->num_rows();

						if ($cek_sudah_ada < 1) {
							$this->db->query("INSERT INTO tr_siswa_mapel VALUES (null, '" . $p->id_mhs . "', '" . $a->id . "')");
						} else {
							$this->db->query("UPDATE tr_siswa_mapel SET id_mapel = '" . $p->$p_sub . "' WHERE id_siswa = '" . $p->id_mhs . "' AND id_mapel = '" . $a->id . "'");
						}
					} else {
						//echo "0<br>";
						$this->db->query("DELETE FROM tr_siswa_mapel WHERE id_siswa = '" . $p->id_mhs . "' AND id_mapel = '" . $a->id . "'");
					}
				}
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket . " sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$data = $this->db->query("SELECT a.*, (SELECT COUNT(id) FROM m_admin WHERE level = 'siswa' AND kon_id = a.id) AS ada
											FROM m_siswa a ORDER BY id DESC")->result_array();

			j(array("data" => $data));

			exit;
		} else if ($uri3 == "import") {
			$a['p']	= "f_siswa_import";
		} else if ($uri3 == "aktifkan_semua") {
			$q_get_user = $this->db->query("select 
								a.id, a.nama, a.nim, ifnull(b.username,'N') usernya
								from m_siswa a 
								left join m_admin b on concat(b.level,b.kon_id) = concat('siswa',a.id)")->result_array();
			$jml_aktif = 0;
			if (!empty($q_get_user)) {
				foreach ($q_get_user as $j) {
					if ($j['usernya'] == "N") {
						$this->db->query("INSERT INTO m_admin VALUES (null, '" . $j['nim'] . "', md5('" . $j['nim'] . "'), 'siswa', '" . $j['id'] . "')");
						$jml_aktif++;
					}
				}
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $jml_aktif . " user diaktifkan";
			j($ret_arr);
			exit();
		} else {
			$a['p']	= "m_siswa";
		}
		$this->load->view('aaa', $a);
	}

	public function m_jurusan()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$a['data'] = $this->db->query("SELECT m_jurusan.* FROM m_jurusan")->result();
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_jurusan WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_jurusan SET kelas = '" . bersih($p, "jurusan") . "'
									WHERE id = '" . bersih($p, "id") . "'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_jurusan VALUES (null, '" . bersih($p, "jurusan") . "')");
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket . " sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_jurusan WHERE id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');

			$d_total_row = $this->db->query("SELECT id FROM m_jurusan a WHERE a.jurusan LIKE '%" . $search['value'] . "%'")->num_rows();

			$q_datanya = $this->db->query("SELECT a.*
												FROM m_jurusan a
												WHERE a.jurusan LIKE '%" . $search['value'] . "%' ORDER BY a.id DESC LIMIT " . $start . ", " . $length . "")->result_array();
			$data = array();
			$no = ($start + 1);

			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[0] = $no++;
				$data_ok[1] = $d['jurusan'];
				$data_ok[2] = '<div class="btn-group">
							  <a href="#" onclick="return m_jurusan_e(' . $d['id'] . ');" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Edit</a>
							  <a href="#" onclick="return m_jurusan_h(' . $d['id'] . ');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
							 ';

				$data[] = $data_ok;
			}

			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else {
			$a['p']	= "m_jurusan";
		}
		$this->load->view('aaa', $a);
	}
	/* == KELAS == */
	public function m_kelas()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$a['data'] = $this->db->query("SELECT m_kelas.* FROM m_kelas")->result();
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_kelas WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_kelas SET kelas = '" . bersih($p, "kelas") . "'
									WHERE id = '" . bersih($p, "id") . "'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_kelas VALUES (null, '" . bersih($p, "kelas") . "')");
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket . " sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_kelas WHERE id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$start = $this->input->post('start');
			$length = $this->input->post('length');
			$draw = $this->input->post('draw');
			$search = $this->input->post('search');

			$d_total_row = $this->db->query("SELECT id FROM m_kelas a WHERE a.kelas LIKE '%" . $search['value'] . "%'")->num_rows();

			$q_datanya = $this->db->query("SELECT a.*
												FROM m_kelas a
												WHERE a.kelas LIKE '%" . $search['value'] . "%' ORDER BY a.id ASC LIMIT " . $start . ", " . $length . "")->result_array();
			$data = array();
			$no = ($start + 1);

			foreach ($q_datanya as $d) {
				$data_ok = array();
				$data_ok[0] = $no++;
				$data_ok[1] = $d['kelas'];
				$data_ok[2] = '<div class="btn-group">
							  <a href="#" onclick="return m_kelas_e(' . $d['id'] . ');" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Edit</a>
							  <a href="#" onclick="return m_kelas_h(' . $d['id'] . ');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
							 ';

				$data[] = $data_ok;
			}

			$json_data = array(
				"draw" => $draw,
				"iTotalRecords" => $d_total_row,
				"iTotalDisplayRecords" => $d_total_row,
				"data" => $data
			);
			j($json_data);
			exit;
		} else {
			$a['p']	= "m_kelas";
		}
		$this->load->view('aaa', $a);
	}

	public function m_guru()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		/*
		$a['data'] = $this->db->query("SELECT m_guru.*,
									(SELECT COUNT(id) FROM m_admin WHERE level = 'guru' AND kon_id = m_guru.id) AS ada
									FROM m_guru")->result();
		*/

		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_guru WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_guru SET nama = '" . bersih($p, "nama") . "', nip = '" . bersih($p, "nip") . "' WHERE id = '" . bersih($p, "id") . "'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_guru VALUES (null, '" . bersih($p, "nip") . "', '" . bersih($p, "nama") . "')");
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket . " sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_guru WHERE id = '" . $uri4 . "'");
			$this->db->query("DELETE FROM m_admin WHERE level = 'guru' AND kon_id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "non_aktifkan") {
			$this->db->query("DELETE FROM m_admin WHERE level = 'guru' AND kon_id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "disable sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "user") {
			$det_user = $this->db->query("SELECT id, nip FROM m_guru WHERE id = '$uri4'")->row();

			if (!empty($det_user)) {
				$q_cek_username = $this->db->query("SELECT id FROM m_admin WHERE username = '" . $det_user->nip . "' AND level = 'guru'")->num_rows();

				if ($q_cek_username < 1) {

					$this->db->query("INSERT INTO m_admin VALUES (null, '" . $det_user->nip . "', md5('" . $det_user->nip . "'), 'guru', '" . $det_user->id . "')");
					$ret_arr['status'] 	= "ok";
					$ret_arr['caption']	= "tambah user sukses";
					j($ret_arr);
				} else {
					$ret_arr['status'] 	= "gagal";
					$ret_arr['caption']	= "Username telah digunakan";
					j($ret_arr);
				}
			} else {
				$ret_arr['status'] 	= "gagal";
				$ret_arr['caption']	= "tambah user gagal";
				j($ret_arr);
			}
			exit();
		} else if ($uri3 == "user_reset") {
			$det_user = $this->db->query("SELECT id, nip FROM m_guru WHERE id = '$uri4'")->row();

			$this->db->query("UPDATE m_admin SET password = md5('" . $det_user->nip . "') WHERE level = 'guru' AND kon_id = '" . $det_user->id . "'");

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "Update password sukses";
			j($ret_arr);

			exit();
		} else if ($uri3 == "ambil_matkul") {
			$matkul = $this->db->query("SELECT m_mapel.*,
										(SELECT COUNT(id) FROM tr_guru_mapel WHERE id_guru = " . $uri4 . " AND id_mapel = m_mapel.id) AS ok
										FROM m_mapel
										")->result();
			$ret_arr['status'] = "ok";
			$ret_arr['data'] = $matkul;
			j($ret_arr);
			exit;
		} else if ($uri3 == "simpan_matkul") {
			$ket 	= "";
			//echo var_dump($p);
			$ambil_matkul = $this->db->query("SELECT id FROM m_mapel ORDER BY id ASC")->result();
			if (!empty($ambil_matkul)) {
				foreach ($ambil_matkul as $a) {
					$p_sub = "id_mapel_" . $a->id;
					if (!empty($p->$p_sub)) {

						$cek_sudah_ada = $this->db->query("SELECT id FROM tr_guru_mapel WHERE  id_guru = '" . $p->id_mhs . "' AND id_mapel = '" . $a->id . "'")->num_rows();

						if ($cek_sudah_ada < 1) {
							$this->db->query("INSERT INTO tr_guru_mapel VALUES (null, '" . $p->id_mhs . "', '" . $a->id . "')");
						} else {
							$this->db->query("UPDATE tr_guru_mapel SET id_mapel = '" . $p->$p_sub . "' WHERE id_guru = '" . $p->id_mhs . "' AND id_mapel = '" . $a->id . "'");
						}
					} else {
						//echo "0<br>";
						$this->db->query("DELETE FROM tr_guru_mapel WHERE id_guru = '" . $p->id_mhs . "' AND id_mapel = '" . $a->id . "'");
					}
				}
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket . " sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$data = $this->db->query("SELECT a.*, (SELECT COUNT(id) FROM m_admin WHERE level = 'guru' AND kon_id = a.id) AS ada
											FROM m_guru a ORDER BY id DESC")->result_array();

			j(array("data" => $data));

			exit;
		} else if ($uri3 == "import") {
			$a['p']	= "f_guru_import";
		} else if ($uri3 == "aktifkan_semua_guru") {
			$q_get_user = $this->db->query("select 
								a.id, a.nama, a.nip, ifnull(b.username,'N') usernya
								from m_guru a 
								left join m_admin b on concat(b.level,b.kon_id) = concat('guru',a.id)")->result_array();
			$jml_aktif = 0;
			if (!empty($q_get_user)) {
				foreach ($q_get_user as $j) {
					if ($j['usernya'] == "N") {
						$this->db->query("INSERT INTO m_admin VALUES (null, '" . $j['nip'] . "', md5('" . $j['nip'] . "'), 'guru', '" . $j['id'] . "')");
						$jml_aktif++;
					}
				}
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $jml_aktif . " user diaktifkan";
			j($ret_arr);
			exit();
		} else {

			$a['p']	= "m_guru";
		}

		$this->load->view('aaa', $a);
	}
	public function m_mapel()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin"), $this->session->userdata('admin_level'));

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$a['data'] = $this->db->query("SELECT m_mapel.* FROM m_mapel")->result();
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_mapel WHERE id = '$uri4'")->row();
			j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_mapel SET nama = '" . bersih($p, "nama") . "'
								WHERE id = '" . bersih($p, "id") . "'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_mapel VALUES (null, '" . bersih($p, "nama") . "')");
			}

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket . " sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_mapel WHERE id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {
			$data = $this->db->query("SELECT * FROM m_mapel")->result_array();

			j(array("data" => $data));

			exit;
		} else {
			$a['p']	= "m_mapel";
		}
		$this->load->view('aaa', $a);
	}
	/* == GURU == */
	public function m_soal()
	{
		$this->cek_aktif();
		cek_hakakses(array("admin", "guru"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		$a['huruf_opsi'] = array("a", "b", "c", "d", "e");
		$a['jml_opsi'] = $this->config->item('jml_opsi');
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$id_guru = $this->session->userdata('admin_level') == "guru" ? "WHERE a.id_guru = '" . $a['sess_konid'] . "'" : "";

		$a['p_guru'] = $this->db->query("SELECT DISTINCT a.id_guru, b.nama FROM tr_guru_mapel a INNER JOIN m_guru b ON a.id_guru = b.id $id_guru")->result_array();
		$a['p_mapel'] = $this->db->query("SELECT a.*, b.nama FROM tr_guru_mapel a INNER JOIN m_mapel b ON a.id_mapel = b.id $id_guru")->result_array();

		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_soal WHERE id = '$uri4' ORDER BY id DESC")->row();
			j($a);
			exit();
		} else if ($uri3 == "import") {
			$a['p']	= "f_soal_import";
		} else if ($uri3 == "hapus_gambar") {
			$nama_gambar = $this->db->query("SELECT file FROM m_soal WHERE id = '" . $uri5 . "'")->row();
			$this->db->query("UPDATE m_soal SET file = '', tipe_file = '' WHERE id = '" . $uri5 . "'");
			@unlink("./upload/gambar_soal/" . $nama_gambar->file);
			redirect('adm/m_soal/pilih_mapel/' . $uri4);
		} else if ($uri3 == "pilih_mapel") {
			if ($a['sess_level'] == "guru") {
				$a['data'] = $this->db->query("SELECT m_soal.*, m_guru.nama AS nama_guru FROM m_soal INNER JOIN m_guru ON m_soal.id_guru = m_guru.id WHERE m_soal.id_guru = '" . $a['sess_konid'] . "' AND m_soal.id_mapel = '$uri4' ORDER BY id DESC")->result();
			} else {
				$a['data'] = $this->db->query("SELECT m_soal.*, m_guru.nama AS nama_guru FROM m_soal INNER JOIN m_guru ON m_soal.id_guru = m_guru.id WHERE m_soal.id_mapel = '$uri4' ORDER BY id DESC")->result();
			}
			//echo $this->db->last_query();
			$a['p']	= "m_soal";
		} else if ($uri3 == "simpan") {
			$p = $this->input->post();

			if ($p['mode'] == "edit") {
				unset($p['mode']);

				// $old_soal = $this->db->query("SELECT soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal WHERE id = " . $this->db->escape($p['id']))->row_array();

				// $new_soal = [
				// 	'soal' => $p['soal'],
				// 	'opsi_a' => $p['opsi_a'],
				// 	'opsi_b' => $p['opsi_b'],
				// 	'opsi_c' => $p['opsi_c'],
				// 	'opsi_d' => $p['opsi_d'],
				// 	'opsi_e' => $p['opsi_e'],
				// ];

				// $old_soal_str = implode(" ", $old_soal);
				// $new_soal_str = implode(" ", $new_soal);

				// function extract_image_src($html)
				// {
				// 	preg_match_all('/<img\s+[^>]*src=["\']([^"\']+)["\'][^>]*>/i', $html, $matches);
				// 	return $matches[1];
				// }

				// $old_images = extract_image_src($old_soal_str);
				// $new_images = extract_image_src($new_soal_str);

				// // mencari gambar yang ada di old_images tapi tidak ada di new_images
				// $images_to_delete = array_diff($old_images, $new_images);

				// foreach ($images_to_delete as $image) {
				// 	$file_path = __DIR__ . str_replace('http://localhost/cbt_website_cooler', '../../..', $image);


				// 	if (file_exists($file_path)) {
				// 		unlink($file_path);
				// 		echo "Deleted: " . $file_path . "\n";
				// 	} else {
				// 		echo "File not found: " . $file_path . "\n";
				// 	}
				// }

				// echo '<pre>';
				// echo htmlspecialchars(print_r($p, true));  // Escape HTML in the printed array structure
				// echo '</pre>';

				// exit();

				$this->db->where("id", $p['id']);
				$this->db->update("m_soal", $p);
				// $__id_soal = $p['id'];
			} else {
				unset($p['mode']);
				unset($p['id']);

				$p['tgl_input'] = date('Y-m-d H:i:s');

				$this->db->insert("m_soal", $p);
			}

			redirect('adm/m_soal/');
		} else if ($uri3 == "edit") {
			$a['opsij'] = array("" => "Jawaban", "A" => "A", "B" => "B", "C" => "C", "D" => "D", "E" => "E");
			$id_guru = $this->session->userdata('admin_level') == "guru" ? "WHERE a.id_guru = '" . $a['sess_konid'] . "'" : "";
			// $a['p_mapel'] = obj_to_array($this->db->query("SELECT b.id, b.nama FROM tr_guru_mapel a INNER JOIN m_mapel b ON a.id_mapel = b.id $id_guru ORDER BY nama ASC")->result(), "id,nama");
			// $a['p_guru_mapel'] = $this->db->query("SELECT * FROM tr_guru_mapel")->result_array();
			// $a['p_kelas'] = obj_to_array($this->db->query("SELECT * FROM m_kelas ORDER BY kelas ASC")->result(), "id,kelas");

			$a['p_guru'] = $this->db->query("SELECT DISTINCT a.id_guru, b.nama FROM tr_guru_mapel a INNER JOIN m_guru b ON a.id_guru = b.id $id_guru")->result_array();
			$a['p_mapel'] = $this->db->query("SELECT a.*, b.nama FROM tr_guru_mapel a INNER JOIN m_mapel b ON a.id_mapel = b.id $id_guru")->result_array();

			if ($uri4 == 0) {
				$a['d'] = array("mode" => "add", "id" => "", "id_guru" => "", "id_mapel" => "", "id_kelas" => "", "bobot" => "1", "file" => "", "soal" => "", "opsi_a" => "", "opsi_b" => "", "opsi_c" => "", "opsi_d" => "", "opsi_e" => "", "jawaban" => "a", "tgl_input" => "");
			} else {
				$a['d'] = $this->db->query("SELECT m_soal.*, 'edit' AS mode FROM m_soal WHERE id = '$uri4'")->row_array();
			}

			// $data = array();

			// for ($e = 0; $e < $a['jml_opsi']; $e++) {
			// 	$iidata = array();
			// 	$idx = "opsi_" . $a['huruf_opsi'][$e];
			// 	$idx2 = $a['huruf_opsi'][$e];
			// 	$pc_opsi_edit = explode("#####", $a['d'][$idx]);
			// 	$iidata['opsi'] = $pc_opsi_edit[1];
			// 	$iidata['gambar'] = $pc_opsi_edit[0];
			// 	$data[$idx2] = $iidata;
			// }
			// $a['data_pc'] = $data;
			// echo '<pre>';
			// echo htmlspecialchars(print_r($a, true));  // Escape HTML in the printed array structure
			// echo '</pre>';

			$a['p'] = "f_soal";
		} else if ($uri3 == "hapus") {
			$nama_gambar = $this->db->query("SELECT id_mapel, file, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal WHERE id = '" . $uri4 . "'")->row();
			$pc_opsi_a = explode("#####", $nama_gambar->opsi_a);
			$pc_opsi_b = explode("#####", $nama_gambar->opsi_b);
			$pc_opsi_c = explode("#####", $nama_gambar->opsi_c);
			$pc_opsi_d = explode("#####", $nama_gambar->opsi_d);
			$pc_opsi_e = explode("#####", $nama_gambar->opsi_e);
			$this->db->query("DELETE FROM m_soal WHERE id = '" . $uri4 . "'");
			@unlink("./upload/gambar_soal/" . $nama_gambar->file);
			@unlink("./upload/gambar_soal/" . $pc_opsi_a[0]);
			@unlink("./upload/gambar_soal/" . $pc_opsi_b[0]);
			@unlink("./upload/gambar_soal/" . $pc_opsi_c[0]);
			@unlink("./upload/gambar_soal/" . $pc_opsi_d[0]);
			@unlink("./upload/gambar_soal/" . $pc_opsi_e[0]);
			redirect('adm/m_soal/pilih_mapel/' . $nama_gambar->id_mapel);
		} else if ($uri3 == "cetak") {
			$html = "<link href='" . base_url() . "___/css/style_print.css' rel='stylesheet' media='' type='text/css'/>";
			if ($a['sess_level'] == "admin") {
				$data = $this->db->query("SELECT * FROM m_soal")->result();
			} else {
				$data = $this->db->query("SELECT * FROM m_soal WHERE id_guru = '" . $a['sess_konid'] . "'")->result();
			}
			$mapel = $this->db->query("SELECT nama FROM m_mapel WHERE id = '" . $uri4 . "'")->row();
			if (!empty($data)) {
				$no = 1;
				$jawaban = array("A", "B", "C", "D", "E");
				foreach ($data as $d) {
					$arr_tipe_media = array(
						"" => "none",
						"image/jpeg" => "gambar",
						"image/png" => "gambar",
						"image/gif" => "gambar",
						"audio/mpeg" => "audio",
						"audio/mpg" => "audio",
						"audio/mpeg3" => "audio",
						"audio/mp3" => "audio",
						"audio/x-wav" => "audio",
						"audio/wave" => "audio",
						"audio/wav" => "audio",
						"video/mp4" => "video",
						"application/octet-stream" => "video"
					);
					$tipe_media = $arr_tipe_media[$d->tipe_file];
					$file_ada = file_exists("./upload/gambar_soal/" . $d->file) ? "ada" : "tidak_ada";
					$tampil_media = "";
					if ($file_ada == "ada" && $tipe_media == "audio") {
						$tampil_media = '<<< Ada media Audionya >>>';
					} else if ($file_ada == "ada" && $tipe_media == "video") {
						$tampil_media = '<<< Ada media Videonya >>>';
					} else if ($file_ada == "ada" && $tipe_media == "gambar") {
						$tampil_media = '<p><img src="' . base_url() . 'upload/gambar_soal/' . $d->file . '" class="thumbnail" style="width: 300px; height: 280px; display: inline; float: left"></p>';
					} else {
						$tampil_media = '';
					}
					$html .= '<table>
	                <tr><td>' . $no . '.</td><td colspan="2">' . $d->soal . '<br>' . $tampil_media . '</td></tr>';
					for ($j = 0; $j < ($this->config->item('jml_opsi')); $j++) {
						$opsi = "opsi_" . strtolower($jawaban[$j]);
						$pc_pilihan_opsi = explode("#####", $d->$opsi);
						$tampil_media_opsi = (file_exists('./upload/gambar_soal/' . $pc_pilihan_opsi[0]) and $pc_pilihan_opsi[0] != "") ? '<img src="' . base_url() . 'upload/gambar_soal/' . $pc_pilihan_opsi[0] . '" style="width: 100px; height: 100px; margin-right: 20px">' : '';
						if ($jawaban[$j] == $d->jawaban) {
							$html .= '<tr><td width="2%" style="font-weight: bold">' . $jawaban[$j] . '</td><td style="font-weight: bold">' . $tampil_media_opsi . $pc_pilihan_opsi[1] . '</td></label></tr>';
						} else {
							$html .= '<tr><td width="2%">' . $jawaban[$j] . '</td><td>' . $tampil_media_opsi . $pc_pilihan_opsi[1] . '</td></label></tr>';
						}
					}
					$html .= '</table></div>';
					$no++;
				}
			}
			echo $html;
			exit;
		} else if ($uri3 == "data") {
			if ($a['sess_level'] == "guru") {
				$wh = "WHERE a.id_guru = '" . $a['sess_konid'] . "'";
			} else if ($a['sess_level'] == "admin") {
				$wh = "";
			}

			$q_datanya = $this->db->query("SELECT a.*, b.nama nmguru, c.nama nmmapel
                                    FROM m_soal a
                                    INNER JOIN m_guru b ON a.id_guru = b.id
                                    INNER JOIN m_mapel c ON a.id_mapel = c.id " . $wh . "")->result_array();

			$data = array();

			foreach ($q_datanya as $d) {
				$jml_benar = empty($d['jml_benar']) ? 0 : intval($d['jml_benar']);
				$jml_salah = empty($d['jml_salah']) ? 0 : intval($d['jml_salah']);
				$total = ($jml_benar + $jml_salah);
				$persen_benar = $total > 0 ? (($jml_benar / $total) * 100) : 0;
				$data_ok = array();

				$data_ok["id"] = $d['id'];
				$data_ok["soal"] = $d['soal'];
				$data_ok["opsi_a"] = $d['opsi_a'];
				$data_ok["opsi_b"] = $d['opsi_b'];
				$data_ok["opsi_c"] = $d['opsi_c'];
				$data_ok["opsi_d"] = $d['opsi_d'];
				$data_ok["opsi_e"] = $d['opsi_e'];
				$data_ok["jawaban"] = $d['jawaban'];
				$data_ok["dipakai"] = $total;
				$data_ok["benar"] = $jml_benar;
				$data_ok["salah"] = $jml_salah;
				$data_ok["bobot"] = $d['bobot'];
				$data_ok["pk"] = $d['nmguru'] . ' / ' . $d['nmmapel'];

				// $data_ok["analisa"] = "Dipakai : " . ($total) . ", Benar: " . $jml_salah . ", Salah: " . $jml_salah . "<br>Persentase benar : " . number_format($persen_benar) . " %";

				$data[] = $data_ok;
			}

			j(["data" => $data]);
			exit;
		} else {
			$a['p']	= "m_soal";
		}
		$this->load->view('aaa', $a);
	}
	public function m_ujian()
	{
		$this->cek_aktif();
		cek_hakakses(array("guru", "admin"), $this->session->userdata('admin_level'));
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');
		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		//return as json
		$jeson = array();
		$a['jurusan'] = $this->db->query("SELECT m_jurusan.* FROM m_jurusan ORDER BY jurusan ASC")->result();
		$a['kelas'] = $this->db->query("SELECT m_kelas.* FROM m_kelas ORDER BY kelas ASC")->result();
		$a['pola_tes'] = array("" => "Pengacakan Soal", "acak" => "Soal Diacak", "set" => "Soal Diurutkan");
		$a['p_mapel'] = obj_to_array($this->db->query("SELECT * FROM m_mapel WHERE id IN (SELECT id_mapel FROM tr_guru_mapel WHERE id_guru = '" . $a['sess_konid'] . "')")->result(), "id,nama");

		if ($uri3 == "det") {
			$are = array();
			$a = $this->db->query("SELECT * FROM tr_guru_tes WHERE id = '$uri4'")->row();
			if (!empty($a)) {
				$pc_waktu = explode(" ", $a->tgl_mulai);
				$pc_tgl = explode("-", $pc_waktu[0]);
				$pc_terlambat = explode(" ", $a->terlambat);
				$are['id'] = $a->id;
				$are['id_guru'] = $a->id_guru;
				$are['id_mapel'] = $a->id_mapel;
				$are['nama_ujian'] = $a->nama_ujian;
				$are['jumlah_soal'] = $a->jumlah_soal;
				$are['kelas'] = $a->kelas;
				$are['jurusan'] = $a->jurusan;
				$are['waktu'] = $a->waktu;
				$are['terlambat'] = $pc_terlambat[0];
				$are['terlambat2'] = substr($pc_terlambat[1], 0, 5);
				$are['jenis'] = $a->jenis;
				$are['detil_jenis'] = $a->detil_jenis;
				$are['tgl_mulai'] = $pc_waktu[0];
				$are['wkt_mulai'] = substr($pc_waktu[1], 0, 5);
				$are['token'] = $a->token;
			} else {
				$are['id'] = "";
				$are['id_guru'] = "";
				$are['id_mapel'] = "";
				$are['nama_ujian'] = "";
				$are['jumlah_soal'] = "";
				$are['kelas'] = "";
				$are['jurusan'] = "";
				$are['waktu'] = "";
				$are['terlambat'] = "";
				$are['terlambat2'] = "";
				$are['jenis'] = "";
				$are['detil_jenis'] = "";
				$are['tgl_mulai'] = "";
				$are['wkt_mulai'] = "";
				$are['token'] = "";
			}
			j($are);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			$ambil_data = $this->db->query("SELECT id FROM m_soal WHERE id_mapel = '" . bersih($p, "mapel") . "' AND id_guru = '" . $a['sess_konid'] . "'")->num_rows();
			$jml_soal_diminta = intval(bersih($p, "jumlah_soal"));
			if ($ambil_data < $jml_soal_diminta) {
				$ret_arr['status'] 	= "gagal";
				$ret_arr['caption']	= "Jumlah soal diinput, melebihi jumlah soal yang ada: " . $ambil_data;
			} else {
				if ($p->id != 0) {
					$this->db->query("UPDATE tr_guru_tes SET 
						id_mapel = '" . bersih($p, "mapel") . "', 
						nama_ujian = '" . bersih($p, "nama_ujian") . "',
						jumlah_soal = '" . bersih($p, "jumlah_soal") . "', 
						kelas = 'mau dihapus',
						jurusan = 'mau dihapus',
						waktu = '" . bersih($p, "waktu") . "', 
						terlambat = '" . bersih($p, "terlambat") . " " . bersih($p, "terlambat2") . "', 
						tgl_mulai = '" . bersih($p, "tgl_mulai") . " " . bersih($p, "wkt_mulai") . "', 
						jenis = '" . bersih($p, "acak") . "'
						WHERE id = '" . bersih($p, "id") . "'");
					$ket = "edit";
				} else {
					$ket = "tambah";
					$token = strtoupper(random_string('alpha', 5));
					$this->db->query("INSERT INTO tr_guru_tes VALUES (
						null, 
						'" . $a['sess_konid'] . "', 
						'" . bersih($p, "mapel") . "',
						'" . bersih($p, "nama_ujian") . "', 
						'" . bersih($p, "jumlah_soal") . "', 
						'mau dihapus',
						'mau dihapus',
						'" . bersih($p, "waktu") . "', 
						'" . bersih($p, "acak") . "', 
						'', 
						'" . bersih($p, "tgl_mulai") . " " . bersih($p, "wkt_mulai") . "', 
						'" . bersih($p, "terlambat") . " " . bersih($p, "terlambat2") . "', 
						'$token')");
				}
				$ret_arr['status'] 	= "ok";
				$ret_arr['caption']	= $ket . " sukses";
			}
			j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM tr_guru_tes WHERE id = '" . $uri4 . "'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			j($ret_arr);
			exit();
		} else if ($uri3 == "data") {

			$q_datanya = $this->db->query("SELECT a.*, b.nama AS mapel
												FROM tr_guru_tes a
									        	INNER JOIN m_mapel b ON a.id_mapel = b.id 
									        	WHERE a.id_guru = '" . $a['sess_konid'] . "' ORDER BY id DESC")->result_array();
			$data = array();
			foreach ($q_datanya as $d) {
				$jenis_soal = $d['jenis'] == "acak" ? "Soal diacak" : "Soal urut";
				$data_ok = array();

				$data_ok['nama_ujian'] = $d['nama_ujian'] . "<br>Token : <b>" . $d['token'] . "</b> &nbsp;&nbsp; <a href='#' onclick='return refresh_token(" . $d['id'] . ")' title='Perbarui Token'><i class='fa fa-refresh'></i></a>";
				$data_ok['mapel'] = $d['mapel'];
				$data_ok['jumlah_soal'] = $d['jumlah_soal'];
				$data_ok['id'] = $d['id'];

				$data_ok['mulai'] = tjs($d['tgl_mulai'], "s") . "<br>(" . $d['waktu'] . " menit)";
				$data_ok['pengacakan'] = $jenis_soal;

				$data[] = $data_ok;
			}

			j(["data" => $data]);
			exit;
		} else if ($uri3 == "refresh_token") {
			$token = strtoupper(random_string('alpha', 5));
			$this->db->query("UPDATE tr_guru_tes SET token = '$token' WHERE id = '$uri4'");
			$ret_arr['status'] = "ok";
			j($ret_arr);
			exit();
		} else {
			$a['p']	= "m_guru_tes";
		}
		$this->load->view('aaa', $a);
	}
	public function h_ujian()
	{
		$this->cek_aktif();
		cek_hakakses(array("guru", "admin"), $this->session->userdata('admin_level'));

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$uri5 = $this->uri->segment(5);
		$p = json_decode(file_get_contents('php://input'));
		$jeson = array();

		$wh_1 = $a['sess_level'] == "admin" ? "" : " AND a.id_guru = '" . $a['sess_konid'] . "'";

		$a['p_mapel'] = obj_to_array($this->db->query("SELECT * FROM m_mapel")->result(), "id,nama");

		if ($uri3 == "det") {
			$a['detil_tes'] = $this->db->query("SELECT m_mapel.nama AS namaMapel, m_guru.nama AS nama_guru, 
												tr_guru_tes.* 
												FROM tr_guru_tes 
												INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id
												INNER JOIN m_guru ON tr_guru_tes.id_guru = m_guru.id
												WHERE tr_guru_tes.id = '$uri4'")->row();
			$a['statistik'] = $this->db->query("SELECT MAX(nilai) AS max_, MIN(nilai) AS min_, AVG(nilai) AS avg_ 
											FROM tr_ikut_ujian
											WHERE tr_ikut_ujian.id_tes = '$uri4'")->row();

			$a['p'] = "m_guru_tes_hasil_detil";
		} else if ($uri3 == "data_det") {
			$data = $this->db->query("
	        	SELECT a.id, a.id_tes, b.nama, a.nilai, a.jml_benar, a.nilai_bobot
				FROM tr_ikut_ujian a
				INNER JOIN m_siswa b ON a.id_user = b.id
				WHERE a.id_tes = '$uri4'")->result_array();

			j(["data" => $data]);
			exit;
		} else if ($uri3 == "batalkan_ujian") {
			$this->db->query("DELETE FROM tr_ikut_ujian WHERE id = '$uri4'");
			redirect('adm/h_ujian/det/' . $uri5);
		} else if ($uri3 == "data") {
			$data = $this->db->query("SELECT a.*, b.nama AS mapel, c.nama AS nama_guru FROM tr_guru_tes a
											INNER JOIN m_mapel b ON a.id_mapel = b.id 
											INNER JOIN m_guru c ON a.id_guru = c.id " . "$wh_1")->result_array();


			j(["data" => $data]);
			exit;
		} else if ($uri3 == "detail_jawaban") {
			$detail = $this->db->query("SELECT a.*, b.nama AS nama_siswa, d.nama AS nama_guru, c.nama_ujian, c.jumlah_soal FROM tr_ikut_ujian a
										JOIN m_siswa b ON a.id_user = b.id
										JOIN tr_guru_tes c ON a.id_tes = c.id 
										JOIN m_guru d ON c.id_guru = d.id
										WHERE a.id = '$uri4'
			")->row_array();

			$soal = $this->db->query('SELECT * FROM m_soal WHERE id IN (' . $detail["list_soal"] . ')')->result_array();

			$items = explode(',', $detail['list_jawaban']);

			$jawaban_siswa = [];

			foreach ($items as $item) {
				list($id, $answer, $doubt) = explode(':', $item);

				$jawaban_siswa[$id] = $answer;
			}

			foreach ($soal as &$question) {
				$id = $question['id'];
				if (isset($jawaban_siswa[$id])) {
					$question['jawaban_siswa'] = strtolower($jawaban_siswa[$id]);
				}
			}

			$a['detail'] = $detail;
			$a['soal'] = $soal;
			$a['p'] = "m_detail_jawaban";
		} else {
			$a['p']	= "m_guru_tes_hasil";
		}
		$this->load->view('aaa', $a);
	}
	public function hasil_ujian_cetak()
	{
		$this->cek_aktif();

		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		$a['detil_tes'] = $this->db->query("SELECT m_mapel.nama AS namaMapel, m_guru.nama AS nama_guru, 
												tr_guru_tes.* 
												FROM tr_guru_tes 
												INNER JOIN m_mapel ON tr_guru_tes.id_mapel = m_mapel.id
												INNER JOIN m_guru ON tr_guru_tes.id_guru = m_guru.id
												WHERE tr_guru_tes.id = '$uri3'")->row();

		$a['statistik'] = $this->db->query("SELECT MAX(nilai) AS max_, MIN(nilai) AS min_, AVG(nilai) AS avg_ 
										FROM tr_ikut_ujian
										WHERE tr_ikut_ujian.id_tes = '$uri3'")->row();
		$a['hasil'] = $this->db->query("SELECT m_siswa.nama, tr_ikut_ujian.nilai, tr_ikut_ujian.jml_benar, tr_ikut_ujian.nilai_bobot
										FROM tr_ikut_ujian
										INNER JOIN m_siswa ON tr_ikut_ujian.id_user = m_siswa.id
										WHERE tr_ikut_ujian.id_tes = '$uri3' ORDER BY tr_ikut_ujian.nilai DESC")->result();
		$this->load->view("m_guru_tes_hasil_detil_cetak", $a);
	}
	/* == SISWA == */
	public function ikuti_ujian()
	{
		$this->cek_aktif();
		cek_hakakses(array("siswa"), $this->session->userdata('admin_level'));

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);


		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();
		$x = $this->db->query("SELECT id, jurusan, id_jurusan FROM m_siswa WHERE id = '" . $a['sess_konid'] . "'")->row();
		$d = date('Y-m-d');
		$a['data'] = $this->db->query("SELECT 
									a.id, a.nama_ujian, a.jumlah_soal, a.waktu, a.kelas, a.jurusan, a.tgl_mulai, a.terlambat,
									b.nama nmmapel,
									c.nama nmguru,
									IF((d.status='Y' AND NOW() BETWEEN d.tgl_mulai AND d.tgl_selesai),'Sedang Tes',
									IF(d.status='Y' AND NOW() NOT BETWEEN d.tgl_mulai AND d.tgl_selesai,'Waktu Habis',
									IF(d.status='N','Selesai','Belum Ikut'))) status
									FROM tr_guru_tes a
									INNER JOIN m_mapel b ON a.id_mapel = b.id
									INNER JOIN m_guru c ON a.id_guru = c.id
									LEFT JOIN tr_ikut_ujian d ON CONCAT('" . $a['sess_konid'] . "',a.id) = CONCAT(d.id_user,d.id_tes)
									ORDER BY a.tgl_mulai DESC")->result();
		$a['p']	= "m_list_ujian_siswa";

		$this->load->view('aaa', $a);
	}
	public function ikut_ujian()
	{
		$this->cek_aktif();
		cek_hakakses(array("siswa"), $this->session->userdata('admin_level'));

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		// echo '<pre>';
		// print_r("a : ");
		// print_r($a);
		// echo '</pre>';

		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);

		// echo '<pre>';
		// print_r("uri2 : ");
		// print_r($uri2);
		// print_r("uri3 : ");
		// print_r($uri3);
		// print_r("uri4 : ");
		// print_r($uri4);
		// echo '</pre>';

		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		// echo '<pre>';
		// print_r("p : ");
		// print_r($p);
		// echo '</pre>';


		$a['detil_user'] = $this->db->query("SELECT * FROM m_siswa WHERE id = '" . $a['sess_konid'] . "'")->row();
		// echo '<pre>';
		// print_r("a : ");
		// print_r($a);
		// echo '</pre>';

		if ($uri3 == "simpan_satu") {
			$p			= json_decode(file_get_contents('php://input'));

			$update_ 	= "";
			for ($i = 1; $i < $p->jml_soal; $i++) {
				$_tjawab 	= "opsi_" . $i;
				$_tidsoal 	= "id_soal_" . $i;
				$_ragu 		= "rg_" . $i;
				$jawaban_ 	= empty($p->$_tjawab) ? "" : $p->$_tjawab;
				$update_	.= "" . $p->$_tidsoal . ":" . $jawaban_ . ":" . $p->$_ragu . ",";
			}
			$update_		= substr($update_, 0, -1);
			$this->db->query("UPDATE tr_ikut_ujian SET list_jawaban = '" . $update_ . "' WHERE id_tes = '$uri4' AND id_user = '" . $a['sess_konid'] . "'");
			//echo $this->db->last_query();

			$q_ret_urn 	= $this->db->query("SELECT list_jawaban FROM tr_ikut_ujian WHERE id_tes = '$uri4' AND id_user = '" . $a['sess_konid'] . "'");

			$d_ret_urn 	= $q_ret_urn->row_array();
			$ret_urn 	= explode(",", $d_ret_urn['list_jawaban']);
			$hasil 		= array();
			foreach ($ret_urn as $key => $value) {
				$pc_ret_urn = explode(":", $value);
				$idx 		= $pc_ret_urn[0];
				$val 		= $pc_ret_urn[1] . '_' . $pc_ret_urn[2];
				$hasil[] = $val;
			}

			$d['data'] = $hasil;
			$d['status'] = "ok";

			j($d);
			exit;
		} else if ($uri3 == "simpan_akhir") {
			$id_tes = abs($uri4);

			$get_jawaban = $this->db->query("SELECT list_jawaban FROM tr_ikut_ujian WHERE id_tes = '$uri4' AND id_user = '" . $a['sess_konid'] . "'")->row_array();
			$pc_jawaban = explode(",", $get_jawaban['list_jawaban']);

			$jumlah_benar 	= 0;
			$jumlah_salah 	= 0;
			$jumlah_ragu  	= 0;
			$nilai_bobot 	= 0;
			$total_bobot	= 0;
			$jumlah_soal	= sizeof($pc_jawaban);

			for ($x = 0; $x < $jumlah_soal; $x++) {
				$pc_dt = explode(":", $pc_jawaban[$x]);
				$id_soal 	= $pc_dt[0];
				$jawaban 	= $pc_dt[1];
				$ragu 		= $pc_dt[2];

				$cek_jwb 	= $this->db->query("SELECT bobot, jawaban FROM m_soal WHERE id = '" . $id_soal . "'")->row();
				$kunci_jawaban 	= strtoupper($cek_jwb->jawaban);
				$total_bobot = $total_bobot + $cek_jwb->bobot;

				if (($kunci_jawaban == $jawaban)) {
					//jika jawaban benar 
					$jumlah_benar++;
					$nilai_bobot = $nilai_bobot + $cek_jwb->bobot;
					$q_update_jwb = "UPDATE m_soal SET jml_benar = jml_benar + 1 WHERE id = '" . $id_soal . "'";
				} else {
					//jika jawaban salah
					$jumlah_salah++;
					$q_update_jwb = "UPDATE m_soal SET jml_salah = jml_salah + 1 WHERE id = '" . $id_soal . "'";
				}
				$this->db->query($q_update_jwb);
			}

			$nilai = ($jumlah_benar / $jumlah_soal)  * 100;
			$nilai_bobot = ($nilai_bobot / $total_bobot)  * 100;

			$this->db->query("UPDATE tr_ikut_ujian SET jml_benar = " . $jumlah_benar . ", nilai = " . $nilai . ", nilai_bobot = " . $nilai_bobot . ", status = 'N' WHERE id_tes = '$id_tes' AND id_user = '" . $a['sess_konid'] . "'");
			$a['status'] = "ok";
			j($a);
			exit;
		} else if ($uri3 == "token") {
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");

			$a['du'] = $this->db->query("SELECT a.id, a.tgl_mulai, a.terlambat, 
										a.token, a.nama_ujian, a.jumlah_soal, a.waktu,
										b.nama nmguru, c.nama nmmapel,
										(case
											when (now() < a.tgl_mulai) then 0
											when (now() >= a.tgl_mulai and now() <= a.terlambat) then 1
											else 2
										end) statuse
										FROM tr_guru_tes a 
										INNER JOIN m_guru b ON a.id_guru = b.id
										INNER JOIN m_mapel c ON a.id_mapel = c.id 
										WHERE a.id = '$uri4'")->row_array();

			$a['dp'] = $this->db->query("SELECT * FROM m_siswa WHERE id = '" . $a['sess_konid'] . "'")->row_array();

			// echo '<pre>';
			// print_r("a : ");
			// print_r($a);
			// echo '</pre>';

			//$q_status = $this->db->query();

			if (!empty($a['du']) || !empty($a['dp'])) {
				$tgl_selesai = $a['du']['tgl_mulai'];
				//$tgl_selesai2 = strtotime($tgl_selesai);
				//$tgl_baru = date('F j, Y H:i:s', $tgl_selesai);
				//$tgl_terlambat = strtotime("+".$a['du']['terlambat']." minutes", $tgl_selesai2);	
				$tgl_terlambat_baru = $a['du']['terlambat'];
				$a['tgl_mulai'] = $tgl_selesai;
				$a['terlambat'] = $tgl_terlambat_baru;
				$a['p']	= "m_token";

				// echo '<pre>';
				// print_r("a : ");
				// print_r($a);
				// echo '</pre>';

				$this->load->view('aaa', $a);
			} else {
				redirect('adm/ikuti_ujian');
			}
		} else {
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");


			$cek_sdh_selesai = $this->db->query("SELECT id FROM tr_ikut_ujian WHERE id_tes = '$uri4' AND id_user = '" . $a['sess_konid'] . "' AND status = 'N'")->num_rows();

			// echo '<pre>';
			// print_r("cek_sdh_selesai : ");
			// print_r($cek_sdh_selesai);
			// echo '</pre>';

			//sekalian validasi waktu sudah berlalu...
			if ($cek_sdh_selesai < 1) {
				//ini jika ujian belum tercatat, belum ikut
				//ambil detil soal
				$cek_detil_tes = $this->db->query("SELECT a.*, b.nama nama_guru, c.nama nama_mapel FROM tr_guru_tes a INNER JOIN m_guru b ON a.id_guru = b.id INNER JOIN m_mapel c ON a.id_mapel = c.id WHERE a.id = '$uri4'")->row();
				$cek_detil_soal = $this->db->query("SELECT a.id FROM m_kelas a INNER JOIN tr_guru_tes b ON a.kelas=b.kelas WHERE b.id='$uri4'")->row();
				$q_cek_sdh_ujian = $this->db->query("SELECT id FROM tr_ikut_ujian WHERE id_tes = '$uri4' AND id_user = '" . $a['sess_konid'] . "'");
				$d_cek_sdh_ujian = $q_cek_sdh_ujian->row();
				$cek_sdh_ujian	= $q_cek_sdh_ujian->num_rows();
				$acakan = $cek_detil_tes->jenis == "acak" ? "ORDER BY RAND()" : "ORDER BY id ASC";

				// echo '<pre>';
				// print_r("cek_detil_tes : ");
				// print_r($cek_detil_tes);
				// print_r("cek_detil_soal : ");
				// print_r($cek_detil_soal);
				// print_r("q_cek_sdh_ujian : ");
				// print_r($q_cek_sdh_ujian);
				// print_r("d_cek_sdh_ujian : ");
				// print_r($d_cek_sdh_ujian);
				// print_r("cek_sdh_ujian : ");
				// print_r($cek_sdh_ujian);
				// print_r("acakan : ");
				// print_r($acakan);
				// echo '</pre>';

				if ($cek_sdh_ujian < 1) {
					// echo '<pre>';
					// print_r("true : ");
					// echo '</pre>';
					$soal_urut_ok = array();
					$q_soal			= $this->db->query("SELECT id, file, tipe_file, soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e, '' AS jawaban FROM m_soal WHERE id_mapel = '" . $cek_detil_tes->id_mapel . "' AND id_guru = '" . $cek_detil_tes->id_guru . "' " . $acakan . " LIMIT " . $cek_detil_tes->jumlah_soal)->result();
					$i = 0;
					foreach ($q_soal as $s) {
						$soal_per = new stdClass();
						$soal_per->id = $s->id;
						$soal_per->soal = $s->soal;
						$soal_per->file = $s->file;
						$soal_per->tipe_file = $s->tipe_file;
						$soal_per->opsi_a = $s->opsi_a;
						$soal_per->opsi_b = $s->opsi_b;
						$soal_per->opsi_c = $s->opsi_c;
						$soal_per->opsi_d = $s->opsi_d;
						$soal_per->opsi_e = $s->opsi_e;
						$soal_per->jawaban = $s->jawaban;
						$soal_urut_ok[$i] = $soal_per;
						$i++;
					}
					$soal_urut_ok = $soal_urut_ok;
					$list_id_soal	= "";
					$list_jw_soal 	= "";
					if (!empty($q_soal)) {
						foreach ($q_soal as $d) {
							$list_id_soal .= $d->id . ",";
							$list_jw_soal .= $d->id . "::N,";
						}
					}
					$list_id_soal = substr($list_id_soal, 0, -1);
					$list_jw_soal = substr($list_jw_soal, 0, -1);
					$waktu_selesai = tambah_jam_sql($cek_detil_tes->waktu);
					$time_mulai		= date('Y-m-d H:i:s');
					$this->db->query("INSERT INTO tr_ikut_ujian VALUES (null, '$uri4', '" . $a['sess_konid'] . "', '$list_id_soal', '$list_jw_soal', 0, 0, 0, '$time_mulai', ADDTIME('$time_mulai', '$waktu_selesai'), 'Y')");

					$detil_tes = $this->db->query("SELECT * FROM tr_ikut_ujian WHERE id_tes = '$uri4' AND id_user = '" . $a['sess_konid'] . "'")->row();

					$soal_urut_ok = $soal_urut_ok;
				} else {

					// echo '<pre>';
					// print_r("false : ");
					// echo '</pre>';

					$q_ambil_soal 	= $this->db->query("SELECT * FROM tr_ikut_ujian WHERE id_tes = '$uri4' AND id_user = '" . $a['sess_konid'] . "'")->row();
					// echo '<pre>';
					// print_r("q_ambil_soal : ");
					// print_r($q_ambil_soal);
					// echo '</pre>';

					$urut_soal 		= explode(",", $q_ambil_soal->list_jawaban);

					// echo '<pre>';
					// print_r("urut_soal : ");
					// print_r($urut_soal);
					// echo '</pre>';

					$soal_urut_ok	= array();
					// echo '<pre>';
					// print_r("masuk for loop : ");
					// echo '</pre>';
					for ($i = 0; $i < sizeof($urut_soal); $i++) {
						$pc_urut_soal = explode(":", $urut_soal[$i]);
						$pc_urut_soal1 = empty($pc_urut_soal[1]) ? "''" : "'" . $pc_urut_soal[1] . "'";
						$ambil_soal = $this->db->query("SELECT *, $pc_urut_soal1 AS jawaban FROM m_soal WHERE id = '" . $pc_urut_soal[0] . "'")->row();
						$soal_urut_ok[] = $ambil_soal;

						// echo '<pre>';
						// print_r("pc_urut_soal : ");
						// print_r($pc_urut_soal);
						// print_r("pc_urut_soal1 : ");
						// print_r($pc_urut_soal1);
						// print_r("ambil_soal : ");
						// print_r($ambil_soal);
						// print_r("soal_urut_ok : ");
						// print_r($soal_urut_ok);
						// echo '</pre>';
					}

					// echo '<pre>';
					// print_r("pc_urut_soal : ");
					// print_r($pc_urut_soal);
					// echo '</pre>';

					// echo '<pre>';
					// print_r("pc_urut_soal1 : ");
					// print_r($pc_urut_soal1);
					// echo '</pre>';

					// echo '<pre>';
					// print_r("ambil_soal : ");
					// print_r($ambil_soal);
					// echo '</pre>';

					// echo '<pre>';
					// print_r("soal_urut_ok : ");
					// print_r($soal_urut_ok);
					// echo '</pre>';

					$detil_tes = $q_ambil_soal;

					$soal_urut_ok = $soal_urut_ok;
				}

				$pc_list_jawaban = explode(",", $detil_tes->list_jawaban);

				$arr_jawab = array();
				foreach ($pc_list_jawaban as $v) {
					$pc_v = explode(":", $v);
					$idx = $pc_v[0];
					$val = $pc_v[1];
					$rg = $pc_v[2];

					$arr_jawab[$idx] = array("j" => $val, "r" => $rg);
				}

				// echo '<pre>';
				// print_r("arr_jawab : ");
				// print_r($arr_jawab);
				// echo '</pre>';

				// echo '<pre>';
				// print_r("this->config->item('jml_opsi') : ");
				// print_r($this->config->item('jml_opsi'));
				// echo '</pre>';

				// echo '<pre>';
				// print_r("this->opsi[0] : ");
				// print_r($this->opsi[0]);
				// echo '</pre>';

				$html = '';
				$soal_jawaban = '';
				$no = 1;
				if (!empty($soal_urut_ok)) {
					foreach ($soal_urut_ok as $d) {
						// $tampil_media = tampil_media("./upload/gambar_soal/" . $d->file, 'auto', 'auto');
						$vrg = $arr_jawab[$d->id]["r"] == "" ? "N" : $arr_jawab[$d->id]["r"];

						$html .= '<input type="hidden" name="id_soal_' . $no . '" value="' . $d->id . '">';
						$html .= '<input type="hidden" name="rg_' . $no . '" id="rg_' . $no . '" value="' . $vrg . '">';
						$html .= '<div class="step" id="widget_' . $no . '">';

						$soal_jawaban .= '<input type="hidden" name="id_soal_' . $no . '" value="' . $d->id . '">';
						$soal_jawaban .= '<input type="hidden" name="rg_' . $no . '" id="rg_' . $no . '" value="' . $vrg . '">';
						$soal_jawaban .= '<div class="step" id="widget_' . $no . '" style="margin-top: 16px; color: #3C3C3C; font-size: 14px">';

						// $html .= $d->soal . '<br>' . $tampil_media . '<div class="funkyradio">';
						$html .= $d->soal . '<br><div class="funkyradio">';
						$soal_jawaban .= $d->soal . '<div style="margin-top: 16px">';


						for ($j = 0; $j < $this->config->item('jml_opsi'); $j++) {
							$opsi = "opsi_" . $this->opsi[$j];

							$checked = $arr_jawab[$d->id]["j"] == strtoupper($this->opsi[$j]) ? "checked" : "";

							// $pc_pilihan_opsi = explode("#####", $d->$opsi);

							// $tampil_media_opsi = (is_file('./upload/gambar_soal/' . $pc_pilihan_opsi[0]) || $pc_pilihan_opsi[0] != "") ? tampil_media('./upload/gambar_opsi/' . $pc_pilihan_opsi[0], 'auto', 'auto') : '';

							// $pilihan_opsi = empty($pc_pilihan_opsi[1]) ? "-" : $pc_pilihan_opsi[1];

							$html .= '<div class="funkyradio-success" onclick="return simpan_sementara();">
										<input type="radio" id="opsi_' . strtoupper($this->opsi[$j]) . '_' . $d->id . '" name="opsi_' . $no . '" value="' . strtoupper($this->opsi[$j]) . '" ' . $checked . ' /> 
										<label for="opsi_' . strtoupper($this->opsi[$j]) . '_' . $d->id . '">
											<div class="huruf_opsi">' . $this->opsi[$j] . '</div> 
											<p>' . $d->$opsi . '</p>
										</label>
									</div>';

							$soal_jawaban .= '<div onclick="simpan_sementara()" style="display: flex; align-items: start; gap: 16px;">
												<input style="display: block" type="radio" id="opsi_' . strtoupper($this->opsi[$j]) . '_' . $d->id . '" name="opsi_' . $no . '" value="' . strtoupper($this->opsi[$j]) . '" ' . $checked . ' /> 
												<label for="opsi_' . strtoupper($this->opsi[$j]) . '_' . $d->id . '" style="font-weight: 400">' . $d->$opsi . '</label>
											</div>';
						}
						$html .= '</div></div>';
						$soal_jawaban .= '</div></div>';
						$no++;
					}
				}

				$a['jam_mulai'] = $detil_tes->tgl_mulai;
				$a['jam_selesai'] = $detil_tes->tgl_selesai;
				$a['id_tes'] = $cek_detil_tes->id;
				$a['waktu'] = $cek_detil_tes->waktu;
				$a['no'] = $no;
				$a['html'] = $html;
				$a['soal_jawaban'] = $soal_jawaban;
				$a['info_soal'] = $cek_detil_tes->nama_ujian . " / " . $cek_detil_tes->nama_mapel . " / " . $cek_detil_tes->nama_guru;

				$this->load->view('v_ujian', $a);
			} else {
				redirect('adm/sudah_selesai_ujian/' . $uri4);
			}
		}
	}
	public function jvs()
	{
		$this->cek_aktif();
		$data_soal 		= $this->db->query("SELECT id, gambar, soal, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e FROM m_soal ORDER BY RAND()")->result();
		j($data_soal);
		exit;
	}
	public function rubah_password()
	{
		$this->cek_aktif();

		//var def session
		$a['sess_admin_id'] = $this->session->userdata('admin_id');
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		$ret = array();
		if ($uri3 == "simpan") {
			$p1_md5 = md5($p->p1);
			$p2_md5 = md5($p->p2);
			$p3_md5 = md5($p->p3);
			$cek_pass_lama = $this->db->query("SELECT password FROM m_admin WHERE id = '" . $a['sess_admin_id'] . "'")->row();
			if ($cek_pass_lama->password != $p1_md5) {
				$ret['status'] = "error";
				$ret['msg'] = "Password lama tidak sama!";
			} else if ($p2_md5 != $p3_md5) {
				$ret['status'] = "error";
				$ret['msg'] = "Password baru konfirmasinya tidak sama!";
			} else if (strlen($p->p2) < 6) {
				$ret['status'] = "error";
				$ret['msg'] = "Password baru minimal terdiri dari 6 huruf!";
			} else {
				$this->db->query("UPDATE m_admin SET password = '" . $p3_md5 . "' WHERE id = '" . $a['sess_admin_id'] . "'");
				$ret['status'] = "ok";
				$ret['msg'] = "Password berhasil diubah!";
			}
			j($ret);
			exit;
		} else {
			$data = $this->db->query("SELECT id, kon_id, level, username FROM m_admin WHERE id = '" . $a['sess_admin_id'] . "'")->row();
			j($data);
			exit;
		}
	}
	public function sudah_selesai_ujian()
	{
		$this->cek_aktif();

		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_konid'] = $this->session->userdata('admin_konid');

		//var def uri segment
		$uri2 = $this->uri->segment(2);
		$uri3 = $this->uri->segment(3);
		$uri4 = $this->uri->segment(4);

		$q_nilai = $this->db->query("SELECT nilai, tgl_selesai FROM tr_ikut_ujian WHERE id_tes = $uri3 AND id_user = '" . $a['sess_konid'] . "' AND status = 'N'")->row();
		if (empty($q_nilai)) {
			redirect('adm/ikut_ujian/_/' . $uri3);
		} else {

			$a['p'] = "v_selesai_ujian";

			if ($this->config->item('tampil_nilai')) {
				$a['data'] = "<div class='alert alert-danger'>Anda telah selesai mengikuti ujian ini pada : <strong style='font-size: 16px'>" . tjs($q_nilai->tgl_selesai, "l") . "</strong>.</div>";
				$a['tgl_selesai'] = $q_nilai->tgl_selesai;
			} else {
				$a['data'] = "<div class='alert alert-danger'>Anda telah selesai mengikuti ujian ini pada : <strong style='font-size: 16px'>" . tjs($q_nilai->tgl_selesai, "l") . "</strong>.</div>";
				$a['tgl_selesai'] = $q_nilai->tgl_selesai;
			}
		}
		$this->load->view('aaa', $a);
	}
	/* Login Logout */
	public function login()
	{
		$this->load->view('aaa_login');
	}
	public function act_login()
	{

		$username	= $this->input->post('username');
		$password	= $this->input->post('password');

		$hashed_password	= md5($password);

		$q_data		= $this->db->query("SELECT * FROM m_admin WHERE username = '" . $username . "' AND password = '$hashed_password'");
		$j_data		= $q_data->num_rows();
		$a_data		= $q_data->row();

		$_log		= array();
		if ($j_data === 1) {
			$sess_nama_user = "";
			if ($a_data->level == "siswa") {
				$det_user = $this->db->query("SELECT nama FROM m_siswa WHERE id = '" . $a_data->kon_id . "'")->row();
				if (!empty($det_user)) {
					$sess_nama_user = $det_user->nama;
				}
			} else if ($a_data->level == "guru") {
				$det_user = $this->db->query("SELECT nama FROM m_guru WHERE id = '" . $a_data->kon_id . "'")->row();
				if (!empty($det_user)) {
					$sess_nama_user = $det_user->nama;
				}
			} else {
				$sess_nama_user = "Administrator";
			}
			$data = array(
				'admin_id' => $a_data->id,
				'admin_user' => $a_data->username,
				'admin_level' => $a_data->level,
				'admin_konid' => $a_data->kon_id,
				'admin_nama' => $sess_nama_user,
				'admin_valid' => true
			);
			$this->session->set_userdata($data);
			$_log['log']['status']			= "1";
			$_log['log']['keterangan']		= "Login Berhasil";
			$_log['log']['detil_admin']		= $this->session->userdata;
		} else {
			$_log['log']['status']			= "0";
			$_log['log']['keterangan']		= "username atau password tidak ditemukan";
			$_log['log']['detil_admin']		= null;
		}

		j($_log);
	}
	public function logout()
	{
		$data = array(
			'admin_id' 		=> "",
			'admin_user' 	=> "",
			'admin_level' 	=> "",
			'admin_konid' 	=> "",
			'admin_nama' 	=> "",
			'admin_valid' 	=> false
		);
		$this->session->set_userdata($data);
		redirect('adm');
	}
	//fungsi tambahan
	public function get_akhir($tabel, $field, $kode_awal, $pad)
	{
		$get_akhir	= $this->db->query("SELECT MAX($field) AS max FROM $tabel LIMIT 1")->row();
		$data		= (intval($get_akhir->max)) + 1;
		$last		= $kode_awal . str_pad($data, $pad, '0', STR_PAD_LEFT);

		return $last;
	}

	private function delete_temp_images()
	{
		$tempFolder = './temp/';
		$files = glob($tempFolder . '*'); // Get all file names

		foreach ($files as $file) {
			if (is_file($file)) {
				unlink($file); // Delete each file
			}
		}
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */