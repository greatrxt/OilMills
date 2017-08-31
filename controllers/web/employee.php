<?php
class Employee extends Admin_controller {

public function __construct()
{
		parent::__construct();
		$this->load->model('location_model');
		$this->load->model('employee_model');
		$this->load->model('user_model');
		$this->load->helper('url_helper');
}


public function edit($id = NULL){
	
	if($id == NULL){
		redirect('ParmarOilMills/web/landing_employee', 'refresh');
		return;
	}
	
	$data['employee'] = $this->employee_model->get_employee_with_id($id)[0];
	//print_r($data);			
	if (empty($data['employee'])){
			show_404();
	}
			
	$this->load->library('form_validation');
	$this->form_validation->set_rules('city', 'City', 'required');
	$this->form_validation->set_error_delimiters('<div class="error" style="display:none;width:82%;padding:10px;margin-top:20px;border: 1px solid #FF0000">', '</div>'); 
	$this->form_validation->set_rules('name', 'Name', 'required');
	
	if($this->input->post('username')!=null){
		$this->form_validation->set_rules('role[]', 'Role', 'required');
		$applicationuser = $this->user_model->user_exists($this->input->post('username'));
		if($applicationuser!=null){		
			if($applicationuser['UserId']!=$data['employee']['UserId']){
				
				$this->form_validation->set_rules(
					'username', 'Username',
					'required|is_unique[ApplicationUser.username]',
					array(
							'required'      => 'You have not provided %s.',
							'is_unique'     => 'This %s already exists.'
					)
				);
			}
		}
	}
	
	if ($this->form_validation->run() == FALSE) {
						
		$data['location'] = $this->location_model->get_all_locations();
		//print_r($this->input->post());
		$this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/header_master');
		$this->load->view('parmaroilmills/templates/upper_menu');
		$this->load->view('parmaroilmills/employee_edit', $data);
		$this->load->view('parmaroilmills/templates/footer');	
		
	} else {
		
		$result = $this->employee_model->edit_employee($id, $this->input->post());
		//print_r($result);
		redirect('ParmarOilMills/web/landing_employee', 'refresh');
	}		
	//print_r($this->input->post());
	
}

public function create()
{
    $this->load->helper('form');
    $this->load->library('form_validation');

    $data['title'] = 'Parmar Oil Mills';
	$this->form_validation->set_error_delimiters('<div class="error" style="display:none;width:82%;padding:10px;margin-top:20px;border: 1px solid #FF0000">', '</div>'); 
    $this->form_validation->set_rules('name', 'Name', 'required');
	
	//while creating employee, if user is active then check if username exists
	if (array_key_exists('userActive', $this->input->post())) {
		$this->form_validation->set_rules('role[]', 'Role', 'required');
		$this->form_validation->set_rules(
        'username', 'Username',
        'required|is_unique[ApplicationUser.username]',
        array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => 'The %s you entered already exists.'
        )
		);
	} 
	
	
	$this->form_validation->set_message('is_unique', 'This %s is already taken');

    if ($this->form_validation->run() === FALSE)
    {
        $data['title'] = 'Parmar Oil Mills';
		$data['location'] = $this->location_model->get_all_locations();
		
        $this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/header_master');
		$this->load->view('parmaroilmills/templates/upper_menu');
        $this->load->view('parmaroilmills/employee', $data);
        $this->load->view('parmaroilmills/templates/footer');

    } else {
		
        $this->employee_model->add_employee($this->input->post());
        redirect('ParmarOilMills/web/landing_employee', 'refresh');
		//print_r($this->input->post());
    }
}
}