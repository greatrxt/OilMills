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
		$this->load->helper('form');
		$this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/upper_menu');
		$this->load->view('parmaroilmills/home');
		$this->load->view('parmaroilmills/templates/footer');
	}
}	
?>