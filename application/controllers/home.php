<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->check_logged_in();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_general','', TRUE);
		$this->load->model('Model_laundry','', TRUE);
		$this->load->model('Model_sms','', TRUE);
	}
	
	function index($error){
		$data['content'] = 'main/sx_home';
		$data['page_title'] = "Waroenk Laundry | Selamat Datang";
		$data['kar_form'] = site_url( $this->mza_secureurl->setSecureUrl_encode('karyawan','login') );
		$data['pengeluaran'] = $this->Model_laundry->ambilKeluarApp($this->session->userdata("id"))->num_rows();
		$data['error'] = $error;
		$this->cekWarning();
		$this->cekStatus();
		
		$this->load->view('template', $data);
	}
	function cekWarning(){
		$query = $this->Model_general->getDataBy("sx_aktivitas","status","SIAP AMBIL");
		foreach ($query->result() as $get){
			$new_date = date('Y/m/d',strtotime($get->warning_sent_date."+6 days"));
			if($this->is_expired($new_date) == true)
				$this->Model_general->updateData('sx_aktivitas','resi',$get->resi,array("export" => "Yes", 'warning_sent'=> 0));
		}
	}
	function cekStatus(){
		$query = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"status","SIAP AMBIL");
		foreach ($query->result() as $row){
			if($this->is_expired($row->tgl_finish) == true && $row->warning_sent == 0){
				$this->sendSMS('C02',$row->no_tlp,$row->nama,$row->resi,0,0,0);
				$this->Model_general->updateData("sx_aktivitas","resi",$row->resi,array("export"=>"Yes","warning_sent"=>1,"warning_sent_date"=>date("Y/m/d H:i:s")));
			}
		}
	}
	function sendSMS($tipe,$dest,$nama,$resi,$jsaldo,$asaldo,$saldo){
		$date = date('Y-m-d H:i:s');
		$obyek = array("[NAMA]","[RESI]","[BSALDO]","[ASALDO]","[SALDO]");
		$gobyek = array($nama,$resi,$jsaldo,$asaldo,$saldo);
		$message = $this->Model_general->getDataBy('master_pesan','tipe_pesan',$tipe)->row();
		$pesan = "[WaroenkLaundry] " . str_replace($obyek,$gobyek,$message->text_pesan);
		$messagelength = strlen($pesan);
		if($messagelength > 160) { 
			// split string
			$tmpmsg = str_split($pesan, 150);
			$jumlah = count($tmpmsg);
			$jumlah = sprintf('%02s', $jumlah);
			// insert first part to outbox
			$this->Model_sms->insertOutbox($dest, date('Y-m-d H:i:s',strtotime($date."$message->selang_pesan")), $tmpmsg[0],$jumlah);
			
			// get last outbox ID
			$outboxid = $this->Model_sms->getLastOutboxID();
			$outboxid = $outboxid->row('value');
			
			// insert the rest part to Outbox Multipart
			for($i=1; $i<count($tmpmsg); $i++) $this->Model_sms->insertOutboxMultipart($outboxid, $tmpmsg[$i], $i,$jumlah);
		} else
			$this->Model_sms->sendMessage($dest, date('Y-m-d H:i:s',strtotime($date."$message->selang_pesan")), $pesan);
	}
	function is_expired($expired) {
		$date_now = date("Y/m/d H:i:s");
		if ( strtotime($date_now) > strtotime($expired) )
			return true;
		else
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