<?php
class Landing_product extends Admin_controller {

        public function __construct()
        {
                parent::__construct();
				$this->load->model('product_model');
                $this->load->helper('url_helper');
        }

public function index()
{
        $data['title'] = 'Parmar Oil Mills';
		$data['products'] = $this->product_model->get_all_products();
		//print_r($data);
        $this->load->view('parmaroilmills/templates/header', $data);
		$this->load->view('parmaroilmills/templates/upper_menu', $data);
        $this->load->view('parmaroilmills/landing_product', $data);
        $this->load->view('parmaroilmills/templates/footer');
			
}

public function delete($id){
	if ($this->input->server('REQUEST_METHOD') === 'DELETE'){
		if( $this->product_model->deleteProductBy($id) == false ){
		   echo "failed";
		} else {
		   echo "success";
		}
	}
}

}