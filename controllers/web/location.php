<?php
class Location extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('location_model');
                $this->load->helper('url_helper');
        }

public function view($id = NULL)
{
		if($id == NULL){
			redirect('index.php/ParmarOilMills/web/landing_location', 'refresh');
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
					'state' => $this->input->post('state'),
					'RecordCreatedBy' => 1
			);

			$result = $this->location_model->edit_location($id, $data);
			redirect('index.php/ParmarOilMills/web/location/view/'.$id, 'refresh');
		} 
}


public function create()
{
    $this->load->helper('form');
    $this->load->library('form_validation');

    $data['title'] = 'Parmar Oil Mills';

    $this->form_validation->set_rules('city', 'City', 'required');

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
				'RecordCreatedBy' => 1
		);
		
		//echo $data['city'];
        $this->location_model->add_location($data);
        redirect('index.php/ParmarOilMills/web/landing_location', 'refresh');
    }
}
}