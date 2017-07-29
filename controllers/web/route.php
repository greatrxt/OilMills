<?php
class Route extends Admin_controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('route_model');
                $this->load->helper('url_helper');
        }

public function view($id = NULL)
{
		if($id == NULL){
			redirect('ParmarOilMills/web/landing_route', 'refresh');
			return;
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');
        $data['route'] = $this->route_model->get_route_with_id($id);

        if (empty($data['route']))
        {
                show_404();
        }
		//print_r($data);
		$this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/upper_menu');
		$this->load->view('parmaroilmills/route_edit', $data);
		$this->load->view('parmaroilmills/templates/footer');	
}

public function edit($id = NULL)
{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('routeName', 'Route Name', 'required');

		if ($this->form_validation->run())
		{
			$data = array(
					'routeName' => $this->input->post('routeName'),
					'routeCode' => $this->input->post('routeCode'),
					'RecordCreatedBy' => 1
			);

			$result = $this->route_model->edit_route($id, $data);
			//print_r($result);
			redirect('ParmarOilMills/web/route/view/'.$id, 'refresh');
		} 
}


public function create()
{
    $this->load->helper('form');
    $this->load->library('form_validation');

    $data['title'] = 'Parmar Oil Mills';

    $this->form_validation->set_rules('routeName', 'Route Name', 'required');

    if ($this->form_validation->run() === FALSE)
    {
        $this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/upper_menu');
        $this->load->view('parmaroilmills/route', $data);
        $this->load->view('parmaroilmills/templates/footer');

    } else {
		$data = array(
				'routeName' => $this->input->post('routeName'),
				'routeCode' => $this->input->post('routeCode'),
				'RecordCreatedBy' => 1
		);
	
        $this->route_model->add_route($data);
        redirect('ParmarOilMills/web/landing_route', 'refresh');
    }
}

}