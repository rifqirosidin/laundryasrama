<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->check_logged_in();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_general','', TRUE);
		$this->load->model('Model_out','', TRUE);
	}
	
	function upload($outlet){
		$this->uploadAktivitas($outlet);
		$this->uploadSecond($outlet);
		$this->uploadMember($outlet);
		$this->uploadPegawai($outlet);
		$this->uploadPengeluaran($outlet);
		$this->uploadJurnal($outlet);
		
		redirect ('setting','index');
	}
	function uploadAktivitas($outlet){
		// Aktivitas
		$mainAct = $this->Model_general->getDataWhere("sx_aktivitas","outlet_id = $outlet AND export = 'Yes'");
		if($mainAct->num_rows() > 0){
			foreach($mainAct->result() as $row){
				$cabAct = $this->Model_out->getDataBy("sx_aktivitas","resi",$row->resi);
				if($cabAct->num_rows() == 0){
					// Transaksi
					$param_act = array("resi" => $row->resi,
							"jumlah_kiloan" => $row->jumlah_kiloan,
							"jenis_laundry" => $row->jenis_laundry,
							"jenis_pewangi" => $row->jenis_pewangi,
							"extra" => $row->extra,
							"status" => $row->status,
							"tgl_finish" => $row->tgl_finish,
							'outlet_id' => $row->outlet_id
						);
					// Invoice
					$inv = $this->Model_general->getDataBy("sx_invoice","resi",$row->resi)->row();
					$param_inv = array("resi" => $inv->resi,
							"total" => $inv->total,
							"sisa_bayar" => $inv->sisa_bayar,
							"tgl_bayar" => $inv->tgl_bayar,
							"metode_bayar" => $inv->metode_bayar,
							"status_bayar" => $inv->status_bayar
						);
					// Customer
					$cust = $this->Model_general->getDataBy("sx_customer","resi",$row->resi)->row();
					$param_cust = array("resi" => $cust->resi,
							"member" => $cust->member,
							"id_member" => $cust->id_member,
							"nama" => $cust->nama,
							"alamat" => $cust->alamat,
							"areanya" => $cust->areanya,
							"no_tlp" => $cust->no_tlp
						);
					// Job Monitor
					$job = $this->Model_general->getDataBy("sx_job_monitor","resi",$row->resi)->row();
					$param_job = array("resi" => $job->resi,
							"tgl_trans" => $job->tgl_trans,
							"id_trans" => $job->id_trans,
							"cat_trans" => $job->cat_trans
						);
					$this->Model_out->insertData("sx_aktivitas",$param_act);
					$this->Model_out->insertData("sx_invoice",$param_inv);
					$this->Model_out->insertData("sx_customer",$param_cust);
					$this->Model_out->insertData("sx_job_monitor",$param_job);
					// Non Kiloan
					$nonkilo = $this->Model_general->getDataBy("sx_aktivitas_non","resi",$row->resi);
					if($nonkilo->num_rows() > 0){
						foreach($nonkilo->result() as $non){
							$param_non = array("resi" => $non->resi,
									"item_non" => $non->item_non,
									"jum_non" => $non->jum_non,
									'outlet_id' => $non->outlet_id
								);
							$this->Model_out->insertData("sx_aktivitas_non",$param_non);
						}
					}
					// Layanan Extra
					$extra = $this->Model_general->getDataBy("sx_aktivitas_ex","resi",$row->resi);
					if($extra->num_rows() > 0){
						foreach($extra->result() as $ex){
							$param_ex = array("resi" => $ex->resi,
									"item_extra" => $ex->item_extra,
									"jum_extra" => $ex->jum_extra,
									'outlet_id' => $ex->outlet_id
								);
							$this->Model_out->insertData("sx_aktivitas_ex",$param_ex);
						}
					}
				}else{
					// Transaksi
					$param_actup = array("status" =>$row->status,"warning_sent"=>$row->warning_sent,"warning_sent_date"=>$row->warning_sent_date);
					$this->Model_out->updateData("sx_aktivitas","resi",$row->resi,$param_actup);
					// Job Monitor
					$job = $this->Model_general->getDataBy("sx_job_monitor","resi",$row->resi)->row();
					$param_job = array("tgl_cek" => $job->tgl_cek,
							"id_cek" => $job->id_cek,
							"cat_cek" => $job->cat_cek,
							"tgl_pack" => $job->tgl_pack,
							"id_pack" => $job->id_pack,
							"cat_pack" => $job->cat_pack,
							"tgl_ambil" => $job->tgl_ambil,
							"id_ambil" => $job->id_ambil,
							"tgl_deliver" => $job->tgl_deliver,
							"id_deliver" => $job->id_deliver
						);
					$this->Model_out->updateData("sx_job_monitor","resi",$row->resi,$param_job);
					// Ceklist
					$ceklist = $this->Model_general->getDataWhere("sx_ceklist","resi = '$row->resi' AND export = 'Yes'");
					if($ceklist->num_rows() > 0){
						$cek = $ceklist->row();
						$this->Model_out->insertData("sx_ceklist",array("resi" => $cek->resi,"jum_mesin" => $cek->jum_mesin,"jum_cloth" => $cek->jum_cloth));
						$detail = $this->Model_general->getDataBy("sx_ceklist_detail","resi",$row->resi);
						foreach($detail->result() as $det){
							$param_detail = array("resi" => $det->resi,
									"nama_cloth" => $det->nama_cloth,
									"q_cloth" => $det->q_cloth
								);
							$this->Model_out->insertData("sx_ceklist_detail",$param_detail);
						}
						$this->Model_general->updateData("sx_ceklist","resi",$row->resi,array('export' => 'No'));
					}
					// Cuci Kering
					$cuker = $this->Model_general->getDataWhere("sx_job_cuker","resi = '$row->resi' AND export = 'Yes'");
					if($cuker->num_rows() > 0){
						foreach($cuker->result() as $cuk){
							$cabCuk = $this->Model_out->getDataBy("sx_job_cuker","resi",$row->resi);
							if($cabCuk->num_rows() == 0){
								$param_cuk = array("no_ceklist" => $cuk->no_ceklist,
											"resi" => $cuk->resi,
											"stat_cuci" => $cuk->stat_cuci,
											"stat_kering" => $cuk->stat_kering
									);
								$this->Model_out->insertData("sx_job_cuker",$param_cuk);
							}else{
								foreach($cabCuk->result() as $ccuk){
									$param_cuk = array("tgl_cuci" => $cuk->tgl_cuci,
												"id_cuci" => $cuk->id_cuci,
												"aset_cuci" => $cuk->aset_cuci,
												"cat_cuci" => $cuk->cat_cuci,
												"stat_cuci" => $cuk->stat_cuci,
												"tgl_kering" => $cuk->tgl_kering,
												"id_kering" => $cuk->id_kering,
												"aset_kering" => $cuk->aset_kering,
												"cat_kering" => $cuk->cat_kering,
												"stat_kering" => $cuk->stat_kering
										);
									$this->Model_out->updateData("sx_job_cuker","id_job_cuker",$ccuk->id_job_cuker,$param_cuk);
								}
							}
						}
						$this->Model_general->updateData("sx_job_cuker","resi",$row->resi,array('export' => 'No'));
					}
					// Packing
					$packing = $this->Model_general->getDataWhere("sx_packing","resi = '$row->resi' AND export = 'Yes'");
					if($packing->num_rows() > 0){
						foreach($packing->result() as $pack){
							$this->Model_out->insertData("sx_packing",array("resi" => $pack->resi,"kode_aset" => $pack->kode_aset));
						}
						$this->Model_general->updateData("sx_packing","resi",$row->resi,array('export' => 'No'));
					}
					// Komplain
					$komp = $this->Model_general->getDataBy("sx_customer","resi",$row->resi)->row();
					$this->Model_out->updateData("sx_customer","resi",$row->resi,array("komplain" => $komp->komplain, "tgl_komplain" => $komp->tgl_komplain));
				}
				// Update Status Upload
				$this->Model_general->updateData("sx_aktivitas","resi",$row->resi,array('export' => 'No'));
			}
		}
	}
	function uploadSecond($outlet){
		// Aset
		$mainAset = $this->Model_general->getDataWhere("wl_aset","outlet_id = $outlet AND export = 'Yes'");
		if($mainAset->num_rows() > 0){
			foreach($mainAset->result() as $row){
				$this->Model_out->updateData("wl_aset","kode_aset",$row->kode_aset,array('use_day' => $row->use_day, 'kondisi' => $row->kondisi));
				// Update Status Upload
				$this->Model_general->updateData("wl_aset","kode_aset",$row->kode_aset,array('export' => 'No'));
			}
		}
		// Perawatan Aset
		$mainRawat = $this->Model_general->getDataWhere("sx_perawatan","outlet_id = $outlet AND export = 'Yes'");
		if($mainRawat->num_rows() > 0){
			foreach($mainRawat->result() as $row){
				$param_rawat = array("id_aset" => $row->id_aset,
						"perawatan" => $row->perawatan,
						"cat_rawat" => $row->cat_rawat,
						"tgl_rawat" => $row->tgl_rawat,
						"jam_rawat" => $row->jam_rawat,
						"nip_rawat" => $row->nip_rawat
					);
				$this->Model_out->insertData("sx_perawatan",$param_rawat);
				// Update Status Upload
				$this->Model_general->updateData("sx_perawatan","id_rawat",$row->id_rawat,array('export' => 'No'));
			}
		}
		// Inventori
		$mainStock = $this->Model_general->getDataWhere("sx_stock","outlet_id = $outlet AND export = 'Yes'");
		if($mainStock->num_rows() > 0){
			foreach($mainStock->result() as $row){
				$param_stok = array("id_stock" => $row->id_stock,
						"act_stock" => $row->act_stock,
						"jum_stock" => $row->jum_stock,
						"cat_stock" => $row->cat_stock,
						"tgl_stock" => $row->tgl_stock,
						"nip_stock" => $row->nip_stock
					);
				$this->Model_out->insertData("sx_stock",$param_stok);
				$inv = $this->Model_general->getDataBy("wl_stock","id_stock",$row->id_stock)->row();
				$this->Model_out->updateData("wl_stock","id_stock",$inv->id_stock,array('stock' => $inv->stock, 'stock_gudang' => $inv->stock_gudang));
				// Update Status Upload
				$this->Model_general->updateData("sx_stock","id_pakai",$row->id_pakai,array('export' => 'No'));
			}
		}
	}
	function uploadMember($outlet){
		// Member
		$mainMem = $this->Model_general->getDataWhere("wl_member","outlet_id = $outlet AND export = 'Yes'");
		if($mainMem->num_rows() > 0){
			foreach($mainMem->result() as $row){
				$param_member = array('id_member' => $row->id_member,
						'nama_member' => $row->nama_member,
						'area_member' => $row->area_member,
						'alamat_member' => $row->alamat_member,
						'tlp_member' => $row->tlp_member,
						'tmpt_lhr_member' => $row->tmpt_lhr_member,
						'tgl_lhr_member' => $row->tgl_lhr_member,
						'agama' => $row->agama,
						'jenis_member' => $row->jenis_member,
						'akhir_kg' => $row->akhir_kg,
						'akhir_rp' => $row->akhir_rp,
						'outlet_id' => $row->outlet_id
					);
				$cabMem = $this->Model_out->getDataBy("wl_member","id_member",$row->id_member);
				if($cabMem->num_rows() == 0)
					$this->Model_out->insertData("wl_member",$param_member);
				else
					$this->Model_out->updateData("wl_member","id_member",$row->id_member,$param_member);
				
				// Update Status Upload
				$this->Model_general->updateData("wl_member","id_member",$row->id_member,array('export' => 'No'));
			}
		}
		// Non Member
		$mainNon = $this->Model_general->getDataWhere("wl_member_non","outlet_id = $outlet AND export = 'Yes'");
		if($mainNon->num_rows() > 0){
			foreach($mainNon->result() as $row){
				$param_non = array('area_non' => $row->area_non,
						'nama_non' => $row->nama_non,
						'alamat_non' => $row->alamat_non,
						'tlp_non' => $row->tlp_non,
						'outlet_id' => $row->outlet_id
					);
				$cabNon = $this->Model_out->getDataBy("wl_member_non","id_non",$row->id_non);
				if($cabNon->num_rows() == 0)
					$this->Model_out->insertData("wl_member_non",$param_non);
				else
					$this->Model_out->updateData("wl_member_non","id_non",$row->id_non,$param_non);
				// Update Status Upload
				$this->Model_general->updateData("wl_member_non","id_non",$row->id_non,array('export' => 'No'));
			}
		}
	}
	function uploadPegawai($outlet){
		// Absen Pegawai
		$mainAbs = $this->Model_general->getDataWhere("wl_pegawai_absen","outlet_id = $outlet AND export = 'Yes'");
		if($mainAbs->num_rows() > 0){
			foreach($mainAbs->result() as $row){
				$param_absen = array('nip' => $row->nip,
						'tgl_absen' => $row->tgl_absen,
						'shift_absen' => $row->shift_absen,
						'jam_masuk' => $row->jam_masuk,
						'jam_keluar' => $row->jam_keluar,
						'ket_absen' => $row->ket_absen
					);
				$this->Model_out->insertData("wl_pegawai_absen",$param_absen);
				// Update Status Upload
				$this->Model_general->updateData("wl_pegawai_absen","id_absen",$row->id_absen,array('export' => 'No'));
			}
		}
		// Pesan to Manajemen
		$mainPesan = $this->Model_general->getDataWhere("master_admin_pesan","outlet_id = $outlet AND export = 'Yes'");
		if($mainPesan->num_rows() > 0){
			foreach($mainPesan->result() as $row){
				$param_pesan = array('id_admin' => $row->id_admin,
						'id_pegawai' => $row->id_pegawai,
						'tgl_pesan' => $row->tgl_pesan,
						'judul_pesan' => $row->judul_pesan,
						'isi_pesan' => $row->isi_pesan,
						'foto_pesan' => $row->foto_pesan,
						'status_pesan' => $row->status_pesan,
						'outlet_id' => $row->outlet_id
					);
				$this->Model_out->insertData("master_admin_pesan",$param_pesan);
				// Update Status Upload
				$this->Model_general->updateData("master_admin_pesan","id_pesan",$row->id_pesan,array('export' => 'No'));
			}
		}
	}
	function uploadPengeluaran($outlet){
		// Jurnal
		$mainKeluar = $this->Model_general->getDataWhere("sx_pengeluaran","outlet_id = $outlet AND export = 'Yes'");
		if($mainKeluar->num_rows() > 0){
			foreach($mainKeluar->result() as $row){
				$param_kas = array("id_keluar" => $row->id_keluar,
						"id_pegawai" => $row->id_pegawai,
						"jum_keluar" => $row->jum_keluar,
						"tgl_keluar" => $row->tgl_keluar,
						"ket_keluar" => $row->ket_keluar,
						"status_keluar" => $row->status_keluar,
						"outlet_id" => $row->outlet_id
					);
				$this->Model_out->insertData("sx_pengeluaran",$param_kas);
				// Update Status Upload
				$this->Model_general->updateData("sx_pengeluaran","id_pengeluaran",$row->id_pengeluaran,array('export' => 'No'));
			}
		}
	}
	function uploadJurnal($outlet){
		// Jurnal
		$mainJurnal = $this->Model_general->getDataWhere("ak_jurnal","outlet_id = $outlet AND export = 'Yes'");
		if($mainJurnal->num_rows() > 0){
			foreach($mainJurnal->result() as $row){
				$param_jurnal = array("tgl_jurnal" => $row->tgl_jurnal,
						"debit_jurnal" => $row->debit_jurnal,
						"jum_debit_jurnal" => $row->jum_debit_jurnal,
						"kredit_jurnal" => $row->kredit_jurnal,
						"jum_kredit_jurnal" => $row->jum_kredit_jurnal,
						"ket_jurnal" => $row->ket_jurnal,
						'outlet_id' => $row->outlet_id
					);
				$this->Model_out->insertData("ak_jurnal",$param_jurnal);
				// Update Status Upload
				$this->Model_general->updateData("ak_jurnal","id_jurnal",$row->id_jurnal,array('export' => 'No'));
			}
		}
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