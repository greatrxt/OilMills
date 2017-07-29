<?php

class Auth_controller extends MY_controller {
    public function __construct() {
       parent::__construct();
		$this->load->library('session');
		$this->load->helper('url_helper');
		if ($this->session->userdata('userid') <= 0)
		{ 
			redirect('ParmarOilMills/web/login/', 'refresh');
		}
    }
}
?>

