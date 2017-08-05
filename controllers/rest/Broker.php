<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Broker extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('broker_model');
		$this->load->helper('url_helper');
	}

  public function index_get()
  {  
	$data['broker'] = $this->broker_model->get_all_brokers();
	$this->response($data, 200);
  }
}
?>