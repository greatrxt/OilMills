<?php
class Live_rates extends Admin_controller {

public function __construct()
{
	parent::__construct();
	$this->load->model('product_model');
	$this->load->helper('url_helper');
	$this->load->helper('date');
	$this->load->helper('form');
	$this->load->library('form_validation');
}



public function index()
{       
	$data['title'] = 'Parmar Oil Mills';
	$data['products'] = $this->product_model->get_all_products();

	$this->load->view('parmaroilmills/templates/header', $data);
	$this->load->view('parmaroilmills/templates/upper_menu', $data);
	$this->load->view('parmaroilmills/product_live_rates', $data);
	$this->load->view('parmaroilmills/templates/footer');
}

public function update_rates()
{       
	if($this->product_model->update_rates($this->input->post())){
		//notify users
		$ch = curl_init();
		
		$data = array(
			'message' => 'Product rates changed. Please check app for more details.'
		);
		
		$payload = array(
			'data' => $data,
			'to' => '/topics/LiveRates'
		);
		$content = json_encode($payload);
		
		
		curl_setopt($ch, CURLOPT_URL,"https://fcm.googleapis.com/fcm/send");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);  //Post Fields
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$headers = [
			'Content-Type: application/json',
			'Authorization: key=AAAAcqcKp98:APA91bEJH9ThA4qg07XhkxTS2SizXAyF5SKxGiyYfwLKxk0jeoGdRi3A3CYm2RliXy0TSVzoVxHPtNW4Ad_zcNxeIhR_t26-HG54LaX0kGGk8ACTJdtYDyZN-2aafs4tdhDiS0UEE4QU'
		];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$server_output = curl_exec ($ch);
		
		curl_close ($ch);
	}
	
	redirect('ParmarOilMills/web/Live_rates/', 'refresh');
}

}
