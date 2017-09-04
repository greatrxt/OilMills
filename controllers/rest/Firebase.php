<?php
require(APPPATH.'/libraries/REST_Controller.php');

class firebase extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url_helper');
	}
	public function update_post()
	{  
		$token = $this->post('FirebaseInstanceToken');
		$appVersion = 'NA';
		if($this->post('appVersion')!=null){
			$appVersion = $this->post('appVersion');
		}
		$headers=array();
		foreach (getallheaders() as $name => $value) {
			$headers[$name] = $value;
		}
		
		$application_user = $this->user_model->get_user_from_token($headers['X-Api-Key']);
		$result = $this->user_model->update_firebase_user_token($application_user, $token, $appVersion);
		$this->response('', 200);
  }
}
?>