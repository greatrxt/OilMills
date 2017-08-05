<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Customer extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('customer_model');
		$this->load->helper('url_helper');
	}

  public function index_get()
  {  
	$data['customer'] = $this->customer_model->get_all_customers();
	$this->response($data, 200);
  }
}
?>