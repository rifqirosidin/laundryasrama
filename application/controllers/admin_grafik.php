<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_grafik extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->check_logged_in();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_general','', TRUE);
		$this->load->model('Model_laundry','', TRUE);
		$this->load->model('Model_user','', TRUE);
		$this->load->model('Model_sms','', TRUE);
		$this->load->model('Model_report','', TRUE);
	}
	
	function cuciArea(){
		$data['content'] = 'admin/laporan/g_Area';
		$data['page_title'] = "Waroenk Laundry | Frekuensi Transaksi";
		$data['dbarea'] = $this->Model_report->getArea();
		$data['g_form'] = site_url( $this->mza_secureurl->setSecureUrl_encode('admin_grafik','cuciArea') );
		$data['s_Send']= site_url( $this->mza_secureurl->setSecureUrl_encode('admin_grafik','cuciSend') );
		
		if($_POST==NULL){
			$area = -1;
			$from = date('Y/m/d',strtotime(date('Y/m/d')."-1 months"));
			$to = date('Y/m/d');
		}else{
			$area = $this->input->post('areanya');
			$from = $this->input->post('dari');
			$to = $this->input->post('sampai');
			$data['tableArea'] = $this->tableArea();
		}
		$get = $this->Model_general->getDataBy("wl_outlet","outlet_id",$this->session->userdata('out'))->row();
		$data['outlet'] = $get->outlet_name;
		$data['dari'] = $from;
		$data['sampai'] = $to;
		
		$perArea = $this->Model_report->getCuci($area,$from,$to,"Area");
		if($perArea->num_rows()>0){
			$i = 0;
			foreach($perArea->result() as $per){
				$data['db']['kdArea'][$i] = $per->area_code;
				$data['db']['trArea'][$i] = $this->Model_report->getCuci($per->id_area,$from,$to,"perArea");
				$i++;
			}
		}
		$this->load->view('admin/template', $data);
	}
	function tableArea(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="smsTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Kode Area', 'Nama Area', 'Transaksi' );
		
		$i = 0;
		$query = $this->Model_report->getArea();
		foreach($query->result() as $row){
			$count = 0;
			$trans = $this->Model_report->getCuci($row->id_area,$this->input->post('dari'),$this->input->post('sampai'),"perArea");
			foreach($trans->result() as $tr){
				$count = $count + 1;
			}
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'), array('data' => $row->area_code, 'style' => 'width:10%;'),
									array('data' => $row->area_name, 'style' => 'text-align:left;padding-left:10opx;'), array('data' => $count . "x", 'style' => 'width:10%;') );
			$i++;
		}
		return $this->table->generate();
	}
	function cuciProd(){
		$data['content'] = 'admin/laporan/g_Non';
		$data['page_title'] = "Waroenk Laundry | Frekuensi Transaksi";
		$data['dbarea'] = $this->Model_report->getArea();
		$data['g_form'] = site_url( $this->mza_secureurl->setSecureUrl_encode('admin_grafik','cuciProd') );
		$data['s_Send']= site_url( $this->mza_secureurl->setSecureUrl_encode('admin_grafik','cuciSend') );
		
		if($_POST==NULL){
			$area = -1;
			$from = date('Y/m/d',strtotime(date('Y/m/d')."-1 months"));
			$to = date('Y/m/d');
		}else{
			$area = $this->input->post('areanya');
			$from = $this->input->post('dari');
			$to = $this->input->post('sampai');
		}
		$get = $this->Model_general->getDataBy("wl_outlet","outlet_id",$this->session->userdata('out'))->row();
		$data['outlet'] = $get->outlet_name;
		$data['dari'] = $from;
		$data['sampai'] = $to;
		
		$perProduk = $this->Model_report->getCuci($area,$from,$to,"Produk");
		if($perProduk->num_rows()>0){
			$i = 0;
			foreach($perProduk->result() as $per){
				$data['db']['kdProd'][$i] = $per->item_non;
				$data['db']['trProd'][$i] = $this->Model_report->getCuci($per->item_non,$from,$to,"perProduk");
				$i++;
			}
		}
		
		$i = 0;
		$data['transProd'] = null;
		$query = $this->Model_report->getProduk();
		foreach($query->result() as $row){
			$j = 0; $jum = 0;
			$area = $this->Model_report->getArea();
			foreach($area->result() as $ar){
				$count = 0;
				$trans = $this->Model_report->getFTProd($row->kode_laundry,$ar->id_area,$this->input->post('dari'),$this->input->post('sampai'));
				if($trans->num_rows() > 0){
					foreach($trans->result() as $tr){
						$count = $count + 1;
					}
					$jum = $jum + $count;
					$data['transProd'] = 1;
				}
				$data['kodeArea'][$j] = $ar->area_code;
				$data['countTrans'][$i][$j] = $count;
				$j++;
			}
			$data['kodeProd'][$i] = $row->kode_laundry;
			$data['namaProd'][$i] = $row->nama_laundry;
			$data['totTrans'][$i] = $jum;
			$i++;
		}
		$this->load->view('admin/template', $data);
	}
	function cuciSend(){
		$query = $this->Model_report->getArea();
		foreach($query->result() as $row){
			if($this->input->post("area$row->id_area") == "Yes"){
				$member = $this->Model_general->getDataBy("wl_member","area_member",$row->id_area);
				if($member->num_rows()>0){
					foreach($member->result() as $mem){
						$this->sendSMS($mem->tlp_member,$this->input->post("isi"),date('Y-m-d',strtotime($this->input->post("tgl"))) . " 09:00:00");
					}
				}
				$nonmem = $this->Model_general->getDataBy("wl_member_non","area_non",$row->id_area);
				if($nonmem->num_rows()>0){
					foreach($nonmem->result() as $non){
						$this->sendSMS($non->tlp_non,$this->input->post("isi"),date('Y-m-d',strtotime($this->input->post("tgl"))) . " 09:00:00");
					}
				}
			}
		}
		redirect( $this->mza_secureurl->setSecureUrl_encode('admin_sms','outbox',array(0,'NO')) );
	}
	
	function cuciCust(){
		$data['content']="admin/laporan/g_Cust";
		$data['page_title'] = "Waroenk Laundry | Frekuensi Transaksi";
		$data['form_sms']= site_url( $this->mza_secureurl->setSecureUrl_encode('admin_grafik','cuciCust') );
		$data['form_crm']= site_url( $this->mza_secureurl->setSecureUrl_encode('admin_grafik','custSend') );
		$data['dbarea'] = $this->Model_report->getArea();
		
		if($_POST==NULL){
			$data['default']['area'] = -1;
			$data['default']['jum'] = 0;
			$data['default']['dari'] = date('Y/m/d');
			$data['default']['ke'] = date('Y/m/d');
		}else{
			$data['default']['member'] = $this->input->post('member');
			$data['default']['non'] = $this->input->post('non');
			$data['default']['area'] = $this->input->post('area');
			$data['default']['jum'] = $this->input->post('jum');
			$data['default']['dari'] = $this->input->post('dari');
			$data['default']['ke'] = $this->input->post('ke');
			$data['tableCust'] = $this->tableCust();
		}
		
		$this->load->view('admin/template', $data);
	}
	function custSend(){
		if($this->input->post('kmem') == "Yes"){
			$member = $this->Model_laundry->ambilMember($this->session->userdata('out'));
			foreach($member->result() as $mem){
				$count = 0;
				$tmember = $this->Model_report->getCust($mem->id_member,$this->input->post('kare'),$this->input->post('kdar'),$this->input->post('kake'));
				foreach($tmember->result() as $tmem){
					$count = $count + 1;
				}
				if($this->input->post('kope') == 1){
					if($count == $this->input->post('jum'))
						$this->sendSMS($mem->tlp_member,$this->input->post("isi"),date('Y-m-d',strtotime($this->input->post("tgl"))) . " 09:00:00");
				}else{
					if($this->input->post('kope') == 2){
						if($count > $this->input->post('jum'))
							$this->sendSMS($mem->tlp_member,$this->input->post("isi"),date('Y-m-d',strtotime($this->input->post("tgl"))) . " 09:00:00");
					}else{
						if($count < $this->input->post('jum'))
							$this->sendSMS($mem->tlp_member,$this->input->post("isi"),date('Y-m-d',strtotime($this->input->post("tgl"))) . " 09:00:00");
					}
				}
			}
		}
		if($this->input->post('non') == "Yes"){
			$nonmem = $this->Model_laundry->ambilCustomer($this->session->userdata('out'));
			foreach($nonmem->result() as $non){
				$count = 0;
				$tnonmem = $this->Model_report->getCust($non->id_non,$this->input->post('kare'),$this->input->post('kdar'),$this->input->post('kake'));
				foreach($tnonmem->result() as $tnon){
					$count = $count + 1;
				}
				if($this->input->post('kope') == 1){
					if($count == $this->input->post('jum'))
						$this->sendSMS($non->tlp_non,$this->input->post("isi"),date('Y-m-d',strtotime($this->input->post("tgl"))) . " 09:00:00");
				}else{
					if($this->input->post('kope') == 2){
						if($count > $this->input->post('jum'))
							$this->sendSMS($non->tlp_non,$this->input->post("isi"),date('Y-m-d',strtotime($this->input->post("tgl"))) . " 09:00:00");
					}else{
						if($count < $this->input->post('jum'))
							$this->sendSMS($non->tlp_non,$this->input->post("isi"),date('Y-m-d',strtotime($this->input->post("tgl"))) . " 09:00:00");
					}
				}
			}
		}
		redirect( $this->mza_secureurl->setSecureUrl_encode('admin_sms','outbox',array(0,'NO')) );
	}
	function tableCust(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="smsTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Nama', 'Membership', 'Transaksi' );
		
		$i = 0;
		if($this->input->post('member') == "Yes"){
			$member = $this->Model_laundry->ambilMember($this->session->userdata('out'));
			foreach($member->result() as $mem){
				$count = 0;
				$tmember = $this->Model_report->getCust($mem->id_member,$this->input->post('area'),$this->input->post('dari'),$this->input->post('ke'));
				foreach($tmember->result() as $tmem){
					$count = $count + 1;
				}
				$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'), array('data' => $mem->nama_member, 'style' => 'text-align:left;padding-left:10px;'),
										array('data' => "Member", 'style' => 'width:10%;'), array('data' => $count . "x", 'style' => 'width:10%;') );
			}
		}
		
		if($this->input->post('non') == "Yes"){
			$nonmem = $this->Model_laundry->ambilCustomer($this->session->userdata('out'));
			foreach($nonmem->result() as $non){
				$count = 0;
				$tnonmem = $this->Model_report->getCust($non->id_non,$this->input->post('area'),$this->input->post('dari'),$this->input->post('ke'));
				foreach($tnonmem->result() as $tnon){
					$count = $count + 1;
				}
				$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'), array('data' => $non->nama_non, 'style' => 'text-align:left;padding-left:10px;'),
										array('data' => "Non", 'style' => 'width:10%;'),array('data' => $count . "x", 'style' => 'width:10%;') );
			}
		}
		return $this->table->generate();
	}
	
	function krisan($id){
		$data['content'] = 'admin/laporan/g_Respon';
		$data['page_title'] = "Waroenk Laundry | Respon Pelanggan";
		$data['tableKris'] = $this->tabelKrisan();
		if($id > -1){
			$data['pesan'] = $this->Model_general->getDataBy("ad_shout","id_shout",$id)->row();
			$tlp = str_replace("+62","0",$data['pesan']->tlp_shout);
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
	function tabelKrisan(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="krisTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Jenis', 'Tgl. Masuk', 'Pengirim', 'Isi', 'Action' );
		
		$i = 0;
		$query = $this->Model_general->getData("ad_shout","tgl_shout");
		foreach ($query->result() as $row){
			$baca = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_grafik','krisan',array($row->id_shout)),' ',array('class' => 'view','title' => 'Baca') );
			$hapus = anchor( $this->mza_secureurl->setSecureUrl_encode('admin_grafik','delKrisan',array($row->id_shout)),' ',array('class' => 'delete','title' => 'Hapus','onclick' => 'return confirm(\'Hapus kritik / saran ini ?\')') );
			
			$tlp = str_replace("+62","0",$row->tlp_shout);
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
			
			if(strlen($row->isi_shout) > 50)
				$pesan = substr($row->isi_shout,0,50) . "...";
			else
				$pesan = $row->isi_shout;
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'), array('data' => $row->jenis_shout, 'style' => 'width:10%;'),
								array('data' => $row->tgl_shout, 'style' => 'width:15%;'), array('data' => $pengirim, 'style' => 'width:20%;'),
								array('data' => $pesan, 'style' => 'text-align:left;padding-left:10px;'), array('data' => $baca . $hapus, 'style' => 'width:5%;'));
		}
		return $this->table->generate();
	}
	function delKrisan($id){
		$this->Model_general->deleteData("ad_shout","id_shout",$id);
		redirect( $this->mza_secureurl->setSecureUrl_encode('admin_grafik','krisan',array(-1)) );
	}
	
	function statusTrans(){
		$data['content'] = 'admin/laporan/g_Status';
		$data['page_title'] = "Waroenk Laundry | Status Transaksi";
		$data['g_form'] = site_url( $this->mza_secureurl->setSecureUrl_encode('admin_grafik','statusTrans') );
		$from = $this->input->post('dari');
		$to = $this->input->post('sampai');
		if($from == NULL || $to == NULL){
			$from = date('Y/m/d',strtotime(date('Y/m/d')."-1 months"));
			$to = date('Y/m/d');
		}
		$get = $this->Model_general->getDataBy("wl_outlet","outlet_id",$this->session->userdata('out'))->row();
		$data['outlet'] = $get->outlet_name;
		$data['dari'] = $from;
		$data['sampai'] = $to;
		$data['tabelAktivitas'] = $this->tabelAktivitas($from,$to);
		$this->load->view('admin/template', $data);
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
		$this->table->set_heading( array('data' => 'No', 'width' => '3%'),'No. Resi', 'Nama Pelanggan', 'No. Tlp', 'Tgl Masuk', 'Jumlah',  'Status Bayar', 'Status' );
		
		$i = 0;
		$PENDING = $this->Model_laundry->ambilAktivitas("PENDING",$this->session->userdata('out'),$from,$to);
		foreach ($PENDING->result() as $row){
			if($row->kiloan == "Kiloan"){
				$jumlah = $row->jumlah_kiloan . " Kg";
			}else{
				$jumlah = $row->jumlah_kiloan . " Buah";
			}
			$this->table->add_row( ++$i, $row->resi, $row->nama, $row->no_tlp, $row->tgl_trans, $jumlah, $row->status_bayar, $row->status );
		}
		$CEKLIST = $this->Model_laundry->ambilAktivitas("CEKLIST",$this->session->userdata('out'),$from,$to);
		foreach ($CEKLIST->result() as $row){
			if($row->kiloan == "Kiloan"){
				$jumlah = $row->jumlah_kiloan . " Kg";
			}else{
				$jumlah = $row->jumlah_kiloan . " Buah";
			}
			$this->table->add_row( ++$i, $row->resi, $row->nama, $row->no_tlp, $row->tgl_trans, $jumlah, $row->status_bayar, $row->status );
		}
		$WASHING = $this->Model_laundry->ambilAktivitas("WASHING",$this->session->userdata('out'),$from,$to);
		foreach ($WASHING->result() as $row){
			if($row->kiloan == "Kiloan"){
				$jumlah = $row->jumlah_kiloan . " Kg";
			}else{
				$jumlah = $row->jumlah_kiloan . " Buah";
			}
			$this->table->add_row( ++$i, $row->resi, $row->nama, $row->no_tlp, $row->tgl_trans, $jumlah, $row->status_bayar, $row->status );
		}
		$DRYING = $this->Model_laundry->ambilAktivitas("DRYING",$this->session->userdata('out'),$from,$to);
		foreach ($DRYING->result() as $row){
			if($row->kiloan == "Kiloan"){
				$jumlah = $row->jumlah_kiloan . " Kg";
			}else{
				$jumlah = $row->jumlah_kiloan . " Buah";
			}
			$this->table->add_row( ++$i, $row->resi, $row->nama, $row->no_tlp, $row->tgl_trans, $jumlah, $row->status_bayar, $row->status );
		}
		$SIAP = $this->Model_laundry->ambilAktivitas("SIAP AMBIL",$this->session->userdata('out'),$from,$to);
		foreach ($SIAP->result() as $row){
			if($row->kiloan == "Kiloan"){
				$jumlah = $row->jumlah_kiloan . " Kg";
			}else{
				$jumlah = $row->jumlah_kiloan . " Buah";
			}
			$this->table->add_row( ++$i, $row->resi, $row->nama, $row->no_tlp, $row->tgl_trans, $jumlah, $row->status_bayar, $row->status );
		}
		$DELIVERY = $this->Model_laundry->ambilAktivitas("DELIVERY",$this->session->userdata('out'),$from,$to);
		foreach ($DELIVERY->result() as $row){
			if($row->kiloan == "Kiloan"){
				$jumlah = $row->jumlah_kiloan . " Kg";
			}else{
				$jumlah = $row->jumlah_kiloan . " Buah";
			}
			$this->table->add_row( ++$i, $row->resi, $row->nama, $row->no_tlp, $row->tgl_trans, $jumlah, $row->status_bayar, $row->status );
		}
		$SELESAI = $this->Model_laundry->ambilAktivitas("SELESAI",$this->session->userdata('out'),$from,$to);
		foreach ($SELESAI->result() as $row){
			if($row->kiloan == "Kiloan"){
				$jumlah = $row->jumlah_kiloan . " Kg";
			}else{
				$jumlah = $row->jumlah_kiloan . " Buah";
			}
			$this->table->add_row( ++$i, $row->resi, $row->nama, $row->no_tlp, $row->tgl_trans, $jumlah, $row->status_bayar, $row->status );
		}
		return $this->table->generate();
	}
	
	function omset(){
		$data['content'] = 'admin/laporan/g_Omset';
		$data['page_title'] = "Waroenk Laundry | Laporan";
		$data['g_form'] = site_url( $this->mza_secureurl->setSecureUrl_encode('admin_grafik','omset') );
		
		if($_POST==NULL){
			$from = date('Y/m/d',strtotime(date('Y/m/d')."-1 months"));
			$to = date('Y/m/d');
		}else{
			$from = $this->input->post('dari');
			$to = $this->input->post('sampai');
		}
		$get = $this->Model_general->getDataBy("wl_outlet","outlet_id",$this->session->userdata('out'))->row();
		$data['outlet'] = $get->outlet_name;
		$data['dari'] = $from;
		$data['sampai'] = $to;
		
		$data['db'] = null;
		$jurnal = $this->Model_report->getOmset($from,$to);
		if($jurnal->num_rows()>0){
			$i = 0;
			$a = 0;
			foreach($jurnal->result() as $jur){
				$data['db']['tgl'][$a] = $jur->tgl_jurnal;
				$data['db']['cuci'][$a] = $this->Model_report->getOmsetOn($jur->tgl_jurnal);
				$omset = $this->Model_report->getOmsetGroup($jur->tgl_jurnal)->result();
				
				foreach($omset as $oms){
					$data['db']['date'][$i] = $oms->tgl_jurnal;
					$data['db']['area'][$i] = $oms->outlet_code;
					$ambilOmset = $this->Model_report->countOmset($oms->tgl_jurnal)->row();
					$data['db']['omset'][$i] = $ambilOmset->omset;
					$i++;
				}
				$a++;
			}
		}
		$this->load->view('admin/template', $data);
	}
	
	function kinerja(){
		$data['content'] = 'admin/laporan/g_kinerja';
		$data['page_title'] = "Waroenk Laundry | Laporan";
		$data['dbPegawai'] = $this->Model_user->get_pegawai($this->session->userdata('out'));
		$data['kinerja_f'] = site_url( $this->mza_secureurl->setSecureUrl_encode("admin_grafik","kinerja") );
		$nip = $this->input->post('nip');
		$periode = $this->input->post('periode');
		if($nip == NULL || $periode == NULL){
			$get = $this->Model_general->getDataBy("wl_outlet","outlet_id",$this->session->userdata('out'))->row();
			$nip = $get->outlet_code."01";
			$periode = date('Y/m');
		}
		$data['tabelMain'] = $this->tabelMain($nip,$periode);
		$data['tabelSupport'] = $this->tabelSupport($nip,$periode);
		$data['periode'] = $periode;
		$data['nip'] = $nip;
		$data['bulan'] = date("F Y", strtotime("$periode/01"));
		
		$this->load->view('admin/template', $data);
	}
	function tabelMain($nip,$periode){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table class="detail" width="100%">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'Tgl', array('data' => 'Kasir', 'style' => 'width:13%;'),
									array('data' => 'Ceklist', 'style' => 'width:13%;'),
									array('data' => 'Cuci', 'style' => 'width:13%;'),
									array('data' => 'Kering', 'style' => 'width:13%;'),
									array('data' => 'Setrika', 'style' => 'width:13%;'),
									array('data' => 'Ambil', 'style' => 'width:13%;'),
									array('data' => 'Delivery', 'style' => 'width:13%;') );
		
		$jtrans = 0; $jcek = 0; $jcuci = 0; $jkering = 0; $jpack = 0; $jambil = 0; $jdeliver = 0;
		$days = cal_days_in_month(CAL_GREGORIAN, substr($periode, 5, 2), substr($periode, 0, 4));
		for($i=1;$i<=$days;$i++){
			if($i<10){
				$trans = $this->Model_report->mainKinerja("trans","$periode/0$i",$nip,"sx_job_monitor");
				$cek = $this->Model_report->mainKinerja("cek","$periode/0$i",$nip,"sx_job_monitor");
				$cuci = $this->Model_report->mainKinerja("cuci","$periode/0$i",$nip,"sx_job_cuker");
				$kering = $this->Model_report->mainKinerja("kering","$periode/0$i",$nip,"sx_job_cuker");
				$pack = $this->Model_report->mainKinerja("pack","$periode/0$i",$nip,"sx_job_monitor");
				$ambil = $this->Model_report->mainKinerja("ambil","$periode/0$i",$nip,"sx_job_monitor");
				$deliver = $this->Model_report->mainKinerja("deliver","$periode/0$i",$nip,"sx_job_monitor");
			}else{
				$trans = $this->Model_report->mainKinerja("trans","$periode/$i",$nip,"sx_job_monitor");
				$cek = $this->Model_report->mainKinerja("cek","$periode/$i",$nip,"sx_job_monitor");
				$cuci = $this->Model_report->mainKinerja("cuci","$periode/$i",$nip,"sx_job_cuker");
				$kering = $this->Model_report->mainKinerja("kering","$periode/$i",$nip,"sx_job_cuker");
				$pack = $this->Model_report->mainKinerja("pack","$periode/$i",$nip,"sx_job_monitor");
				$ambil = $this->Model_report->mainKinerja("ambil","$periode/$i",$nip,"sx_job_monitor");
				$deliver = $this->Model_report->mainKinerja("deliver","$periode/$i",$nip,"sx_job_monitor");
			}
			$jtrans = $jtrans + $trans;
			$jcek = $jcek + $cek;
			$jcuci = $jcuci + $cuci;
			$jkering = $jkering + $kering;
			$jpack = $jpack + $pack;
			$jambil = $jambil + $ambil;
			$jdeliver = $jdeliver + $deliver;
			$this->table->add_row( $i, $trans,$cek,$cuci,$kering,$pack,$ambil,$deliver);
		}
		$this->table->add_row( array('data' => 'TOTAL', 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'),
							array('data' => $jtrans, 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'),
							array('data' => $jcek, 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'),
							array('data' => $jcuci, 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'),
							array('data' => $jkering, 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'),
							array('data' => $jpack, 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'),
							array('data' => $jambil, 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'),
							array('data' => $jdeliver, 'style' => 'font-weight:bold;background:#8BD23F;color:#fff;'));
		return $this->table->generate();
	}
	function tabelSupport($nip,$periode){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table class="detail" width="100%">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( array('data' => 'Tgl', 'style' => 'width:15%;'),array('data' => 'Jam', 'style' => 'width:15%;'),
								array('data' => 'Aset', 'style' => 'width:20%;'),'Perawatan',array('data' => 'Keterangan', 'style' => 'width:30%;') );
		
		$days = cal_days_in_month(CAL_GREGORIAN, substr($periode, 5, 2), substr($periode, 0, 4));
		$query = $this->Model_report->suppKinerja("$periode/01","$periode/$days",$nip);
		foreach($query->result() as $row){
			$this->table->add_row( date("d M",strtotime($row->tgl_rawat)),$row->jam_rawat,
								array('data' => $row->nama_jenis . " " . substr($row->kode_aset,-2), 'style' => 'text-align:left;'),$row->perawatan,
								array('data' => $row->cat_rawat, 'style' => 'text-align:left;'));
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