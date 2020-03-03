<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends CI_Controller {
	function __construct(){
		parent::__construct();	
		$this->check_logged_in();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_general','', TRUE);
		$this->load->model('Model_user','', TRUE);
		$this->load->model('Model_laundry','', TRUE);
	}
	
	function message($jenis){
		$data['content'] = 'admin/sms/message';
		$data['page_title'] = "Waroenk Laundry | SMS Gateway";
		$data['table_sms'] = $this->table_sms($jenis);
		$data['send'] = site_url( $this->mza_secureurl->setSecureUrl_encode('sms','message_send') );
		
		$this->load->view('admin/template', $data);
	}
	function table_inbox(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="smsTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Tanggal Diterima', 'Nama Layanan', 'Jenis Layanan', 'Harga', 'Outlet', 'Action' );
		
		$i = 0;
		$query = $this->Model_general->getData("inbox","ReceivingDateTime");
		foreach ($query->result() as $row){
			$link = anchor($this->mza_secureurl->setSecureUrl_encode('administrator','laundry_form',array($row->outlet_id,$row->id_laundry,"Ubah","NO")),$row->kode_laundry);
			$action = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','delete_laundry',array($row->outlet_id,$row->id_laundry)),'Hapus',array('class' => 'delete','onclick' => 'return confirm(\'Hapus layanan : '. $row->nama_laundry .' ?\')') );
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'),
								array('data' => $link, 'style' => 'width:10%;'),
								array('data' => $row->nama_laundry, 'style' => 'text-align:left;padding-left:10px;'),
								array('data' => $row->jenis, 'style' => 'width:15%;'),
								array('data' => number_format($row->harga_laundry,0,',','.'), 'style' => 'text-align:right;padding-right:10px;'),
								array('data' => $row->outlet_name, 'style' => 'width:27%;'),
								array('data' => $action, 'style' => 'width:15%;') );
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
			redirect( $this->mza_secureurl->setSecureUrl_encode('admin_login','logout'), 'refresh' );
		}else{
			if ($this->session->userdata('user') !== "ADMIN" ) {
				redirect( $this->mza_secureurl->setSecureUrl_encode('admin_login','logout'), 'refresh' );
			}
		}
	}
	
}