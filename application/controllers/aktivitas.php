<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aktivitas extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->check_logged_in();
        date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_general','', TRUE);
		$this->load->model('Model_laundry','', TRUE);
		$this->load->model('Model_sms','', TRUE);
	}
	
	/* TRANSAKSI */
	function index($error){
		$data['content'] = 'main/activity/transaksi';
		$data['tab'] = 'main/activity/form_cari_order';
		$data['page_title'] = "Waroenk Laundry | Transaksi";
		$data['fresi'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","cariResi") );
		$data['error'] = $error;
		
		if($this->session->userdata('jenismember') == "Asrut")
			$this->resetAsrut();
		
		$this->load->view('template', $data);
	}
	function transMem($error){
		$data['content'] = 'main/activity/transaksi';
		$data['tab'] = 'main/activity/form_m';
		$data['page_title'] = "Waroenk Laundry | Transaksi";
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("home","index",array("NO")) );
		$data['error'] = $error;
		
		$data['dbKilo'] = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"jenis","Kiloan")->result();
		$data['dbSatu'] = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"jenis","Satuan")->result();
		$data['dbLaundry'] = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"jenis","Non")->result();
		$data['dbExtra'] = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"jenis","Extra")->result();
		$data['dbPewangi'] = $this->Model_laundry->ambilPewangi($this->session->userdata('id'))->result();
		$data['member_kilo'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","prosesTransaksi",array("tMember","YES1","transMem")) );
		$data['member_satu'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","prosesSatu",array("tMember","YES1","transMem")) );
		$data['dbMember'] = $this->Model_laundry->ambilMember($this->session->userdata('id'));
		$data['jumMember'] = $data['dbMember']->num_rows();
		$data['default']['depe'] = 0;
		
		// DAFTAR MEMBER / NON MEMBER BARU & DEPOSIT SALDO
		$data['member_action']= site_url( $this->mza_secureurl->setSecureUrl_encode('aktivitas','member_process') );
		$data['deposit_action']= site_url( $this->mza_secureurl->setSecureUrl_encode('aktivitas','deposit_process') );
		$data['dbDeposit'] = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"jenis","Deposit")->result();
		$data['dbMasa'] = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"jenis","Masa")->result();
		$data['jmember'] = $this->Model_general->getDataBy("wl_outlet","outlet_id",$this->session->userdata('id'))->row();
		$data['dbarea'] = $this->Model_laundry->ambilCakupanBy("outlet_id",$this->session->userdata('id'));
		
		if ( $error == 'YES1' || $error == 'YES2' || $error == 'CUCI' || $error == 'NIP' || $error == 'MEMBER' || $error == 'SALDO' || $error == 'YESBAYAR' || $error == 'PROMO' ){
			$data['default']['id'] = $this->input->post('id');
			$data['default']['cust'] = $this->input->post('cust');
			$data['default']['alamat'] = $this->input->post('alamat');
			$data['default']['nohp'] = $this->input->post('nohp');
			$data['default']['cat'] = $this->input->post('cat');
			$data['default']['kiloan'] = $this->input->post('kiloan');
			$data['default']['laundry'] = $this->input->post('laundry');
			$data['default']['pewangi'] = $this->input->post('pewangi');
			$data['default']['kartu'] = $this->input->post('kartu');
			$data['default']['depe'] = $this->input->post('depe');
			$data['default']['promo'] = $this->input->post('promo');
		}
		
		$this->load->view('template', $data);
	}
	function transNon($error){
		$data['content'] = 'main/activity/transaksi';
		$data['tab'] = 'main/activity/form_non';
		$data['page_title'] = "Waroenk Laundry | Transaksi";
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("home","index",array("NO")) );
		$data['error'] = $error;
		
		$data['dbKilo'] = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"jenis","Kiloan")->result();
		$data['dbSatu'] = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"jenis","Satuan")->result();
		$data['dbLaundry'] = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"jenis","Non")->result();
		$data['dbExtra'] = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"jenis","Extra")->result();
		$data['dbPewangi'] = $this->Model_laundry->ambilPewangi($this->session->userdata('id'))->result();
		$data['non_kilo'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","prosesTransaksi",array("tNon","YES2","transNon")) );
		$data['non_satu'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","prosesSatu",array("tNon","YES2","transNon")) );
		$data['dbNon'] = $this->Model_laundry->ambilCustomer($this->session->userdata('id'));
		$data['jumNon'] = $data['dbNon']->num_rows();
		$data['default']['depe'] = 0;
		
		// DAFTAR MEMBER / NON MEMBER BARU & DEPOSIT SALDO
		$data['non_action']= site_url( $this->mza_secureurl->setSecureUrl_encode('aktivitas','non_process') );
		$data['dbarea'] = $this->Model_laundry->ambilCakupanBy("outlet_id",$this->session->userdata('id'));
		
		if ( $error == 'YES1' || $error == 'YES2' || $error == 'CUCI' || $error == 'NIP' || $error == 'MEMBER' || $error == 'SALDO' || $error == 'YESBAYAR' || $error == 'PROMO' ){
			$data['default']['id'] = $this->input->post('id');
			$data['default']['cust'] = $this->input->post('cust');
			$data['default']['alamat'] = $this->input->post('alamat');
			$data['default']['nohp'] = $this->input->post('nohp');
			$data['default']['cat'] = $this->input->post('cat');
			$data['default']['kiloan'] = $this->input->post('kiloan');
			$data['default']['laundry'] = $this->input->post('laundry');
			$data['default']['pewangi'] = $this->input->post('pewangi');
			$data['default']['kartu'] = $this->input->post('kartu');
			$data['default']['depe'] = $this->input->post('depe');
			$data['default']['promo'] = $this->input->post('promo');
		}
		
		$this->load->view('template', $data);
	}
	function statCuci($error){
		$data['content'] = 'main/activity/transaksi';
		$data['tab'] = 'main/activity/status_order';
		$data['page_title'] = "Waroenk Laundry | Transaksi";
		$data['error'] = $error;
		
		// STATUS CUCIAN
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		if($from == NULL || $to == NULL){
			$from = date('Y/m/d',strtotime(date('Y/m/d')."-1 months"));
			$to = date('Y/m/d');
		}
		$data['dari'] = $from;
		$data['sampai'] = $to;
		
		$data['status_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","statCuci",array("NO")) );
		$data['cetak'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","cetakStatus") );
		$data['tabelAktivitas'] = $this->tabelAktivitas($from,$to);
		
		$this->load->view('template', $data);
	}
	/* CARI RESI */
	function cariResi(){
		$resi = $this->input->post('resi');
		if($resi == ""){
			redirect ( $this->mza_secureurl->setSecureUrl_encode('aktivitas','index',array("RESI")) );
		}else{
			if(substr($resi,0,5) !== $this->session->userdata('code')){
				if($resi < 10){
					$resi = "000" . $resi;
				}else {
					if($resi < 100){
						$resi = "00" . $resi;
					}else if ($resi < 1000){
						$resi = "0" . $resi;
					}
				}
				$resi1 = $this->session->userdata('code') . date('y', time()) . date('m', time()) . $resi;
				$resi2 = $this->session->userdata('code') . date('y', time()) . date('m',strtotime(date('Y/m/d')."-1 months")) . $resi;
			}else{
				$resi1 = $resi;
				$resi2 = $resi;
			}
			$query = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"resi",$resi1);
			if($query->num_rows() > 0){
				$ambil = $query->row();
				if($ambil->status == "SELESAI")
					redirect ( $this->mza_secureurl->setSecureUrl_encode('aktivitas','detailAktivitas',array($ambil->resi,"NO")) );
				else
					redirect ( $this->mza_secureurl->setSecureUrl_encode('aktivitas','pilihAct',array($ambil->resi)) );
			}else{
				$query2 = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"resi",$resi2);
				if($query2->num_rows() > 0){
					$get = $query2->row();
					if($get->status == "SELESAI")
						redirect ( $this->mza_secureurl->setSecureUrl_encode('aktivitas','detailAktivitas',array($get->resi,"NO")) );
					else
						redirect ( $this->mza_secureurl->setSecureUrl_encode('aktivitas','pilihAct',array($get->resi)) );
				}else{
					redirect ( $this->mza_secureurl->setSecureUrl_encode('aktivitas','index',array("RESI")) );
				}
			}
		}
	}
	/* TRANSAKSI KILO */
	function prosesTransaksi($validation,$error,$cont){
		if ($this->form_validation->run($validation) == FALSE){
			$this->$cont($error);
		}else{
			if( $this->cekPegawai($this->input->post("nip")) == true ){
				$laundry = substr($this->input->post('laundry'), 0, 3);
				$ambil = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"kode_laundry",$laundry)->row();
				$hargakg = $ambil->harga_laundry * $this->input->post("kiloan");
				$total = $hargakg;
				$k = 0;
				$xtotal = 0;
				$lextra = "Tidak";
				for($i=0;$i<$this->input->post("tambahan");$i++){
					if($this->input->post("jex$i") > 0){
						$tambah = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"kode_laundry",$this->input->post("extra$i"))->row();
						$xtotal = ($tambah->harga_laundry * $this->input->post("jex$i"));
						if($xtotal > 0){
							$total = $total + $xtotal;
							$extra[$k] = $this->input->post("extra$i");
							$jextra[$k] = $this->input->post("jex$i");
							$lextra = "Ya";
							$k++;
						}
					}
				}
				
				if(substr($ambil->proses,-5) == "hours")
					$finish = date('Y-m-d H:i:s');
				else
					$finish = date('Y-m-d 16:59:30');
					
				$tanggal = date('Y/m/d H:i:s',strtotime($finish."$ambil->proses"));
				
				$resi = $this->generateCode();
				$param_act = array("resi" => $resi,
								"jumlah_kiloan" => $this->input->post("kiloan"),
								"kiloan" => "Kiloan",
								"jenis_laundry" => $laundry,
								"jenis_pewangi" => $this->input->post("pewangi"),
								"extra" => $lextra,
								"status" => "PENDING",
								"tgl_finish" => $tanggal,
								'outlet_id' => $this->session->userdata('id')
							);
				$param_job = array("resi" => $resi,
								"tgl_trans" => date("Y/m/d H:i:s"),
								"id_trans" => $this->input->post("nip"),
								"cat_trans" => $this->input->post("cat")
							);
				if($validation == "tNon"){
					if( $this->input->post('promo') == ""){
						$this->prosesBayar($resi,$total,0,$param_act);
					}else{
						$query = $this->Model_general->getDataBy("wl_promo","kode_promo",$this->input->post('promo'));
						if($query->num_rows() > 0){
							$data = $query->row();
							if( $this->is_expired($data->tgl_akhir) == true ){
								redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","transNon",array("PROMO")) );
							}else{
								if ( $data->status_promo == "Tidak" ){
									redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","transNon",array("PROMO")) );
								}else{
									$this->prosesBayar($resi,$total,$this->konversiPromo1($ambil->harga_laundry,$total,$data->jenis_promo,$data->jumlah),$param_act);
									$this->Model_general->updateData("wl_promo","kode_promo",$this->input->post('promo'),array('status_promo' => 'Tidak'));
								}
							}
						}else{
							redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","transNon",array("PROMO")) );
						}
					}
					$param_cust = array("resi" => $resi,
										"member" => "Tidak",
										"id_member" => $this->input->post("id"),
										"nama" => $this->input->post("cust"),
										"alamat" => $this->input->post("alamat"),
										"areanya" => $this->input->post("areanya"),
										"no_tlp" => $this->input->post("nohp")
									);
					$this->Model_general->insertData("sx_job_monitor",$param_job);
					$this->Model_general->insertData("sx_customer",$param_cust);
					
					for($i=0;$i<$k;$i++){
						$param_ex = array("resi" => $resi,
											"item_extra" => $extra[$i],
											"jum_extra" => $jextra[$i],
											'outlet_id' => $this->session->userdata('id')
										);
						$this->Model_general->insertData("sx_aktivitas_ex",$param_ex);
					}
					$this->sendSMS('C01',$this->input->post('nohp'),$this->input->post('cust'),$resi,0,0,0);
					redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","detailAktivitas",array($resi,"NO")) );
				}else if($validation == "tMember"){
					$param_cust = array("resi" => $resi,
									"member" => "Ya",
									"id_member" => $this->input->post("id"),
									"nama" => $this->input->post("cust"),
									"alamat" => $this->input->post("alamat"),
									"areanya" => $this->input->post("areanya"),
									"no_tlp" => $this->input->post("nohp")
							);
					$param_inv = array("resi" => $resi,
								"tgl_bayar" => date('Y/m/d'),
								"metode_bayar" => "MEMBER",
								"total" => $total,
								"sisa_bayar" => 0,
								"status_bayar" => "LUNAS"
							);
					$query = $this->Model_general->getDataBy("wl_member","id_member",$this->input->post("id"));
					if($query->num_rows() > 0){
						$data = $query->row();
						if($data->jenis_member == "Rupiah"){
							if( ($data->saldo_rp >= $total) && ($this->is_expired($data->akhir_rp) == false) ){
								$this->Model_general->insertData("sx_aktivitas",$param_act);
								$this->Model_general->insertData("sx_job_monitor",$param_job);
								$this->Model_general->insertData("sx_customer",$param_cust);
								$this->Model_general->insertData("sx_invoice",$param_inv);
								
								for($i=0;$i<$k;$i++){
									$param_ex = array("resi" => $resi,
														"item_extra" => $extra[$i],
														"jum_extra" => $jextra[$i],
														'outlet_id' => $this->session->userdata('id')
													);
									$this->Model_general->insertData("sx_aktivitas_ex",$param_ex);
								}
								
								$hutang = $data->saldo_rp - $total;
								if($hutang > 0){
									$param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
												"debit_jurnal" => "Utang Usaha",
												"jum_debit_jurnal" => $hutang,
												"kredit_jurnal" => "Pendapatan Laundry",
												"jum_kredit_jurnal" => $hutang,
												"ket_jurnal" => "MEMBER : " . $resi . " - " . $this->input->post("cust"),
												'outlet_id' => $this->session->userdata('id')
											);
									$this->Model_general->insertData("ak_jurnal",$param_jurnal);
								}
								$this->Model_general->updateData("wl_member","id_member",$this->input->post("id"),array("saldo_rp" => $data->saldo_rp - $total, "export" => "Yes"));
								$this->sendSMS('C01',$this->input->post('nohp'),$this->input->post('cust'),$resi,0,0,0);
								
								redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","detailAktivitas",array($resi,"NO")) );
							}else{
								$this->$cont("SALDO");
							}
						}else{
							if( ($data->saldo_kg >= $this->input->post("kiloan")) && ($this->is_expired($data->akhir_kg) == false) ){
								$this->Model_general->insertData("sx_aktivitas",$param_act);
								$this->Model_general->insertData("sx_job_monitor",$param_job);
								$this->Model_general->insertData("sx_customer",$param_cust);
								$this->Model_general->insertData("sx_invoice",$param_inv);
								
								for($i=0;$i<$k;$i++){
									$param_ex = array("resi" => $resi,
														"item_extra" => $extra[$i],
														"jum_extra" => $jextra[$i],
														'outlet_id' => $this->session->userdata('id')
													);
									$this->Model_general->insertData("sx_aktivitas_ex",$param_ex);
								}
								
								$hutang = $data->bonus - $hargakg;
								if($hutang < 0){
									$bonus = 0;
									$kg_rp = $data->kg_rp - abs($hutang);
									$param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
												"debit_jurnal" => "Utang Usaha",
												"jum_debit_jurnal" => abs($hutang),
												"kredit_jurnal" => "Pendapatan Laundry",
												"jum_kredit_jurnal" => abs($hutang),
												"ket_jurnal" => "MEMBER : " . $resi . " - " . $this->input->post("cust"),
												'outlet_id' => $this->session->userdata('id')
											);
									$this->Model_general->insertData("ak_jurnal",$param_jurnal);
								}else{
									$bonus = $hutang;
									$kg_rp = $data->kg_rp;
								}
								$param_saldo = array("saldo_kg" => $data->saldo_kg - $this->input->post("kiloan"),
													"kg_rp" => $kg_rp,
													"bonus" => $bonus,
													"export" => "Yes"
												);
								$this->Model_general->updateData("wl_member","id_member",$this->input->post("id"),$param_saldo);
								$this->sendSMS('C01',$this->input->post('nohp'),$this->input->post('cust'),$resi,0,0,0);
								
								redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","detailAktivitas",array($resi,"NO")) );
							}else{
								$this->$cont("SALDO");
							}
						}
					}else{
						$this->$cont("MEMBER");
					}
				}
			}else{
				$this->$cont("NIP");
			}
		}
	}
	/* TRANSAKSI NON KILO */
	function prosesSatu($validation,$error,$cont){
		if ($this->form_validation->run($validation) == FALSE){
			$this->$cont($error);
		}else{
			if( $this->cekPegawai($this->input->post("nip")) == true ){
				$j = 0;
				$buah = 0;
				$total = 0;
				$ctotal = 0;
				$laundry = substr($this->input->post('laundry'), 0, 3);
				$ambil = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"kode_laundry",$laundry)->row();
				for($i=0;$i<$this->input->post("kiloan");$i++){
					if($this->input->post("jum$i") > 0){
						$get = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"kode_laundry",$this->input->post("cuci$i"))->row();
						$ctotal = ($ambil->harga_laundry * $get->harga_laundry * $this->input->post("jum$i"));
						if($ctotal > 0){
							$total = $total + $ctotal;
							$cuci[$j] = $this->input->post("cuci$i");
							$jumlah[$j] = $this->input->post("jum$i");
							$buah = $buah + $jumlah[$j];
							$j++;
						}
					}
				}
				if($total == 0)
					redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","$cont",array("CUCI")) );
				
				if(substr($ambil->proses,-5) == "hours")
					$finish = date('Y-m-d H:i:s');
				else
					$finish = date('Y-m-d 16:59:30');
					
				$tanggal = date('Y/m/d H:i:s',strtotime($finish."$ambil->proses"));
				
				$k = 0;
				$xtotal = 0;
				$lextra = "Tidak";
				for($i=0;$i<$this->input->post("tambahan");$i++){
					if($this->input->post("jex$i") > 0){
						$tambah = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"kode_laundry",$this->input->post("extra$i"))->row();
						$xtotal = ($tambah->harga_laundry * $this->input->post("jex$i"));
						if($xtotal > 0){
							$total = $total + $xtotal;
							$extra[$k] = $this->input->post("extra$i");
							$jextra[$k] = $this->input->post("jex$i");
							$lextra = "Ya";
							$k++;
						}
					}
				}
				$resi = $this->generateCode();
				$param_act = array("resi" => $resi,
								"jumlah_kiloan" => $buah,
								"kiloan" => "Non",
								"jenis_laundry" => $laundry,
								"jenis_pewangi" => $this->input->post("pewangi"),
								"extra" => $lextra,
								"status" => "PENDING",
								"tgl_finish" => $tanggal,
								'outlet_id' => $this->session->userdata('id')
							);
				$param_job = array("resi" => $resi,
								"tgl_trans" => date("Y/m/d H:i:s"),
								"id_trans" => $this->input->post("nip"),
								"cat_trans" => $this->input->post("cat")
							);
				if($validation == "tNon"){
					if( $this->input->post('promo') == ""){
						$this->prosesBayar($resi,$total,0,$param_act);
					}else{
						$query = $this->Model_general->getDataBy("wl_promo","kode_promo",$this->input->post('promo'));
						if($query->num_rows() > 0){
							$data = $query->row();
							if( $this->is_expired($data->tgl_akhir) == true ){
								redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","transNon",array("PROMO")) );
							}else{
								if ( $data->status_promo == "Tidak" ){
									redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","transNon",array("PROMO")) );
								}else{
									if ( $data->jenis_promo == "Kiloan" ){
										redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","transNon",array("PROMO")) );
									}else{
										$this->prosesBayar($resi,$total,$this->konversiPromo1(0,$total,$data->jenis_promo,$data->jumlah),$param_act);
										$this->Model_general->updateData("wl_promo","kode_promo",$this->input->post('promo'),array('status_promo' => 'Tidak'));
									}
								}
							}
						}else{
							redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","transNon",array("PROMO")) );
						}
					}
					$param_cust = array("resi" => $resi,
										"member" => "Tidak",
										"id_member" => $this->input->post("id"),
										"nama" => $this->input->post("cust"),
										"alamat" => $this->input->post("alamat"),
										"areanya" => $this->input->post("areanya"),
										"no_tlp" => $this->input->post("nohp")
									);
					$this->Model_general->insertData("sx_job_monitor",$param_job);
					$this->Model_general->insertData("sx_customer",$param_cust);
					
					for($i=0;$i<$j;$i++){
						$param_non = array("resi" => $resi,
											"item_non" => $cuci[$i],
											"jum_non" => $jumlah[$i],
											'outlet_id' => $this->session->userdata('id')
										);
						$this->Model_general->insertData("sx_aktivitas_non",$param_non);
					}
					for($i=0;$i<$k;$i++){
						$param_ex = array("resi" => $resi,
											"item_extra" => $extra[$i],
											"jum_extra" => $jextra[$i],
											'outlet_id' => $this->session->userdata('id')
										);
						$this->Model_general->insertData("sx_aktivitas_ex",$param_ex);
					}
					$this->sendSMS('C01',$this->input->post('nohp'),$this->input->post('cust'),$resi,0,0,0);
					
					redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","detailAktivitas",array($resi,"NO")) );
				}else if($validation == "tMember"){
					$param_cust = array("resi" => $resi,
									"member" => "Ya",
									"id_member" => $this->input->post("id"),
									"nama" => $this->input->post("cust"),
									"alamat" => $this->input->post("alamat"),
									"areanya" => $this->input->post("areanya"),
									"no_tlp" => $this->input->post("nohp")
							);
					$query = $this->Model_general->getDataBy("wl_member","id_member",$this->input->post("id"));
					if($query->num_rows() > 0){
						$data = $query->row();
						if($data->jenis_member == "Rupiah"){
							if( ($data->saldo_rp >= $total) && ($this->is_expired($data->akhir_rp) == false) ){
								$param_inv = array("resi" => $resi,
											"tgl_bayar" => date('Y/m/d'),
											"metode_bayar" => "MEMBER",
											"total" => $total,
											"sisa_bayar" => 0,
											"status_bayar" => "LUNAS"
										);
								$this->Model_general->insertData("sx_aktivitas",$param_act);
								$this->Model_general->insertData("sx_job_monitor",$param_job);
								$this->Model_general->insertData("sx_customer",$param_cust);
								$this->Model_general->insertData("sx_invoice",$param_inv);
								
								for($i=0;$i<$j;$i++){
									$param_non = array("resi" => $resi,
														"item_non" => $cuci[$i],
														"jum_non" => $jumlah[$i],
														'outlet_id' => $this->session->userdata('id')
													);
									$this->Model_general->insertData("sx_aktivitas_non",$param_non);
								}
								for($i=0;$i<$k;$i++){
									$param_ex = array("resi" => $resi,
														"item_extra" => $extra[$i],
														"jum_extra" => $jextra[$i],
														'outlet_id' => $this->session->userdata('id')
													);
									$this->Model_general->insertData("sx_aktivitas_ex",$param_ex);
								}
								
								$hutang = $data->saldo_rp - $total;
								if($hutang > 0){
									$param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
												"debit_jurnal" => "Pendapatan Laundry",
												"jum_debit_jurnal" => $hutang,
												"kredit_jurnal" => "Utang Usaha",
												"jum_kredit_jurnal" => $hutang,
												"ket_jurnal" => "MEMBER : " . $resi . " - " . $this->input->post("cust"),
												'outlet_id' => $this->session->userdata('id')
											);
									$this->Model_general->insertData("ak_jurnal",$param_jurnal);
								}
								$this->Model_general->updateData("wl_member","id_member",$this->input->post("id"),array("saldo_rp" => $data->saldo_rp - $total, "export" => "Yes"));
								$this->sendSMS('C01',$this->input->post('nohp'),$this->input->post('cust'),$resi,0,0,0);
								
								redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","detailAktivitas",array($resi,"NO")) );
							}else{
								$this->$cont("SALDO");
//								break;
							}
						}else{
							if( $this->input->post('promo') == ""){
								$this->prosesBayar($resi,$total,0,$param_act);
							}else{
								$query = $this->Model_general->getDataBy("wl_promo","kode_promo",$this->input->post('promo'));
								if($query->num_rows() > 0){
									$data = $query->row();
									if( $this->is_expired($data->tgl_akhir) == true ){
										redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","transMem",array("PROMO")) );
									}else{
										if ( $data->status_promo == "Tidak" ){
											redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","transMem",array("PROMO")) );
										}else{
											if ( $data->jenis_promo == "Kiloan" ){
												redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","transMem",array("PROMO")) );
											}else{
												$this->prosesBayar($resi,$total,$this->konversiPromo1(0,$total,$data->jenis_promo,$data->jumlah),$param_act);
												$this->Model_general->updateData("wl_promo","kode_promo",$this->input->post('promo'),array('status_promo' => 'Tidak'));
											}
										}
									}
								}else{
									redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","transMem",array("PROMO")) );
								}
							}
							$this->Model_general->insertData("sx_job_monitor",$param_job);
							$this->Model_general->insertData("sx_customer",$param_cust);
							
							for($i=0;$i<$j;$i++){
								$param_non = array("resi" => $resi,
													"item_non" => $cuci[$i],
													"jum_non" => $jumlah[$i],
													'outlet_id' => $this->session->userdata('id')
												);
								$this->Model_general->insertData("sx_aktivitas_non",$param_non);
							}
							for($i=0;$i<$k;$i++){
								$param_ex = array("resi" => $resi,
													"item_extra" => $extra[$i],
													"jum_extra" => $jextra[$i],
													'outlet_id' => $this->session->userdata('id')
												);
								$this->Model_general->insertData("sx_aktivitas_ex",$param_ex);
							}
							$this->sendSMS('C01',$this->input->post('nohp'),$this->input->post('cust'),$resi,0,0,0);
							
							redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","detailAktivitas",array($resi,"NO")) );
						}
					}else{
						$this->$cont("MEMBER");
					}
				}
			}else{
				$this->$cont("NIP");
			}
		}
	}
	/* PEMBAYARAN */
	function prosesBayar($resi,$total,$potongan,$param_act){
		switch ( $this->input->post('metode') ) {
			case 1 : $param_inv = array("resi" => $resi,
								"total" => $total,
								"sisa_bayar" => 0,
								"tgl_bayar" => date('Y/m/d'),
								"metode_bayar" => "TUNAI",
								"status_bayar" => "LUNAS"
							);
					 $this->Model_general->insertData("sx_aktivitas",$param_act);
					 $this->Model_general->insertData("sx_invoice",$param_inv);
					 
					 if($potongan <= 0){
						 $param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
												"debit_jurnal" => "Kas di Tangan",
												"jum_debit_jurnal" => $total,
												"kredit_jurnal" => "Pendapatan Laundry",
												"jum_kredit_jurnal" => $total,
												"ket_jurnal" => "MASUK BAYAR : " . $resi . " - " . $this->input->post("cust"),
												'outlet_id' => $this->session->userdata('id')
											);
						 $this->Model_general->insertData("ak_jurnal",$param_jurnal);
					 }
					break;
			case 2 : if ($this->form_validation->run("tKartu") == FALSE){
						redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("YESBAYAR")) );
					 }else{
						$param_inv = array("resi" => $resi,
								"total" => $total,
								"sisa_bayar" => 0,
								"nama_bank" => $this->input->post('bank'),
								"no_kartu" => $this->input->post('kartu'),
								"tgl_bayar" => date('Y/m/d'),
								"metode_bayar" => "DEBIT / KREDIT",
								"status_bayar" => "LUNAS"
							);
						$this->Model_general->insertData("sx_aktivitas",$param_act);
						$this->Model_general->insertData("sx_invoice",$param_inv);
						
						$param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
												"debit_jurnal" => "Kas",
												"jum_debit_jurnal" => $total,
												"kredit_jurnal" => "Pendapatan Laundry",
												"jum_kredit_jurnal" => $total,
												"ket_jurnal" => "MASUK BAYAR : " . $resi ." - ". $this->input->post("cust") ." - ". $this->input->post('bank') ." [" . $this->input->post('kartu') ."]",
												'outlet_id' => $this->session->userdata('id')
											);
						$this->Model_general->insertData("ak_jurnal",$param_jurnal);
					 }
					break;
			case 3 : if ($this->form_validation->run("tDepe") == FALSE){
						redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("YESBAYAR")) );
					 }else{
						$sisa = $total - $potongan - $this->input->post('depe');
						if($sisa <= 0){
							$metode = "TUNAI";
							$status = "LUNAS";
							
							if($potongan <= 0){
								$param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
												"debit_jurnal" => "Kas di Tangan",
												"jum_debit_jurnal" => $total,
												"kredit_jurnal" => "Pendapatan Laundry",
												"jum_kredit_jurnal" => $total,
												"ket_jurnal" => "MASUK BAYAR : " . $resi . " - " . $this->input->post("cust"),
												'outlet_id' => $this->session->userdata('id')
											);
								$this->Model_general->insertData("ak_jurnal",$param_jurnal);
							}
						}else{
							$metode = "AKHIR / DP";
							$status = "BELUM";
							
							if($this->input->post('depe') > 0){
								$param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
												"debit_jurnal" => "Kas di Tangan",
												"jum_debit_jurnal" => $this->input->post('depe'),
												"kredit_jurnal" => "Pendapatan Laundry",
												"jum_kredit_jurnal" => $this->input->post('depe'),
												"ket_jurnal" => "MASUK BAYAR : " . $resi . " - " . $this->input->post("cust"),
												'outlet_id' => $this->session->userdata('id')
											);
								$this->Model_general->insertData("ak_jurnal",$param_jurnal);
							}
							
							$param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
												"debit_jurnal" => "Piutang Usaha",
												"jum_debit_jurnal" => $sisa,
												"kredit_jurnal" => "Pendapatan Laundry",
												"jum_kredit_jurnal" => $sisa,
												"ket_jurnal" => "MASUK BAYAR : " . $resi . " - " . $this->input->post("cust"),
												'outlet_id' => $this->session->userdata('id')
											);
							$this->Model_general->insertData("ak_jurnal",$param_jurnal);
						}
						
						$param_inv = array("resi" => $resi,
								"total" => $total,
								"dp_bayar" => $this->input->post('depe'),
								"sisa_bayar" => $sisa,
								"tgl_bayar" => date('Y/m/d'),
								"metode_bayar" => $metode,
								"status_bayar" => $status
							);
						$this->Model_general->insertData("sx_aktivitas",$param_act);
						$this->Model_general->insertData("sx_invoice",$param_inv);
					 }
					break;
		}
	}
	function pembayaran($resi,$error){
		$data['content'] = 'main/activity/transaksi_bayar';
		$data['page_title'] = "Waroenk Laundry | Transaksi";
		$data['bayar_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","cekPromo",array($resi)) );
		$data['tRow'] = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"resi",$resi)->row();
		$data['dbDetail'] = $this->Model_laundry->ambilTransNon("resi",$resi)->result();
		$data['dbExtra'] = $this->Model_laundry->ambilExtra("resi",$resi)->result();
		$data['default']['depe'] = 0;
		$data['error'] = $error;
		
		if ( $error == 'YES' ||  $error == 'NIP' || $error == 'PROMO' ){
			$data['default']['kartu'] = $this->input->post('kartu');
			$data['default']['depe'] = $this->input->post('depe');
			$data['default']['promo'] = $this->input->post('promo');
		}
			
		$this->load->view('template', $data);
	}
	function cekPromo($resi){
		if ($this->form_validation->run("tCuci") == FALSE){
			$this->pembayaran($resi,"YES");
		}else{
			if( $this->cekPegawai($this->input->post("nip")) == true ){
				$ambil = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"resi",$resi)->row();
				if( $this->input->post('promo') == ""){
					$this->prosesPembayaran($resi,$ambil->sisa_bayar,0,$ambil->nama);
				}else{
					$query = $this->Model_general->getDataBy("wl_promo","kode_promo",$this->input->post('promo'));
					if($query->num_rows() > 0){
						$data = $query->row();
						if( $this->is_expired($data->tgl_akhir) == true ){
							$this->pembayaran($resi,"PROMO");
						}else{
							if ( $data->status_promo == "Tidak" ){
								$this->pembayaran($resi,"PROMO");
							}else{
								if ( $ambil->jenis == "Non" && $data->jenis_promo == "Kiloan" ){
									$this->pembayaran($resi,"PROMO");
								}else{
									$this->prosesPembayaran($resi,$ambil->sisa_bayar,$this->konversiPromo2($resi,$data->jenis_promo,$data->jumlah),$ambil->nama);
								}
							}
						}
					}else{
						$this->pembayaran($resi,"PROMO");
					}
				}
			}else{
				$this->pembayaran($resi,"NIP");
			}
		}
	}
	function prosesPembayaran($resi,$sisa,$potongan,$cust){
		$bayar = $sisa - $potongan;
		if($bayar > 0){
			switch ( $this->input->post('metode') ) {
				case 1 : $param_inv = array("tgl_bayar" => date('Y/m/d'),
							"status_bayar" => "LUNAS",
							"sisa_bayar" => 0
						 );
						 $this->Model_general->updateData("sx_invoice","resi",$resi,$param_inv);
						 
						 if($potongan <= 0){
							 $param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
													"debit_jurnal" => "Kas di Tangan",
													"jum_debit_jurnal" => $sisa,
													"kredit_jurnal" => "Piutang Usaha",
													"jum_kredit_jurnal" => $sisa,
													"ket_jurnal" => "AMBIL BAYAR : " . $resi . " - " . $cust,
													'outlet_id' => $this->session->userdata('id')
												);
							 $this->Model_general->insertData("ak_jurnal",$param_jurnal);
						 }
						 $this->Model_general->updateData("wl_promo","kode_promo",$this->input->post('promo'),array('status_promo' => 'Tidak'));
						break;
				case 2 : if ($this->form_validation->run("tKartu") == FALSE){
							$this->pembayaran($resi,"YES");
						 }else{
							$param_inv = array("tgl_bayar" => date('Y/m/d'),
									"metode_bayar" => "DEBIT / KREDIT",
									"status_bayar" => "LUNAS",
									"sisa_bayar" => 0,
									"nama_bank" => $this->input->post('bank'),
									"no_kartu" => $this->input->post('kartu')
								 );
							$this->Model_general->updateData("sx_invoice","resi",$resi,$param_inv);
							
							$param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
													"debit_jurnal" => "Kas",
													"jum_debit_jurnal" => $sisa,
													"kredit_jurnal" => "Piutang Usaha",
													"jum_kredit_jurnal" => $sisa,
													"ket_jurnal" => "AMBIL BAYAR : ". $resi ." - ". $cust ." - ". $this->input->post('bank') ." [". $this->input->post('kartu') ."]",
													'outlet_id' => $this->session->userdata('id')
												);
							$this->Model_general->insertData("ak_jurnal",$param_jurnal);
							$this->Model_general->updateData("wl_promo","kode_promo",$this->input->post('promo'),array('status_promo' => 'Tidak'));
						 }
						break;
			}
			$param_job = array("tgl_ambil" => date("Y/m/d H:i:s"),
							"id_ambil" => $this->input->post("nip")
						);
			if($this->input->post("deliver") == "Ya"){
				$status = "DELIVERY";
			}else{
				$status = "SELESAI";
				$this->sendSMS('C03',$this->input->post('nohp'),$cust,$resi,0,0,0);
			}
			$this->Model_general->updateData("sx_job_monitor","resi",$resi,$param_job);
			$this->Model_general->updateData("sx_aktivitas","resi",$resi,array("export" => "Yes", "status" => $status));
			
			redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")) );
		}else{
			$this->pembayaran($resi,"PROMO");
		}
	}
	function cetakTransaksi($resi){
		$data['page_title'] = "Waroenk Laundry | Transaksi";
		$data['tRow'] = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"resi",$resi)->row();
		$data['dbDetail'] = $this->Model_laundry->ambilTransNon("resi",$resi)->result();
		$data['dbExtra'] = $this->Model_laundry->ambilExtra("resi",$resi)->result();
		if($data['tRow']->member == "Ya"){
			$member = $this->Model_general->getDataBy("wl_member","id_member",$data['tRow']->id_member)->row();
			if($member->jenis_member == "Rupiah")
				$data['saldo'] = "Rp " . number_format($member->saldo_rp,0,',','.') . ",-(" . $member->akhir_rp . ")";
			else
				$data['saldo'] = $member->saldo_kg . "Kg (" . $member->akhir_kg . ")";
		}
		$data['outlet'] = $this->Model_laundry->ambilOutletBy("outlet_id",$this->session->userdata('id'))->row();
		
		$this->load->view('main/activity/transaksi_cetak', $data);
	}
	/* PILIH AKTIVITAS*/
	function pilihAct($resi){
		$data['content'] = 'main/activity/act_pilih';
		$data['page_title'] = "Waroenk Laundry | Pilih Aktivitas";
		$data['tRow'] = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"resi",$resi)->row();
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")) );
		
		$this->load->view('template', $data);
	}
	/* CEKLIST */
	function ceklist($resi,$error){
		$data['content'] = 'main/activity/act_ceklist';
		$data['page_title'] = "Waroenk Laundry | Ceklist";
		$data['form_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","prosesCeklist",array($resi)) );
		$data['tRow'] = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"resi",$resi)->row();
		$data['staff'] = $this->Model_general->getData("wl_pegawai","nama_pegawai")->result();
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")) );
		$data['error'] = $error;
		
		if($data['tRow']->jenis == "Kiloan")
			$data['cloth'] = $this->Model_general->getData("master_cloth","nama_cloth")->result();
		else
			$data['cloth'] = $this->Model_laundry->ambilTransNon("resi",$resi)->result();
		
		if ( $error == 'YES' || $error == 'NIP'){
			$data['default']['nip'] = $this->input->post('nip');
			$data['default']['jum'] = $this->input->post('jum');
			$data['default']['ket'] = $this->input->post('ket');
		}else{
			$data['default']['jum'] = 1;
		}
		
		$this->load->view('template', $data);
	}
	function prosesCeklist($resi){
		if ($this->form_validation->run("tCek") == FALSE){
			$this->ceklist($resi,"YES");
		}else{
			if( $this->cekPegawai($this->input->post("nip")) == true ){
				$param_cek = array("resi" => $resi,
							"jum_mesin" => $this->input->post("jum"),
							"jum_cloth" => $this->input->post("jum_cloth")
						);
				$this->Model_general->insertData("sx_ceklist",$param_cek);
				
				$data = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"resi",$resi)->row();
				if($data->jenis == "Kiloan"){
					$query = $this->Model_general->getData("master_cloth","urut_cloth");
					foreach($query->result() as $row){
						$param_detail = array("resi" => $resi,
									"nama_cloth" => $row->nama_cloth,
									"q_cloth" => $this->input->post("$row->var_cloth")
								);
						$this->Model_general->insertData("sx_ceklist_detail",$param_detail);
					}
				}else{
					$query = $this->Model_laundry->ambilTransNon("resi",$resi);
					foreach($query->result() as $row){
						$param_detail = array("resi" => $resi,
									"nama_cloth" => $row->nama_laundry,
									"q_cloth" => $row->jum_non
								);
						$this->Model_general->insertData("sx_ceklist_detail",$param_detail);
					}
				}
				
				$kresi = substr($resi,9,4);
				for($i=1;$i<=$this->input->post("jum");$i++){
					$param_cuker = array("no_ceklist" => $kresi . "-" . $i,
								"resi" => $resi,
								"stat_cuci" => "Belum",
								"stat_kering" => "Belum"
						);
					$this->Model_general->insertData("sx_job_cuker",$param_cuker);
				}
				
				$param_job = array("tgl_cek" => date("Y/m/d H:i:s"),
								"id_cek" => $this->input->post("nip"),
								"cat_cek" => $this->input->post("ket")
							);
				$this->Model_general->updateData("sx_job_monitor","resi",$resi,$param_job);
				$this->Model_general->updateData("sx_aktivitas","resi",$resi,array("export" => "Yes", "status" => "CEKLIST"));
				
				redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","detailCek",array($resi,$this->input->post("jum"),$this->input->post('nip'))) );
			}else{
				$this->ceklist($resi,"NIP");
			}
		}
	}
	function detailCek($resi,$jumlah,$nip){
		$data['content'] = 'main/activity/act_ceklist_detail';
		$data['page_title'] = "Waroenk Laundry | Ceklist";
		$data['cetakCek'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","cetakCek",array($resi,$jumlah,$nip)) );
		$data['tRow'] = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"resi",$resi)->row();
		$data['dbCeklist'] = $this->Model_laundry->ambilCeklistDetail("resi",$resi)->result();
		$data['dbDetail'] = $this->Model_laundry->ambilTransNon("resi",$resi)->result();
		$data['dbExtra'] = $this->Model_laundry->ambilExtra("resi",$resi)->result();
		
		$this->load->view('template', $data);
	}
	function cetakCek($resi,$jumlah,$nip){
		$data['kresi'] = substr($resi,9,4);
		$data['tRow'] = $this->Model_laundry->ambilCeklistDetail("resi",$resi)->result();
		$data['outlet'] = $this->Model_laundry->ambilOutletBy("outlet_id",$this->session->userdata('id'))->row();
		$data['staff'] = $this->Model_general->getDataBy("wl_pegawai","nip",$nip)->row();
		$data['jumlah'] = $jumlah;
		
		$this->load->view('main/activity/ceklist_cetak', $data);
	}
	function cetakCekKopi($resi,$kresi){
		$data['kresi'] = $kresi;
		$data['tRow'] = $this->Model_laundry->ambilCeklistDetail("resi",$resi)->result();
		$data['outlet'] = $this->Model_laundry->ambilOutletBy("outlet_id",$this->session->userdata('id'))->row();
		
		$this->load->view('main/activity/ceklist_cetak_copy', $data);
	}
	/* CUCI */
	function cuci($resi,$error){
		$data['content'] = 'main/activity/act_cuci';
		$data['page_title'] = "Waroenk Laundry | Cuci";
		$data['tRow'] = $this->Model_laundry->ambilCeklist("resi",$resi)->row();
		$data['staff'] = $this->Model_general->getData("wl_pegawai","nama_pegawai")->result();
		$data['mcuci'] = $this->Model_general->getDataBy("wl_aset","jenis_aset","01")->result();
		$data['dataCeklist'] = $this->Model_laundry->ambilCeklistMesin("resi",$resi)->result();
		$data['form_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","prosesCuci",array($resi,$data['tRow']->jum_mesin)) );
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")) );
		$data['error'] = $error;
		
		if ( $error == 'YES' || $error == 'NIP' || $error == 'ASET' ){
			$data['default']['ket'] = $this->input->post('ket');
		}
		
		$this->load->view('template', $data);
	}
	function prosesCuci($resi,$mesin){
		if ($this->form_validation->run("tCuci") == FALSE){
			$this->cuci($resi,"YES");
		}else{
			if( $this->cekPegawai($this->input->post("nip")) == true ){
				for($i=1;$i<=$mesin;$i++){
					if($this->input->post("mesin$i") !== ""){
						if( $this->cekMesinCuci($this->input->post("mesin$i")) == false ){
							redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","cuci",array($resi,"ASET")) );
							break;
						}else{
							$cek[$i] = $this->input->post("cek$i");
							$aset[$i] = $this->input->post("mesin$i");
							$status[$i] = $this->input->post("status$i");
						}
					}else{
						$cek[$i] = 0;
						$status[$i] = 0;
					}
				}
				
				for($i=1;$i<=$mesin;$i++){
					if($cek[$i] > 0 && $status[$i] == "Belum"){
						$param_cuker = array("tgl_cuci" => date("Y/m/d H:i:s"),
									"id_cuci" => $this->input->post("nip"),
									"aset_cuci" => $aset[$i],
									"cat_cuci" => $this->input->post("ket"),
									"stat_cuci" => "Sudah",
									"export" => "Yes"
							);
						$this->Model_general->updateData("sx_job_cuker","id_job_cuker",$cek[$i],$param_cuker);
						$use = $this->Model_general->getDataBy("wl_aset","kode_aset",$aset[$i])->row();
						$this->Model_general->updateData("wl_aset","kode_aset",$aset[$i],array("use_day" => $use->use_day + 1,'export' => 'Yes' ));
					}
				}
				
				if( $this->Model_general->getDataWhere("sx_job_cuker","stat_cuci = 'Sudah' AND resi = '" . $resi . "'")->num_rows() == $mesin){
					$param_job = array("tgl_cuci" => date("Y/m/d H:i:s"),
									"id_cuci" => $this->input->post("nip"),
									"cat_cuci" => $this->input->post("ket")
							);
					$this->Model_general->updateData("sx_job_monitor","resi",$resi,$param_job);
					$this->Model_general->updateData("sx_aktivitas","resi",$resi,array("export" => "Yes", "status" => "WASHING"));
					redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")) );
				}else{
					redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","cuci",array($resi,"NO")) );
				}
			}else{
				$this->cuci($resi,"NIP");
			}
		}
	}
	/* PENGERINGAN */
	function kering($resi,$error){
		$data['content'] = 'main/activity/act_kering';
		$data['page_title'] = "Waroenk Laundry | Pengeringan";
		$data['tRow'] = $this->Model_laundry->ambilCeklist("resi",$resi)->row();
		$data['staff'] = $this->Model_general->getData("wl_pegawai","nama_pegawai")->result();
		$data['mkrg'] = $this->Model_general->getDataBy("wl_aset","jenis_aset","02")->result();
		$data['dataCeklist'] = $this->Model_laundry->ambilCeklistMesin("resi",$resi)->result();
		$data['form_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","prosesKering",array($resi,$data['tRow']->jum_mesin)) );
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")) );
		$data['error'] = $error;
		
		if ( $error == 'YES' || $error == 'NIP' || $error == 'ASET' ){
			$data['default']['ket'] = $this->input->post('ket');
		}
		
		$this->load->view('template', $data);
	}
	function prosesKering($resi,$mesin){
		if ($this->form_validation->run("tCuci") == FALSE){
			$this->kering($resi,"YES");
		}else{
			if( $this->cekPegawai($this->input->post("nip")) == true ){
				for($i=1;$i<=$mesin;$i++){
					if($this->input->post("mesin$i") !== ""){
						if( $this->cekMesinKering($this->input->post("mesin$i")) == false ){
							redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","kering",array($resi,"ASET")) );
							break;
						}else{
							$cek[$i] = $this->input->post("cek$i");
							$aset[$i] = $this->input->post("mesin$i");
							$status[$i] = $this->input->post("status$i");
						}
					}else{
						$cek[$i] = 0;
						$status[$i] = 0;
					}
				}
				
				for($i=1;$i<=$mesin;$i++){
					if($cek[$i] > 0 && $status[$i] == "Belum"){
						$param_cuker = array("tgl_kering" => date("Y/m/d H:i:s"),
									"id_kering" => $this->input->post("nip"),
									"aset_kering" => $aset[$i],
									"cat_kering" => $this->input->post("ket"),
									"stat_kering" => "Sudah",
									"export" => "Yes"
							);
						$this->Model_general->updateData("sx_job_cuker","id_job_cuker",$cek[$i],$param_cuker);
						$use = $this->Model_general->getDataBy("wl_aset","kode_aset",$aset[$i])->row();
						$this->Model_general->updateData("wl_aset","kode_aset",$aset[$i],array("use_day" => $use->use_day + 1,'export' => 'Yes' ));
					}
				}
				
				if( $this->Model_general->getDataWhere("sx_job_cuker","stat_kering = 'Sudah' AND resi = '" . $resi . "'")->num_rows() == $mesin){
					$param_job = array("tgl_kering" => date("Y/m/d H:i:s"),
									"id_kering" => $this->input->post("nip"),
									"cat_kering" => $this->input->post("ket")
							);
					$this->Model_general->updateData("sx_job_monitor","resi",$resi,$param_job);
					$this->Model_general->updateData("sx_aktivitas","resi",$resi,array("export" => "Yes", "status" => "DRYING"));
					redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")) );
				}else{
					redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","kering",array($resi,"NO")) );
				}
			}else{
				$this->kering($resi,"NIP");
			}
		}
	}
	/* PACKING */
	function packing($resi,$error){
		$data['content'] = 'main/activity/act_packing';
		$data['page_title'] = "Waroenk Laundry | Packing";
		$data['staff'] = $this->Model_general->getData("wl_pegawai","nama_pegawai")->result();
		$data['mstr'] = $this->Model_general->getDataBy("wl_aset","jenis_aset","03")->result();
		$data['tRow'] = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"resi",$resi)->row();
		$data['form_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","prosesPacking",array($resi)) );
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")) );
		$data['error'] = $error;
		
		if ( $error == 'NIP' || $error == 'ASET' )
			$data['default']['ket'] = $this->input->post('ket');
		
		$this->load->view('template', $data);
	}
	function prosesPacking($resi){
		if ($this->form_validation->run("tCuci") == FALSE){
			$this->packing($resi,"YES");
		}else{
			if( $this->cekPegawai($this->input->post("nip")) == true ){
				$i = 0;
				foreach($this->input->post('mesin') as $idmesin){
					if( $this->cekSetrika($idmesin[$i]) == true ){
							$mesin[$i] = $idmesin[$i];
							$jumlahMesin = $i;
					}else{
						redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","packing",array($resi,"ASET")) );
						break;
					}
					$i++;
				}
				
				for($i=0;$i<=$jumlahMesin;$i++){
					$param_packing = array("resi" => $resi,
							"kode_aset" => $mesin[$i]
						);
					$this->Model_general->insertData("sx_packing",$param_packing);
					$use = $this->Model_general->getDataBy("wl_aset","kode_aset",$mesin[$i])->row();
					$this->Model_general->updateData("wl_aset","kode_aset",$mesin[$i],array("use_day" => $use->use_day + 1,'export' => 'Yes'));
				}
				
				$param_job = array("tgl_pack" => date("Y/m/d H:i:s"),
								"id_pack" => $this->input->post("nip"),
								"cat_pack" => $this->input->post("ket")
							);
				$this->Model_general->updateData("sx_job_monitor","resi",$resi,$param_job);
				$this->Model_general->updateData("sx_aktivitas","resi",$resi,array("export" => "Yes", "status" => "SIAP AMBIL"));
				
				$get = $this->Model_general->getDataBy("sx_aktivitas","resi",$resi)->row();
				if($this->is_expired($get->tgl_finish) == true){
					$this->sendSMS('C02',$this->input->post('nohp'),$this->input->post('cust'),$resi,0,0,0);
					$this->Model_general->updateData("sx_aktivitas","resi",$resi,array("warning_sent" => 1,"warning_sent_date"=>date("Y/m/d H:i:s")));
				}
				
				redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")) );
			}else{
				$this->packing($resi,"NIP");
			}
		}
	}
	/* PENGAMBILAN */
	function ambil($resi,$error){
		$data['content'] = 'main/activity/act_ambil';
		$data['page_title'] = "Waroenk Laundry | Ambil";
		$data['form_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","prosesAmbil",array($resi)) );
		$data['tRow'] = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"resi",$resi)->row();
		$data['dbExtra'] = $this->Model_laundry->ambilExtra("resi",$resi)->result();
		$data['dbDetail'] = $this->Model_laundry->ambilTransNon("resi",$resi)->result();
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")) );
		$data['tLegend'] = "PENGAMBILAN";
		$data['error'] = $error;
		
		$this->load->view('template', $data);
	}
	function prosesAmbil($resi){
		if ($this->form_validation->run("tAmbil") == FALSE){
			$this->ambil($resi,"YES");
		}else{
			if( $this->cekPegawai($this->input->post("nip")) == true ){
				$param_job = array("tgl_ambil" => date("Y/m/d H:i:s"),
								"id_ambil" => $this->input->post("nip")
							);
				if($this->input->post("deliver") == "Ya"){
					$status = "DELIVERY";
				}else{
					$status = "SELESAI";
					$this->sendSMS('C03',$this->input->post('nohp'),$this->input->post('cust'),$resi,0,0,0);
				}
				$this->Model_general->updateData("sx_job_monitor","resi",$resi,$param_job);
				$this->Model_general->updateData("sx_aktivitas","resi",$resi,array("export" => "Yes", "status" => $status));
				
				redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")) );
			}else{
				$this->ambil($resi,"NIP");
			}
		}
	}
	/* PENGANTARAN */
	function antar($resi,$error){
		$data['content'] = 'main/activity/act_ambil';
		$data['page_title'] = "Waroenk Laundry | Delivery";
		$data['form_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","prosesAntar",array($resi)) );
		$data['tRow'] = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"resi",$resi)->row();
		$data['dbExtra'] = $this->Model_laundry->ambilExtra("resi",$resi)->result();
		$data['dbDetail'] = $this->Model_laundry->ambilTransNon("resi",$resi)->result();
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")) );
		$data['tLegend'] = "DELIVERY";
		$data['error'] = $error;
		
		$this->load->view('template', $data);
	}
	function prosesAntar($resi){
		if ($this->form_validation->run("tAmbil") == FALSE){
			$this->antar($resi,"YES");
		}else{
			if( $this->cekPegawai($this->input->post("nip")) == true ){
				$param_job = array("tgl_deliver" => date("Y/m/d H:i:s"),
								"id_deliver" => $this->input->post("nip")
							);
				$this->Model_general->updateData("sx_job_monitor","resi",$resi,$param_job);
				$this->Model_general->updateData("sx_aktivitas","resi",$resi,array("export" => "Yes", "status" => "SELESAI"));
				$this->sendSMS('C03',$this->input->post('nohp'),$this->input->post('cust'),$resi,0,0,0);
				
				redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")) );
			}else{
				$this->antar($resi,"NIP");
			}
		}
	}
	/* KOMPLAIN */
	function transKomplain($resi){
		if( $this->cekPegawai($this->input->post("nip")) == true ){
			$this->Model_general->updateData("sx_customer","resi",$resi,array("komplain" => $this->input->post("ket"),"tgl_komplain" => date("Y/m/d H:i:s")));
			$param_shout = array("tlp_shout" => $this->input->post("notlp"),
								"jenis_shout" => "KRITIK",
								"tgl_shout" => date("Y-m-d H:i:s"),
								"isi_shout" => $this->input->post("ket")
							);
			$this->Model_general->insertData("ad_shout",$param_shout);
			$this->Model_general->updateData("sx_aktivitas","resi",$resi,array("export" => "Yes"));
			redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NO")) );
		}else{
			$this->detailAktivitas($resi,"NIP");
		}
	}
	
	/* SPK */
	function cetakStatus(){
		if( $this->cekPegawai($this->input->post("nip")) == true ){
			$stcuci = array("PENDING","CEKLIST","WASHING","DRYING","PACKING","SIAP AMBIL","DELIVERY","SELESAI");
			$stbayar = array("LUNAS","BELUM");
			$stcust = array("Ya","Tidak","MEMBER","NON MEMBER");
			$cuci = ""; $scuci = "";
			$bayar = ""; $sbayar = "";
			$cust = ""; $scust = "";
			for($i=0;$i<8;$i++){
				if(!isset($_POST["cuci$i"]))
					$cuci = $cuci . " AND a.status != '" . $stcuci[$i] . "'";
				else
					$scuci = $scuci . $stcuci[$i] . ", ";
			}
			for($i=0;$i<2;$i++){
				if(!isset($_POST["bayar$i"]))
					$bayar = $bayar . " AND i.status_bayar != '" . $stbayar[$i] . "'";
				else
					$sbayar = $sbayar . $stbayar[$i] . ", ";
					
				if(!isset($_POST["cust$i"]))
					$cust = $cust . " AND c.member != '" . $stcust[$i] . "'";
				else
					$scust = $scust . $stcust[$i+2] . ", ";
			}
			$tgl = 'AND j.tgl_trans BETWEEN "'.$this->input->post("ti").'" AND "'.$this->input->post("ka").'"';
			$table = "sx_aktivitas a, sx_customer c, sx_invoice i, sx_job_monitor j";
			$where = "a.resi = c.resi AND a.resi = i.resi AND a.resi = j.resi $cuci $bayar $cust $tgl AND a.outlet_id = " . $this->session->userdata('id');
			
			$data['page_title'] = "Waroenk Laundry | Monitoring Cucian";
			$data['scuci'] = $scuci;
			$data['sbayar'] = $sbayar;
			$data['scust'] = $scust;
			$data['tRow'] = $this->Model_general->getDataWhere($table,$where)->result();
			$data['outlet'] = $this->Model_laundry->ambilOutletBy("outlet_id",$this->session->userdata('id'))->row();
			$data['staff'] = $this->Model_general->getDataBy("wl_pegawai","nip",$this->input->post('nip'))->row();
			
			//echo "TABEL : $table<br/>WHERE : $where";
			$this->load->view('main/activity/status_order_cetak', $data);
		}else{
			redirect ( $this->mza_secureurl->setSecureUrl_encode("aktivitas","index",array("NIP")) );
		}
	}
	
	/* DAFTAR MEMBER / NON MEMBER */
	function non_process() {
		if( $this->cekPegawai($this->input->post("nip")) == true ){
			$kode = $this->generateID("N");
			$param_non = array('id_non' => $kode,
							'area_non' => $this->input->post('areanonbaru'),
							'nama_non' => $this->input->post('namanonbaru'),
							'alamat_non' => $this->input->post('alamatnonbaru'),
							'tlp_non' => $this->input->post('nohpnonbaru'),
							'outlet_id' => $this->session->userdata('id')
						);
			$this->Model_general->insertData("wl_member_non",$param_non);
			
			redirect( $this->mza_secureurl->setSecureUrl_encode('aktivitas','transNon',array("NO")) );
		} else {
			redirect( $this->mza_secureurl->setSecureUrl_encode('aktivitas','transNon',array("NIP")) );
		}
	}
	function member_process() {
		if ($this->form_validation->run("fMember") == FALSE){
			redirect( $this->mza_secureurl->setSecureUrl_encode('aktivitas','transMem',array("YESMEMBER")) );
		} else {
			if( $this->cekPegawai($this->input->post("nip")) == true ){
				$kode = $this->generateID("M");
				if($this->input->post('jenisbaru') == "Asrut"){
					if(substr($this->input->post('deposit'),1,2) == "MO")
						$akhir = substr($this->input->post('deposit'),0,1);
					else
						$akhir = 10;
					
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
				
				redirect( $this->mza_secureurl->setSecureUrl_encode('aktivitas','transMem',array("NO")) );
			} else {
				redirect( $this->mza_secureurl->setSecureUrl_encode('aktivitas','transMem',array("NIP")) );
			}
		}
	}
	function generateID($jenis){
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
	/* DEPOSIT MEMBER */
	function deposit_process(){
		if( $this->cekPegawai($this->input->post("nip")) == true ){
			$datamember = $this->Model_general->getDataBy("wl_member","id_member",$this->input->post('idmember'));
			if($datamember->num_rows > 0){
				$ambil = $datamember->row();
				if ( $this->input->post('jdp') == "Rupiah"){
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
					if ( $this->input->post('jdp') == "Kiloan"){
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
						$depo = 0;
						$saldo = 20;
						$kg_rp = $bayar;
						$bonus = ($standar * 20 * $akhir) - $bayar;
						if($bonus < 0)
							$bonus = 0;
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
												"ket_jurnal" => "MEMBER : $ambil->id_member - $ambil->nama_member - RESET SALDO",
												'outlet_id' => $this->session->userdata('id')
											);
							$this->Model_general->insertData("ak_jurnal",$param_jurnal);
						}
					}
				}
					
				$kode = $this->generateDeposit();
				$param_deposit = array('dresi' => $kode,
										'id_member' => $this->input->post('idmember'),
										'jenis_deposit' => $this->input->post('jdp'),
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
				$this->Model_general->updateData("wl_member","id_member",$this->input->post('idmember'),$param_member);
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
				redirect( $this->mza_secureurl->setSecureUrl_encode('aktivitas','transMem',array("MEMBER")) );
			}
		}else{
			redirect( $this->mza_secureurl->setSecureUrl_encode('aktivitas','transMem',array("NIP")) );
		}
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
	
	/* MONITORING */
	function jobMonitor($resi){
		$data['content'] = 'main/activity/transaksi_monitoring';
		$data['page_title'] = "Waroenk Laundry | Monitoring Cucian";
		$data['tRow'] = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"resi",$resi)->row();
		$ambil = $this->Model_general->getDataBy("sx_job_monitor","resi",$resi)->row();
		$id[1] = $ambil->id_trans;
		$id[2] = $ambil->id_cek;
		$id[3] = $ambil->id_pack;
		$id[4] = $ambil->id_ambil;
		$id[5] = $ambil->id_deliver;
		for($i=1;$i<=5;$i++){
			$staff = $this->Model_general->getDataBy("wl_pegawai","nip",$id[$i])->row();
			if($staff)
				$data["id$i"] = $staff->nama_pegawai;
			else
				$data["id$i"] = "-";
		}
		$stcuci = ""; $stkering = "";
		$cuker = $this->Model_general->getDataBy("sx_job_cuker","resi",$resi)->result();
		foreach($cuker as $row){
			$staff1 = $this->Model_general->getDataBy("wl_pegawai","nip",$row->id_cuci)->row();
			if($staff1)
				$stcuci = $staff1->nama_pegawai . ", " . $stcuci;
			else
				$stcuci = $stcuci . "";
			
			$staff2 = $this->Model_general->getDataBy("wl_pegawai","nip",$row->id_kering)->row();
			if($staff2)
				$stkering = $staff2->nama_pegawai . ", " . $stkering;
			else
				$stkering = $stkering . "";
		}
		$data["cuci"] = $stcuci;
		$data["kering"] = $stkering;
		
		$this->load->view('template', $data);
	}

	//Reset saldo member
	/* AUTO RESET MEMBER ASRAMA UNTEL*/
    //checkpoint digunakan untuk mengecek reset saldo
    // checkpoint 2020/02/02 update saldo 2020/03/03
	function resetAsrut(){

		$dbAsrut = $this->Model_general->getDataBy("wl_member","jenis_member","Asrut");
		foreach($dbAsrut->result() as $row){
			if($this->is_expired($row->akhir_kg) == FALSE){
				if($this->is_expired(date('Y/m/d',strtotime($row->checkpoint."+1 month"))) == TRUE){
				    var_dump("benar");
					$standar = $this->Model_laundry->ambilLaundryBy($this->session->userdata('id'),"kode_laundry","CKS")->row()->harga_laundry;
					$sisa_rp = $row->kg_rp;
					$sisa_bonus = $row->bonus - ($row->saldo_kg * $standar);
					if($sisa_bonus < 0){
						$sisa_rp = $row->kg_rp - abs($sisa_bonus);
						$sisa_bonus = 0;
						$param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
											"debit_jurnal" => "Utang Usaha",
											"jum_debit_jurnal" => $sisa_rp,
											"kredit_jurnal" => "Pendapatan Laundry",
											"jum_kredit_jurnal" => $sisa_rp,
											"ket_jurnal" => "MEMBER : $row->id_member - $row->nama_member - RESET SALDO",
											'outlet_id' => $this->session->userdata('id')
										);
						$this->Model_general->insertData("ak_jurnal",$param_jurnal);
					}
					$paramMember = array("saldo_kg" => 20,
										"kg_rp" => $sisa_rp,
										"bonus" => $sisa_bonus,
										"checkpoint"=>date("Y/m/d")
									);
					$this->Model_general->updateData("wl_member","id_member",$row->id_member,$paramMember);
				}
			}
		}
	}
    function is_expired($expired) {
        date_default_timezone_set('Asia/Jakarta');
        $date_now = date("Y/m/d H:i:s");

        if ( strtotime($date_now) > strtotime($expired) )
            return true;
        else
            return false;
    }
	
	function detailAktivitas($resi,$error){
		$data['content'] = 'main/activity/transaksi_detail';
		$data['page_title'] = "Waroenk Laundry | Transaksi";
		$data['form_komplain'] = site_url( $this->mza_secureurl->setSecureUrl_encode("aktivitas","transKomplain",array($resi)) );
		$data['tRow'] = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"resi",$resi)->row();
		$data['dbDetail'] = $this->Model_laundry->ambilTransNon("resi",$resi)->result();
		$data['dbExtra'] = $this->Model_laundry->ambilExtra("resi",$resi)->result();
		$data['error'] = $error;
		
		if ( $error == 'NIP' )
			$data['default']['ket'] = $this->input->post('ket');
		
		$this->load->view('template', $data);
	}
	function tabelAktivitas($from,$to){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="actTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( array('data' => 'No', 'width' => '3%'),
									'No. Resi', 'Nama Pelanggan', 'No. Tlp', 'Alamat', 'Tgl Masuk', 'Jumlah',  'Biaya', 'Status Bayar', 'Status', 'Action' );
		$i = 0;
		$PENDING = $this->Model_laundry->ambilAktivitas("PENDING",$this->session->userdata('id'),$from,$to);
		foreach ($PENDING->result() as $row){
			if($row->kiloan == "Kiloan"){
				$jumlah = $row->jumlah_kiloan . " Kg";
			}else{
				$jumlah = $row->jumlah_kiloan . " Buah";
			}
			
			
			$link = anchor( $this->mza_secureurl->setSecureUrl_encode('aktivitas','detailAktivitas',array($row->resi,"NO")) , $row->resi );
			$action = anchor($this->mza_secureurl->setSecureUrl_encode('aktivitas','ceklist',array($row->resi,"NO")),'Confirm',array('class' => 'confirm'));
			
			$this->table->add_row( ++$i, $link, $row->nama, $row->no_tlp, $row->alamat, $row->tgl_trans, $jumlah, "Rp. ".$row->total,$row->status_bayar, $row->status, "none" );
		}
		$CEKLIST = $this->Model_laundry->ambilAktivitas("CEKLIST",$this->session->userdata('id'),$from,$to);
		foreach ($CEKLIST->result() as $row){
			if($row->kiloan == "Kiloan"){
				$jumlah = $row->jumlah_kiloan . " Kg";
			}else{
				$jumlah = $row->jumlah_kiloan . " Buah";
			}
			$link = anchor( $this->mza_secureurl->setSecureUrl_encode('aktivitas','detailAktivitas',array($row->resi,"NO")) , $row->resi );
			$action = anchor($this->mza_secureurl->setSecureUrl_encode('aktivitas','cuci',array($row->resi,"NO")),'Confirm',array('class' => 'confirm'));
			
			$this->table->add_row( ++$i, $link, $row->nama, $row->no_tlp, $row->alamat,$row->tgl_trans, $jumlah, "Rp. ".$row->total,$row->status_bayar, $row->status, "none" );
		}
		$WASHING = $this->Model_laundry->ambilAktivitas("WASHING",$this->session->userdata('id'),$from,$to);
		foreach ($WASHING->result() as $row){
			if($row->kiloan == "Kiloan"){
				$jumlah = $row->jumlah_kiloan . " Kg";
			}else{
				$jumlah = $row->jumlah_kiloan . " Buah";
			}
			$link = anchor( $this->mza_secureurl->setSecureUrl_encode('aktivitas','detailAktivitas',array($row->resi,"NO")) , $row->resi );
			$action = anchor($this->mza_secureurl->setSecureUrl_encode('aktivitas','kering',array($row->resi,"NO")),'Confirm',array('class' => 'confirm'));
			
			$this->table->add_row( ++$i, $link, $row->nama, $row->no_tlp, $row->alamat,$row->tgl_trans, $jumlah, "Rp. ".$row->total,$row->status_bayar, $row->status, "none" );
		}
		$DRYING = $this->Model_laundry->ambilAktivitas("DRYING",$this->session->userdata('id'),$from,$to);
		foreach ($DRYING->result() as $row){
			if($row->kiloan == "Kiloan"){
				$jumlah = $row->jumlah_kiloan . " Kg";
			}else{
				$jumlah = $row->jumlah_kiloan . " Buah";
			}
			$link = anchor( $this->mza_secureurl->setSecureUrl_encode('aktivitas','detailAktivitas',array($row->resi,"NO")) , $row->resi );
			$action = anchor($this->mza_secureurl->setSecureUrl_encode('aktivitas','packing',array($row->resi,"NO")),'Confirm',array('class' => 'confirm'));
			
			$this->table->add_row( ++$i, $link, $row->nama, $row->no_tlp, $row->alamat,$row->tgl_trans, $jumlah, "Rp. ".$row->total,$row->status_bayar, $row->status, "none" );
		}
		$SIAP = $this->Model_laundry->ambilAktivitas("SIAP AMBIL",$this->session->userdata('id'),$from,$to);
		foreach ($SIAP->result() as $row){
			if($row->kiloan == "Kiloan"){
				$jumlah = $row->jumlah_kiloan . " Kg";
			}else{
				$jumlah = $row->jumlah_kiloan . " Buah";
			}
			$link = anchor( $this->mza_secureurl->setSecureUrl_encode('aktivitas','detailAktivitas',array($row->resi,"NO")) , $row->resi );
			$action = anchor($this->mza_secureurl->setSecureUrl_encode('aktivitas','ambil',array($row->resi,"NO")),'Confirm',array('class' => 'confirm'));
			
			if($row->metode_bayar == "AKHIR / DP")
				$action = anchor($this->mza_secureurl->setSecureUrl_encode('aktivitas','pembayaran',array($row->resi,"NO")),'Confirm',array('class' => 'confirm'));
			
			$this->table->add_row( ++$i, $link, $row->nama, $row->no_tlp, $row->alamat,$row->tgl_trans, $jumlah, "Rp. ".$row->total,$row->status_bayar, $row->status, "none" );
		}
		$DELIVERY = $this->Model_laundry->ambilAktivitas("DELIVERY",$this->session->userdata('id'),$from,$to);
		foreach ($DELIVERY->result() as $row){
			if($row->kiloan == "Kiloan"){
				$jumlah = $row->jumlah_kiloan . " Kg";
			}else{
				$jumlah = $row->jumlah_kiloan . " Buah";
			}
			$link = anchor( $this->mza_secureurl->setSecureUrl_encode('aktivitas','detailAktivitas',array($row->resi,"NO")) , $row->resi );
			$action = anchor($this->mza_secureurl->setSecureUrl_encode('aktivitas','antar',array($row->resi,"NO")),'Confirm',array('class' => 'confirm'));
			
			$this->table->add_row( ++$i, $link, $row->nama, $row->no_tlp, $row->alamat,$row->tgl_trans, $jumlah, "Rp. ".$row->total,$row->status_bayar, $row->status, "none" );
		}
		$SELESAI = $this->Model_laundry->ambilAktivitas("SELESAI",$this->session->userdata('id'),$from,$to);
		foreach ($SELESAI->result() as $row){
			if($row->kiloan == "Kiloan"){
				$jumlah = $row->jumlah_kiloan . " Kg";
			}else{
				$jumlah = $row->jumlah_kiloan . " Buah";
			}
			$action = "none";
			$link = anchor( $this->mza_secureurl->setSecureUrl_encode('aktivitas','detailAktivitas',array($row->resi,"NO")) , $row->resi );
			
			$this->table->add_row( ++$i, $link, $row->nama, $row->no_tlp, $row->alamat,$row->tgl_trans, $jumlah, "Rp. ".$row->total,$row->status_bayar, $row->status, $action );
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
	function cekMesinCuci($kode){
		$query = $this->Model_general->getDataBy("wl_aset","kode_aset",$kode);
		if($query->num_rows() > 0){
			$data = $query->row();
			$jenis = substr($data->kode_aset,7,2);
			if($jenis == "01")
				return true;
			else
				return false;
		}else
			return false;
	}
	function cekMesinKering($kode){
		$query = $this->Model_general->getDataBy("wl_aset","kode_aset",$kode);
		if($query->num_rows() > 0){
			$data = $query->row();
			$jenis = substr($data->kode_aset,7,2);
			if($jenis == "02")
				return true;
			else
				return false;
		}else
			return false;
	}
	function cekSetrika($kode){
		$query = $this->Model_general->getDataBy("wl_aset","kode_aset",$kode);
		if($query->num_rows() > 0){
			$data = $query->row();
			$jenis = substr($data->kode_aset,7,2);
			if($jenis == "03")
				return true;
			else
				return false;
		}else
			return false;
	}
	function generateCode(){
		$kode = $this->session->userdata('code') . date('y', time()) . date('m', time());
		
		// generate code
		$getcode = $this->Model_general->getMaxCode("sx_aktivitas","resi",$kode)->row();
		$idMax = $getcode->maxID; // [kode]0001
		$autoCode = (int) substr($idMax, 9, 4);
		$autoCode++;
		$newID = $kode.sprintf("%04s", $autoCode);
		
		return $newID;
	}
	function konversiPromo1($harga,$total,$jenis,$jumlah){
		if($jenis == "Rupiah"){
			if($jumlah <= $total )
				return $jumlah;
			else
				return $total;
		}else if($jenis == "Diskon"){
			return ( ($total * $jumlah) / 100 );
		}else if($jenis == "Kiloan"){
			$totPromo = $harga * $jumlah;
			if($totPromo <= $total )
				return $totPromo;
			else
				return $total;
		}
	}
	function konversiPromo2($resi,$jenis,$jumlah){
		$ambil = $this->Model_laundry->ambilTransaksi($this->session->userdata('id'),"resi",$resi)->row();
		if($jenis == "Rupiah"){
			if($jumlah <= $ambil->total )
				return $jumlah;
			else
				return $ambil->total;
		}else if($jenis == "Diskon"){
			return ( ($ambil->total * $jumlah) / 100 );
		}else if($jenis == "Kiloan"){
			$totPromo = $ambil->harga_laundry * $jumlah;
			if($totPromo <= $ambil->total )
				return $totPromo;
			else
				return $ambil->total;
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