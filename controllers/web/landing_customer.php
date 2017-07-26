<?php
class Landing_customer extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('customer_model');
                $this->load->helper('url_helper');
        }

public function index()
{
        $data['title'] = 'Parmar Oil Mills';
		$data['customer'] = $this->customer_model->get_all_customers();
		//print_r($data);
        $this->load->view('parmaroilmills/templates/header', $data);
		$this->load->view('parmaroilmills/templates/upper_menu', $data);
        $this->load->view('parmaroilmills/landing_customer', $data);
        $this->load->view('parmaroilmills/templates/footer');
			
}

public function delete($id){
	if ($this->input->server('REQUEST_METHOD') === 'DELETE'){
		if( $this->customer_model->deleteCustomerBy($id) == false ){
		   echo "failed";
		} else {
		   echo "success";
		}
	}
}
}