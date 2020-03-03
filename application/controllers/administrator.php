<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends CI_Controller {
	function __construct(){
		parent::__construct();	
		$this->check_logged_in();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_general','', TRUE);
		$this->load->model('Model_user','', TRUE);
		$this->load->model('Model_laundry','', TRUE);
	}
	
	function index(){
		redirect($this->mza_secureurl->setSecureUrl_encode('administrator','outlet_form',array(3,"Ubah","NO")));
	}
	
	// OUTLET
	function outlet($outlet){
		$data['content'] = 'admin/setting/setting_outlet';
		$data['page_title'] = "Waroenk Laundry | Administrator";
		$this->load->view('admin/template', $data);
	}
	function ganti_outlet(){
		$this->session->set_userdata(array('out' => $this->input->post('outlet')));
		redirect($this->mza_secureurl->setSecureUrl_encode( 'administrator','outlet_form',array($this->input->post('outlet'),"Ubah","NO") ));
	}
	function outlet_form($outlet,$status,$error){
		if($status == "Tambah" || $status == "Pass")
			$status = "Ubah";
			
		$data['page_title'] = "Waroenk Laundry | Administrator - Outlet";
		$data['content'] = 'admin/setting/outlet_form';
		$data['error'] = $error;
		$data['dbzona'] = $this->Model_general->getData("zona","zona_name");
		$data['dbcity'] = $this->Model_general->getData("zona_city","city_name");
		$data['dbarea'] = $this->Model_general->getData("zona_area","area_name");
		$data['tabelCakupan'] = $this->tabelCakupan($outlet);
		$data['tabelArea'] = $this->create_table_area();
		$data['tLegend'] = $status;
		$data['add_out']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','outlet_process',array($outlet,'Tambah')) );
		$data['form_outlet']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','outlet_process',array($outlet,$status)) );
		$data['form_pass']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','outlet_process',array($outlet,"Pass")) );
		$data['form_cakupan']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','tambahCakupan',array($outlet)) );
		$data['set_area']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','area',array($outlet)) );
		
		$data['idOut'] = $outlet;
		if ( $error == 'YES' ){
			$data['default']['name'] = $this->input->post('name');
			$data['default']['address'] = $this->input->post('address');
			$data['default']['phone'] = $this->input->post('phone');
			$data['jmember'] = $this->input->post('jmember');
			$data['default']['foot'] = $this->input->post('foot');
			$data['default']['username'] = $this->input->post('username');
			$data['default']['zona'] = $this->input->post('zona');
			$data['default']['city'] = $this->input->post('city');
			$data['default']['area'] = $this->input->post('area');
			$data['default']['ccity'] = $this->input->post('ccity');
			$data['dbcarea'] = $this->Model_general->getDataBy("zona_area","id_city",$this->input->post('ccity'));
		}else{
			$koutlet = $this->Model_general->getDataBy("wl_outlet","outlet_id",$outlet)->row();
			$data['default']['name'] = $koutlet->outlet_name;
			$data['default']['address'] = $koutlet->outlet_address;
			$data['default']['phone'] = $koutlet->outlet_phone;
			$data['jmember'] = $koutlet->jmember;
			$data['default']['foot'] = $koutlet->footer;
			$data['default']['username'] = $koutlet->username;
			$zona = $this->Model_laundry->ambilOutletBy("outlet_id",$koutlet->outlet_id)->row();
			$data['ccity'] = $zona->id_city;
			$data['dbcarea'] = $this->Model_general->getDataBy("zona_area","id_city",$zona->id_city);
		}

		$this->load->view('admin/template', $data);
	}
	function outlet_process($outlet,$status) {
		$validation = "fOutlet" . $status;
		if ($this->form_validation->run($validation) == FALSE){
			$this->outlet_form($outlet,$status,"YES");
		} else {
			if($status == 'Tambah'){
				$param_outlet = array('outlet_name' => $this->input->post('name'),
									'outlet_code' => $this->input->post('code'),
									'area_code' => $this->input->post('area'),
									'outlet_address' => $this->input->post('address'),
									'outlet_phone' => $this->input->post('phone'),
									'jmember' => $this->input->post('jmember'),
									'footer' => $this->input->post('foot'),
									'username' => $this->input->post('username'),
									'pass' => sha1($this->input->post('pass'))
						);
				$this->Model_general->insertData("wl_outlet",$param_outlet);
				
				$ambil = $this->Model_general->getDataBy("wl_outlet","outlet_code",$this->input->post('code'))->row();
				$laundry = $this->Model_general->getDataBy("wl_laundry","outlet_id",3);
				foreach($laundry->result() as $row){
					$param_laundry = array('kode_laundry' => $row->kode_laundry,
											'nama_laundry' => $row->nama_laundry,
											'harga_laundry' => $row->harga_laundry,
											'jenis' => $row->jenis,
											'outlet_id' => $ambil->outlet_id
							);
					$this->Model_general->insertData("wl_laundry",$param_laundry);
				}
				redirect( $this->mza_secureurl->setSecureUrl_encode('admin_login','logout'), 'refresh' );
			}else{
				if($status == 'Ubah'){
					$param_outlet = array('outlet_name' => $this->input->post('name'),
									'outlet_address' => $this->input->post('address'),
									'outlet_phone' => $this->input->post('phone'),
									'jmember' => $this->input->post('jmember'),
									'footer' => $this->input->post('foot'),
									'username' => $this->input->post('username')
							);
					$this->Model_general->updateData("wl_outlet","outlet_id",$outlet,$param_outlet);
				}else{
					$param_outlet = array( 'pass' => sha1($this->input->post('pass')) );
					$this->Model_general->updateData("wl_outlet","outlet_id",$outlet,$param_outlet);
				}
				redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','outlet_form',array($outlet,$status,"NO")) );
			}
		}
	}
	function delete_outlet($outlet){
		$this->Model_general->deleteData("wl_outlet","outlet_id",$outlet);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','outlet',array($outlet)) );
	}
	function create_table_outlet(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="outletTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Kode Outlet', 'Nama Outlet', 'No. Telpon', 'Zona', 'Action' );
		
		$i = 0;
		$query = $this->Model_laundry->ambilOutlet();
		foreach ($query->result() as $row){
			$action = anchor($this->mza_secureurl->setSecureUrl_encode('administrator','outlet_form',array($row->outlet_id,"Ubah","NO")),'Ubah',array('class' => 'edit'));
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'),array('data' => $row->outlet_code, 'style' => 'width:12%;'),
								array('data' => $row->outlet_name, 'style' => 'width:35%;text-align:left;padding-left:10px;'),
								array('data' => $row->outlet_phone, 'style' => 'width:15%;'), array('data' => $row->zona_name, 'style' => 'width:25%;'), $action );
		}
		return $this->table->generate();
	}
	function tambahCakupan($outlet){
		$param_cakupan = array('outlet_id' => $outlet,
							'area_id' => $this->input->post('carea')
						);
		$this->Model_general->insertData("wl_outlet_area",$param_cakupan);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','outlet_form',array($outlet,"Ubah","NO")) );
	}
	function delete_cakupan($id_cakupan,$outlet){
		$this->Model_general->deleteData("wl_outlet_area","id_ot_area",$id_cakupan);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','outlet_form',array($outlet,"Ubah","NO")) );
	}
	function tabelCakupan($outlet){
		$query = $this->Model_laundry->ambilCakupanBy("outlet_id",$outlet);
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="cakupanTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Kota', 'Area', 'Action' );
		
		$i = 0;
		foreach ($query->result() as $row){
			$link = anchor($this->mza_secureurl->setSecureUrl_encode('administrator','delete_cakupan',array($row->id_ot_area,$row->outlet_id)),"Hapus",array("class" => "delete"));
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'),
								array('data' => $row->city_name, 'style' => 'width:20%;'), array('data' => $row->area_name, 'style' => 'text-align:left;padding-left:10px;'),
								array('data' => $link, 'style' => 'width:12%;') );
		}
		return $this->table->generate();
	}
	
	// AREA
	function area($outlet) {
		$param_area = array('area_code' => $this->input->post('kode_area'),
						'area_name' => $this->input->post('nama_area'),
						'id_city' => $this->input->post('city_id')
					);
		$this->Model_general->insertData("zona_area",$param_area);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','outlet_form',array($outlet,"Ubah","NO")) );
	}
	function create_table_area(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table class="uiTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Kode Area', 'Nama Area', 'Kota', 'Zona', 'Action' );
		
		$i = 0;
		$query = $this->Model_laundry->ambilArea();
		foreach ($query->result() as $row){
			$action = "none";
			//$action = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','delete_area',array($row->id_area)),'Hapus',array('class' => 'delete','onclick' => 'return confirm(\'Hapus area : '. $row->area_name .' ?\')') );
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:6%;'),array('data' => $row->area_code),
								array('data' => $row->area_name, 'style' => 'text-align:left;padding-left:10px;'),array('data' => $row->city_name),array('data' => $row->zona_name),
								array('data' => $action, 'style' => 'width:10%;') );
		}
		return $this->table->generate();
	}
	
	// LAYANAN
	function layanan($outlet){
		$data['content'] = 'admin/setting/setting_layanan';
		$data['page_title'] = "Waroenk Laundry | Administrator";
		$data['dbKilo'] = $this->Model_laundry->ambilLaundryBy($outlet,"jenis","Kiloan");
		$data['dbNon'] = $this->Model_laundry->ambilLaundryBy($outlet,"jenis","Non");
		$data['dbSatu'] = $this->Model_laundry->ambilLaundryBy($outlet,"jenis","Satuan");
		$data['dbEx'] = $this->Model_laundry->ambilLaundryBy($outlet,"jenis","Extra");
		$data['dbDepo'] = $this->Model_laundry->ambilLaundryBy($outlet,"jenis","Deposit");
		$data['dbMasa'] = $this->Model_laundry->ambilLaundryBy($outlet,"jenis","Masa");
		$data['layan_ubah'] = site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','layanan_process',array($outlet,"Ubah")) );
		$data['layan_tambah'] = site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','layanan_process',array($outlet,"Tambah")) );
		$data['cloth_jenis']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','cloth_jenis',array($outlet)) );
		$data['tableCloth'] = $this->tableCloth();
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','outlet_form',array($outlet,"Ubah","NO")),'Kembali',array('class' => 'back') );
		$this->load->view('admin/template', $data);
	}
	function layanan_form($outlet,$id,$status,$error){
		$data['page_title']="Waroenk Laundry | Administrator - Laundry";
		$data['content']='main/setting/laundry_form';
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','layanan',array($outlet)),'Kembali',array('class' => 'back') );
		$data['tLegend'] = $status;
		$data['error'] = $error;
		
		if($status == 'Tambah')
			$data['form_laundry']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','layanan_process',array($outlet,0,$status)) );
		else
			$data['form_laundry']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','layanan_process',array($outlet,$id,$status)) );
		
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

		$this->load->view('admin/template', $data);
	}
	function layanan_process($outlet,$status){
		if($status == 'Tambah'){
			$param_laundry = array('kode_laundry' => strtoupper($this->input->post('kode')),
									'nama_laundry' => $this->input->post('nama'),
									'harga_laundry' => $this->input->post('harga'),
									'jenis' => $this->input->post('jenis'),
									'proses' => $this->input->post('proses'),
									'outlet_id' => $outlet
					);
			$this->Model_general->insertData("wl_laundry",$param_laundry);
		}else{
			$query = $this->Model_general->getDataBy("wl_laundry","outlet_id",$outlet);
			foreach($query->result() as $row){
				$param_laundry = array("nama_laundry" => $this->input->post("nama$row->id_laundry"),
										"harga_laundry" => $this->input->post("harga$row->id_laundry"),
										"jenis" => $this->input->post("jenis$row->id_laundry"),
										"proses" => $this->input->post("proses$row->id_laundry")
						);
				$this->Model_general->updateData("wl_laundry","id_laundry",$row->id_laundry,$param_laundry);
			}
		}
		redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','layanan',array($outlet)) );
	}
	function delete_laundry($outlet,$id){
		$this->Model_general->deleteData("wl_laundry","id_laundry",$id);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode( 'administrator','layanan',array($outlet) ) );
	}
	function create_table_laundry($outlet){
		$query = $this->Model_laundry->ambilLaundry($outlet);
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="laundryTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Kode Layanan', 'Nama Layanan', 'Jenis Layanan', 'Harga', 'Outlet', 'Action' );
		
		$i = 0;
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
	function cloth_jenis($outlet) {
		// generate code
		$param_cloth = array('nama_cloth' => $this->input->post('nama_cloth'),
							'jenis_cloth' => "Kiloan",
							'var_cloth' => $this->input->post('var_cloth')
					);
		$this->Model_general->insertData("master_cloth",$param_cloth);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','layanan',array($outlet)) );
	}
	function tableCloth(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="uiTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Jenis', 'Variabel', 'Action' );
		
		$i = 0;
		$query = $this->Model_general->getData("master_cloth","nama_cloth");
		foreach ($query->result() as $row){
			$action = "none";
			//$action = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','delete_aset_jenis',array($row->id_aset)),'Hapus',array('class' => 'delete','onclick' => 'return confirm(\'Hapus jenis aset : '. $row->nama_jenis .' ?\')') );
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:6%;'),array('data' => $row->nama_cloth, 'style' => 'text-align:left;padding-left:10px;'),
								array('data' => $row->var_cloth, 'style' => 'width:15%;'), array('data' => $action, 'style' => 'width:15%;') );
		}
		return $this->table->generate();
	}
	
	// PEWANGI
	function pewangi($outlet){
		$data['content'] = 'admin/setting/setting_pewangi';
		$data['page_title'] = "Waroenk Laundry | Administrator";
		// pewangi
		$data['table_pewangi'] = $this->create_table_pewangi($outlet);
		$data['form_wangi']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','pewangi_process',array($outlet)) );
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','outlet_form',array($outlet,"Ubah","NO")),'Kembali',array('class' => 'back') );
		$this->load->view('admin/template', $data);
	}
	function pewangi_process($outlet) {
		if ($this->form_validation->run("fPewangi") == FALSE){
			redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','index',array($outlet)) );
		} else {
			$param_pewangi = array('kode_pewangi' => strtoupper($this->input->post('kode')),
								'nama_pewangi' => $this->input->post('nama'),
								'outlet_id' => $outlet
						);
			$this->Model_general->insertData("wl_pewangi",$param_pewangi);
			
			redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','pewangi',array($outlet)) );
		}
	}
	function delete_pewangi($outlet,$id){
		$this->Model_general->deleteData("wl_pewangi","id_pewangi",$id);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','pewangi',array($outlet)) );
	}
	function create_table_pewangi($outlet){
		$query = $this->Model_laundry->ambilPewangi($outlet);
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="pewangiTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Kode Pewangi', 'Nama Pewangi', 'Outlet', 'Action' );
		
		$i = 0;
		foreach ($query->result() as $row){
			$link = anchor($this->mza_secureurl->setSecureUrl_encode('administrator','pewangi_form',array($row->outlet_id,$row->id_pewangi,"Ubah","NO")),$row->kode_pewangi);
			$action = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','delete_pewangi',array($row->outlet_id,$row->id_pewangi)),'Hapus',array('class' => 'delete','onclick' => 'return confirm(\'Hapus pewangi : '. $row->nama_pewangi .' ?\')') );
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'),
								array('data' => $link, 'style' => 'width:15%;'),
								array('data' => $row->nama_pewangi, 'style' => 'text-align:left;padding-left:10px;'),
								array('data' => $row->outlet_name, 'style' => 'width:37%;'),
								array('data' => $action, 'style' => 'width:15%;') );
		}
		return $this->table->generate();
	}
	
	// PROMO
	function promo($outlet){
		$data['content'] = 'admin/setting/setting_promo';
		$data['page_title'] = "Waroenk Laundry | Administrator";
		// promo
		$data['table_promo'] = $this->create_table_promo($outlet);
		$data['addpromo']=anchor($this->mza_secureurl->setSecureUrl_encode('administrator','promo_form',array($outlet,0,0,'Tambah','NO')),'Tambah Promo',array('class' => 'add'));
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','outlet_form',array($outlet,"Ubah","NO")),'Kembali',array('class' => 'back') );
		$this->load->view('admin/template', $data);
	}
	function promo_form($outlet,$id,$group,$status,$error){
		$data['page_title'] = "Waroenk Laundry | Administrator - Promo";
		$data['content'] = 'main/setting/promo_form';
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','promo',array($outlet)),'Kembali',array('class' => 'back') );
		$data['list_promo'] = $this->list_promo($group);
		$data['error'] = $error;
		$data['tLegend'] = $status;
		
		if($status == 'Tambah')
			$data['form_promo']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','promo_process',array($outlet,0,0,$status)) );
		else
			$data['form_promo']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','promo_process',array($outlet,$id,$group,$status)) );
		
		if($status == 'Ubah'){
			$promo = $this->Model_general->getDataBy("wl_promo","id_promo",$id)->row();
			$data['default']['nama'] = $promo->nama_promo;
			$data['default']['ket'] = $promo->ket_promo;
			$data['default']['jenis'] = $promo->jenis_promo;
			$data['default']['ptg'] = $promo->jumlah;
			$data['default']['start'] = $promo->tgl_mulai;
			$data['default']['end'] = $promo->tgl_akhir;
		} else {
			if ( $error == 'YES' ){
				$data['default']['nama'] = $this->input->post('nama');
				$data['default']['ket'] = $this->input->post('ket');
				$data['default']['jenis'] = $this->input->post('jenis');
				$data['default']['ptg'] = $this->input->post('ptg');
				$data['default']['start'] = $this->input->post('start');
				$data['default']['end'] = $this->input->post('end');
			}
		}
		$data['default']['jum'] = 1;

		$this->load->view('admin/template', $data);
	}
	function promo_process($outlet,$id,$group,$status) {
		if ($this->form_validation->run("fPromo") == FALSE){
			$this->promo_form($outlet,$id,$group,$status,"YES");
		} else {
			if($status == 'Tambah'){
				$IDPromo = $this->generateIDPromo();
				
				if($this->input->post('jenis') == "Diskon")
					$kode = "DS";
				else if($this->input->post('jenis') == "Kiloan")
					$kode = "KG";
				else if($this->input->post('jenis') == "Rupiah")
					$kode = "RP";
				
				for($i=0;$i<$this->input->post('jum');$i++){
					$param_promo = array('id_group' => $IDPromo,
										'kode_promo' => $this->generatePromo($kode),
										'nama_promo' => $this->input->post('nama'),
										'ket_promo' => $this->input->post('ket'),
										'tgl_mulai' => $this->input->post('start'),
										'tgl_akhir' => $this->input->post('end'),
										'jenis_promo' => $this->input->post('jenis'),
										'jumlah' => $this->input->post('ptg'),
										'status_promo' => "Ya",
										'outlet_id' => $outlet
								);
					$this->Model_general->insertData("wl_promo",$param_promo);
				}
			}else{
				$param_promo = array('nama_promo' => $this->input->post('nama'),
									'ket_promo' => $this->input->post('ket'),
									'tgl_mulai' => $this->input->post('start'),
									'tgl_akhir' => $this->input->post('end'),
									'jumlah' => $this->input->post('ptg'),
									'status_promo' => $this->input->post('stat')
							);
				$this->Model_general->updateData("wl_promo","id_group",$group,$param_promo);
			}
			
			redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','promo',array($outlet)) );
		}
	}
	function delete_promo($outlet,$kolom,$id){
		$this->Model_general->deleteData("wl_promo",$kolom,$id);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','promo',array($outlet)) );
	}
	function create_table_promo($outlet){
		$query = $this->Model_laundry->ambilPromo($outlet);
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="promoTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'ID Promo', 'Nama Promo', 'Tgl Mulai', 'Tgl Berakhir', 'Jenis Promo', 'Outlet', 'Action' );
		
		$i = 0;
		foreach ($query->result() as $row){
			$link = anchor($this->mza_secureurl->setSecureUrl_encode('administrator','promo_form',array($row->outlet_id,$row->id_promo,$row->id_group,"Ubah","NO")),$row->id_group);
			$action = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','delete_promo',array($row->outlet_id,"id_group",$row->id_group)),'Hapus',array('class' => 'delete','onclick' => 'return confirm(\'Hapus promo :\n'. $row->nama_promo .' ?\')') );
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'), array('data' => $link, 'style' => 'width:10%;'),
								array('data' => $row->nama_promo, 'style' => 'text-align:left;padding-left:10px;'), array('data' => $row->tgl_mulai, 'style' => 'width:10%;'),
								array('data' => $row->tgl_akhir, 'style' => 'width:10%;'), array('data' => $row->jenis_promo, 'style' => 'width:10%;'),
								array('data' => $row->outlet_name, 'style' => 'width:20%;'), array('data' => $action, 'style' => 'width:12%;') );
		}
		return $this->table->generate();
	}
	function list_promo($group){
		$query = $this->Model_general->getDataBy("wl_promo","id_group",$group);
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="promoTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Kode Promo', 'Tgl Mulai', 'Tgl Berakhir', 'Jenis Promo', 'Potongan', 'Status', 'Action' );
		
		$i = 0;
		foreach ($query->result() as $row){
			$status = "Tidak Aktif";
			
			if($row->status_promo == "Ya")
				$status = "Aktif";
			
			$action = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','delete_promo',array($row->outlet_id,"id_promo",$row->id_promo)),'Hapus',array('class' => 'delete','onclick' => 'return confirm(\'Hapus promo :\n'. $row->kode_promo .' ?\')') );
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'), $row->kode_promo,
								array('data' => $row->tgl_mulai, 'style' => 'width:12%;'), array('data' => $row->tgl_akhir, 'style' => 'width:12%;'),
								array('data' => $row->jenis_promo, 'style' => 'width:12%;'), array('data' => number_format($row->jumlah,1,',','.'), 'style' => 'width:12%;'),
								array('data' => $status, 'style' => 'width:10%;'), array('data' => $action, 'style' => 'width:12%;') );
		}
		return $this->table->generate();
	}
	
	// PEGAWAI
	function user($outlet){
		$data['content'] = 'admin/setting/setting_user';
		$data['page_title'] = "Waroenk Laundry | Administrator";
		// pegawai
		$data['table_pegawai'] = $this->create_table_pegawai($outlet);
		$data['addpegawai']=anchor($this->mza_secureurl->setSecureUrl_encode('administrator','pegawai_form',array($outlet,0,'Tambah')),'Tambah Pegawai',array('class' => 'add-user'));
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','outlet_form',array($outlet,"Ubah","NO")),'Kembali',array('class' => 'back') );
		$this->load->view('admin/template', $data);
	}
	function pegawai_form($outlet,$pegawai_id,$status) {
		$this->load->view('admin/template',$this->view_pegawai_form($outlet,$pegawai_id,$status,'NO'));
	}
	function view_pegawai_form($outlet,$pegawai_id,$status,$error){
		$data['page_title']="Waroenk Laundry | Administrator - Pegawai";
		$data['content']='main/setting/pegawai_form';
		$data['error']=$error;
		
		$data['photo'] = 'themes/img/pegawai-pic/anonim.png';
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','user',array($outlet)),'Kembali',array('class' => 'back') );
		$data['dbzona'] = $this->Model_general->getData("zona","zona_name");
		$data['dbcity'] = $this->Model_general->getData("zona_city","city_name");
		$data['dbarea'] = $this->Model_general->getData("zona_area","area_name");
		$data['dbout'] = $this->Model_general->getData("wl_outlet","outlet_code");
		$data['dbpos'] = $this->Model_user->get_position();
		$data['tLegend'] = $status;
		
		if($status == 'Tambah')
			$data['form_pegawai']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','pegawai_process',array($outlet,0,$status)) );
		else
			$data['form_pegawai']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','pegawai_process',array($outlet,$pegawai_id,$status)) );
		
		if($status == 'Ubah'){
			$pegawai = $this->Model_general->getDataBy("wl_pegawai","id_pegawai",$pegawai_id)->row();
			$data['default']['name'] = $pegawai->nama_pegawai;
			$data['default']['add'] = $pegawai->alamat_pegawai;
			$data['default']['pno'] = $pegawai->tlp_pegawai;
			$data['default']['bplace'] = $pegawai->lhr_pegawai;
			$data['default']['bdate'] = $pegawai->tgl_pegawai;
			$data['default']['pos'] = $pegawai->position_id;
			$data['photo'] = $pegawai->foto_pegawai;
			$data['default']['outlet'] = $pegawai->outlet_id;
			$zona = $this->Model_laundry->ambilOutletBy("outlet_id",$pegawai->outlet_id)->row();
			$data['default']['zona'] = $zona->id_zona;
			$data['default']['city'] = $zona->id_city;
			$data['default']['area'] = $zona->area_code;
		} else {
			$data['default']['outlet'] = $outlet;
			$zona = $this->Model_laundry->ambilOutletBy("outlet_id",$outlet)->row();
			$data['nama_outlet'] = $zona->outlet_name;
			if ( $error == 'YES' ){
				$data['default']['name'] = $this->input->post('name');
				$data['default']['add'] = $this->input->post('add');
				$data['default']['pno'] = $this->input->post('pno');
				$data['default']['bplace'] = $this->input->post('bplace');
				$data['default']['bdate'] = $this->input->post('bdate');
				$data['default']['pos'] = $this->input->post('pos');
				$data['photo'] = $this->input->post('photo');
				$data['default']['outlet'] = $this->input->post('outlet');
				$data['default']['zona'] = $this->input->post('zona');
				$data['default']['city'] = $this->input->post('city');
				$data['default']['area'] = $this->input->post('area');
			}
		}

		return $data;
	}
	function pegawai_process($outlet,$pegawai_id,$status) {
		if ($this->form_validation->run("pegawai") == FALSE){
			$this->load->view('template',$this->view_pegawai_form($outlet,$pegawai_id,$status,'YES'));
		} else {
			$this->insert_pegawai($outlet,$pegawai_id,$status);
			
			redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','user',array($outlet)) );
		}
	}
	function insert_pegawai($outlet,$pegawai_id,$status){
		$photo = $this->uploadPhoto('pegawai');
		if($status == 'Tambah'){
			$ambil = $this->Model_general->getDataBy("wl_outlet","outlet_id",$this->input->post('outlet'))->row();
			// preparing pegawai data
			$nip = $this->generateNIP($ambil->outlet_code);
			$param_pegawai = array('nip' => $nip,
						'pass_pegawai' => sha1($nip),
						'nama_pegawai' => $this->input->post('name'),
						'alamat_pegawai' => $this->input->post('add'),
						'tlp_pegawai' => $this->input->post('pno'),
						'lhr_pegawai' => $this->input->post('bplace'),
						'tgl_pegawai' => $this->input->post('bdate'),
						'foto_pegawai' => $photo,
						'position_id' => $this->input->post('pos'),
						'outlet_id' => $this->input->post('outlet')
					);
			$this->Model_general->insertData("wl_pegawai",$param_pegawai);
		}else{
			// preparing pegawai data
			$param_pegawai = array('nama_pegawai' => $this->input->post('name'),
						'alamat_pegawai' => $this->input->post('add'),
						'tlp_pegawai' => $this->input->post('pno'),
						'lhr_pegawai' => $this->input->post('bplace'),
						'tgl_pegawai' => $this->input->post('bdate'),
						'foto_pegawai' => $photo,
						'position_id' => $this->input->post('pos'),
						'outlet_id' => $this->input->post('outlet')
					);
			$this->Model_general->updateData("wl_pegawai","id_pegawai",$pegawai_id,$param_pegawai);
		}
	}
	function delete_pegawai($outlet,$pegawaiID){
		$data = $this->Model_general->getDataBy("wl_pegawai","id_pegawai",$pegawaiID)->row();
		$file = $data->foto_pegawai;
		if($file !== "themes/img/pegawai-pic/anonim.png"){
			if(is_file( "./$file" ))
				unlink( "./$file" );
		}
		$this->Model_general->deleteData("wl_pegawai","id_pegawai",$pegawaiID);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','user',array($outlet)) );
	}
	function create_table_pegawai($outlet){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="pegawaiTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'ID Pegawai', 'Nama', 'No. Tlp', 'Jabatan', 'Outlet', 'Action' );
		
		$i = 0;
		$query = $this->Model_user->get_pegawai($outlet);
		foreach ($query->result() as $row){
			$link = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','pegawai_form',array($row->outlet_id,$row->id_pegawai,'Ubah')), $row->nip );
			$action = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','delete_pegawai',array($row->outlet_id,$row->id_pegawai)),'Hapus',array('class' => 'delete','onclick' => 'return confirm(\'Hapus pegawai : '. $row->nama_pegawai .' ?\')') );
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'), $link,
								array('data' => $row->nama_pegawai, 'style' => 'width:25%;text-align:left;text-indent:10px;'), $row->tlp_pegawai, $row->position_name,
								$row->outlet_name, array('data' => $action, 'style' => 'width:15%;') );
		}
		return $this->table->generate();
	}
	
	// ASET
	function aset($outlet){
		$data['content'] = 'admin/setting/setting_aset';
		$data['page_title'] = "Waroenk Laundry | Administrator";
		// aset
		$data['table_aset'] = $this->create_table_aset($outlet);
		$data['form_aset']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','aset_process',array($outlet,"NO")) );
		$data['dbAset'] = $this->Model_general->getData("master_aset","kode_jenis")->result();
		$data['default']['jum'] = 1;
		$data['table_aset_jenis'] = $this->create_table_aset_jenis();
		$data['aset_jenis']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','aset_jenis',array($outlet)) );
		$data['table_aset_rawat'] = $this->create_table_aset_rawat();
		$data['aset_rawat']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','aset_rawat',array($outlet)) );
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','outlet_form',array($outlet,"Ubah","NO")),'Kembali',array('class' => 'back') );
		$this->load->view('admin/template', $data);
	}
	function aset_form($outlet,$status,$error){
		$data['page_title']="Waroenk Laundry | Administrator - Aset";
		$data['content']='main/setting/aset_form';
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','aset',array($outlet)),'Kembali',array('class' => 'back') );
		$data['form_aset']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','aset_process',array($outlet,$status)) );
		$data['dbAset'] = $this->Model_general->getData("master_aset","kode_jenis")->result();
		$data['tLegend'] = $status;
		$data['error'] = $error;
		
		if ( $error == 'YES' ){
			$data['default']['kode'] = $this->input->post('kode');
			$data['default']['jenis'] = $this->input->post('jenis');
		}
		$data['default']['jum'] = 1;

		$this->load->view('admin/template', $data);
	}
	function aset_process($outlet,$status) {
		if ($this->form_validation->run("fAset") == FALSE){
			redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','index',array($outlet)) );
		} else {
			$ambil = $this->Model_general->getDataBy("wl_outlet","outlet_id",$outlet)->row();
			$kode = "AS" . $ambil->outlet_code . $this->input->post('jenis');
			
			for($i=0;$i<$this->input->post('jum');$i++){
				$param_aset = array('kode_aset' => $this->generateAset($kode),
							'jenis_aset' => $this->input->post('jenis'),
							'outlet_id' => $outlet
						);
				$this->Model_general->insertData("wl_aset",$param_aset);
			}
			
			redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','aset',array($outlet)) );
		}
	}
	function delete_aset($outlet,$asetID){
		$this->Model_general->deleteData("wl_aset","id_aset",$asetID);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','aset',array($outlet)) );
	}
	function create_table_aset($outlet){
		$query = $this->Model_laundry->ambilAset($outlet);
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="asetTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Kode Aset', 'Jenis Aset', 'Kondisi', 'Outlet', 'Action' );
		
		$i = 0;
		foreach ($query->result() as $row){
			$action = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','delete_aset',array($row->outlet_id,$row->id_aset)),'Hapus',array('class' => 'delete','onclick' => 'return confirm(\'Hapus aset :\n'. $row->kode_aset .' - ' . $row->nama_jenis . ' ?\')') );
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'),array('data' => $row->kode_aset, 'style' => 'width:15%;'),
							$row->nama_jenis,$row->kondisi, $row->outlet_name,array('data' => $action, 'style' => 'width:12%;') );
		}
		return $this->table->generate();
	}
	function aset_jenis($outlet) {
		// generate code
		$getcode = $this->Model_general->getMaxCode("master_aset","kode_jenis","")->row();
		$idMax = $getcode->maxID; // 01
		$autoCode = (int) $idMax;
		$autoCode++;
		
		$param_aset = array('kode_jenis' => sprintf("%02s", $autoCode),
						'nama_jenis' => $this->input->post('nama_jenis')
					);
		$this->Model_general->insertData("master_aset",$param_aset);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','aset',array($outlet)) );
	}
	function create_table_aset_jenis(){
		$query = $this->Model_general->getData("master_aset","kode_jenis");
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table class="uiTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Kode Jenis', 'Nama Jenis', 'Action' );
		
		$i = 0;
		foreach ($query->result() as $row){
			$action = "none";
			//$action = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','delete_aset_jenis',array($row->id_aset)),'Hapus',array('class' => 'delete','onclick' => 'return confirm(\'Hapus jenis aset : '. $row->nama_jenis .' ?\')') );
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:6%;'),array('data' => $row->kode_jenis, 'style' => 'width:15%;'),
								array('data' => $row->nama_jenis, 'style' => 'text-align:left;padding-left:10px;'), array('data' => $action, 'style' => 'width:15%;') );
		}
		return $this->table->generate();
	}
	function aset_rawat($outlet) {
		$param_rawat = array('kode_jenis' => $this->input->post('jenis'),
						'perawatan' => $this->input->post('rawat')
					);
		$this->Model_general->insertData("master_rawat",$param_rawat);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','aset',array($outlet)) );
	}
	function create_table_aset_rawat(){
		$query = $this->Model_laundry->ambilRawat();
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table class="uiTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Jenis Aset', 'Perawatan', 'Action' );
		
		$i = 0;
		foreach ($query->result() as $row){
			$action = "none";
			//$action = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','delete_aset_rawat',array($row->id_rawat)),'Hapus',array('class' => 'delete','onclick' => 'return confirm(\'Hapus jenis perawatan :\n'. $row->perawatan .' ?\')') );
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:6%;'), array('data' => $row->nama_jenis, 'style' => 'width:25%;'),
								array('data' => $row->perawatan, 'style' => 'text-align:left;padding-left:10px;'), array('data' => $action, 'style' => 'width:15%;') );
		}
		return $this->table->generate();
	}
	
	// INVENTORI
	function inventori($outlet){
		$data['content'] = 'admin/setting/setting_inventori';
		$data['page_title'] = "Waroenk Laundry | Administrator";
		// inventory
		$data['table_stok'] = $this->create_table_stok($outlet);
		$data['form_stok']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','stok_process',array($outlet)) );
		$data['default']['stok'] = 0;
		$data['dbStok'] = $this->Model_general->getData("master_stock","kode_stock")->result();
		$data['table_stok_jenis'] = $this->create_table_stok_jenis();
		$data['stok_jenis']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','stok_jenis',array($outlet)) );
		$data['link'] = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','outlet_form',array($outlet,"Ubah","NO")),'Kembali',array('class' => 'back') );
		$this->load->view('admin/template', $data);
	}
	function stok_process($outlet) {
		if ($this->form_validation->run("fStok") == FALSE){
			redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','index',array($outlet)) );
		} else {
			$query = $this->Model_laundry->ambilStokBy($outlet,"id_mstock",$this->input->post('jenis'));
			if($query->num_rows() > 0){
				$ambil = $query->row();
				$this->Model_general->updateData("wl_stock","id_stock",$ambil->id_stock,array('stock_gudang' => $ambil->stock_gudang + $this->input->post('stok')));
			}else{
				$param_stok = array('id_mstock' => $this->input->post('jenis'),
							'stock_gudang' => $this->input->post('stok'),
							'outlet_id' => $outlet
						);
				$this->Model_general->insertData("wl_stock",$param_stok);
			}
			redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','inventori',array($outlet)) );
		}
	}
	function delete_stok($outlet,$stokID){
		$this->Model_general->deleteData("wl_stock","id_stock",$stokID);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','inventori',array($outlet)) );
	}
	function create_table_stok($outlet){
		$query = $this->Model_laundry->ambilStok($outlet);
		
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="stokTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Jenis Inventori', 'Stock Outlet', 'Stock Gudang', 'Outlet', 'Action' );
		
		$i = 0;
		foreach ($query->result() as $row){
			$action = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','delete_stok',array($row->outlet_id,$row->id_stock)),'Hapus',array('class' => 'delete','onclick' => 'return confirm(\'Hapus stok :' . $row->nama_stock . ' ?\')') );
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:3%;'),array('data' => $row->nama_stock, 'style' => 'width:25%;'),
									$row->stock . " Kg",$row->stock_gudang . " Kg", $row->outlet_name,array('data' => $action, 'style' => 'width:12%;') );
		}
		return $this->table->generate();
	}
	function stok_jenis($outlet) {
		// generate code
		$getcode = $this->Model_general->getMaxCode("master_stock","kode_stock","")->row();
		$idMax = $getcode->maxID; // 01
		$autoCode = (int) $idMax;
		$autoCode++;
		
		$param_stok = array('kode_stock' => sprintf("%02s", $autoCode),
						'nama_stock' => $this->input->post('nama_jstok')
					);
		$this->Model_general->insertData("master_stock",$param_stok);
		
		redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','inventori',array($outlet)) );
	}
	function create_table_stok_jenis(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table class="uiTable">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Kode Jenis', 'Nama Jenis', 'Action' );
		
		$i = 0;
		$query = $this->Model_general->getData("master_stock","kode_stock");
		foreach ($query->result() as $row){
			$action = "none";
			//$action = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','delete_stok_jenis',array($row->id_stok)),'Hapus',array('class' => 'delete','onclick' => 'return confirm(\'Hapus jenis stok : '. $row->nama_jenis .' ?\')') );
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:6%;'),array('data' => $row->kode_stock, 'style' => 'width:15%;'),
								array('data' => $row->nama_stock, 'style' => 'text-align:left;padding-left:10px;'), array('data' => $action, 'style' => 'width:15%;') );
		}
		return $this->table->generate();
	}
	
	// INVESTOR
	function investorList(){
		$data['content'] = 'admin/investor/invest_list';
		$data['page_title'] = "Waroenk Laundry | Investor";
		$data['tLegend'] = "Investor";
		$data['tabelInvest'] = $this->tableInvestor();
		$data['add_inv']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','investorAdd') );
		$data['dbzona'] = $this->Model_general->getData("zona","zona_name");
		$data['dbcity'] = $this->Model_general->getData("zona_city","city_name");
		$data['dbarea'] = $this->Model_general->getData("zona_area","area_name");
		$data['dbout'] = $this->Model_general->getData("wl_outlet","outlet_code");
		$this->load->view('admin/template', $data);
	}
	function investorForm($id,$error){
		$data['content'] = 'admin/investor/invest_form';
		$data['page_title'] = "Waroenk Laundry | Profil Investor";
		$data['form_pegawai']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','investorProcess',array($id,"Edit")) );
		$data['form_pass']= site_url( $this->mza_secureurl->setSecureUrl_encode('administrator','investorProcess',array($id,"Pass")) );
		$data['back'] = site_url( $this->mza_secureurl->setSecureUrl_encode("administrator","investorList") );
		$data['error'] = $error;
		
		$pegawai = $this->Model_general->getDataBy("master_invest","invest_id",$id)->row();
		$data['default']['name'] = $pegawai->invest_name;
		$data['default']['add'] = $pegawai->inv_alamat;
		$data['default']['pno'] = $pegawai->inv_tlp;
		$data['default']['outlet'] = $pegawai->outlet_id;
		
		$this->load->view('admin/template', $data);
	}
	function investorAdd(){
		$param_pegawai = array('invest_name' => $this->input->post('name'),
			'inv_alamat' => $this->input->post('add'),
			'inv_tlp' => $this->input->post('pno'),
			'username' => $this->input->post('username'),
			'pass' => sha1($this->input->post('pass')),
			'outlet_id' => $this->input->post('outlet')
		);
		$this->Model_general->insertData("master_invest",$param_pegawai);
		redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','investorList') );
	}
	
	function investorProcess($id,$status){
		if($status == "Pass")
			$validation = "pegawai" . $status;
		else
			$validation = "pegawai";
		
		if ($this->form_validation->run($validation) == FALSE){
			redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','investorForm',array($id,"YES")) );
		} else {
			if($status == "Pass"){
				$param_pegawai = array( 'pass' => sha1($this->input->post('pass')) );
				$this->Model_general->updateData("master_invest","invest_id",$this->session->userdata('id'),$param_pegawai);
			}else{
				// preparing pegawai data
				$param_pegawai = array('invest_name' => $this->input->post('name'),
							'inv_alamat' => $this->input->post('add'),
							'inv_tlp' => $this->input->post('pno')
						);
				$this->Model_general->updateData("master_invest","invest_id",$this->session->userdata('id'),$param_pegawai);
			}
			redirect( $this->mza_secureurl->setSecureUrl_encode('administrator','investorList') );
		}
	}
	function tableInvestor(){
		// Table
		/*Set table template*/
		$tmpl = array( 'table_open' => '<table id="invList">',
						'row_alt_start' => '<tr>',
						'row_alt_end' => '</tr>'
					);
		$this->table->set_template($tmpl);
		
		/*Set table heading */
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading( 'No', 'Nama Investor', 'No.Tlp', 'Outlet', 'Action' );
		
		$i = 0;
		$query = $this->Model_laundry->ambilInvestor();
		foreach ($query->result() as $row){
			$link = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','investorForm',array($row->invest_id,'NO')), $row->invest_name );
			$action = "none";
			//$action = anchor( $this->mza_secureurl->setSecureUrl_encode('administrator','delete_investor',array($row->id_invest)),'Hapus',array('class' => 'delete','onclick' => 'return confirm(\'Hapus Investor : '. $row->invest_name . ' / ' . $row->outlet_name .' ?\')') );
			
			$this->table->add_row( array('data' => ++$i, 'style' => 'width:6%;'),array('data' => $link, 'style' => 'text-align:left;padding-left:10px;'),
								array('data' => $row->inv_tlp, 'style' => 'width:15%;'),array('data' => $row->outlet_name, 'style' => 'width:25%;'),
								array('data' => $action, 'style' => 'width:15%;') );
		}
		return $this->table->generate();
	}
	
	function uploadPhoto($type){
		$photo = $this->input->post('photo');
			
		if (($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpeg") ||
				($_FILES["file"]["type"] == "image/jpg") && ($_FILES["file"]["size"] < 20000)) {
					move_uploaded_file($_FILES["file"]["tmp_name"],"themes/img/".$type."-pic/" . $_FILES["file"]["name"]);
					$photo = "themes/img/".$type."-pic/" . $_FILES["file"]["name"];
		}
		
		return $photo;
	}
	function generateCode($kode){
		// generate code
		$getcode = $this->Model_general->getMaxCode("wl_outlet","outlet_code",$kode)->row();
		$idMax = $getcode->maxID; // [kode]01
		$autoCode = (int) substr($idMax, 3, 2);
		$autoCode++;
		$newID = $kode.sprintf("%02s", $autoCode);
		
		return $newID;
	}
	function generateNIP($kode){
		// generate code
		$getcode = $this->Model_general->getMaxCode("wl_pegawai","nip",$kode)->row();
		$idMax = $getcode->maxID; // [kode]01
		$autoCode = (int) substr($idMax, 5, 2);
		$autoCode++;
		$newID = $kode.sprintf("%02s", $autoCode);
		
		return $newID;
	}
	function generateAset($kode){
		// generate code
		$getcode = $this->Model_general->getMaxCode("wl_aset","kode_aset",$kode)->row();
		$idMax = $getcode->maxID; // [kode]01
		$autoCode = (int) substr($idMax, 9, 2);
		$autoCode++;
		$newID = $kode.sprintf("%02s", $autoCode);
		
		return $newID;
	}
	function generateIDPromo(){
		$kode = "PR" . date('y', time()) . date('m', time());
		// generate code
		$getcode = $this->Model_general->getMaxCode("wl_promo","id_group",$kode)->row();
		$idMax = $getcode->maxID; // [kode]01
		$autoCode = (int) substr($idMax, 6, 2);
		$autoCode++;
		$newID = $kode.sprintf("%02s", $autoCode);
		
		return $newID;
	}
	function generatePromo($kode){
		$array_word = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9');
		shuffle($array_word);
		reset($array_word);
		$acak = "";
		$no=0;
		foreach($array_word as $line){
			$acak .= strtoupper($line);
			$no++;
			if (($no >= 20))
				break;
		}
		return "$kode$acak";
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