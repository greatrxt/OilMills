<?php
class Dispatch extends Operations_controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url_helper');
		$this->load->model('dispatch_model');
		$this->load->model('route_model');
		$this->load->library('session');
	}
	
	public function index(){
		$data['dispatchs'] = $this->dispatch_model->get_all_dispatch();
		$this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/upper_menu');
		$this->load->view('parmaroilmills/landing_dispatch', $data);
		$this->load->view('parmaroilmills/templates/footer');
	}
	
	public function view($id){
		if($id == null){
			redirect('ParmarOilMills/web/dispatch', 'refresh');
			return;
		}
		
		$data['id'] = $id;
		$data['dispatchs'] = $this->dispatch_model->get_dispatch($id);
		$data['routes'] = $this->dispatch_model->get_routes_for_dispatch($id);
		$this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/upper_menu');
		$this->load->view('parmaroilmills/dispatch_view', $data);
		$this->load->view('parmaroilmills/templates/footer');
	}

	public function view_print($id){
		if($id == null){
			redirect('ParmarOilMills/web/dispatch', 'refresh');
			return;
		}
		
		$data['id'] = $id;
		$data['dispatch_details'] = $this->dispatch_model->get_dispatch_details($id);
		$data['dispatchs'] = $this->dispatch_model->get_dispatch($id);
		$data['routes'] = $this->dispatch_model->get_routes_for_dispatch($id); 
		$this->load->view('parmaroilmills/dispatch_print', $data);
	}
	
	public function estimate()
	{
		$entryIds = $_GET["entryId"];
		$data['entryIds'] = $entryIds;
		$data['dispatchs'] = $this->dispatch_model->get_dispatch_estimate($entryIds);
		$data['customers'] = $this->dispatch_model->get_customer_for($entryIds);
		$data['product_wise_dispatch'] = $this->dispatch_model->get_customer_product_wise_total($entryIds);
		
		$data['routes'] = $this->route_model->get_all_routes();
		$data['entryIds'] = $entryIds;
		//print_r($data);
		$this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/upper_menu');
		$this->load->view('parmaroilmills/dispatch_estimate', $data);
		$this->load->view('parmaroilmills/templates/footer');	
	}
	
	public function confirm()
	{
		$entryIds = $_GET["entryId"];
		$dispatch_changes = json_decode($this->input->raw_input_stream, true);
		
		$dispatchId = $this->dispatch_model->confirm_dispatch($entryIds, $dispatch_changes);
		echo base_url().'index.php/ParmarOilMills/web/dispatch/view/'.$dispatchId;
		//redirect('ParmarOilMills/web/dispatch', 'refresh');		
	}
}
?>