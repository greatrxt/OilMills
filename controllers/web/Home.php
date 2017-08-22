<?php
class Home extends Admin_controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url_helper');
		$this->load->library('session');
	}
	
	public function index()
	{
		//print_r($this->session->all_userdata());
		//print_r($_COOKIE); 
		$this->load->helper('form');
		$this->load->view('parmaroilmills/templates/header');
		if ($this->session->userdata('role') == 'ADMIN'){ 
			$this->load->view('parmaroilmills/templates/upper_menu');
		} else {
			$this->load->view('parmaroilmills/templates/upper_menu_operations');
		}
		
		$this->load->view('parmaroilmills/home');
		$this->load->view('parmaroilmills/templates/footer');
	}
}	
?>