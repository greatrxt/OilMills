<?php

class Operations_controller extends Auth_controller {
    public function __construct() {
       parent::__construct();
	   	$this->load->library('session');
		$this->load->helper('url_helper');
		if (! (($this->session->userdata('role') == 'OPERATIONS') ||
				($this->session->userdata('role') == 'ADMIN')))
		{ 
			redirect('ParmarOilMills/web/login/', 'refresh');
		}
    }
}
?>

