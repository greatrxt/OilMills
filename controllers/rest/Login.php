<?php
require(APPPATH.'/libraries/REST_Controller.php');

class login extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url_helper');
	}

  public function index_get()
  {  
	$this->response('1', 200);
  }

  public function id_get($id)
  {
	$this->response('2', 200);
  }
  
  public function id_put($id)
  {
	$this->response('3', 200);
  }
  
  public function index_post()
  {
    $response = $this->user_model->token_based_login($this->post('Username'), $this->post('Password'));
	
	$this->response($response, 201);
  }
  
  public function authenticate_post()
  {
    $response = $this->user_model->token_based_login($this->post('Username'), $this->post('Password'));
 	$this->response($response, 200);
  }
}
?>