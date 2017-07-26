<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Location extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('location_model');
		$this->load->helper('url_helper');
	}

  public function index_get()
  {  
	$data['location'] = $this->location_model->get_all_locations();
	$this->response($data, 200);
  }

  public function id_get($id)
  {
	$data['location'] = $this->location_model->get_location_with_id($id);
	$this->response($data, 200);
  }
  
  public function id_put($id)
  {
	$data=array(
	   'City' => $this->put('City'),
	   'District' => $this->put('District'),
	   'State' => $this->put('State')
	);

	$response = array(
       'Result' => 'Failed'
       );

	$response = $this->location_model->edit_location($id, $data);
	$this->response($response, 200);
  }
  
  public function index_post()
  {
    //$data=array(
    //   'City' => $this->post('City'),
     //  'District' => $this->post('District'),
	 //  'State' => $this->post('State')
    //   );
    //print_r($data);
	//$this->response($data, 200);
	$response = array(
       'Result' => 'Failed'
    );

	$response = $this->location_model->add_location($this->post());
	
	$this->response($response, 201);
  }
}
?>