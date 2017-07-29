<?php

class Admin_controller extends MY_controller {
    public function __construct() {
       parent::__construct();
	   	$this->load->library('session');
		$this->load->helper('url_helper');
		if ($this->session->userdata('role') != 'ADMIN')
		{ 
			redirect('ParmarOilMills/web/login/', 'refresh');
		}
    }
}

?>

