<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->check_logged_in();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_general','', TRUE);
		$this->load->model('Model_laundry','', TRUE);
		$this->load->model('Model_sms','', TRUE);
	}
	
	// MEMBER
	function member(){
		$data['content'] = 'main/customer/member';
		$data['page_title'] = "Waroenk Laundry | Member";
		$data['tabelMember'] = $this->tabelMember();
		$data['addlink'] = anchor( $this->mza_secureurl->setSecureUrl_encode('customer','member_form',array(0,'Tambah','NO')),'Member Baru', array('class' => 'add') );
		$data['warning'] = anchor( $this->mza_secureurl->setSecureUrl_encode('customer','kirimWarning'),'SMS Warning', array('class' => 'sms') );
		$data['tLegend'] = "MEMBER";

		$this->load->view('template', $data);
	}

	function member_form($id,$status,$error){
		$data['page_title'] = "Waroenk Laundry | Member";
		$data['content'] = 'main/customer/member_form';
		$data['deposit_action']= site_url( $this->mza_secureurl->setSecureUrl_encode('customer','deposit_process',array($id)) );
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('customer','member'),'Kembali',array('class' => 'back') );
		$data['hist'] = anchor($this->mza_secureurl->setSecureUrl_encode('customer','printHMember',array($id)),'Cetak History Transaksi',array('class'=>'print','target'=>'_blank'));
		$data['depo'] = anchor($this->mza_secureurl->setSecureUrl_encode('customer','printHDepo',array($id)),'Cetak History Deposit',array('class'=>'print','target'=>'_blank') );
		$data['dbDeposit'] = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"jenis","Deposit")->result();
		$data['dbarea'] = $this->Model_laundry->ambilCakupanBy("outlet_id",$this->session->userdata('id'));
		$data['dbMasa'] = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"jenis","Masa")->result();
		$data['tabelMember'] = $this->histMember($id);
		$data['tabelKomplain'] = $this->kompMember($id);
		$data['tLegend'] = $status;
		$data['error'] = $error;
		
		if($status == 'Tambah')
			$data['form_member']= site_url( $this->mza_secureurl->setSecureUrl_encode('customer','member_process',array(0,$status)) );
		else
			$data['form_member']= site_url( $this->mza_secureurl->setSecureUrl_encode('customer','member_process',array($id,$status)) );
		
		$data['default']['jenisbaru'] = $this->session->userdata('jenismember');
		if($status == 'Ubah'){
			$member = $this->Model_general->getDataBy("wl_member","id_member",$id)->row();


			$data['default']['kode'] = $member->id_member;
			$data['default']['namabaru'] = $member->nama_member;
			$data['default']['alamatbaru'] = $member->alamat_member;
			$data['default']['areabaru'] = $member->area_member;
			$data['default']['nohpbaru'] = $member->tlp_member;
			$data['default']['tmptbaru'] = $member->tmpt_lhr_member;
			$data['default']['tglbaru'] = $member->tgl_lhr_member;
			$data['default']['agamabaru'] = $member->agama;
			$data['default']['kilo'] = $member->saldo_kg . " Kg";
			$data['default']['rup'] = "Rp " . number_format($member->saldo_rp,0,',','.') . ",-";
			$data['default']['asr'] = $member->saldo_kg;
			$data['default']['akhirKg'] =  $member->akhir_kg;
			$data['default']['checkpoint'] = $this->formatDate($member->checkpoint, 'EDIT') ;

		} else {
			if ( $error == 'YES' ){
				$data['default']['kode'] = $this->input->post('kode');
				$data['default']['namabaru'] = $this->input->post('namabaru');
				$data['default']['alamatbaru'] = $this->input->post('alamatbaru');
				$data['default']['areabaru'] = $this->input->post('areabaru');
				$data['default']['nohpbaru'] = $this->input->post('nohpbaru');
				$data['default']['tmptbaru'] = $this->input->post('tmptbaru');
				$data['default']['tglbaru'] = $this->input->post('tglbaru');
				$data['default']['agamabaru'] = $this->input->post('agamabaru');
				$data['default']['kilo'] = $this->input->post('kilo');
				$data['default']['asr'] = $this->input->post('asr');
			}
		}

		$this->load->view('template', $data);
	}

	function formatDate($date,$type) {
        $time = strtotime($date);
        if ($type == 'EDIT'){
            $newformat = date('Y-m-d',$time);
        }else if ($type == 'POST') {
            $newformat = date('Y/m/d',$time);
        }

        return $newformat;
    }
	function member_process($id,$status) {
		if ($this->form_validation->run("fMember") == FALSE){
			$this->member_form($id,$status,"YES");
		} else {
			if($status == 'Tambah'){
				$kode = $this->generateCode("M");
				if($this->input->post('jenisbaru') == "Asrut"){
					if(substr($this->input->post('deposit'),1,2) == "MO")
						$akhir = substr($this->input->post('deposit'),0,1);
					else
						$akhir = 12;
					
					$id = substr($this->input->post('deposit'),3);
					$saldokg = 20;
					$kg_rp = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"id_laundry",$id)->row()->harga_laundry;
					$akhirkg = date('Y/m/d',strtotime(date('Y/m/d')."+$akhir months"));
					$standar = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"kode_laundry","CKS")->row()->harga_laundry;
					$bonus = ($standar * 20 * $akhir) - $kg_rp;
					if($bonus < 0)
						$bonus = 0;
					
					$param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
										"debit_jurnal" => "Kas di Tangan",
										"jum_debit_jurnal" => $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"id_laundry",$id)->row()->harga_laundry,
										"kredit_jurnal" => "Utang Usaha",
										"jum_kredit_jurnal" => $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"id_laundry",$id)->row()->harga_laundry,
										"ket_jurnal" => "DEPOSIT: " . $this->generateDeposit() ." - ". $kode,
										'outlet_id' => $this->session->userdata('id')
									);
					$this->Model_general->insertData("ak_jurnal",$param_jurnal);
				}else{
					$saldokg = 0;
					$kg_rp = 0;
					$akhirkg = date("Y/m/d H:i:s");
					$bonus = 0;
				}
				$param_member = array('id_member' => $kode,
									'nama_member' => $this->input->post('namabaru'),
									'area_member' => $this->input->post('areabaru'),
									'alamat_member' => $this->input->post('alamatbaru'),
									'tlp_member' => $this->input->post('nohpbaru'),
									'tmpt_lhr_member' => $this->input->post('tmptbaru'),
									'tgl_lhr_member' => $this->input->post('tglbaru'),
									'agama' => $this->input->post('agamabaru'),
									'jenis_member' => $this->input->post('jenisbaru'),
									'saldo_kg' => $saldokg,
									'kg_rp' => $kg_rp,
									"bonus" => $bonus,
									"checkpoint" => date("Y/m/d H:i:s"),
									'akhir_kg' => $akhirkg,
									'akhir_rp' => date("Y/m/d H:i:s"),
									'outlet_id' => $this->session->userdata('id')
							);
				$this->Model_general->insertData("wl_member",$param_member);
			}else{
				$param_member = array('nama_member' => $this->input->post('namabaru'),
									'area_member' => $this->input->post('areabaru'),
									'alamat_member' => $this->input->post('alamatbaru'),
									'tlp_member' => $this->input->post('nohpbaru'),
									'tmpt_lhr_member' => $this->input->post('tmptbaru'),
									'tgl_lhr_member' => $this->input->post('tglbaru'),
									'agama' => $this->input->post('agamabaru'),
									'saldo_kg' => $this->input->post('saldo_kg'),
									'checkpoint' => $this->formatDate($this->input->post('checkpoint'), 'POST') ,
									"export" => "Yes"
							);
				$this->Model_general->updateData("wl_member","id_member",$id,$param_member);
			}
			
			redirect( $this->mza_secureurl->setSecureUrl_encode('customer','member') );
		}
	}
	function delete_member($id,$kode){
		$this->Model_general->deleteData("wl_member","id_member",$kode);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('customer','member') );
	}
	function tabelMember(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="memberTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( array('data' => 'No', 'style' => 'width:3%;'), 'ID Member', 'Nama', 'No. Tlp', 'Saldo', 'Masa Aktif', 'Keterangan' );
		
		$i = 0;
		$query = $this->Model_general->getDataBy("wl_member","outlet_id",$this->session->userdata('id'));
		foreach ($query->result() as $row){

			$link = anchor($this->mza_secureurl->setSecureUrl_encode('customer','member_form',array($row->id_member,"Ubah","NO")),$row->id_member);
			if($row->jenis_member == "Rupiah"){
				if( ($row->saldo_rp < 6000) || ($this->is_expired(date('Y/m/d',strtotime($row->akhir_rp."-1 weeks"))) == true) ){
					$saldo = array('data'=>"Rp ".number_format($row->saldo_rp,0,',','.').",-",'style'=>'text-align:right;padding-right:10px;text-decoration:blink;font-weight:bold;');
					$masa = array('data' => $row->akhir_rp, 'style' => 'text-decoration:blink;font-weight:bold;');
					if( $this->is_expired($row->akhir_rp) == true )
						$warning = array('data' => "HABIS", 'style' => 'text-decoration:blink;font-weight:bold;color:red;');
					else
						$warning = array('data' => "PERINGATAN", 'style' => 'text-decoration:blink;font-weight:bold;color:orange;');
				}else{
					$saldo = array('data'=>"Rp ".number_format($row->saldo_rp,0,',','.').",-",'style'=>'text-align:right;padding-right:10px;');
					$masa = $row->akhir_rp;
					$warning = "-";
				}
			}else{
				if($row->saldo_kg < 2 || ($this->is_expired(date('Y/m/d',strtotime($row->akhir_kg."-1 weeks"))) == true)){
					$saldo = array('data' => $row->saldo_kg . " Kg", 'style' => 'text-decoration:blink;font-weight:bold;');
					$masa = array('data' => $row->akhir_kg, 'style' => 'text-decoration:blink;font-weight:bold;');
					if( $this->is_expired($row->akhir_kg) == true )
						$warning = array('data' => "HABIS", 'style' => 'text-decoration:blink;font-weight:bold;color:red;');
					else
						$warning = array('data' => "PERINGATAN", 'style' => 'text-decoration:blink;font-weight:bold;color:orange;');
				}else{
					$saldo = $row->saldo_kg . " Kg";
					$masa = $row->akhir_kg;
					$warning = "-";
				}
			}
			$this->table->add_row( ++$i, $link, array('data' => $row->nama_member, 'style' => 'text-align:left;padding-left:10px;'), $row->tlp_member, $saldo, $masa, $warning );
		}
		return $this->table->generate();
	}
	function histMember($id){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="memberTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( array('data' => 'No', 'style' => 'width:3%;'),'No. Resi','Jenis Layanan','Jumlah','Status','Tgl Transaksi','Tgl Delivery');
		
		$i = 0;
		$trans = $this->Model_laundry->histMember($id,$this->session->userdata('id'));
		foreach ($trans->result() as $row){
			if($row->jenis == "Kiloan")
				$jumlah = $row->jumlah_kiloan . " Kg";
			else
				$jumlah = $row->jumlah_kiloan . " Buah";
			
			$link = anchor($this->mza_secureurl->setSecureUrl_encode('aktivitas','detailAktivitas',array($row->resi,"NO")),$row->resi);
			
			$this->table->add_row( ++$i, $link, $row->nama_laundry, $jumlah, $row->status, $row->tgl_trans, $row->tgl_ambil );
		}
		$depo = $this->Model_laundry->histDeposit($id,$this->session->userdata('id'));
		foreach ($depo->result() as $row){
			if($row->jenis_deposit == "Rupiah")
				$jumlah = "Rp " . number_format($row->jumlah_deposit,0,',','.') . ",-";
			else
				$jumlah = $row->jumlah_deposit . " Kg";
			
			$link = anchor($this->mza_secureurl->setSecureUrl_encode('customer','detailDeposit',array($row->dresi)),$row->dresi);
			
			$this->table->add_row( ++$i, $link, "Deposit " . $row->jenis_deposit, $jumlah, $row->metode_bayar, $row->tgl_depo, "-" );
		}
		return $this->table->generate();
	}
	function kompMember($id){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="kompTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( array('data' => 'No', 'style' => 'width:3%;'),'No. Resi','Komplain');
		
		$i = 0;
		$query = $this->Model_laundry->kompMember($id,$this->session->userdata('id'));
		foreach ($query->result() as $row){
			$link = anchor($this->mza_secureurl->setSecureUrl_encode('aktivitas','detailAktivitas',array($row->resi,"NO")),$row->resi);
			
			$this->table->add_row( ++$i, $link, array('data' => $row->komplain, 'style' => 'width:80%;text-align:left;padding-left:10px;') );
		}
		return $this->table->generate();
	}
	function printHMember($member){
		$data['page_title'] = "Waroenk Laundry | History Transaksi";
		$data['tRow'] = $this->Model_laundry->histMember($member,$this->session->userdata('id'))->result();
		$data['outlet'] = $this->Model_laundry->ambilOutletBy("outlet_id",$this->session->userdata('id'))->row();
		
		$this->load->view('main/customer/transaksi_history', $data);
	}
	function generateCode($jenis){
		$kode = $jenis . $this->session->userdata('code') . date('y', time()) . date('m', time());
		if($jenis == "M"){
			$tabel = "wl_member";
			$param = "id_member";
		}else{
			$tabel = "wl_member_non";
			$param = "id_non";
		}
		// generate code
		$getcode = $this->Model_general->getMaxCode($tabel,$param,$kode)->row();
		$idMax = $getcode->maxID; // [kode]01
		$autoCode = (int) substr($idMax, 10, 4);
		$autoCode++;
		$newID = $kode.sprintf("%04s", $autoCode);
		
		return $newID;
	}
	
	// DEPOSIT
	function deposit_process($id){
		if( $this->cekPegawai($this->input->post("nip")) == true ){
			$ambil = $this->Model_general->getDataBy("wl_member","id_member",$id)->row();
			if ( $this->input->post('jenis') == "Rupiah"){
				$depo = $this->input->post('deposit');
				$bayar = $this->input->post('deposit');
				$saldo = $ambil->saldo_rp;
				$kg_rp = 0;
				$bonus = 0;
				$jenis = "saldo_rp";
				$jnstgl = "akhir_rp";
				$lawan = "saldo_kg";
				$tgl = $this->getMasa($ambil->akhir_rp);
				$depo_sms = "Rp " . $depo . ",-";
				$saldo_sms = "Rp " . ($saldo + $depo) . ",-";
			}else{
				if ( $this->input->post('jenis') == "Kiloan"){
					$cek = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"kode_laundry","CKS")->row();
					$get = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"id_laundry",$this->input->post('deposit'))->row();
					$depo = substr($get->kode_laundry, 1, 2);
					$bayar = $get->harga_laundry;
					$saldo = $ambil->saldo_kg;
					$kg_rp = $ambil->kg_rp + $bayar;
					$bonus = $ambil->bonus + ($cek->harga_laundry * $depo) - $get->harga_laundry;
					$jenis = "saldo_kg";
					$jnstgl = "akhir_kg";
					$lawan = "saldo_rp";
					$tgl = $this->getMasa($ambil->akhir_kg);
					$depo_sms = $depo . " Kg";
					$saldo_sms = $saldo + $depo . " Kg";
				}else{
					if(substr($this->input->post('deposit'),1,2) == "MO")
						$akhir = substr($this->input->post('deposit'),0,1);
					else
						$akhir = 12;
					$id = substr($this->input->post('deposit'),3);
					$bayar = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"id_laundry",$id)->row()->harga_laundry;
					$standar = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"kode_laundry","CKS")->row()->harga_laundry;
					if($bonus < 0)
						$bonus = 0;
					$depo = 0;
					$saldo = 20;
					$kg_rp = $bayar;
					$bonus = ($standar * 20 * $akhir) - $bayar;
					$jenis = "saldo_kg";
					$jnstgl = "akhir_kg";
					$lawan = "saldo_rp";
					$tgl =  date('Y/m/d',strtotime(date('Y/m/d')."+$akhir months"));;
					$depo_sms = "20 Kg";
					$saldo_sms = "20 Kg";
					
					$sisa_rp = $ambil->kg_rp;
					if($sisa_rp > 0){
						$param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
											"debit_jurnal" => "Utang Usaha",
											"jum_debit_jurnal" => $sisa_rp,
											"kredit_jurnal" => "Pendapatan Laundry",
											"jum_kredit_jurnal" => $sisa_rp,
											"ket_jurnal" => "MEMBER : $ambil->idmember - $ambil->nama_member - RESET SALDO",
											'outlet_id' => $this->session->userdata('id')
										);
						$this->Model_general->insertData("ak_jurnal",$param_jurnal);
					}
				}
			}
			
			$kode = $this->generateDeposit();
			$param_deposit = array('dresi' => $kode,
									'id_member' => $id,
									'jenis_deposit' => $this->input->post('jenis'),
									'jumlah_deposit' => $depo,
									'metode_bayar' => $this->input->post('metode'),
									'no_kartu' => $this->input->post('kartu'),
									'bayar_deposit' => $bayar,
									'tgl_depo' => date("Y/m/d H:i:s"),
									'id_depo' => $this->input->post('nip'),
									'outlet_id' => $this->session->userdata('id')
							);
			$this->Model_general->insertData("sx_deposit",$param_deposit);
			$param_member = array( "kg_rp" => $kg_rp,
								"bonus" => $bonus,
								$lawan => 0,
								$jenis => $saldo + $depo,
								$jnstgl => $tgl,
								"checkpoint" => date("Y/m/d H:i:s"),
								"export" => "Yes",
								"warning_sent" => 0
							);
			$this->Model_general->updateData("wl_member","id_member",$id,$param_member);
			$this->sendSMS('C04',$ambil->tlp_member,$ambil->nama_member,0,$depo_sms,$tgl,$saldo_sms);
			
			if($this->input->post('metode') == "Tunai"){
				$keterangan = "DEPOSIT: " . $kode ." - ". $this->input->post("idmember");
				$masuk = "Kas di Tangan";
			}else{
				$keterangan = "DEPOSIT: " . $kode ." - ". $this->input->post("idmember") ." - ". $this->input->post('bank') ." [" . $this->input->post('kartu') ."]";
				$masuk = "Kas";
			}
			$param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
									"debit_jurnal" => $masuk,
									"jum_debit_jurnal" => $bayar,
									"kredit_jurnal" => "Utang Usaha",
									"jum_kredit_jurnal" => $bayar,
									"ket_jurnal" => $keterangan,
									'outlet_id' => $this->session->userdata('id')
								);
			$this->Model_general->insertData("ak_jurnal",$param_jurnal);
			
			redirect( $this->mza_secureurl->setSecureUrl_encode('customer','cetakDeposit',array($kode)) );
		}else{
			redirect( $this->mza_secureurl->setSecureUrl_encode('customer','member_form',array($id,"Ubah","NIP")) );
		}
	}
	function detailDeposit($dresi){
		$data['content'] = 'main/customer/deposit_detail';
		$data['page_title'] = "Waroenk Laundry | Deposit";
		$data['tRow'] = $this->Model_laundry->ambilDeposit($dresi)->row();
		
		$this->load->view('template', $data);
	}
	function cetakDeposit($resi){
		$content = 'main/customer/deposit_cetak';
		$data['page_title'] = "Waroenk Laundry | Transaksi";
		$data['tRow'] = $this->Model_laundry->ambilDeposit($resi)->row();
		$data['outlet'] = $this->Model_laundry->ambilOutletBy("outlet_id",$this->session->userdata('id'))->row();
		
		$this->load->view($content, $data);
	}
	function printHDepo($member){
		$data['page_title'] = "Waroenk Laundry | History Deposit";
		$data['tRow'] = $this->Model_laundry->histDeposit($member,$this->session->userdata('id'))->result();
		$data['outlet'] = $this->Model_laundry->ambilOutletBy("outlet_id",$this->session->userdata('id'))->row();
		
		$this->load->view('main/customer/deposit_history', $data);
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
	function generateDeposit(){
		$kode = "D" . $this->session->userdata('code') . date('y', time()) . date('m', time());
		// generate code
		$getcode = $this->Model_general->getMaxCode("sx_deposit","dresi",$kode)->row();
		$idMax = $getcode->maxID; // [kode]01
		$autoCode = (int) substr($idMax, 10, 3);
		$autoCode++;
		$newID = $kode.sprintf("%03s", $autoCode);
		
		return $newID;
	}
	function getMasa($tanggal){
		if($this->is_expired($tanggal) == true)
			return date('Y/m/d',strtotime(date('Y/m/d')."+1 months"));
		else
			return date('Y/m/d',strtotime($tanggal."+1 months"));
	}
	function kirimWarning(){
		$query = $this->Model_general->getDataBy("wl_member","outlet_id",$this->session->userdata('id'));
		foreach ($query->result() as $row){
			if($row->jenis_member == "Rupiah"){
				$saldo = "Rp ". $row->saldo_rp .",-";
				if( ($row->saldo_rp < 6000) || ($this->is_expired(date('Y/m/d',strtotime($row->akhir_rp."-1 weeks"))) == true) ){
					if( ($row->warning_sent == 0) || ($this->is_expired($row->warning_sent_date) == true) ){
						if($this->is_expired($row->akhir_kg) == true)
							$this->sendSMS('C06',$row->tlp_member,$row->nama_member,0,0,$row->akhir_rp,$saldo);
						else
							$this->sendSMS('C05',$row->tlp_member,$row->nama_member,0,0,$row->akhir_rp,$saldo);
						
						$this->Model_general->updateData("wl_member","id_member",$row->id_member,array("export"=>"Yes","warning_sent"=>1,"warning_sent_date"=>date("Y/m/d H:i:s")));
					}
				}
			}else{
				$saldo = $row->saldo_kg . " Kg";
				if($row->saldo_kg < 2 || ($this->is_expired(date('Y/m/d',strtotime($row->akhir_kg."-1 weeks"))) == true)){
					if( ($row->warning_sent == 0) || ($this->is_expired($row->warning_sent_date) == true) ){
						if($this->is_expired($row->akhir_kg) == true)
							$this->sendSMS('C06',$row->tlp_member,$row->nama_member,0,0,$row->akhir_kg,$saldo);
						else
							$this->sendSMS('C05',$row->tlp_member,$row->nama_member,0,0,$row->akhir_kg,$saldo);
						
						$this->Model_general->updateData("wl_member","id_member",$row->id_member,array("export"=>"Yes","warning_sent"=>1,"warning_sent_date"=>date("Y/m/d H:i:s")));
					}
				}
			}
		}
		redirect( $this->mza_secureurl->setSecureUrl_encode('customer','member') );
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
	
	// NON MEMBER
	function nonmem(){
		$data['content'] = 'main/customer/member';
		$data['page_title'] = "Waroenk Laundry | Non Member";
		$data['tabelMember'] = $this->tabelNon();
		$data['tLegend'] = "NON MEMBER";
		$data['addlink'] = anchor( $this->mza_secureurl->setSecureUrl_encode('customer','non_form',array(0,'Tambah','NO')),'Pelanggan Baru', array('class' => 'add') );
		$data['warning'] = "";
		
		$this->load->view('template', $data);
	}
	function non_form($id,$status,$error){
		$data['content'] = 'main/customer/non_form';
		$data['page_title'] = "Waroenk Laundry | Non Member";
		$data['form_member']= site_url( $this->mza_secureurl->setSecureUrl_encode('customer','non_process',array($id,$status)) );
		$data['tRow'] = $this->Model_general->getDataBy("wl_member_non","id_non",$id)->row();
		$data['link'] = anchor($this->mza_secureurl->setSecureUrl_encode('customer','nonmem'),'Kembali',array('class'=>'back'));
		$data['hist'] = anchor($this->mza_secureurl->setSecureUrl_encode('customer','printHNon',array($id)),'Cetak History Transaksi',array('class'=>'print','target'=>'_blank'));
		$data['dbarea'] = $this->Model_laundry->ambilCakupanBy("outlet_id",$this->session->userdata('id'));
		$data['tabelMember'] = $this->histNon($id);
		$data['tabelKomplain'] = $this->kompNon($id);
		$data['tLegend'] = $status;
		$data['error'] = $error;
		
		if($status == 'Ubah'){
			$cust = $this->Model_general->getDataBy("wl_member_non","id_non",$id)->row();
			$data['default']['nama'] = $cust->nama_non;
			$data['default']['area'] = $cust->area_non;
			$data['default']['add'] = $cust->alamat_non;
			$data['default']['tlp'] = $cust->tlp_non;
		} else {
			if ( $error == 'YES' ){
				$data['default']['nama'] = $this->input->post('nama');
				$data['default']['area'] = $this->input->post('area');
				$data['default']['add'] = $this->input->post('add');
				$data['default']['tlp'] = $this->input->post('tlp');
			}
		}
		
		$this->load->view('template', $data);
	}
	function non_process($id,$status){
		if ($this->form_validation->run("fNon") == FALSE){
			$this->non_form($id,$status,"YES");
		} else {
			$kode = $this->generateCode("N");
			$param_non = array('id_non' => $kode,
							'area_non' => $this->input->post('area'),
							'nama_non' => $this->input->post('nama'),
							'alamat_non' => $this->input->post('add'),
							'tlp_non' => $this->input->post('tlp'),
							'outlet_id' => $this->session->userdata('id')
						);
			if($status == 'Tambah'){
				$this->Model_general->insertData("wl_member_non",$param_non);
			}else{
				$this->Model_general->updateData("wl_member_non","id_non",$id,$param_non);
				$this->Model_general->updateData("wl_member_non","id_non",$id,array("export" => "Yes"));
			}
			
			redirect( $this->mza_secureurl->setSecureUrl_encode('customer','nonmem') );
		}
	}
	function tabelNon(){
		$query = $this->Model_laundry->ambilCustomer($this->session->userdata('id'));
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="memberTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( array('data' => 'No', 'style' => 'width:3%;'), 'Nama', 'Alamat', 'No. Tlp');
		
		$i = 0;
		foreach ($query->result() as $row){
			$link = anchor($this->mza_secureurl->setSecureUrl_encode('customer','non_form',array($row->id_non,"Ubah","NO")),$row->nama_non);
			
			$this->table->add_row( ++$i, array('data' => $link, 'style' => 'text-align:left;padding-left:10px;'), $row->alamat_non, $row->tlp_non );
		}
		return $this->table->generate();
	}
	function histNon($id){
		$query = $this->Model_laundry->histNon($id,$this->session->userdata('id'));
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="memberTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( array('data' => 'No', 'style' => 'width:3%;'),'No. Resi','Jenis Layanan','Jumlah','Status','Tgl Masuk','Tgl Ambil','Ket');
		
		$i = 0;
		foreach ($query->result() as $row){
			if($row->jenis == "Kiloan")
				$jumlah = $row->jumlah_kiloan . " Kg";
			else
				$jumlah = $row->jumlah_kiloan . " Buah";
			
			$link = anchor($this->mza_secureurl->setSecureUrl_encode('aktivitas','detailAktivitas',array($row->resi,"NO")),$row->resi);
			
			$this->table->add_row( ++$i, $link, $row->nama_laundry, $jumlah, $row->status, $row->tgl_trans, $row->tgl_ambil, $row->status_bayar );
		}
		return $this->table->generate();
	}
	function kompNon($id){
		$query = $this->Model_laundry->kompNon($id,$this->session->userdata('id'));
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="kompTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( array('data' => 'No', 'style' => 'width:3%;'),'No. Resi','Komplain');
		
		$i = 0;
		foreach ($query->result() as $row){
			$link = anchor($this->mza_secureurl->setSecureUrl_encode('aktivitas','detailAktivitas',array($row->resi,"NO")),$row->resi);
			
			$this->table->add_row( ++$i, $link, array('data' => $row->komplain, 'style' => 'width:80%;text-align:left;padding-left:10px;') );
		}
		return $this->table->generate();
	}
	function printHNon($id){
		$data['page_title'] = "Waroenk Laundry | History Transaksi";
		$data['tRow'] = $this->Model_laundry->histNon($id,$this->session->userdata('id'))->result();
		$data['outlet'] = $this->Model_laundry->ambilOutletBy("outlet_id",$this->session->userdata('id'))->row();
		
		$this->load->view('main/customer/transaksi_history', $data);
	}
	
	// KOMPLAIN
	function komplain(){
		$data['content'] = 'main/customer/member';
		$data['page_title'] = "Waroenk Laundry | Komplain";
		$data['tabelMember'] = $this->tabelKomplain();
		$data['tLegend'] = "KOMPLAIN";
		
		$this->load->view('template', $data);
	}
	function tabelKomplain(){
		$query = $this->Model_laundry->komplain($this->session->userdata('id'));
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="memberTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( array('data' => 'No', 'style' => 'width:3%;'),'No. Resi','Tgl.','Komplain');
		
		$i = 0;
		foreach ($query->result() as $row){
			$link = anchor($this->mza_secureurl->setSecureUrl_encode('aktivitas','detailAktivitas',array($row->resi,"NO")),$row->resi);
			
			$this->table->add_row( ++$i, $link, $row->tgl_komplain, array('data' => $row->komplain, 'style' => 'width:75%;text-align:left;padding-left:10px;') );
		}
		return $this->table->generate();
	}
	
	function is_expired($expired) {
		$date_now = date("Y/m/d");
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