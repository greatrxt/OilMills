<?php
class Home_operations extends Operations_controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url_helper');
		$this->load->library('session');
		$this->load->model('order_model');
		$this->load->model('product_model');
		$this->load->model('production_model');
		$this->load->model('dispatch_model');
	}
	
	public function index()
	{
		$role = $this->session->userdata('role');
		if($role == 'ADMIN'){
			redirect('ParmarOilMills/web/home', 'refresh');
		} 
		
		$this->load->helper('form');
		$this->load->view('parmaroilmills/templates/header');
		
		$data['pending_approval_order_entries'] = $this->order_model->get_pending_approval_orders_entries();
		$data['approved_and_pending_dispatch_orders_entries'] = $this->order_model->get_approved_and_pending_dispatch_orders_entries();
		$data['approved_order_entries'] = $this->order_model->get_approved_and_partially_dispatched_orders_entries_count();
		
		$data['order_entries_dispatched_today'] = $this->dispatch_model->get_orders_entries_dispatched_today_count();
		$data['get_orders_entries_dispatched_today_amount'] = $this->dispatch_model->get_orders_entries_dispatched_today_amount();
		$data['order_entries_dispatched_for_current_month'] = $this->dispatch_model->get_order_entries_dispatched_for_current_month();
		
		$data['orders'] = $this->order_model->get_orders_received_today();
		$data['production'] = $this->production_model->get_production_details_for_current_month();
		$data['products'] = $this->product_model->get_all_products();

		$this->load->view('parmaroilmills/templates/upper_menu_operations');
		$this->load->view('parmaroilmills/home', $data);
		$this->load->view('parmaroilmills/templates/footer');
	}
}	
?>