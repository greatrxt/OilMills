<?php
class Live_rates extends Admin_controller {

public function __construct()
{
	parent::__construct();
	$this->load->model('product_model');
	$this->load->helper('url_helper');
	$this->load->helper('date');
	$this->load->helper('form');
	$this->load->library('form_validation');
}



public function index()
{       
	$data['title'] = 'Parmar Oil Mills';
	$data['products'] = $this->product_model->get_all_products();

	if (empty($data['products']))
	{
			show_404();
	}

	$this->load->view('parmaroilmills/templates/header', $data);
	$this->load->view('parmaroilmills/templates/upper_menu', $data);
	$this->load->view('parmaroilmills/product_live_rates', $data);
	$this->load->view('parmaroilmills/templates/footer');
}

public function update_rates()
{       
	$this->product_model->update_rates($this->input->post());
	redirect('ParmarOilMills/web/Live_rates/', 'refresh');
}

}
