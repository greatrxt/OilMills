<?php
class Landing_location extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('location_model');
                $this->load->helper('url_helper');
        }

public function index()
{
        $data['title'] = 'Parmar Oil Mills';
		$data['location'] = $this->location_model->get_all_locations();
		
        $this->load->view('parmaroilmills/templates/header', $data);
		$this->load->view('parmaroilmills/templates/upper_menu', $data);
        $this->load->view('parmaroilmills/landing_location', $data);
        $this->load->view('parmaroilmills/templates/footer');
			
}

public function delete($id){
	if ($this->input->server('REQUEST_METHOD') === 'DELETE'){
		if( $this->location_model->deleteLocationBy($id) == false ){
		   echo "failed";
		} else {
		   echo "success";
		}
	}
}

}