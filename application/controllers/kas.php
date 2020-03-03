<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kas extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->check_logged_in();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_general','', TRUE);
		$this->load->model('Model_laundry','', TRUE);
		$this->load->model('Model_finance','', TRUE);
	}
	
	function input($error){
		$data['content'] = 'main/activity/second/kas_input';
		$data['page_title'] = "Waroenk Laundry | Input Pengeluaran";
		$data['dbKeluar'] = $this->Model_general->getDataBy("master_akun","user_akun",2);
		$data['form_kas'] = site_url( $this->mza_secureurl->setSecureUrl_encode("kas","input_process") );
		$data['status_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode("kas","input",array("NO")) );
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("home","index",array("NO")) );
		$data['error'] = $error;
		
		$i=0;
		$query = $this->Model_laundry->ambilKeluarApp($this->session->userdata("id"));
		if($query->num_rows > 0){
			foreach ($query->result() as $row){
				$data["form_app"]["$i"] = site_url( $this->mza_secureurl->setSecureUrl_encode("kas","app_keluar",array($row->id_keluar)) );
				$i++;
			}
		}
		$data["jumlah"] = $i;
		
		$from = $this->input->post('from');
		$to = $this->input->post('to');
		if($from == NULL || $to == NULL){
			$from = date('Y/m/d',strtotime(date('Y/m/d')."-1 months"));
			$to = date('Y/m/d');
		}
		$data['dari'] = $from;
		$data['sampai'] = $to;
		$data['tabelKeluar'] = $this->tabelKas($from,$to);
		
		$this->load->view('template', $data);
	}
	function input_process(){
		if ($this->form_validation->run("tKas") == FALSE){
			$this->input("YES");
		}else{
			$query = $this->Model_general->getDataBy("wl_pegawai","nip",$this->input->post("nip"));
			if($query->num_rows() > 0){
				$data = $query->row();
				$pass = sha1($this->input->post('pass'));
				if($data->position_id > 3 && $pass == $data->pass_pegawai){
					if($data->position_id == 4){
						$ambil = $this->Model_general->getDataBy("master_akun","id_keluar",$this->input->post("item"))->row();
						$param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
												"debit_jurnal" => $ambil->nama_akun,
												"jum_debit_jurnal" => $this->input->post("jum"),
												"kredit_jurnal" => "Kas di Tangan",
												"jum_kredit_jurnal" => $this->input->post("jum"),
												"ket_jurnal" => $this->input->post("ket"),
												'outlet_id' => $this->session->userdata('id')
											);
						$this->Model_general->insertData("ak_jurnal",$param_jurnal);
						$status = "Approved";
						$export = "Yes";
					}else{
						$status = "Approval";
						$export = "No";
					}
					
					$param_kas = array("id_keluar" => $this->input->post("item"),
									"id_pegawai" => $this->input->post("nip"),
									"jum_keluar" => $this->input->post("jum"),
									"tgl_keluar" => date("Y/m/d H:i:s"),
									"ket_keluar" => $this->input->post("ket"),
									"status_keluar" => $status,
									"outlet_id" => $this->session->userdata("id"),
									"export" => $export
								);
					$this->Model_general->insertData("sx_pengeluaran",$param_kas);
					
					redirect ( $this->mza_secureurl->setSecureUrl_encode("kas","input",array("NO")) );
				}else{
					$this->input("NIP");
				}
			}else{
				$this->input("NIP");
			}
		}
	}
	function app_keluar($id_keluar){
		$query = $this->Model_general->getDataBy("wl_pegawai","nip",$this->input->post("nip"));
		if($query->num_rows() > 0){
			$data = $query->row();
			$pass = sha1($this->input->post("pass"));
			if($data->position_id == 4 && $data->pass_pegawai == $pass){
				if($this->input->post("approve") == 1){
					$ambil = $this->Model_laundry->ambilKeluarBy("id_keluar",$id_keluar)->row();
					$param_jurnal = array("tgl_jurnal" => $ambil->tgl_keluar,
											"debit_jurnal" => $ambil->nama_akun,
											"jum_debit_jurnal" => $ambil->jum_keluar,
											"kredit_jurnal" => "Kas di Tangan",
											"jum_kredit_jurnal" => $ambil->jum_keluar,
											"ket_jurnal" => $ambil->ket_keluar,
											'outlet_id' => $this->session->userdata('id')
										);
					$this->Model_general->insertData("ak_jurnal",$param_jurnal);
					$this->Model_general->updateData("sx_pengeluaran","id_keluar",$id_keluar,array("status_keluar" => "Approved","export" => "Yes"));
				}else{
					$this->Model_general->deleteData("sx_pengeluaran","id_keluar",$id_keluar);
				}
				redirect ( $this->mza_secureurl->setSecureUrl_encode("kas","input",array("NO")) );
			}else{
				$this->input("NIP");
			}
		}else{
			$this->input("NIP");
		}
	}
	function tabelKas($from,$to){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="kasTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( array('data' => 'No', 'style' => 'width:3%;'), 'Tgl. Pengeluaran', 'Item', 'Jumlah', 'Pegawai', 'Status' );
		
		$i = 0;
		$query = $this->Model_laundry->ambilKeluarApp($this->session->userdata("id"));
		foreach ($query->result() as $row){
			$action = "<a id='app-button$i' class='confirm'>$row->status_keluar</a>";
			$jumlah = "Rp " . number_format($row->jum_keluar,0,',','.') . ",-";
			
			$this->table->add_row( ++$i, array('data' => $row->tgl_keluar, 'style' => 'width:15%'), $row->nama_akun, $jumlah, $row->nama_pegawai,
								array('data' => $action, 'style' => 'width:15%')  );
		}
		$query = $this->Model_laundry->ambilKeluar($from,$to,$this->session->userdata("id"));
		foreach ($query->result() as $row){
			$jumlah = "Rp " . number_format($row->jum_keluar,0,',','.') . ",-";
			
			$this->table->add_row( ++$i, array('data' => $row->tgl_keluar, 'style' => 'width:15%'), $row->nama_akun, $jumlah, $row->nama_pegawai,
								array('data' => $row->status_keluar, 'style' => 'width:15%')  );
		}
		return $this->table->generate();
	}
	
	function nabung($error){
		$data['content'] = 'main/activity/second/kas_nabung';
		$data['page_title'] = "Waroenk Laundry | Transfer Kas";
		$data['form_kas'] = site_url( $this->mza_secureurl->setSecureUrl_encode("kas","nabung_process") );
		$data['status_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode("kas","nabung",array("NO")) );
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("home","index",array("NO")) );
		$data['saldoKas'] = $this->ambilSaldo();
		$data['error'] = $error;
		
		if($error == "YES")
			$data["trans"] = $this->input->post("trans");
		
		$this->load->view('template', $data);
	}
	function nabung_process(){
		if ($this->form_validation->run("tTabung") == FALSE){
			$this->nabung("YES");
		}else{
			if( $this->input->post("trans") <= $this->input->post("saldo") ){
				$query = $this->Model_general->getDataBy("wl_pegawai","nip",$this->input->post("nip"));
				if($query->num_rows() > 0){
					$data = $query->row();
					$pass = sha1($this->input->post('pass'));
					if($data->position_id == 4 && $pass == $data->pass_pegawai){
						$ambil = $this->Model_general->getDataBy("master_akun","id_keluar",$this->input->post("item"))->row();
						$param_jurnal = array("tgl_jurnal" => date("Y/m/d H:i:s"),
												"debit_jurnal" => "Kas",
												"jum_debit_jurnal" => $this->input->post("trans"),
												"kredit_jurnal" => "Kas di Tangan",
												"jum_kredit_jurnal" => $this->input->post("trans"),
												"ket_jurnal" => "Transfer Kas di Tangan ke Bank",
												'outlet_id' => $this->session->userdata('id')
											);
						$this->Model_general->insertData("ak_jurnal",$param_jurnal);
						redirect ( $this->mza_secureurl->setSecureUrl_encode("kas","nabung",array("NO")) );
					}else{
						$this->nabung("NIP");
					}
				}else{
					$this->nabung("NIP");
				}
			}else{
				$this->nabung("SALDO");
			}
		}
	}
	function ambilSaldo(){
		$saldo = 0;
		$query = $this->Model_laundry->ambilSaldo($this->session->userdata("id"));
		foreach ($query->result() as $row){
			if('Kas di Tangan' == $row->kredit_jurnal)
				$nilai = 0 - $row->jum_kredit_jurnal;
			else if('Kas di Tangan' == $row->debit_jurnal)
				$nilai = $row->jum_debit_jurnal;
			$saldo = $saldo + $nilai;
		}
		return $saldo;
	}
	
	function histori($error){
		$data['content'] = 'main/activity/second/kas_history';
		$data['page_title'] = "Waroenk Laundry | Histori Kas";
		$data['form_jurnal'] = site_url( $this->mza_secureurl->setSecureUrl_encode('kas','histori',array($error)) );
		$data['error'] = $error;
		
		if($_POST==NULL){
			$from = date('Y/m/d');
			$to = date('Y/m/d');
			$jenis = "0";
		}else{
			$from = $this->input->post('dari');
			$to = $this->input->post('sampai');
			$jenis = $this->input->post('jenis');
		}
		$data['dari'] = $from;
		$data['sampai'] = $to;
		$data['jenis'] = $jenis;
		$data['tabelHistori'] = $this->tabelHistori($from,$to,$this->session->userdata('id'),'Kas di Tangan',$jenis);
		
		$this->load->view('template', $data);
	}
	function tabelHistori($from,$to,$outlet,$akun,$jenis){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table width="100%" id="histTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Tanggal', 'Uraian', 'Masuk','Keluar', 'Saldo' );
		
		$i = 0;
		$saldo = 0;
		$query = $this->Model_finance->ambilLRBy($from,$to,$outlet,$akun,$jenis);
		foreach ($query->result() as $row){
			if($akun == $row->kredit_jurnal){
				$debit = "";
				$kredit = "Rp " . number_format($row->jum_kredit_jurnal,0,',','.');
				$nilai = 0 - $row->jum_kredit_jurnal;
			}else if($akun == $row->debit_jurnal){
				$debit = "Rp " . number_format($row->jum_debit_jurnal,0,',','.');
				$kredit = "";
				$nilai = $row->jum_debit_jurnal;
			}
			
			if(strpos($akun,'Pendapatan') !== false){
				$saldo = $saldo - $nilai;
				$sdebit = "";
			}else{
				$saldo = $saldo + $nilai;
				$sdebit = "Rp " . number_format($saldo,0,',','.');
			}
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%'), array('data' => $row->tgl_jurnal, 'style' => 'width:12%'), $row->ket_jurnal,
								array('data' => $debit, 'style' => 'text-align:right;width:15%;'), array('data' => $kredit, 'style' => 'text-align:right;width:15%;'),
								array('data' => $sdebit, 'style' => 'text-align:right;width:15%;') );
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