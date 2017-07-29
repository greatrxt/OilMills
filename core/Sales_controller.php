<?php

class Sales_controller extends MY_Controller {
    public function __construct() {
       parent::__construct();
	   	$this->load->library('session');
		$this->load->helper('url_helper');
		if (! (($this->session->userdata('role') == 'SALES') ||
				($this->session->userdata('role') == 'ADMIN')))
		{ 
			redirect('ParmarOilMills/web/login/', 'refresh');
		}
    }
}

?>

