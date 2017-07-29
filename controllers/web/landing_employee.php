<?php
class Landing_employee extends Admin_controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('location_model');
				$this->load->model('employee_model');
                $this->load->helper('url_helper');
        }

public function index()
{
        $data['title'] = 'Parmar Oil Mills';
		$data['employee'] = $this->employee_model->get_all_employees();
		//print_r($data);
        $this->load->view('parmaroilmills/templates/header', $data);
		$this->load->view('parmaroilmills/templates/upper_menu', $data);
        $this->load->view('parmaroilmills/landing_employee', $data);
        $this->load->view('parmaroilmills/templates/footer');
			
}

public function delete($id){
	if ($this->input->server('REQUEST_METHOD') === 'DELETE'){
		if( $this->employee_model->deleteEmployeeBy($id) == false ){
		   echo "failed";
		} else {
		   echo "success";
		}
	}
}
}