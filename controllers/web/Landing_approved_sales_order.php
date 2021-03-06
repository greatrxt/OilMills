<?php
class Landing_approved_sales_order extends Operations_controller {

        public function __construct()
        {
			parent::__construct();
			$this->load->model('order_model');
			$this->load->model('user_model');
			$this->load->helper('url_helper');			
        }

		public function close()
		{
			$entryIds = $_GET["entryId"];
			$this->order_model->close_order_entries($entryIds);
			redirect('ParmarOilMills/web/landing_approved_sales_order', 'refresh');	
		}
		
		public function index()
		{
			$data['dispatched_order_entries'] = $this->order_model->get_all_closed_and_dispatched_order_entries();
			$data['pending_dispatch_order_entries'] = $this->order_model->get_all_approved_partially_dispatched_order_entries_with_balance();
			
			$this->load->view('parmaroilmills/templates/header');
			if ($this->session->userdata('role') == 'ADMIN'){ 
				$this->load->view('parmaroilmills/templates/upper_menu');
			} else {
				$this->load->view('parmaroilmills/templates/upper_menu_operations');
			}
			$this->load->view('parmaroilmills/landing_approved_sales_order', $data);
			$this->load->view('parmaroilmills/templates/footer');					
		}
}