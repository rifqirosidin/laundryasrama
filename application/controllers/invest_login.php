<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invest_login extends CI_Controller {
	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_user','', TRUE);
		$this->load->model('Model_general','', TRUE);
	}
	
	function index() {
		if($_POST==NULL){
			$data['page_title'] = "Waroenk Laundry | Login Investor";
			$data['form_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode('invest_login','index') );
			$data['error']='NO';
			
			$this->load->view('invest/sx_login', $data);
		} else {
			if ($this->form_validation->run('login') == FALSE){
				$data['page_title'] = "Waroenk Laundry | Login Investor";
				$data['form_action'] = site_url( $this->mza_secureurl->setSecureUrl_encode('invest_login','index') );
				$data['error']='YES';
				$this->load->view('invest/sx_login', $data);
			} else {
				$user = $this->input->post('username');
				$passx = sha1($this->input->post('password'));
        		$query = $this->Model_general->getDataWhere("master_invest","username = '$user' AND pass = '$passx';");
				
				if($query->num_rows() > 0){
					$data = $query->row();
					
					if ($data->pass == $passx){
						$session_data = array(
							'id' => $data->invest_id,
							'name' => $data->invest_name,
							'user' => "INVEST",
							'out' => $data->outlet_id,
							'is_login' => TRUE
						);
						$this->session->set_userdata($session_data);
						
						redirect($this->mza_secureurl->setSecureUrl_encode( 'investor','index'));
					} else {
						redirect($this->mza_secureurl->setSecureUrl_encode('invest_login','index'));
						exit();
					}
				} else {
					redirect($this->mza_secureurl->setSecureUrl_encode('invest_login','index'));
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
		
        redirect($this->mza_secureurl->setSecureUrl_encode('invest_login','index'));
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