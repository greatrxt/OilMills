<?php
class Production extends Operations_controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url_helper');
		$this->load->model('production_model');
		$this->load->library('session');
	}
	
	public function index(){
		$data['productions'] = $this->production_model->get_all_production();
		$this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/upper_menu');
		$this->load->view('parmaroilmills/production_landing', $data);
		$this->load->view('parmaroilmills/templates/footer');
	}
	
	public function view($id){
		if($id == null){
			redirect('ParmarOilMills/web/production', 'refresh');
			return;
		}
		
		$data['title'] = 'PROD'.$id;
		$data['productions'] = $this->production_model->get_production($id);
		$this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/upper_menu');
		$this->load->view('parmaroilmills/production_view', $data);
		$this->load->view('parmaroilmills/templates/footer');
	}
	
	public function estimate()
	{
		$entryIds = $_GET["entryId"];
		$data['productions'] = $this->production_model->get_production_estimate($entryIds);
		$data['entryIds'] = $entryIds;
		//print_r($data);
		$this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/upper_menu');
		$this->load->view('parmaroilmills/production_estimate', $data);
		$this->load->view('parmaroilmills/templates/footer');	
	}
	
	public function confirm()
	{
		$entryIds = $_GET["entryId"];
		$data['productions'] = $this->production_model->confirm_production($entryIds);
		redirect('ParmarOilMills/web/production', 'refresh');		
	}
}
?>