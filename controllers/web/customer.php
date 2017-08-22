<?php
class Customer extends Admin_controller {

public function __construct()
{
		parent::__construct();
		$this->load->model('location_model');
		$this->load->model('route_model');
		$this->load->model('customer_model');
		$this->load->model('user_model');
		$this->load->helper('url_helper');
}



public function edit($id = NULL){
	
	if($id == NULL){
		redirect('ParmarOilMills/web/landing_customer', 'refresh');
		return;
	}
	
	$data['customer'] = $this->customer_model->get_customer_with_id($id)[0];
				
	if (empty($data['customer'])){
			show_404();
	}
			
	$this->load->library('form_validation');
	$this->form_validation->set_rules('city', 'City', 'required');
	$this->form_validation->set_error_delimiters('<div class="error" style="display:none;width:82%;padding:10px;margin-top:20px;border: 1px solid #FF0000">', '</div>'); 
	$this->form_validation->set_rules('name', 'Name', 'required');
	
	if($this->input->post('username')!=null){
		$applicationuser = $this->user_model->user_exists($this->input->post('username'));
		if($applicationuser!=null){		
			if($applicationuser['UserId']!=$data['customer']['UserId']){
				$this->form_validation->set_rules(
					'username', 'Username',
					'required|min_length[5]|max_length[25]|is_unique[ApplicationUser.username]',
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
		$data['routes'] = $this->route_model->get_all_routes();
	
		$this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/header_master');
		$this->load->view('parmaroilmills/templates/upper_menu');
		$this->load->view('parmaroilmills/customer_edit', $data);
		$this->load->view('parmaroilmills/templates/footer');	
		
	} else {
		
		$result = $this->customer_model->edit_customer($id, $this->input->post());
		redirect('ParmarOilMills/web/landing_customer', 'refresh');
	}		
	//print_r($this->input->post());
	//print_r($data);
}


public function create()
{
    $this->load->helper('form');
    $this->load->library('form_validation');

	$this->form_validation->set_error_delimiters('<div class="error" style="display:none;width:82%;padding:10px;margin-top:20px;border: 1px solid #FF0000">', '</div>'); 
    $this->form_validation->set_rules('name', 'Name', 'required');

	//while creating employee, if user is active then check if username exists
	if (array_key_exists('userActive', $this->input->post())) {
		$this->form_validation->set_rules(
        'username', 'Username',
        'required|min_length[5]|max_length[12]|is_unique[ApplicationUser.username]',
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
		$data['routes'] = $this->route_model->get_all_routes();
		
        $this->load->view('parmaroilmills/templates/header', $data);
		$this->load->view('parmaroilmills/templates/header_master', $data);
		$this->load->view('parmaroilmills/templates/upper_menu', $data);
        $this->load->view('parmaroilmills/customer', $data);
        $this->load->view('parmaroilmills/templates/footer');

    } else {	
		$result = $this->customer_model->add_customer($this->input->post());
		redirect('ParmarOilMills/web/landing_customer', 'refresh');
    }
	
}
}