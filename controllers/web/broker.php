<?php
class Broker extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('location_model');
				$this->load->model('broker_model');
                $this->load->helper('url_helper');
        }

public function view($id = NULL)
{		$this->load->library('form_validation');
		$this->form_validation->set_rules('city', 'City', 'required');
		if($id == NULL){
			redirect('index.php/ParmarOilMills/web/landing_broker', 'refresh');
			return;
		}
		
        $data['broker'] = $this->broker_model->get_broker_with_id($id);
		$data['location'] = $this->location_model->get_all_locations();
		print_r($data);
        if (empty($data['broker']))
        {
                show_404();
        }

		$this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/header_master');
		$this->load->view('parmaroilmills/templates/upper_menu');
		$this->load->view('parmaroilmills/broker_edit', $data);
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
			$result = $this->broker_model->edit_broker($id, $data);
			redirect('index.php/ParmarOilMills/web/broker/view/'.$id, 'refresh');
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

    $this->form_validation->set_rules('name', 'Name', 'required');

    if ($this->form_validation->run() === FALSE)
    {
        $data['title'] = 'Parmar Oil Mills';
		$data['location'] = $this->location_model->get_all_locations();
		
        $this->load->view('parmaroilmills/templates/header', $data);
		$this->load->view('parmaroilmills/templates/header_master', $data);
		$this->load->view('parmaroilmills/templates/upper_menu', $data);
        $this->load->view('parmaroilmills/broker', $data);
        $this->load->view('parmaroilmills/templates/footer');

    } else {
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
		
        $this->broker_model->add_broker($data);
        redirect('index.php/ParmarOilMills/web/landing_broker', 'refresh');
    }
}
}