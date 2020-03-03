<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Karyawan extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->check_logged_in();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_general','', TRUE);
		$this->load->model('Model_laundry','', TRUE);
	}
	
	function index($nip){
		$data['content'] = 'main/karyawan/kar_home';
		$data['page_title'] = "Waroenk Laundry | Karyawan";
		$data['ambil'] = $this->Model_general->getDataBy("wl_pegawai","nip",$nip)->row();
		$data['pesan'] = $this->Model_general->countDataWhere("wl_pegawai_pesan","nip = '$nip' AND status_pesan = 'Unread'");
		$data['nip'] = $nip;
		
		$this->load->view('main/karyawan/template', $data);
	}
	
	/* LOGIN */
	function login(){
		if( $this->cekPegawai($this->input->post("nip")) == true ){
			$nip = $this->input->post('nip');
			$pass = sha1($this->input->post('pass'));
        	$query = $this->Model_general->getDataWhere("wl_pegawai","nip = '$nip' AND pass_pegawai = '$pass'");
			if($query->num_rows() > 0){
				redirect($this->mza_secureurl->setSecureUrl_encode('karyawan','index',array($nip)));
			}else{
				redirect ( $this->mza_secureurl->setSecureUrl_encode("home","index",array("PASS")) );
			}
		}else{
			redirect ( $this->mza_secureurl->setSecureUrl_encode("home","index",array("NIP")) );
		}
	}
	function cekPegawai($nip){
		$query = $this->Model_general->getDataBy("wl_pegawai","nip",$nip);
		if($query->num_rows() > 0){
			$data = $query->row();
			if($data->position_id == 4 || $data->position_id == 5)
				return true;
			else
				return false;
		}else
			return false;
	}
	
	/* PROFIL */
	function profil($nip,$error){
		$data['content'] = 'main/karyawan/kar_form';
		$data['page_title'] = "Waroenk Laundry | Profil Karyawan";
		$data['form_pegawai']= site_url( $this->mza_secureurl->setSecureUrl_encode('karyawan','profil_process',array($nip,"")) );
		$data['form_pass']= site_url( $this->mza_secureurl->setSecureUrl_encode('karyawan','profil_process',array($nip,"Pass")) );
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("karyawan","index",array($nip)) );
		$data['error'] = $error;
		$data['nip'] = $nip;
		
		$pegawai = $this->Model_general->getDataBy("wl_pegawai","nip",$nip)->row();
		$data['default']['name'] = $pegawai->nama_pegawai;
		$data['default']['add'] = $pegawai->alamat_pegawai;
		$data['default']['pno'] = $pegawai->tlp_pegawai;
		$data['default']['bplace'] = $pegawai->lhr_pegawai;
		$data['default']['bdate'] = $pegawai->tgl_pegawai;
		$data['default']['pos'] = $pegawai->position_id;
		$data['default']['outlet'] = $pegawai->outlet_id;
		$data['photo'] = $pegawai->foto_pegawai;
		
		$this->load->view('main/karyawan/template', $data);
	}
	function profil_process($nip,$status) {
		$validation = "pegawai" . $status;
		if ($this->form_validation->run($validation) == FALSE){
			redirect( $this->mza_secureurl->setSecureUrl_encode('karyawan','profil',array($nip,"YES")) );
		} else {
			$photo = $this->uploadPhoto('pegawai');
			if($status == "Pass"){
				$param_pegawai = array( 'pass_pegawai' => sha1($this->input->post('pass')) );
				$this->Model_general->updateData("wl_pegawai","nip",$nip,$param_pegawai);
			}else{
				// preparing pegawai data
				$param_pegawai = array('nama_pegawai' => $this->input->post('name'),
							'alamat_pegawai' => $this->input->post('add'),
							'tlp_pegawai' => $this->input->post('pno'),
							'lhr_pegawai' => $this->input->post('bplace'),
							'tgl_pegawai' => $this->input->post('bdate'),
							'foto_pegawai' => $photo
						);
				$this->Model_general->updateData("wl_pegawai","nip",$nip,$param_pegawai);
			}
			
			redirect( $this->mza_secureurl->setSecureUrl_encode('karyawan','index',array($nip)) );
		}
	}
	function uploadPhoto($type){
		$photo = $this->input->post('photo');
			
		if (($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpeg") ||
				($_FILES["file"]["type"] == "image/jpg") && ($_FILES["file"]["size"] < 20000)) {
					move_uploaded_file($_FILES["file"]["tmp_name"],"themes/img/".$type."-pic/" . $_FILES["file"]["name"]);
					$photo = "themes/img/".$type."-pic/" . $_FILES["file"]["name"];
		}
		
		return $photo;
	}
	
	/* PESAN */
	function pesan($nip,$id_pesan){
		$data['content'] = 'main/karyawan/kar_pesan';
		$data['page_title'] = "Waroenk Laundry | Pesan";
		if($id_pesan > 0){
			$data['pesan'] = $this->Model_general->getDataBy("wl_pegawai_pesan","id_pesan",$id_pesan)->row();
			$this->Model_general->updateData("wl_pegawai_pesan","id_pesan",$id_pesan,array( 'status_pesan' => "Read" ));
		}else{
			$data['pesan'] = NULL;
		}
		$data['tabelPesan'] = $this->tabelPesan($nip);
		$data['nip'] = $nip;
		
		$pegawai = $this->Model_general->getDataBy("wl_pegawai","nip",$nip)->row();
		if($pegawai->position_id == 4)
			$data['form_kirim'] = site_url( $this->mza_secureurl->setSecureUrl_encode('karyawan','pesan_process',array($nip)) );
		else
			$data['form_kirim'] = NULL;
		
		$this->load->view('main/karyawan/template', $data);
	}
	function pesan_process($nip){
		if( $this->input->post('photo') == "" )
			$photo = "";
		else
			$photo = $this->uploadPhoto('pesan');
			
		// preparing pegawai data
		$param_pesan = array('id_admin' => 1,
					'id_pegawai' => $nip,
					'tgl_pesan' => date('Y/m/d'),
					'judul_pesan' => "[" . $this->input->post('subyek') . "] " . $this->input->post('judul'),
					'isi_pesan' => $this->input->post('pesan'),
					'foto_pesan' => $photo,
					'status_pesan' => "Unread",
					'outlet_id' => $this->session->userdata('id')
				);
		$this->Model_general->insertData("master_admin_pesan",$param_pesan);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('karyawan','pesan',array($nip,0)) );
	}
	function tabelPesan($nip){
		$query = $this->Model_general->getDataBy("wl_pegawai_pesan","nip",$nip);
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="pesanTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( array('data' => 'No', 'style' => 'width:5%;'), 'Tanggal', 'Judul Pesan', 'Action' );
		
		$i = 0;
		foreach ($query->result() as $row){
			$link = anchor($this->mza_secureurl->setSecureUrl_encode('karyawan','pesan',array($nip,$row->id_pesan)),$row->judul_pesan);
			$action = "none";
			
			if($row->status_pesan == "Unread"){
				$nomor = array('data' => ++$i, 'style' => 'font-weight:bold');
				$tanggal = array('data' => $row->tgl_pesan, 'style' => 'width:18%;font-weight:bold;');
				$judul = array('data' => $link, 'style' => 'font-weight:bold;text-align:left;text-indent:10px;');
			}else{
				$nomor = ++$i;
				$tanggal = array('data' => $row->tgl_pesan, 'style' => 'width:18%;');
				$judul = array('data' => $link, 'style' => 'text-align:left;text-indent:10px;');
			}
			$this->table->add_row( $nomor, $tanggal, $judul, array('data' => $action, 'style' => 'width:10%') );
		}
		return $this->table->generate();
	}
	
	/* ABSENSI */
	function absensi($nip){
		$data['content'] = 'main/karyawan/kar_absen';
		$data['page_title'] = "Waroenk Laundry | Absensi";
		$data['ambil'] = $this->Model_general->getDataBy("wl_pegawai","nip",$nip)->row();
		$query = $this->Model_general->getDataWhere("wl_pegawai_absen","nip = '$nip' AND tgl_absen = '" . date('Y/m/d') . "'");
		if($query->num_rows() > 0){
			$cokot = $query->row();
			if($cokot->jam_keluar == NULL){
				$data['href'] = "<a style='font-size:20px;' class='tombol' href='" . site_url( $this->mza_secureurl->setSecureUrl_encode("karyawan","absensi_pulang",array($nip)) ) . "' onclick=\"return confirm('Bergegas pulang ?')\" >&nbsp;ABSEN PULANG&nbsp;</a>";
			}else{
				$data['href'] = NULL;
			}
		}else{
			$data['href'] = "<a style='font-size:20px;' class='tombol' id='absen-button' >&nbsp;ABSEN MASUK&nbsp;</a>";
		}
		$data['absen_masuk'] = site_url( $this->mza_secureurl->setSecureUrl_encode("karyawan","absensi_masuk",array($nip)) );
		$data['tabelAbsen'] = $this->tabelAbsen($nip);
		$data['nip'] = $nip;
		
		$data['tampil_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode("karyawan","absensi",array($nip)) );
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		if($from == NULL || $to == NULL){
			$from = date('Y/m/d',strtotime(date('Y/m/d')."-1 months"));
			$to = date('Y/m/d');
		}
		$data['dari'] = $from;
		$data['sampai'] = $to;
		
		$this->load->view('main/karyawan/template', $data);
	}
	function absensi_masuk($nip){
		$param_absen = array('nip' => $nip,
				'tgl_absen' => date('Y/m/d'),
				'shift_absen' => $this->input->post('shift'),
				'jam_masuk' => date('H:i:s'),
				'ket_absen' => $this->input->post('ket')
		);
		$this->Model_general->insertData("wl_pegawai_absen",$param_absen);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('karyawan','absensi',array($nip)) );
	}
	function absensi_pulang($nip){
		$param_absen = array( 'jam_keluar' => date('H:i:s'), "export" => "Yes" );
		$this->Model_general->updateDataWhere("wl_pegawai_absen","nip = '$nip' AND tgl_absen = '" . date('Y/m/d') . "'",$param_absen);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('karyawan','absensi',array($nip)) );
	}
	function tabelAbsen($nip){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="absenTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( array('data' => 'No', 'style' => 'width:3%;'), 'Tgl. Absen', 'Shift', 'Jam Masuk', 'Jam Keluar', 'Keterangan' );
		
		$i = 0;
		$query = $this->Model_general->getDataBy("wl_pegawai_absen","nip",$nip);
		foreach ($query->result() as $row){
			$this->table->add_row( ++$i, array('data' => $row->tgl_absen, 'style' => 'width:15%'), $row->shift_absen, $row->jam_masuk, $row->jam_keluar,
								array('data' => $row->ket_absen, 'style' => 'width:35%') );
		}
		return $this->table->generate();
	}
	
	/* KINERJA */
	function kinerja($nip){
		$data['content'] = 'main/karyawan/kar_kinerja';
		$data['page_title'] = "Waroenk Laundry | Kinerja";
		$data['ambil'] = $this->Model_general->getDataBy("wl_pegawai","nip",$nip)->row();
		$data['kinerja_f'] = site_url( $this->mza_secureurl->setSecureUrl_encode("karyawan","kinerja",array($nip)) );
		$periode = $this->input->post('periode');
		if($periode == NULL)
			$periode = date('Y/m');
		$data['tabelMain'] = $this->tabelMain($nip,$periode);
		$data['tabelSupport'] = $this->tabelSupport($nip,$periode);
		$data['periode'] = $periode;
		$data['bulan'] = date("F Y", strtotime("$periode/01"));
		$data['nip'] = $nip;
		
		$this->load->view('main/karyawan/template', $data);
	}
	function tabelMain($nip,$periode){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table class="detail" width="100%">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'Tgl', array('data' => 'Kasir', 'style' => 'width:13%;'),
									array('data' => 'Ceklist', 'style' => 'width:13%;'),
									array('data' => 'Cuci', 'style' => 'width:13%;'),
									array('data' => 'Kering', 'style' => 'width:13%;'),
									array('data' => 'Setrika', 'style' => 'width:13%;'),
									array('data' => 'Ambil', 'style' => 'width:13%;'),
									array('data' => 'Delivery', 'style' => 'width:13%;') );
		
		$jtrans = 0; $jcek = 0; $jcuci = 0; $jkering = 0; $jpack = 0; $jambil = 0; $jdeliver = 0;
		$days = cal_days_in_month(CAL_GREGORIAN, substr($periode, 5, 2), substr($periode, 0, 4));
		for($i=1;$i<=$days;$i++){
			if($i<10){
				$trans = $this->Model_laundry->mainKinerja("trans","$periode/0$i",$nip,"sx_job_monitor");
				$cek = $this->Model_laundry->mainKinerja("cek","$periode/0$i",$nip,"sx_job_monitor");
				$cuci = $this->Model_laundry->mainKinerja("cuci","$periode/0$i",$nip,"sx_job_cuker");
				$kering = $this->Model_laundry->mainKinerja("kering","$periode/0$i",$nip,"sx_job_cuker");
				$pack = $this->Model_laundry->mainKinerja("pack","$periode/0$i",$nip,"sx_job_monitor");
				$ambil = $this->Model_laundry->mainKinerja("ambil","$periode/0$i",$nip,"sx_job_monitor");
				$deliver = $this->Model_laundry->mainKinerja("deliver","$periode/0$i",$nip,"sx_job_monitor");
			}else{
				$trans = $this->Model_laundry->mainKinerja("trans","$periode/$i",$nip,"sx_job_monitor");
				$cek = $this->Model_laundry->mainKinerja("cek","$periode/$i",$nip,"sx_job_monitor");
				$cuci = $this->Model_laundry->mainKinerja("cuci","$periode/$i",$nip,"sx_job_cuker");
				$kering = $this->Model_laundry->mainKinerja("kering","$periode/$i",$nip,"sx_job_cuker");
				$pack = $this->Model_laundry->mainKinerja("pack","$periode/$i",$nip,"sx_job_monitor");
				$ambil = $this->Model_laundry->mainKinerja("ambil","$periode/$i",$nip,"sx_job_monitor");
				$deliver = $this->Model_laundry->mainKinerja("deliver","$periode/$i",$nip,"sx_job_monitor");
			}
			$jtrans = $jtrans + $trans;
			$jcek = $jcek + $cek;
			$jcuci = $jcuci + $cuci;
			$jkering = $jkering + $kering;
			$jpack = $jpack + $pack;
			$jambil = $jambil + $ambil;
			$jdeliver = $jdeliver + $deliver;
			$this->table->add_row( $i, $trans,$cek,$cuci,$kering,$pack,$ambil,$deliver);
		}
		$this->table->add_row( array('data' => 'TOTAL', 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'),
							array('data' => $jtrans, 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'),
							array('data' => $jcek, 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'),
							array('data' => $jcuci, 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'),
							array('data' => $jkering, 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'),
							array('data' => $jpack, 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'),
							array('data' => $jambil, 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'),
							array('data' => $jdeliver, 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'));
		return $this->table->generate();
	}
	function tabelSupport($nip,$periode){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table class="detail" width="100%">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( array('data' => 'Tgl', 'style' => 'width:15%;'),array('data' => 'Jam', 'style' => 'width:15%;'),
								array('data' => 'Aset', 'style' => 'width:20%;'),'Perawatan',array('data' => 'Keterangan', 'style' => 'width:30%;') );
		
		$days = cal_days_in_month(CAL_GREGORIAN, substr($periode, 5, 2), substr($periode, 0, 4));
		$query = $this->Model_laundry->suppKinerja("$periode/01","$periode/$days",$nip);
		foreach($query->result() as $row){
			$this->table->add_row( date("d M",strtotime($row->tgl_rawat)),$row->jam_rawat,
								array('data' => $row->nama_jenis . " " . substr($row->kode_aset,-2), 'style' => 'text-align:left;'),$row->perawatan,
								array('data' => $row->cat_rawat, 'style' => 'text-align:left;'));
		}
		return $this->table->generate();
	}
	
	function secure($url){
		$data	= $this->mza_secureurl->setSecureUrl_decode($url);
		if($data != false){
			if (method_exists($this, trim($data['function']))){
				if(!empty($data['params'])){
					return call_user_func_array(array($this, trim($data['function'])), $data['params']);
				}else{
					return $this->$data['function']();
				}
			}
		}
		show_404();
	}
	function check_logged_in() {
		if ($this->session->userdata('is_login') != TRUE ) {
			redirect( $this->mza_secureurl->setSecureUrl_encode('login','logout'), 'refresh' );
		}else{
			if ($this->session->userdata('user') !== "USER" ) {
				redirect( $this->mza_secureurl->setSecureUrl_encode('login','logout'), 'refresh' );
			}
		}
	}
	
}