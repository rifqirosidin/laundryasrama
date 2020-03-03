<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invest_finance extends CI_Controller {
	function __construct(){
		parent::__construct();	
		$this->check_logged_in();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_general','', TRUE);
		$this->load->model('Model_laundry','', TRUE);
		$this->load->model('Model_finance','', TRUE);
	}
	
	function index(){
		$data['content'] = 'invest/finance/ak_home';
		$data['page_title'] = "Waroenk Laundry | Keuangan";
		
		$this->load->view('invest/template', $data);
	}
	
	// JURNAL
	function jurnal($error){
		$data['content'] = 'invest/finance/ak_jurnal';
		$data['page_title'] = "Waroenk Laundry | Jurnal";
		$data['form_jurnal'] = site_url( $this->mza_secureurl->setSecureUrl_encode('invest_finance','jurnal',array($error)) );
		$data['dbout'] = $this->Model_general->getData("wl_outlet","outlet_code");
		$data['cetakJurnal'] = "";
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode('invest_finance','index') );
		$data['error'] = $error;
		
		if($_POST==NULL){
			$from = date('Y/m/d',strtotime(date('Y/m/d')."-1 months"));
			$to = date('Y/m/d');
		}else{
			$from = $this->input->post('dari');
			$to = $this->input->post('sampai');
		}
		$data['nama_outlet'] = $this->Model_general->getDataBy("wl_outlet","outlet_id",$this->session->userdata('out'))->row()->outlet_name;
		$data['dari'] = $from;
		$data['sampai'] = $to;
		$data['tabelJurnal'] = $this->tabelJurnal($from,$to,$this->session->userdata('out'));
		
		$this->load->view('invest/template', $data);
	}
	function tabelJurnal($from,$to,$outlet){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table width="80%" class="detail">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'Tanggal', 'Uraian', 'Debit', 'Kredit', 'Ket.' );
		
		if($outlet == 0)
			$query = $this->Model_finance->ambilJurnal($from,$to);
		else
			$query = $this->Model_finance->ambilJurnalBy($from,$to,$outlet);
		
		foreach ($query->result() as $row){
			$debit = "Rp " . number_format($row->jum_debit_jurnal,0,',','.');
			$kredit = "Rp " . number_format($row->jum_kredit_jurnal,0,',','.');
			$this->table->add_row( array('data' => $row->tgl_jurnal, 'style' => 'width:15%', 'rowspan' => '2'), array('data' => $row->debit_jurnal, 'style' => 'text-align:left'),
								array('data' => $debit, 'style' => 'text-align:right'), "", array('data' => $row->ket_jurnal, 'style' => 'width:30%', 'rowspan' => '2') );
			$this->table->add_row( array('data' => $row->kredit_jurnal, 'style' => 'text-align:right;width:30%'), "", array('data' => $kredit, 'style' => 'text-align:right') );
		}
		return $this->table->generate();
	}
	
	// BUKU BESAR
	function buku($error){
		$data['content'] = 'invest/finance/ak_buku';
		$data['page_title'] = "Waroenk Laundry | Buku Besar";
		$data['form_buku'] = site_url( $this->mza_secureurl->setSecureUrl_encode('invest_finance','buku',array($error)) );
		$data['dbkel'] = $this->Model_general->getData("master_akun","nama_akun");
		$data['cetakBuku'] = "";
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode('invest_finance','index') );
		$data['error'] = $error;
		
		if($_POST==NULL){
			$from = date('Y/m/d',strtotime(date('Y/m/d')."-1 months"));
			$to = date('Y/m/d');
			$akun = "Kas di Tangan";
		}else{
			$from = $this->input->post('dari');
			$to = $this->input->post('sampai');
			$akun = $this->input->post('akun');
		}
		$ambil = $this->Model_general->getDataBy("wl_outlet","outlet_id",$this->session->userdata('out'))->row();
		$data['nama_outlet'] = $ambil->outlet_name;
		$data['dari'] = $from;
		$data['sampai'] = $to;
		$data['akun'] = $akun;
		$data['tabelBuku'] = $this->tabelBuku($from,$to,$this->session->userdata('out'),$akun);
		
		$this->load->view('invest/template', $data);
	}
	function tabelBuku($from,$to,$outlet,$akun){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table width="100%" class="detail">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( array('data' => 'Tanggal', 'rowspan' => '2'), array('data' => 'Uraian', 'rowspan' => '2'),
									array('data' => 'Debit', 'rowspan' => '2'), array('data' => 'Kredit', 'rowspan' => '2'),
									array('data' => 'Saldo', 'colspan' => '2') );
		
		if($outlet == 0)
			$query = $this->Model_finance->ambilLR($from,$to,$akun);
		else
			$query = $this->Model_finance->ambilLRBy($from,$to,$outlet,$akun,0);
		
		$saldo = 0;
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
				$skredit = "Rp " . number_format($saldo,0,',','.');
			}else{
				$saldo = $saldo + $nilai;
				$sdebit = "Rp " . number_format($saldo,0,',','.');
				$skredit = "";
			}
			
			$this->table->add_row( array('data' => $row->tgl_jurnal, 'style' => 'width:12%'), $row->ket_jurnal,
								array('data' => $debit, 'style' => 'text-align:right;width:15%;'), array('data' => $kredit, 'style' => 'text-align:right;width:15%;'),
								array('data' => $sdebit, 'style' => 'text-align:right;width:15%;'), array('data' => $skredit, 'style' => 'text-align:right;width:15%;') );
		}
		return $this->table->generate();
	}
	
	// NERACA SALDO
	function neracaSaldo($error){
		$data['content'] = 'invest/finance/ak_nsaldo';
		$data['page_title'] = "Waroenk Laundry | Neraca Saldo";
		$data['form_neraca'] = site_url( $this->mza_secureurl->setSecureUrl_encode('invest_finance','neracaSaldo',array($error)) );
		$data['cetakNeraca'] = "";
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode('invest_finance','index') );
		$data['error'] = $error;
		$nama_outlet = "Semua Outlet";
		
		if($_POST==NULL){
			$from = date('Y/m/d',strtotime(date('Y/m/d')."-1 months"));
			$to = date('Y/m/d');
		}else{
			$from = $this->input->post('dari');
			$to = $this->input->post('sampai');
		}
		$ambil = $this->Model_general->getDataBy("wl_outlet","outlet_id",$this->session->userdata('out'))->row();
		$data['nama_outlet'] = $ambil->outlet_name;
		$data['dari'] = $from;
		$data['sampai'] = $to;
		$data['tabelNSaldo'] = $this->tabelNSaldo($from,$to,$this->session->userdata('out'));
		
		$this->load->view('invest/template', $data);
	}
	function tabelNSaldo($from,$to,$outlet){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table width="50%" class="detail">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		
		$i = 1; $debit = 0; $kredit = 0; $jdebit = 0; $jkredit = 0;
		$query = $this->Model_general->getData("master_akun","id_keluar");
		foreach ($query->result() as $get){
			if($outlet == 0)
				$dkk = $this->Model_finance->ambilJurnal($from,$to);
			else
				$dkk = $this->Model_finance->ambilJurnalBy($from,$to,$outlet);
			
			$saldo = 0;
			foreach ($dkk->result() as $row){
				if( $get->nama_akun == $row->kredit_jurnal )
					$saldo = $saldo + $row->jum_kredit_jurnal;
				else if( $get->nama_akun == $row->debit_jurnal )
					$saldo = $saldo - $row->jum_debit_jurnal;
			}
			if($i > 15)
				$kredit = $saldo;
			else
				$debit = $saldo;
			
			$jkredit = $jkredit + $kredit;
			$jdebit = $jdebit + $debit;
			
			$this->table->add_row( array('data' => $get->nama_akun, 'style' => 'text-align:left;'),
								array('data' => "Rp " . number_format(abs($debit),0,',','.'), 'style' => 'text-align:right;width:30%;'),
								array('data' => "Rp " . number_format(abs($kredit),0,',','.'), 'style' => 'text-align:right;width:30%;') );
			$i++;
		}
		$this->table->add_row( '',array('data' => "Rp " . number_format(abs($jdebit),0,',','.'), 'style' => 'text-align:right;width:30%;font-weight:bold;'),
								array('data' => "Rp " . number_format(abs($jkredit),0,',','.'), 'style' => 'text-align:right;width:30%;font-weight:bold;') );
		
		return $this->table->generate();
	}
	
	// LABA RUGI
	function labarugi($error){
		$data['content'] = 'invest/finance/ak_labarugi';
		$data['page_title'] = "Waroenk Laundry | Laba / Rugi";
		$data['form_lr'] = site_url( $this->mza_secureurl->setSecureUrl_encode('invest_finance','labarugi',array($error)) );
		$data['cetakLR'] = "";
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode('invest_finance','index') );
		$data['error'] = $error;
		$nama_outlet = "Semua Outlet";
		
		if($_POST==NULL){
			$from = date('Y/m/d',strtotime(date('Y/m/d')."-1 months"));
			$to = date('Y/m/d');
		}else{
			$from = $this->input->post('dari');
			$to = $this->input->post('sampai');
		}
		$ambil = $this->Model_general->getDataBy("wl_outlet","outlet_id",$this->session->userdata('out'))->row();
		$data['nama_outlet'] = $ambil->outlet_name;
		$data['dari'] = $from;
		$data['sampai'] = $to;
		$data['tabelLR'] = $this->tabelLR($from,$to,$this->session->userdata('out'));
		
		$this->load->view('invest/template', $data);
	}
	function tabelLR($from,$to,$outlet){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table width="50%" class="detail">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		
		$totalDpt = 0;
		$query = $this->Model_general->getDataBy("master_akun","jenis_akun",1);
		foreach ($query->result() as $get){
			if($outlet == 0)
				$dkk = $this->Model_finance->ambilLR($from,$to,$get->nama_akun);
			else
				$dkk = $this->Model_finance->ambilLRBy($from,$to,$outlet,$get->nama_akun,0);
			
			$saldo = 0;
			foreach ($dkk->result() as $row){
				if($row->debit_jurnal == $get->nama_akun)
					$saldo = $saldo - $row->jum_debit_jurnal;
				else
					$saldo = $saldo + $row->jum_kredit_jurnal;
			}
			$totalDpt = $totalDpt + $saldo;
			$this->table->add_row( array('data' => $get->nama_akun, 'colspan' => 2, 'style' => 'text-align:left;'),
									array('data' => "Rp " . number_format($totalDpt,0,',','.'), 'style' => 'text-align:right;width:30%;') );
		}
		
		$totalBeban = 0;
		$query = $this->Model_general->getDataBy("master_akun","jenis_akun",2);
		foreach ($query->result() as $get){
			if($outlet == 0)
				$dkk = $this->Model_finance->ambilLR($from,$to,$get->nama_akun);
			else
				$dkk = $this->Model_finance->ambilLRBy($from,$to,$outlet,$get->nama_akun,0);
			
			$saldo = 0;
			foreach ($dkk->result() as $row){
				if($row->debit_jurnal == $get->nama_akun)
					$saldo = $saldo - $row->jum_debit_jurnal;
				else
					$saldo = $saldo + $row->jum_kredit_jurnal;
			}
			$totalBeban = $totalBeban + $saldo;
			$this->table->add_row( array('data' => $get->nama_akun, 'style' => 'text-align:left;'),
									array('data' => "Rp " . number_format(abs($saldo),0,',','.'), 'style' => 'text-align:right;width:30%;'), "" );
		}
		$this->table->add_row( array('data' => 'Total Beban Operasional', 'colspan' => 2, 'style' => 'text-align:left;'),
									array('data' => "Rp " . number_format(abs($totalBeban),0,',','.'), 'style' => 'text-align:right;width:30%;') );
		
		$lbersih = $totalDpt - abs($totalBeban);
		$this->table->add_row( array('data' => "Laba Bersih", 'colspan' => 2, 'style' => 'text-align:left;'),
									array('data' => "Rp " . number_format($lbersih,0,',','.'), 'style' => 'text-align:right;width:30%;') );					
		
		$query = $this->Model_general->getDataBy("master_akun","jenis_akun",4);
		foreach ($query->result() as $get){
			if($outlet == 0)
				$dkk = $this->Model_finance->ambilLR($from,$to,$get->nama_akun);
			else
				$dkk = $this->Model_finance->ambilLRBy($from,$to,$outlet,$get->nama_akun,0);
			
			$saldo = 0;
			foreach ($dkk->result() as $row){
				$saldo = $saldo + $row->jum_kredit_jurnal;
			}
			$this->table->add_row( array('data' => $get->nama_akun, 'colspan' => 2, 'style' => 'text-align:left;'),
									array('data' => "Rp " . number_format($saldo,0,',','.'), 'style' => 'text-align:right;width:30%;') );
		}
		
		
		return $this->table->generate();
	}
	
	// NERACA
	function neraca($error){
		$data['content'] = 'invest/finance/ak_neraca';
		$data['page_title'] = "Waroenk Laundry | Neraca";
		$data['form_neraca'] = site_url( $this->mza_secureurl->setSecureUrl_encode('invest_finance','neraca',array($error)) );
		$data['cetakNeraca'] = "";
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode('invest_finance','index') );
		$data['error'] = $error;
		$nama_outlet = "Semua Outlet";
		
		if($_POST==NULL){
			$from = date('Y/m/d',strtotime(date('Y/m/d')."-1 months"));
			$to = date('Y/m/d');
		}else{
			$from = $this->input->post('dari');
			$to = $this->input->post('sampai');
		}
		$ambil = $this->Model_general->getDataBy("wl_outlet","outlet_id",$this->session->userdata('out'))->row();
		$data['nama_outlet'] = $ambil->outlet_name;
		$data['dari'] = $from;
		$data['sampai'] = $to;
		$data['tabelAset'] = $this->tabelAset($from,$to,$this->session->userdata('out'));
		$data['tabelWajib'] = $this->tabelWajib($from,$to,$this->session->userdata('out'));
		
		$this->load->view('invest/template', $data);
	}
	function tabelAset($from,$to,$outlet){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table width="49%" class="detail" style="float:left;">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		
		$jumAL = 0;
		$this->table->add_row( array('data' => 'ASET', 'style' => 'text-align:left;font-weight:bold;', 'colspan' => 2) );
		$this->table->add_row( array('data' => 'Aset Lancar', 'style' => 'text-align:left;font-weight:bold;', 'colspan' => 2) );
		$query = $this->Model_general->getDataBy("master_akun","id_master",1);
		foreach ($query->result() as $get){
			if($outlet == 0)
				$dkk = $this->Model_finance->ambilJurnal($from,$to);
			else
				$dkk = $this->Model_finance->ambilJurnalBy($from,$to,$outlet);
			
			$saldo = 0;
			foreach ($dkk->result() as $row){
				if( $get->nama_akun == $row->kredit_jurnal )
					$saldo = $saldo + $row->jum_kredit_jurnal;
				else if( $get->nama_akun == $row->debit_jurnal )
					$saldo = $saldo - $row->jum_debit_jurnal;
			}
			$jumAL = $jumAL + $saldo;
			$this->table->add_row( array('data' => $get->nama_akun, 'style' => 'text-align:left;'),
								array('data' => "Rp " . number_format(abs($saldo),0,',','.'), 'style' => 'text-align:right;width:30%;') );
		}
		$this->table->add_row( array('data' => 'Total Aset Lancar', 'style' => 'text-align:left;font-weight:bold;padding-left:35px'),
								array('data' => "Rp " . number_format(abs($jumAL),0,',','.'), 'style' => 'text-align:right;width:30%;font-weight:bold;') );
		
		$this->table->add_row( array('data' => '&nbsp', 'colspan' => 2) );
		
		$jumAT = 0;
		$this->table->add_row( array('data' => 'Aset Tetap', 'style' => 'text-align:left;font-weight:bold;', 'colspan' => 2) );
		$query = $this->Model_general->getDataBy("master_akun","id_master",2);
		foreach ($query->result() as $get){
			if($outlet == 0)
				$dkk = $this->Model_finance->ambilJurnal($from,$to);
			else
				$dkk = $this->Model_finance->ambilJurnalBy($from,$to,$outlet);
			
			$saldo = 0;
			foreach ($dkk->result() as $row){
				if( $get->nama_akun == $row->kredit_jurnal )
					$saldo = $saldo + $row->jum_kredit_jurnal;
				else if( $get->nama_akun == $row->debit_jurnal )
					$saldo = $saldo - $row->jum_debit_jurnal;
			}
			$jumAT = $jumAT + $saldo;
			$this->table->add_row( array('data' => $get->nama_akun, 'style' => 'text-align:left;'),
								array('data' => "Rp " . number_format(abs($saldo),0,',','.'), 'style' => 'text-align:right;width:30%;') );
		}
		$this->table->add_row( array('data' => 'Total Aset Tetap', 'style' => 'text-align:left;font-weight:bold;padding-left:35px'),
								array('data' => "Rp " . number_format(abs($jumAT),0,',','.'), 'style' => 'text-align:right;width:30%;font-weight:bold;') );
		
		$this->table->add_row( array('data' => '&nbsp', 'colspan' => 2) );
		
		$this->table->add_row( array('data' => 'TOTAL ASET', 'style' => 'text-align:left;font-weight:bold;'),
								array('data' => "Rp " . number_format(abs($jumAL + $jumAT),0,',','.'), 'style' => 'text-align:right;width:30%;font-weight:bold;') );
		
		return $this->table->generate();
	}
	function tabelWajib($from,$to,$outlet){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table width="49%" class="detail" style="float:right;">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		
		$jumST = 0;
		$this->table->add_row( array('data' => 'KEWAJIBAN', 'style' => 'text-align:left;font-weight:bold;', 'colspan' => 2) );
		$this->table->add_row( array('data' => 'Kewajiban Jangka Pendek', 'style' => 'text-align:left;font-weight:bold;', 'colspan' => 2) );
		$query = $this->Model_general->getDataBy("master_akun","id_master",3);
		foreach ($query->result() as $get){
			if($outlet == 0)
				$dkk = $this->Model_finance->ambilJurnal($from,$to);
			else
				$dkk = $this->Model_finance->ambilJurnalBy($from,$to,$outlet);
			
			$saldo = 0;
			foreach ($dkk->result() as $row){
				if( $get->nama_akun == $row->kredit_jurnal )
					$saldo = $saldo + $row->jum_kredit_jurnal;
				else if( $get->nama_akun == $row->debit_jurnal )
					$saldo = $saldo - $row->jum_debit_jurnal;
			}
			$jumST = $jumST + $saldo;
			$this->table->add_row( array('data' => $get->nama_akun, 'style' => 'text-align:left;'),
								array('data' => "Rp " . number_format(abs($saldo),0,',','.'), 'style' => 'text-align:right;width:30%;') );
		}
		$this->table->add_row( array('data' => 'Total Kewajiban Jangka Pendek', 'style' => 'text-align:left;font-weight:bold;padding-left:35px'),
								array('data' => "Rp " . number_format(abs($jumST),0,',','.'), 'style' => 'text-align:right;width:30%;font-weight:bold;') );
		
		$this->table->add_row( array('data' => '&nbsp', 'colspan' => 2) );
		
		$jumLT = 0;
		$this->table->add_row( array('data' => 'Kewajiban Jangka Panjang', 'style' => 'text-align:left;font-weight:bold;', 'colspan' => 2) );
		$query = $this->Model_general->getDataBy("master_akun","id_master",4);
		foreach ($query->result() as $get){
			if($outlet == 0)
				$dkk = $this->Model_finance->ambilJurnal($from,$to);
			else
				$dkk = $this->Model_finance->ambilJurnalBy($from,$to,$outlet);
			
			$saldo = 0;
			foreach ($dkk->result() as $row){
				if( $get->nama_akun == $row->kredit_jurnal )
					$saldo = $saldo + $row->jum_kredit_jurnal;
				else if( $get->nama_akun == $row->debit_jurnal )
					$saldo = $saldo - $row->jum_debit_jurnal;
			}
			$jumLT = $jumLT + $saldo;
			$this->table->add_row( array('data' => $get->nama_akun, 'style' => 'text-align:left;'),
								array('data' => "Rp " . number_format(abs($saldo),0,',','.'), 'style' => 'text-align:right;width:30%;') );
		}
		$this->table->add_row( array('data' => 'Total Kewajiban Jangka Panjang', 'style' => 'text-align:left;font-weight:bold;padding-left:35px'),
								array('data' => "Rp " . number_format(abs($jumLT),0,',','.'), 'style' => 'text-align:right;width:30%;font-weight:bold;') );
		
		$this->table->add_row( array('data' => '&nbsp', 'colspan' => 2) );
		
		$this->table->add_row( array('data' => 'TOTAL KEWAJIBAN', 'style' => 'text-align:left;font-weight:bold;'),
								array('data' => "Rp " . number_format(abs($jumST + $jumLT),0,',','.'), 'style' => 'text-align:right;width:30%;font-weight:bold;') );
								
		$this->table->add_row( array('data' => '&nbsp', 'colspan' => 2) );
		$this->table->add_row( array('data' => '&nbsp', 'colspan' => 2) );
		
		$jumEP = 0;
		$this->table->add_row( array('data' => 'EKUITAS PEMILIK', 'style' => 'text-align:left;font-weight:bold;', 'colspan' => 2) );
		$query = $this->Model_general->getDataBy("master_akun","id_master",5);
		foreach ($query->result() as $get){
			if($outlet == 0)
				$dkk = $this->Model_finance->ambilJurnal($from,$to);
			else
				$dkk = $this->Model_finance->ambilJurnalBy($from,$to,$outlet);
			
			$saldo = 0;
			foreach ($dkk->result() as $row){
				if( $get->nama_akun == $row->kredit_jurnal )
					$saldo = $saldo + $row->jum_kredit_jurnal;
				else if( $get->nama_akun == $row->debit_jurnal )
					$saldo = $saldo - $row->jum_debit_jurnal;
			}
			$jumEP = $jumEP + $saldo;
			$this->table->add_row( array('data' => $get->nama_akun, 'style' => 'text-align:left;'),
								array('data' => "Rp " . number_format(abs($saldo),0,',','.'), 'style' => 'text-align:right;width:30%;') );
		}
		$this->table->add_row( array('data' => 'TOTAL EKUITAS PEMILIK', 'style' => 'text-align:left;font-weight:bold;padding-left:35px'),
								array('data' => "Rp " . number_format(abs($jumEP),0,',','.'), 'style' => 'text-align:right;width:30%;font-weight:bold;') );
		
		$this->table->add_row( array('data' => '&nbsp', 'colspan' => 2) );
		$this->table->add_row( array('data' => '&nbsp', 'colspan' => 2) );
		$this->table->add_row( array('data' => '&nbsp', 'colspan' => 2) );
		
		$this->table->add_row( array('data' => 'TOTAL KEWAJIBAN DAN EKUITAS PEMILIK', 'style' => 'text-align:left;font-weight:bold;'),
								array('data' => "Rp " . number_format(abs($jumST + $jumLT + $jumEP),0,',','.'), 'style' => 'text-align:right;width:30%;font-weight:bold;') );
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