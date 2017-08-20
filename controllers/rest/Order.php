<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Order extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('order_model');
		$this->load->model('user_model');
		$this->load->helper('url_helper');
	}

	public function index_get(){
		$this->response($this->order_model->get_all_orders(), 200);
	}
	
	public function customer_get($id){
		$this->response($this->order_model->get_orders_for_customer($id), 200);
	}
	
	public function user_get($id){
		$this->response($this->order_model->get_orders_for_user($id), 200);
	}
	
	public function entries_get($id){
		if($id == null){
			$this->response($this->order_model->get_all_orders_and_order_entries(), 200);
		} else {
			$this->response($this->order_model->get_order_entries($id), 200);
		}
	}
	
	public function confirm_post()
	{  
		$data = $this->post('ProductList');
		$headers=array();
		foreach (getallheaders() as $name => $value) {
			$headers[$name] = $value;
		}
		
		$order_placed_by_application_user = $this->user_model->get_user_from_token($headers['X-Api-Key']);
		$data = $this->post();
		//$this->response($order_placed_by_application_user['Username'], 200);
		$result = $this->order_model->place_order($data, $order_placed_by_application_user);
		$this->response($result, 200);
  }

}
?>