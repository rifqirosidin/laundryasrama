<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller {
	function __construct(){
		parent::__construct();	
		$this->check_logged_in();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_general','', TRUE);
		$this->load->model('Model_user','', TRUE);
		$this->load->model('Model_laundry','', TRUE);
	}
	
	function index(){
		$data['content'] = 'main/setting/setting_view';
		$data['page_title'] = "Waroenk Laundry | Konfigurasi";
		
		$data['table_laundry'] = $this->create_table_laundry();
		$data['table_pewangi'] = $this->create_table_pewangi();
		$data['table_promo'] = $this->create_table_promo();
		$data['table_pegawai'] = $this->create_table_pegawai();
		$data['table_upload'] = $this->create_table_upload();
		
		$this->load->view('template', $data);
	}
	
	// MASTER LAUNDRY
	function laundry_form($id,$status,$error){
		$data['page_title']="Waroenk Laundry | Konfigurasi - Laundry";
		$data['content']='main/setting/laundry_form';
		$data['form_laundry']= site_url( $this->mza_secureurl->setSecureUrl_encode('setting','laundry_process',array($id,$status)) );
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('setting','index'),'Kembali',array('class' => 'back') );
		$data['error']=$error;
		$data['tLegend']=$status;
		
		if($status == 'Ubah'){
			$laundry = $this->Model_general->getDataBy("wl_laundry","id_laundry",$id)->row();
			$data['default']['kode'] = $laundry->kode_laundry;
			$data['default']['nama'] = $laundry->nama_laundry;
			$data['default']['harga'] = $laundry->harga_laundry;
			$data['default']['jenis'] = $laundry->jenis;
		} else {
			if ( $error == 'YES' ){
				$data['default']['kode'] = $this->input->post('kode');
				$data['default']['nama'] = $this->input->post('nama');
				$data['default']['harga'] = $this->input->post('harga');
				$data['default']['jenis'] = $this->input->post('jenis');
			}
		}
		$data['default']['outlet'] = $this->session->userdata('id');

		$this->load->view('template', $data);
	}
	function laundry_process($id,$status) {
		if ($this->form_validation->run("fLaundry") == FALSE){
			$this->laundry_form($id,$status,"YES");
		} else {
			$param_laundry = array('harga_laundry' => $this->input->post('harga'),
									'outlet_id' => $this->input->post('outlet')
					);
			$this->Model_general->updateData("wl_laundry","id_laundry",$id,$param_laundry);
			
			redirect( $this->mza_secureurl->setSecureUrl_encode('setting','index') );
		}
	}
	function create_table_laundry(){
		$query = $this->Model_general->getDataBy("wl_laundry","outlet_id",$this->session->userdata('id'));
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="laundryTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Kode Layanan', 'Nama Layanan', 'Jenis Layanan', 'Harga' );
		
		$i = 0;
		foreach ($query->result() as $row){
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'),
								array('data' =>$row->kode_laundry, 'style' => 'width:15%;'),
								array('data' => $row->nama_laundry, 'style' => 'text-align:left;padding-left:10px;'),
								array('data' => $row->jenis, 'style' => 'width:20%;'),
								array('data' => number_format($row->harga_laundry,0,',','.'), 'style' => 'text-align:right;padding-right:10px;') );
		}
		return $this->table->generate();
	}
	
	// MASTER PEWANGI
	function create_table_pewangi(){
		$query = $this->Model_general->getDataBy("wl_pewangi","outlet_id",$this->session->userdata('id'));
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="pewangiTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Kode Pewangi', 'Nama Pewangi' );
		
		$i = 0;
		foreach ($query->result() as $row){
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'),
								array('data' => $row->kode_pewangi, 'style' => 'width:15%;'),
								array('data' => $row->nama_pewangi, 'style' => 'text-align:left;padding-left:10px;') );
		}
		return $this->table->generate();
	}
	
	// MASTER PROMO
	function create_table_promo(){
		$query = $this->Model_general->getData("wl_promo","jenis_promo");
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="promoTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Kode Promo', 'Nama Promo', 'Tgl Mulai', 'Tgl Berakhir', 'Jenis Promo', 'Potongan', 'Status' );
		
		$i = 0;
		foreach ($query->result() as $row){
			$status = "Tidak Aktif";
			
			if($row->status_promo == "Ya")
				$status = "Aktif";
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'),
								array('data' => $row->kode_promo, 'style' => 'width:20%;'),
								array('data' => $row->nama_promo, 'style' => 'text-align:left;padding-left:10px;'),
								array('data' => $row->tgl_mulai, 'style' => 'width:10%;'),array('data' => $row->tgl_akhir, 'style' => 'width:10%;'),
								array('data' => $row->jenis_promo, 'style' => 'width:10%;'), array('data' => number_format($row->jumlah,1,',','.'), 'style' => 'width:10%;'),
								array('data' => $status, 'style' => 'width:7%;') );
		}
		return $this->table->generate();
	}
	
	// PEGAWAI
	function pegawai_detail($pegawai_id){
		$data['page_title']="Waroenk Laundry | Konfigurasi - Pegawai";
		$data['content']='main/setting/pegawai_detail';
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('setting','index'),'Kembali',array('class' => 'back') );
		$data['pegawai'] = $this->Model_user->get_pegawai_by("id_pegawai",$pegawai_id)->row();
		
		$this->load->view('template',$data);
	}
	function create_table_pegawai(){
		$query = $this->Model_user->get_pegawai_by("outlet_id",$this->session->userdata('id'));
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="pegawaiTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Nama', 'No. Tlp', 'Jabatan' );
		
		$i = 0;
		foreach ($query->result() as $row){
			$link = anchor( $this->mza_secureurl->setSecureUrl_encode('setting','pegawai_detail',array($row->id_pegawai)) , $row->nama_pegawai );
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'), array('data' => $link, 'style' => 'text-align:left;text-indent:10px;'),
									array('data' => $row->tlp_pegawai, 'style' => 'width:20%;'), $row->position_name  );
		}
		return $this->table->generate();
	}
	
	// TABLE UPLOAD
	function create_table_upload(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table class="listsatu" style="width:50%">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( array('data' => 'No', 'style' => 'width:5%;'),'Data',array('data' => 'Upload', 'style' => 'width:25%;'));
		
		$i=0;
		$exp = $this->Model_general->countDataWhere("sx_aktivitas","outlet_id = " . $this->session->userdata('id') . " AND export = 'Yes'");
		$this->table->add_row( ++$i, array('data' => 'Transaksi', 'style' => 'text-align:left;padding-left:15px;') , $exp );
		
		$exp = $this->Model_general->countDataWhere("wl_member","outlet_id = " . $this->session->userdata('id') . " AND export = 'Yes'");
		$this->table->add_row( ++$i, array('data' => 'Member', 'style' => 'text-align:left;padding-left:15px;') , $exp );
		
		$exp = $this->Model_general->countDataWhere("wl_member_non","outlet_id = " . $this->session->userdata('id') . " AND export = 'Yes'");
		$this->table->add_row( ++$i, array('data' => 'Non Member', 'style' => 'text-align:left;padding-left:15px;') , $exp );
		
		$exp = $this->Model_general->countDataWhere("wl_pegawai_absen","outlet_id = " . $this->session->userdata('id') . " AND export = 'Yes'");
		$this->table->add_row( ++$i, array('data' => 'Absen Pegawai', 'style' => 'text-align:left;padding-left:15px;') , $exp );
		
		$exp = $this->Model_general->countDataWhere("master_admin_pesan","outlet_id = " . $this->session->userdata('id') . " AND export = 'Yes'");
		$this->table->add_row( ++$i, array('data' => 'Pesan', 'style' => 'text-align:left;padding-left:15px;') , $exp );
		
		$exp = $this->Model_general->countDataWhere("sx_perawatan","outlet_id = " . $this->session->userdata('id') . " AND export = 'Yes'");
		$this->table->add_row( ++$i, array('data' => 'Perawatan Mesin / Aset', 'style' => 'text-align:left;padding-left:15px;') , $exp );
		
		$exp = $this->Model_general->countDataWhere("sx_stock","outlet_id = " . $this->session->userdata('id') . " AND export = 'Yes'");
		$this->table->add_row( ++$i, array('data' => 'Inventori', 'style' => 'text-align:left;padding-left:15px;') , $exp );
		
		$exp = $this->Model_general->countDataWhere("sx_pengeluaran","outlet_id = " . $this->session->userdata('id') . " AND export = 'Yes'");
		$this->table->add_row( ++$i, array('data' => 'Pengeluaran', 'style' => 'text-align:left;padding-left:15px;') , $exp );
		
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
			if( $this->session->userdata('user') !== "USER" ){
				redirect( $this->mza_secureurl->setSecureUrl_encode('login','logout'), 'refresh' );
			}
		}
	}
	
}