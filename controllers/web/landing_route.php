<?php
class Landing_route extends Admin_controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('route_model');
                $this->load->helper('url_helper');
        }

public function index()
{
        $data['title'] = 'Parmar Oil Mills';
		$data['routes'] = $this->route_model->get_all_routes();
		//print_r($data);
        $this->load->view('parmaroilmills/templates/header', $data);
		$this->load->view('parmaroilmills/templates/upper_menu', $data);
        $this->load->view('parmaroilmills/landing_route', $data);
        $this->load->view('parmaroilmills/templates/footer');
			
}

public function delete($id){
	if ($this->input->server('REQUEST_METHOD') === 'DELETE'){
		if( $this->route_model->deleteRouteBy($id) == false ){
		   echo "failed";
		} else {
		   echo "success";
		}
	}
}
}