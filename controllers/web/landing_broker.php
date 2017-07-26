<?php
class Landing_broker extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('broker_model');
                $this->load->helper('url_helper');
        }

public function index()
{
        $data['title'] = 'Parmar Oil Mills';
		$data['brokers'] = $this->broker_model->get_all_brokers();
		//print_r($data);
        $this->load->view('parmaroilmills/templates/header', $data);
		$this->load->view('parmaroilmills/templates/upper_menu', $data);
        $this->load->view('parmaroilmills/landing_broker', $data);
        $this->load->view('parmaroilmills/templates/footer');
			
}

public function delete($id){
	if ($this->input->server('REQUEST_METHOD') === 'DELETE'){
		if( $this->broker_model->deleteBrokerBy($id) == false ){
		   echo "failed";
		} else {
		   echo "success";
		}
	}
}

}