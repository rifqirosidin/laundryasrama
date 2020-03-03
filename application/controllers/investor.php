<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Investor extends CI_Controller {
	function __construct(){
		parent::__construct();	
		$this->check_logged_in();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_general','', TRUE);
		$this->load->model('Model_user','', TRUE);
		$this->load->model('Model_laundry','', TRUE);
	}
	
	function index(){
		$data['content'] = 'invest/sx_home';
		$data['page_title'] = "Waroenk Laundry | Selamat Datang";
		$data['ambil'] = $this->Model_general->getDataBy("master_invest","invest_id",$this->session->userdata('id'))->row();
		$data['pesan'] = $this->Model_general->countDataWhere("master_invest_pesan","id_invest = ". $this->session->userdata('id') ." AND status_pesan = 'Unread'");
		$data['cek'] = $this->session->userdata('out');
		$data['outlet'] = $this->Model_general->getDataBy("wl_outlet","outlet_id",$this->session->userdata('out'))->row()->outlet_name;
		$this->load->view('invest/template', $data);
	}
	
	/* PROFIL */
	function profil($error){
		$data['content'] = 'invest/invest_form';
		$data['page_title'] = "Waroenk Laundry | Profil Investor";
		$data['form_pegawai']= site_url( $this->mza_secureurl->setSecureUrl_encode('investor','profil_process',array("")) );
		$data['form_pass']= site_url( $this->mza_secureurl->setSecureUrl_encode('investor','profil_process',array("Pass")) );
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("investor","index") );
		$data['error'] = $error;
		
		$pegawai = $this->Model_general->getDataBy("master_invest","invest_id",$this->session->userdata('id'))->row();
		$data['default']['name'] = $pegawai->invest_name;
		$data['default']['add'] = $pegawai->inv_alamat;
		$data['default']['pno'] = $pegawai->inv_tlp;
		$data['default']['outlet'] = $pegawai->outlet_id;
		
		$this->load->view('invest/template', $data);
	}
	function profil_process($status) {
		$validation = "pegawai" . $status;
		if ($this->form_validation->run($validation) == FALSE){
			redirect( $this->mza_secureurl->setSecureUrl_encode('investor','profil',array("YES")) );
		} else {
			if($status == "Pass"){
				$param_pegawai = array( 'pass' => sha1($this->input->post('pass')) );
				$this->Model_general->updateData("master_invest","invest_id",$this->session->userdata('id'),$param_pegawai);
			}else{
				// preparing pegawai data
				$param_pegawai = array('invest_name' => $this->input->post('name'),
							'inv_alamat' => $this->input->post('add'),
							'inv_tlp' => $this->input->post('pno')
						);
				$this->Model_general->updateData("master_invest","invest_id",$this->session->userdata('id'),$param_pegawai);
			}
			redirect( $this->mza_secureurl->setSecureUrl_encode('investor','index') );
		}
	}
	
	/* PESAN */
	function pesan($id_pesan){
		$data['content'] = 'invest/invest_pesan';
		$data['page_title'] = "Waroenk Laundry | Pesan";
		if($id_pesan > 0){
			$data['pesan'] = $this->Model_general->getDataBy("master_invest_pesan","id_pesan",$id_pesan)->row();
			$this->Model_general->updateData("master_invest_pesan","id_pesan",$id_pesan,array( 'status_pesan' => "Read" ));
		}else{
			$data['pesan'] = NULL;
		}
		$data['tabelPesan'] = $this->tabelPesan($this->session->userdata('id'));
		$data['form_kirim'] = site_url( $this->mza_secureurl->setSecureUrl_encode('investor','pesan_process') );
		
		$this->load->view('invest/template', $data);
	}
	function pesan_process(){
		if( $this->input->post('photo') == "" )
			$photo = "";
		else
			$photo = $this->uploadPhoto('pesan');
			
		// preparing data
		$param_pesan = array('id_admin' => 1,
					'id_pegawai' => $this->session->userdata('id'),
					'tgl_pesan' => date('Y/m/d'),
					'judul_pesan' => "[INVESTOR] " . $this->input->post('judul'),
					'isi_pesan' => $this->input->post('pesan'),
					'foto_pesan' => $photo,
					'status_pesan' => "Unread",
					'pegawai' => 'N',
					'outlet_id' => $this->session->userdata('id')
				);
		$this->Model_general->insertData("master_admin_pesan",$param_pesan);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('investor','pesan',array(0)) );
	}
	function tabelPesan($id){
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
		$query = $this->Model_general->getDataBy("master_invest_pesan","id_invest",$id);
		foreach ($query->result() as $row){
			$link = anchor($this->mza_secureurl->setSecureUrl_encode('investor','pesan',array($row->id_pesan)),$row->judul_pesan);
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
			redirect( $this->mza_secureurl->setSecureUrl_encode('invest_login','logout'), 'refresh' );
		}else{
			if ($this->session->userdata('user') !== "INVEST" ) {
				redirect( $this->mza_secureurl->setSecureUrl_encode('invest_login','logout'), 'refresh' );
			}
		}
	}
	
}