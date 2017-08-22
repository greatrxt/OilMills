<?php
class Location extends Admin_controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('location_model');
                $this->load->helper('url_helper');

        }

public function view($id = NULL)
{
		if($id == NULL){
			redirect('ParmarOilMills/web/landing_location', 'refresh');
			return;
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');
        $data['location'] = $this->location_model->get_location_with_id($id);

        if (empty($data['location']))
        {
                show_404();
        }

		$this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/upper_menu');
		$this->load->view('parmaroilmills/location_edit', $data);
		$this->load->view('parmaroilmills/templates/footer');	
}

public function edit($id = NULL)
{
	$this->load->library('form_validation');
	$this->form_validation->set_rules('city', 'City', 'required');

	if ($this->form_validation->run())
	{
		$data = array(
				'city' => $this->input->post('city'),
				'district' => $this->input->post('district'),
				'state' => $this->input->post('state')
		);

		$result = $this->location_model->edit_location($id, $data);	
		//print_r($result);		
	} 
	redirect('ParmarOilMills/web/landing_location', 'refresh');
}


public function create()
{
    $this->load->helper('form');
    $this->load->library('form_validation');
	$this->form_validation->set_error_delimiters('<div class="error" style="display:none;width:82%;padding:10px;margin-top:20px;border: 1px solid #FF0000">', '</div>'); 
    $data['title'] = 'Parmar Oil Mills';

    //$this->form_validation->set_rules('city', 'City', 'required');

	$this->form_validation->set_rules(
		'city', 'City',
		'required|min_length[2]|max_length[35]|is_unique[Location.City]',
		array(
				'required'      => 'You have not provided a valid %s.',
				'is_unique'     => 'This %s already exists.'
		)
	);

    if ($this->form_validation->run() === FALSE)
    {
        $this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/upper_menu');
        $this->load->view('parmaroilmills/location', $data);
        $this->load->view('parmaroilmills/templates/footer');

    } else {
		$data = array(
				'city' => $this->input->post('city'),
				'district' => $this->input->post('district'),
				'state' => $this->input->post('state'),
				'RecordCreatedBy' => $this->session->userdata('userid')
		);
		
		//echo $data['city'];
        $this->location_model->add_location($data);
        redirect('ParmarOilMills/web/landing_location', 'refresh');
    }
}
}