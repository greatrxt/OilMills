<?php
class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url_helper');
		$this->load->library('session');
	}
	
	public function index()
	{
		$this->session->sess_destroy();
		//print_r($_COOKIE); 
		$this->load->helper('form');
		$this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/login');
		$this->load->view('parmaroilmills/templates/footer');
		
	}
	
	public function authenticate()
	{
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$applicationuser = $this->user_model->get_user_id($username, $password);
		$userid = $applicationuser['UserId'];
		$role = $applicationuser['Role'];
		if($userid > 0){
			$this->session->set_userdata('username', $username);
			$this->session->set_userdata('userid', $userid);
			$this->session->set_userdata('role', $role);
			if($role == 'ADMIN'){
				redirect('ParmarOilMills/web/home', 'refresh');
			} else if(strpos($role, 'OPERATIONS') !== FALSE){
				redirect('ParmarOilMills/web/home_operations', 'refresh');
			} else {
				$this->session->set_flashdata('error_notification', 'Web access not assigned to user');
				redirect('ParmarOilMills/web/Login/', 'refresh');
			}
		} else {
			$this->session->set_flashdata('error_notification','Invalid Username or Password');
			redirect('ParmarOilMills/web/Login/', 'refresh');
		}
	}
	
	public function signout()
	{
		$this->session->set_userdata('userid', '');
		$this->session->set_userdata('role', '');
		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('role');
		redirect('ParmarOilMills/web/login/', 'refresh');
	}
}	
?>