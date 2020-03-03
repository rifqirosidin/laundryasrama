<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aset extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->check_logged_in();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_general','', TRUE);
		$this->load->model('Model_laundry','', TRUE);
	}
	
	// ASET
	function index($error){
		$data['content'] = 'main/activity/second/second';
		$data['page_title'] = "Waroenk Laundry | Perawatan Aset";
		$data['tLegend'] = "Perawatan Aset";
		$data['tabelSecond'] = $this->tabelAset();
		$data['error'] = $error;
		
		$this->load->view('template', $data);
	}
	
	function rawat_form($id,$jenis,$error){
		$data['content'] = 'main/activity/second/rawat_form';
		$data['page_title'] = "Waroenk Laundry | Perawatan Aset";
		$data['form_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aset","rawat_proses",array($id,$jenis)) );
		$data['tRow'] = $this->Model_laundry->ambilAsetBy("id_aset",$id)->row();
		$data['dbRawat'] = $this->Model_general->getDataBy("master_rawat","kode_jenis",$jenis)->result();
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aset","index",array("NO")) );
		$data['error'] = $error;
		
		if ( $error == 'YES' || $error == 'NIP' ){
			$data['default']['cat'] = $this->input->post('cat');
			$data['default']['rawat'] = $this->input->post('rawat');
		}
		$data['tabelAset'] = $this->tabelPerawatan($id);
		
		$this->load->view('template', $data);
	}
	function rawat_proses($id,$jenis){
		if ($this->form_validation->run("tRawat") == FALSE){
			$this->rawat_form($id,$jenis,"YES");
		}else{
			if( $this->cekPegawai($this->input->post("nip")) == true ){
				$param_rawat = array("id_aset" => $id,
									"perawatan" => $this->input->post("rawat"),
									"cat_rawat" => $this->input->post("cat"),
									"tgl_rawat" => date("Y/m/d H:i:s"),
									"jam_rawat" => date("H:i:s"),
									"nip_rawat" => $this->input->post("nip"),
									"outlet_id" => $this->session->userdata('id')
							);
				$this->Model_general->insertData("sx_perawatan",$param_rawat);
				
				redirect ( $this->mza_secureurl->setSecureUrl_encode("aset","rawat_form",array($id,$jenis,"NO")) );
			}else{
				$this->rawat_form($id,$jenis,"NIP");
			}
		}
	}
	function tabelAset(){
		$query = $this->Model_laundry->ambilAset($this->session->userdata('id'));
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="secondTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading(  array('data' => 'No', 'style' => 'width:3%;'), 'Kode Aset', 'Jenis Aset', 'Kondisi', array('data' => 'Action', 'style' => 'width:12%;') );
		
		$i = 0;
		foreach ($query->result() as $row){
			$action = anchor( $this->mza_secureurl->setSecureUrl_encode('aset','rawat_form',array($row->id_aset,$row->jenis_aset,"NO")),'Perawatan',array('class' => 'rawat') );
			
			$this->table->add_row( ++$i, array('data' => $row->kode_aset, 'style' => 'width:15%;'), $row->nama_jenis, $row->kondisi, $action );
		}
		return $this->table->generate();
	}
	function tabelPerawatan($id){
		$query = $this->Model_laundry->ambilPerawatan("id_aset",$id);
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="asetTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading(  array('data' => 'No', 'style' => 'width:3%;'), array('data' => 'Perawatan', 'style' => 'width:20%;'),
									array('data' => 'Petugas', 'style' => 'width:25%;'), array('data' => 'Tanggal Perawatan', 'style' => 'width:15%;'),
									array('data' => 'Jam Perawatan', 'style' => 'width:12%;'), 'Catatan' );
		
		$i = 0;
		foreach ($query->result() as $row){
			$this->table->add_row( ++$i,$row->perawatan,$row->nama_pegawai,$row->tgl_rawat,$row->jam_rawat,
									array('data' => $row->cat_rawat, 'style' => 'text-align:left;padding-left:10px;') );
		}
		return $this->table->generate();
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