<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventori extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->check_logged_in();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_general','', TRUE);
		$this->load->model('Model_laundry','', TRUE);
	}
	
	// STOK
	function index($error){
		$data['content'] = 'main/activity/second/second';
		$data['page_title'] = "Waroenk Laundry | Inventori";
		$data['tLegend'] = "Inventori";
		$data['tabelSecond'] = $this->tabelStok();
		$data['error'] = $error;
		
		$this->load->view('template', $data);
	}
	
	function stok_form($id,$jenis,$error){
		$data['content'] = 'main/activity/second/stok_form';
		$data['page_title'] = "Waroenk Laundry | Inventori";
		$data['form_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode("inventori","stok_proses",array($id,$jenis)) );
		$data['tRow'] = $this->Model_laundry->ambilStokBy($this->session->userdata('id'),"id_stock",$id)->row();
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("inventori","index",array("NO")) );
		$data['error'] = $error;
		
		if ( $error == 'YES' || $error == 'NIP' || $error == 'PASS' || $error == 'GUDANG' ){
			$data['default']['cat'] = $this->input->post('cat');
			$data['default']['stok'] = $this->input->post('stok');
		}else{
			$data['default']['stok'] = 0;
		}
		$data['tabelStok'] = $this->tabelHistStok($id);
		
		$this->load->view('template', $data);
	}
	function stok_proses($id,$jenis){
		if ($this->form_validation->run("tStok") == FALSE){
			$this->stok_form($id,$jenis,"YES");
		}else{
			$query = $this->Model_general->getDataBy("wl_pegawai","nip",$this->input->post("nip"));
			if($query->num_rows() > 0){
				$data = $query->row();
				$pass = sha1($this->input->post('pass'));
				if($data->position_id > 3 && $pass == $data->pass_pegawai){
					if($this->input->post("act") == 1){
						$act_stok = $this->input->post("inv") - $this->input->post("stok");
						$stok = $this->input->post('stok');
						$gudang = $this->input->post("gudang");
						$aksi = "Pemakaian";
					}else{
						if($data->position_id == 4){
							$act_stok = $this->input->post("stok");
							$stok = $this->input->post("inv") + $this->input->post('stok');
							$gudang = $this->input->post("gudang") - $this->input->post('stok');
							$aksi = "Re-Stock";
						}else{
							redirect ( $this->mza_secureurl->setSecureUrl_encode("inventori","stok_form",array($id,$jenis,"NIP")) );
						}
					}
					if($gudang < 0){
						redirect ( $this->mza_secureurl->setSecureUrl_encode("inventori","stok_form",array($id,$jenis,"GUDANG")) );
					}else{
						$param_stok = array("id_stock" => $id,
											"act_stock" => $aksi,
											"jum_stock" => $act_stok,
											"cat_stock" => $this->input->post("cat"),
											"tgl_stock" => date("Y/m/d H:i:s"),
											"nip_stock" => $this->input->post("nip"),
											"outlet_id" => $this->session->userdata('id')
									);
						$this->Model_general->insertData("sx_stock",$param_stok);
						$this->Model_general->updateData("wl_stock","id_stock",$id,array('stock' => $stok, 'stock_gudang' => $gudang));
						redirect ( $this->mza_secureurl->setSecureUrl_encode("inventori","stok_form",array($id,$jenis,"NO")) );
					}
				}else{
					$this->stok_form($id,$jenis,"PASS");
				}
			}else{
				$this->stok_form($id,$jenis,"NIP");
			}
		}
	}
	function tabelStok(){
		$query = $this->Model_laundry->ambilStok($this->session->userdata('id'));
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="secondTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading(  array('data' => 'No', 'style' => 'width:3%;'),'Kode','Jenis Inventori','Stok',array('data' => 'Action', 'style' => 'width:13%;') );
		
		$i = 0;
		foreach ($query->result() as $row){
			$action = anchor( $this->mza_secureurl->setSecureUrl_encode('inventori','stok_form',array($row->id_stock,$row->kode_stock,"NO")),'Pemakaian',array('class' => 'stok') );
			
			$this->table->add_row( ++$i,$row->kode_stock,array('data' => $row->nama_stock, 'style' => 'width:70%;text-align:left;padding-left:10px;'),$row->stock . " Kg",$action );
		}
		return $this->table->generate();
	}
	function tabelHistStok($id){
		$query = $this->Model_laundry->ambilHistStock("id_stock",$id);
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="stokTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading(  array('data' => 'No', 'style' => 'width:3%;'), array('data' => 'Tanggal', 'style' => 'width:15%;'),
									array('data' => 'Jumlah', 'style' => 'width:10%;'), array('data' => 'Aktivitas', 'style' => 'width:15%;'),
									array('data' => 'Petugas', 'style' => 'width:25%;'), 'Catatan' );
		
		$i = 0;
		foreach ($query->result() as $row){
			$this->table->add_row( ++$i,$row->tgl_stock,$row->act_stock,$row->jum_stock . " Kg",$row->nama_pegawai,
								array('data' => $row->cat_stock, 'style' => 'text-align:left;padding-left:10px;') );
		}
		return $this->table->generate();
	}
	
	function cekPegawai($nip){
		$query = $this->Model_general->getDataBy("wl_pegawai","nip",$nip);
		if($query->num_rows() > 0){
			$data = $query->row();
			if($data->position_id == 4 || $data->position_id == 5)
				return $data->position_id;
			else
				return 0;
		}else
			return 0;
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