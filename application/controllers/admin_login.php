<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_login extends CI_Controller {
	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_user','', TRUE);
		$this->load->model('Model_general','', TRUE);
	}
	
	function index() {
		$data['outlet']=$this->Model_general->getData('wl_outlet','outlet_code');
		if($_POST==NULL){
			$data['page_title'] = "Waroenk Laundry | Login Admin";
			$data['form_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode('admin_login','index') );
			$data['error']='NO';
			
			$this->load->view('admin/sx_login', $data);
		} else {
			if ($this->form_validation->run('login') == FALSE){
				$data['page_title'] = "Waroenk Laundry | Login Admin";
				$data['form_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode('admin_login','index') );
				$data['error']='YES';
				$this->load->view('admin/sx_login', $data);
			} else {
				$user = $this->input->post('username');
				$passx = sha1($this->input->post('password'));
        		$query = $this->Model_general->getDataWhere("master_admin","username = '$user' AND pass = '$passx' AND position_id='1';");
				
				if($query->num_rows() > 0){
					$data = $query->row();
					
					if ($data->pass == $passx){
						$session_data = array(
							'id' => $data->admin_id,
							'name' => $data->admin_name,
							'user' => "ADMIN",
							'out' => $this->input->post('outlet'),
							'is_login' => TRUE
						);
						$this->session->set_userdata($session_data);
						
						redirect($this->mza_secureurl->setSecureUrl_encode( 'administrator','outlet_form',array($this->input->post('outlet'),"Ubah","NO") ));
					} else {
						redirect($this->mza_secureurl->setSecureUrl_encode('admin_login','index'));
						exit();
					}
				} else {
					redirect($this->mza_secureurl->setSecureUrl_encode('admin_login','index'));
					exit();
				}
			}
		}
	}
    function logout() {
		$data = array( 'id' => 0,
				'name' => 0,
				'user' => 0,
				'out' => 0,
				'is_login' => FALSE
        );
		$this->session->sess_destroy();
        $this->session->unset_userdata($data);
		
        redirect($this->mza_secureurl->setSecureUrl_encode('admin_login','index'));
		exit();
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

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */