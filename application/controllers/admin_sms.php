<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_sms extends CI_Controller {
	function __construct(){
		parent::__construct();	
		$this->check_logged_in();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_general','', TRUE);
		$this->load->model('Model_laundry','', TRUE);
		$this->load->model('Model_sms','', TRUE);
	}
	
	// INBOX
	function inbox($id,$error){
		$data['content'] = 'admin/sms/sms_inbox';
		$data['page_title'] = "Waroenk Laundry | Kotak Masuk";
		$data['sendSMS'] = "<a id='add-sms' class='sms'>Kirim SMS</a>";
		$data['emptySMS'] = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','emptySMS',array("inbox","inbox")),'Kosongkan',array('class' => 'empty','onclick' => 'return confirm(\'Kosongkan Kotak Masuk ?\')') );
		$data['sms_form'] = site_url( $this->mza_secureurl->setSecureUrl_encode('admin_sms','send') );
		$data['s_Send']= site_url( $this->mza_secureurl->setSecureUrl_encode('admin_sms','copyTo') );
		$data['tableInbox'] = $this->tableInbox();
		if($id > 0){
			$data['pesan'] = $this->Model_general->getDataBy("inbox","ID",$id)->row();
			$tlp = str_replace("+62","0",$data['pesan']->SenderNumber);
			$member = $this->Model_general->getDataBy("wl_member","tlp_member",$tlp);
			if($member->num_rows() > 0){
				$ambil = $member->row();
				$data['pengirim'] = $ambil->nama_member;
			}else{
				$cust = $this->Model_general->getDataBy("wl_member_non","tlp_non",$tlp);
				if($cust->num_rows() > 0){
					$ambil = $cust->row();
					$data['pengirim'] = $ambil->nama_non;
				}else{
					$data['pengirim'] = $tlp;
				}
			}
		}else{
			$data['pesan'] = NULL;
		}
		$data['error'] = $error;
		
		$this->load->view('admin/template', $data);
	}
	function tableInbox(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="smsTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Tgl. Masuk', 'Pengirim', 'Isi Pesan', 'Action' );
		
		$i = 0;
		$query = $this->Model_general->getData("inbox","ReceivingDateTime");
		foreach ($query->result() as $row){
			$baca = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','inbox',array($row->ID,'NO')),' ',array('class' => 'view','title' => 'Baca') );
			$balas = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','reply',array($row->ID,'NO')),' ',array('class' => 'sms','title' => 'Balas') );
			$hapus = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','delInbox',array($row->ID)),' ',array('class' => 'delete','title' => 'Hapus','onclick' => 'return confirm(\'Hapus sms ini ?\')') );
			
			$tlp = str_replace("+62","0",$row->SenderNumber);
			$member = $this->Model_general->getDataBy("wl_member","tlp_member",$tlp);
			if($member->num_rows() > 0){
				$ambil = $member->row();
				$pengirim = $ambil->nama_member;
			}else{
				$cust = $this->Model_general->getDataBy("wl_member_non","tlp_non",$tlp);
				if($cust->num_rows() > 0){
					$ambil = $cust->row();
					$pengirim = $ambil->nama_non;
				}else{
					$pengirim = $tlp;
				}
			}
			
			if(strlen($row->TextDecoded) > 50)
				$pesan = substr($row->TextDecoded,0,50) . "...";
			else
				$pesan = $row->TextDecoded;
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'), array('data' => $row->ReceivingDateTime, 'style' => 'width:15%;'),
								array('data' => $pengirim, 'style' => 'width:20%;'), array('data' => $pesan, 'style' => 'text-align:left;padding-left:10px;'),
								array('data' => $baca . $balas . $hapus, 'style' => 'width:10%;'));
		}
		return $this->table->generate();
	}
	function send(){
		if ($this->form_validation->run("sms_send") == FALSE){
			$this->inbox(0,'YES');
		} else {
			$this->sendSMS($this->input->post('notlp'),$this->input->post('isisms'),date('Y-m-d H:i:s'));
			redirect( $this->mza_secureurl->setSecureUrl_encode('admin_sms','outbox',array(0,'NO')) );
		}
	}
	function reply($id,$error){
		$data['content'] = 'admin/sms/sms_balas';
		$data['page_title'] = "Waroenk Laundry | Balas SMS";
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','inbox',array(0,'NO')),'Kembali',array('class' => 'back') );
		$data['sms_form'] = site_url( $this->mza_secureurl->setSecureUrl_encode('admin_sms','send') );
		$data['pesan'] = $this->Model_general->getDataBy("inbox","ID",$id)->row();
		$tlp = str_replace("+62","0",$data['pesan']->SenderNumber);
		$member = $this->Model_general->getDataBy("wl_member","tlp_member",$tlp);
		if($member->num_rows() > 0){
			$ambil = $member->row();
			$data['pengirim'] = $ambil->nama_member;
		}else{
			$cust = $this->Model_general->getDataBy("wl_member_non","tlp_non",$tlp);
			if($cust->num_rows() > 0){
				$ambil = $cust->row();
				$data['pengirim'] = $ambil->nama_non;
			}else{
				$data['pengirim'] = $tlp;
			}
		}
		$data['notlp'] = $data['pesan']->SenderNumber;
		$data['error'] = $error;
		
		$this->load->view('admin/template', $data);
	}
	function delInbox($id){
		$this->Model_general->deleteData("inbox","ID",$id);
		redirect( $this->mza_secureurl->setSecureUrl_encode('admin_sms','inbox',array(0,'NO')) );
	}
	function copyTo(){
		$get = $this->Model_general->getDataBy("inbox","ID",$this->input->post("idpesan"))->row();
		$param_shout = array("tlp_shout" => str_replace("+62","0",$get->SenderNumber),
							"jenis_shout" => $this->input->post("jenis"),
							"tgl_shout" => $get->ReceivingDateTime,
							"isi_shout" => $get->TextDecoded
						);
		$this->Model_general->insertData("ad_shout",$param_shout);
		redirect( $this->mza_secureurl->setSecureUrl_encode('admin_grafik','krisan',array(-1)) );
	}
	
	// OUTBOX
	function outbox($id,$error){
		$data['content'] = 'admin/sms/sms_outbox';
		$data['page_title']="Waroenk Laundry | Kotak Keluar";
		$data['emptySMS'] = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','emptySMS',array("outbox","outbox")),'Kosongkan',array('class' => 'empty','onclick' => 'return confirm(\'Kosongkan Kotak Keluar ?\')') );
		$data['tableOutbox'] = $this->tableOutbox();
		if($id > 0){
			$data['pesan'] = $this->Model_general->getDataBy("outbox","ID",$id)->row();
			$tlp = str_replace("+62","0",$data['pesan']->DestinationNumber);
			$member = $this->Model_general->getDataBy("wl_member","tlp_member",$tlp);
			if($member->num_rows() > 0){
				$ambil = $member->row();
				$data['pengirim'] = $ambil->nama_member;
			}else{
				$cust = $this->Model_general->getDataBy("wl_member_non","tlp_non",$tlp);
				if($cust->num_rows() > 0){
					$ambil = $cust->row();
					$data['pengirim'] = $ambil->nama_non;
				}else{
					$data['pengirim'] = $tlp;
				}
			}
		}else{
			$data['pesan'] = NULL;
		}
		
		$this->load->view('admin/template', $data);
	}
	function tableOutbox(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="smsTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Tgl. Kirim', 'Penerima', 'Isi Pesan', 'Action' );
		
		$i = 0;
		$query = $this->Model_general->getData("outbox","SendingDateTime");
		foreach ($query->result() as $row){
			$baca = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','outbox',array($row->ID,'NO')),' ',array('class' => 'view','title' => 'Baca') );
			$hapus = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','delOutbox',array($row->ID)),' ',array('class' => 'delete','title' => 'Hapus','onclick' => 'return confirm(\'Hapus sms ini ?\')') );
			
			$tlp = str_replace("+62","0",$row->DestinationNumber);
			$member = $this->Model_general->getDataBy("wl_member","tlp_member",$tlp);
			if($member->num_rows() > 0){
				$ambil = $member->row();
				$pengirim = $ambil->nama_member;
			}else{
				$cust = $this->Model_general->getDataBy("wl_member_non","tlp_non",$tlp);
				if($cust->num_rows() > 0){
					$ambil = $cust->row();
					$pengirim = $ambil->nama_non;
				}else{
					$pengirim = $tlp;
				}
			}
			
			if(strlen($row->TextDecoded) > 50)
				$pesan = substr($row->TextDecoded,0,50) . "...";
			else
				$pesan = $row->TextDecoded;
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'), array('data' => $row->SendingDateTime, 'style' => 'width:15%;'),
								array('data' => $pengirim, 'style' => 'width:20%;'), array('data' => $pesan, 'style' => 'text-align:left;padding-left:10px;'),
								array('data' => $baca . $hapus, 'style' => 'width:8%;'));
		}
		return $this->table->generate();
	}
	function delOutbox($id){
		$this->Model_general->deleteData("outbox","ID",$id);
		redirect( $this->mza_secureurl->setSecureUrl_encode('admin_sms','outbox',array(0,'NO')) );
	}
	
	// SENT
	function sent($id,$error){
		$data['content'] = 'admin/sms/sms_sent';
		$data['page_title']="Waroenk Laundry | Kotak Keluar";
		$data['emptySMS'] = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','emptySMS',array("sentitems","sent")),'Kosongkan',array('class' => 'empty','onclick' => 'return confirm(\'Kosongkan Pesan Terkirim ?\')') );
		$data['tableSent'] = $this->tableSent();
		if($id > 0){
			$data['pesan'] = $this->Model_general->getDataBy("sentitems","ID",$id)->row();
			$tlp = str_replace("+62","0",$data['pesan']->DestinationNumber);
			$member = $this->Model_general->getDataBy("wl_member","tlp_member",$tlp);
			if($member->num_rows() > 0){
				$ambil = $member->row();
				$data['pengirim'] = $ambil->nama_member;
			}else{
				$cust = $this->Model_general->getDataBy("wl_member_non","tlp_non",$tlp);
				if($cust->num_rows() > 0){
					$ambil = $cust->row();
					$data['pengirim'] = $ambil->nama_non;
				}else{
					$data['pengirim'] = $tlp;
				}
			}
		}else{
			$data['pesan'] = NULL;
		}
		
		$this->load->view('admin/template', $data);
	}
	function tableSent(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="smsTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Tgl. Kirim', 'Penerima', 'Isi Pesan', 'Action' );
		
		$i = 0;
		$query = $this->Model_general->getData("sentitems","SendingDateTime");
		foreach ($query->result() as $row){
			$baca = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','sent',array($row->ID,'NO')),' ',array('class' => 'view','title' => 'Baca') );
			$hapus = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','delSent',array($row->ID)),' ',array('class' => 'delete','title' => 'Hapus','onclick' => 'return confirm(\'Hapus sms ini ?\')') );
			
			$tlp = str_replace("+62","0",$row->DestinationNumber);
			$member = $this->Model_general->getDataBy("wl_member","tlp_member",$tlp);
			if($member->num_rows() > 0){
				$ambil = $member->row();
				$pengirim = $ambil->nama_member;
			}else{
				$cust = $this->Model_general->getDataBy("wl_member_non","tlp_non",$tlp);
				if($cust->num_rows() > 0){
					$ambil = $cust->row();
					$pengirim = $ambil->nama_non;
				}else{
					$pengirim = $tlp;
				}
			}
			
			if(strlen($row->TextDecoded) > 50)
				$pesan = substr($row->TextDecoded,0,50) . "...";
			else
				$pesan = $row->TextDecoded;
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'), array('data' => $row->SendingDateTime, 'style' => 'width:15%;'),
								array('data' => $pengirim, 'style' => 'width:20%;'), array('data' => $pesan, 'style' => 'text-align:left;padding-left:10px;'),
								array('data' => $baca . $hapus, 'style' => 'width:8%;'));
		}
		return $this->table->generate();
	}
	function delSent($id){
		$this->Model_general->deleteData("sentitems","ID",$id);
		redirect( $this->mza_secureurl->setSecureUrl_encode('admin_sms','sent',array(0,'NO')) );
	}
	
	// BROADCAST
	function broadcast($id,$error){
		$data['content'] = 'admin/sms/sms_broadcast';
		$data['page_title'] = "Waroenk Laundry | SMS Broadcast";
		$data['eventSMS'] = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','broadForm',array('new',0,'NO')),'Event Broadcast Baru',array('class' => 'sms') );
		$data['sms_form'] = site_url( $this->mza_secureurl->setSecureUrl_encode('admin_sms','send') );
		$data['tableBroad'] = $this->tableBroad();
		if($id > 0)
			$data['pesan'] = $this->Model_general->getDataBy("wl_broadcast","id_broad",$id)->row();
		else
			$data['pesan'] = NULL;
		
		$this->load->view('admin/template', $data);
	}
	function broadForm($status,$id,$error){
		$data['content']="admin/sms/sms_broadcast_$status";
		$data['page_title'] = "Waroenk Laundry | Event Broadcast";
		$data['form_sms']= site_url( $this->mza_secureurl->setSecureUrl_encode('admin_sms','sendBroadcast',array($status,$id)) );
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','broadcast',array(0,'NO')),'Kembali',array('class' => 'back') );
		$data['error']=$error;
		
		if ( $error == 'YES' ){
			$data['default']['nama'] = $this->input->post('nama');
			$data['default']['member'] = $this->input->post('member');
			$data['default']['non'] = $this->input->post('non');
			$data['default']['agama'] = $this->input->post('agama');
			$data['default']['tgl'] = $this->input->post('tgl');
			$data['default']['isi'] = $this->input->post('isi');
			$data['default']['jenis'] = $this->input->post('jenis');
			$data['default']['namajenis'] = $this->input->post('namajenis');
		}else{
			if ( $status == 'repeat' ){
				$get = $this->Model_general->getDataBy("wl_broadcast","id_broad",$id)->row();
				$data['default']['nama'] = $get->nama_broad;
				$data['default']['member'] = $get->is_member;
				$data['default']['non'] = $get->is_non;
				$data['default']['agama'] = $get->agama_broad;
				$data['default']['tgl'] = $get->tgl_kirim;
				$data['default']['isi'] = $get->text_broad;
				$data['default']['namajenis'] = $get->jenis_broad;
				
				if($get->jenis_broad == "Marketing")
					$data['default']['jenis'] = 1;
				else if($get->jenis_broad == "Hari Raya")
					$data['default']['jenis'] = 2;
				else
					$data['default']['jenis'] = 3;
			}
		}
		
		$this->load->view('admin/template', $data);
	}
	function sendBroadcast($status,$id){
		if ($this->form_validation->run("sms_broadcast") == FALSE){
			$this->broadForm($status,$id,'YES');
		} else {
			$member = "Yes"; $non = "Yes";
			switch($this->input->post('jenis')){
				case 1 : 
						 if($this->input->post("member") == NULL) $member = "No";
						 if($this->input->post("non") == NULL) $non = "No";
						 $jenis = "Marketing"; $agama = "";
						break;
				case 2 : $non = "No"; $jenis = "Hari Raya"; $agama = $this->input->post("agama");
						break;
				case 3 : $jenis = "Hari Peringatan"; $agama = "";
						break;
			}
			$param_broad = array( "nama_broad" => $this->input->post("nama"),
								"jenis_broad" => $jenis,
								"agama_broad" => $agama,
								"is_member" => $member,
								"is_non" => $non,
								"tgl_kirim" => $this->input->post("tgl"),
								"text_broad" => $this->input->post("isi"),
								"outlet_id" => $this->session->userdata("out")
						);
			if($status == "new")
				$this->Model_general->insertData("wl_broadcast",$param_broad);
			else
				$this->Model_general->updateData("wl_broadcast","id_broad",$id,$param_broad);
			
			if($member == "Yes")
				$this->sendBroadMember($agama);
			if($non == "Yes")
				$this->sendBroadNon();
			
			redirect( $this->mza_secureurl->setSecureUrl_encode('admin_sms','broadcast',array(0,'NO')) );
		}
	}
	function sendBroadMember($agama){
		if($agama == "")
			$query = $this->Model_general->getDataBy("wl_member","outlet_id",$this->session->userdata("out"));
		else
			$query = $this->Model_general->getDataWhere("wl_member","outlet_id = " . $this->session->userdata('out') . " AND agama LIKE ('%$agama%')");
		
		foreach ($query->result() as $row){
			$this->sendSMS($row->tlp_member,$this->input->post("isi"),date('Y-m-d',strtotime($this->input->post("tgl"))) . " 09:00:00");
		}
	}
	function sendBroadNon(){
		$query = $this->Model_general->getDataBy("wl_member_non","outlet_id",$this->session->userdata("out"));
		foreach ($query->result() as $row){
			$this->sendSMS($row->tlp_non,$this->input->post("isi"),date('Y-m-d',strtotime($this->input->post("tgl"))) . " 09:00:00");
		}
	}
	function tableBroad(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="smsTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Nama Broadcast', 'Jenis', 'Member', 'Non Member', 'Agama', 'Tgl. Kirim', 'Isi Pesan', 'Action' );
		
		$i = 0;
		$query = $this->Model_general->getData("wl_broadcast","tgl_kirim");
		foreach ($query->result() as $row){
			$baca = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','broadcast',array($row->id_broad,'NO')),' ',array('class' => 'view','title' => 'Baca') );
			$ulang = anchor($this->mza_secureurl->setSecureUrl_encode('admin_sms','broadForm',array("repeat",$row->id_broad,'NO')),' ',array('class'=>'sms','title'=>'Kirim Ulang'));
			$hapus = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','delBroad',array($row->id_broad)),' ',array('class' => 'delete','title' => 'Hapus','onclick' => 'return confirm(\'Hapus broadcast ini ?\')') );
			
			if($row->jenis_broad == 1)
				$jenis = "Marketing";
			else if($row->jenis_broad == 2)
				$jenis = "Hari Raya";
			else
				$jenis = "Hari Peringatan";
			
			if(strlen($row->text_broad) > 30)
				$pesan = substr($row->text_broad,0,30) . "...";
			else
				$pesan = $row->text_broad;
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'), array('data' => $row->nama_broad, 'style' => 'width:20%;'),
								array('data' => $jenis, 'style' => 'width:12%;'), array('data' => $row->is_member, 'style' => 'width:7%;'), array('data' => $row->is_non, 'style' => 'width:7%;'), array('data' => $row->agama_broad, 'style' => 'width:10%;'), array('data' => $row->tgl_kirim, 'style' => 'width:10%;'),array('data' => $pesan, 'style' => 'text-align:left;padding-left:10px;'), array('data' => $baca . $ulang . $hapus, 'style' => 'width:10%;'));
		}
		return $this->table->generate();
	}
	function delBroad($id){
		$this->Model_general->deleteData("wl_broadcast","id_broad",$id);
		redirect( $this->mza_secureurl->setSecureUrl_encode('admin_sms','broadcast',array(0,'NO')) );
	}
	
	// KONFIGURASI
	function konfig(){
		$data['content'] = 'admin/sms/sms_konfigur';
		$data['page_title']="Waroenk Laundry | Konfigurasi SMS";
		$data['tableMaster'] = $this->tableMaster();
		
		$this->load->view('admin/template', $data);
	}
	function masterForm($tipe,$error){
		$data['content']='admin/sms/sms_master';
		$data['page_title']="Waroenk Laundry | Konfigurasi SMS";
		$data['form_sms']= site_url( $this->mza_secureurl->setSecureUrl_encode('admin_sms','masterSimpan',array($tipe)) );
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_sms','konfig'),'Kembali',array('class' => 'back') );
		$data['sms'] = $this->Model_general->getDataBy("master_pesan","tipe_pesan",$tipe)->row();
		$data['error']=$error;
		
		if ( $error == 'YES' ){
			$data['default']['isi'] = $this->input->post('isi');
			$data['default']['selang'] = $this->input->post('selang');
		}else{
			$data['default']['isi'] = $data['sms']->text_pesan;
			$data['default']['selang'] = $data['sms']->selang_pesan;
		}
		
		$this->load->view('admin/template', $data);
	}
	function masterSimpan($tipe){
		if ($this->form_validation->run("sms") == FALSE){
			$this->masterForm($tipe,'YES');
		} else {
			$this->Model_general->updateData("master_pesan","tipe_pesan",$tipe,array('text_pesan' => $this->input->post('isi'),'selang_pesan' => $this->input->post('selang')));
			redirect( $this->mza_secureurl->setSecureUrl_encode('admin_sms','konfig') );
		}
	}
	function tableMaster(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="smsTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Kode', 'Judul Pesan', 'Isi Pesan', 'Selang Kirim' );
		
		$i = 0;
		$query = $this->Model_general->getData("master_pesan","tipe_pesan");
		foreach ($query->result() as $row){
			$link = anchor($this->mza_secureurl->setSecureUrl_encode('admin_sms','masterForm',array($row->tipe_pesan,"NO")),$row->tipe_pesan);
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'), array('data' => $link, 'style' => 'width:5%;'),
								array('data' => $row->nama_pesan, 'style' => 'width:18%;text-align:left;padding-left:10px;'),
								array('data' => $row->text_pesan, 'style' => 'text-align:left;padding-left:10px;'), array('data' => $row->selang_pesan, 'style' => 'width:15%;'));
		}
		return $this->table->generate();
	}
	
	function sendSMS($notlp,$pesan,$tglkirim){
		$messagelength = strlen($notlp);
		if($messagelength > 160) { 
			// split string
			$tmpmsg = str_split($pesan, 150);
			$jumlah = count($tmpmsg);
			$jumlah = sprintf('%02s', $jumlah);
			// insert first part to outbox
			$this->Model_sms->insertOutbox($notlp, $tglkirim, $tmpmsg[0],$jumlah);
			
			// get last outbox ID
			$outboxid = $this->Model_sms->getLastOutboxID();
			$outboxid = $outboxid->row('value');
			
			// insert the rest part to Outbox Multipart
			for($i=1; $i<count($tmpmsg); $i++) $this->Model_sms->insertOutboxMultipart($outboxid, $tmpmsg[$i], $i,$jumlah);
		} else
			$this->Model_sms->sendMessage($notlp, $tglkirim, $pesan);
	}
	function emptySMS($tabel,$cont){
		$this->Model_general->emptyTabel("$tabel");
		if($tabel == "outbox")
			$this->Model_general->emptyTabel("outbox_multipart");
		redirect( $this->mza_secureurl->setSecureUrl_encode("admin_sms","$cont",array(0,'NO')) );
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