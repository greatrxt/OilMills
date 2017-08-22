<?php
class Landing_sales_order_approval extends Admin_controller {

        public function __construct()
        {
			parent::__construct();
			$this->load->model('order_model');
			$this->load->model('user_model');
			$this->load->helper('url_helper');			
        }
		
		public function approve(){
			$data = json_decode($this->input->raw_input_stream, true);
			//echo print_r($data);
			$entries = $data['entries'];
			$custom_rates = $data['customRate'];
			$this->order_model->reviewOrdersWithCustomRates($entries, $custom_rates, 'APPROVED');
		}

		public function reject(){
			$data = json_decode($this->input->raw_input_stream);
			$entries = $data->entries;
			$this->order_model->reviewOrders($entries, 'REJECTED');
		}
		
		public function index()
		{
			$data['order_entries'] = $this->order_model->get_all_orders_and_order_entries_pending_approval();
			
			$this->load->view('parmaroilmills/templates/header');
			$this->load->view('parmaroilmills/templates/upper_menu');
			$this->load->view('parmaroilmills/landing_sales_order_approval', $data);
			$this->load->view('parmaroilmills/templates/footer');					
		}
}