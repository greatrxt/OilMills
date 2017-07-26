<?php
class Customer extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('location_model');
				$this->load->model('route_model');
				$this->load->model('customer_model');
                $this->load->helper('url_helper');
        }

public function view($id = NULL)
{		$this->load->library('form_validation');
		$this->form_validation->set_rules('city', 'City', 'required');
		if($id == NULL){
			redirect('index.php/ParmarOilMills/web/landing_customer', 'refresh');
			return;
		}
		
        $data['customer'] = $this->customer_model->get_customer_with_id($id)[0];
		$data['location'] = $this->location_model->get_all_locations();
		$data['routes'] = $this->route_model->get_all_routes();
		
		print_r($data);
        if (empty($data['customer']))
        {
                show_404();
        }

		$this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/header_master');
		$this->load->view('parmaroilmills/templates/upper_menu');
		$this->load->view('parmaroilmills/customer_edit', $data);
		$this->load->view('parmaroilmills/templates/footer');		
}

public function edit($id = NULL){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('city', 'City', 'required');

		if ($this->form_validation->run())
		{
			$data = array(
					'name' => $this->input->post('name'),
					'address' => $this->input->post('address'),
					'area' => $this->input->post('area'),
					'location' => $this->input->post('city'),
					'contactPerson' => $this->input->post('contactPerson'),
					'contactNumber' => $this->input->post('contactNumber'),
					'emailAddress' => $this->input->post('emailAddress'),
					'RecordCreatedBy' => 1
			);
			$result = $this->customer_model->edit_customer($id, $data);
			redirect('index.php/ParmarOilMills/web/customer/view/'.$id, 'refresh');
			//print_r($result);
		}
		//print_r($this->input->post());
		//print_r($data);
}


public function create()
{
    $this->load->helper('form');
    $this->load->library('form_validation');

    $data['title'] = 'Parmar Oil Mills';
	$this->form_validation->set_error_delimiters('<div class="error" style="display:none;width:82%;padding:10px;margin-top:20px;border: 1px solid #FF0000">', '</div>'); 
    $this->form_validation->set_rules('name', 'Name', 'required');
	//$this->form_validation->set_rules('username', 'username', 'trim|required|is_unique[applicationuser.username]'); 
	$this->form_validation->set_rules(
        'username', 'Username',
        'required|min_length[5]|max_length[12]|is_unique[applicationuser.username]',
        array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => 'This %s already exists.'
        )
);
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
		
        print_r($this->customer_model->add_customer($this->input->post()));
        //redirect('index.php/ParmarOilMills/web/landing_customer', 'refresh');
		//print_r($this->input->post());
    }
}
}