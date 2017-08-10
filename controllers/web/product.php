<?php
class Product extends Admin_controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('product_model');
                $this->load->helper('url_helper');
				$this->load->helper('date');
				$this->load->helper('form');
				$this->load->library('form_validation');
        }

public function view($id = NULL)
{
		if($id == NULL){
			redirect('ParmarOilMills/web/landing_product', 'refresh');
			return;
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');
        $data['product'] = $this->product_model->get_product_with_id($id);

        if (empty($data['product']))
        {
                show_404();
        }
		//print_r($data);
		$this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/upper_menu');
		$this->load->view('parmaroilmills/product_edit', $data);
		$this->load->view('parmaroilmills/templates/footer');	
}

public function edit($id = NULL)
{

    //$this->form_validation->set_rules('name', 'Name', 'required|is_unique[product.name]');

	$current_time = now('Asia/Kolkata');
	
	//Text data
	$data = array(
			'Name' => $this->input->post('name'),
			'Code' => $this->input->post('productCode'),
			'UnitOfMeasurement' => $this->input->post('unitOfMeasurement'),
			'ProductCategory' => $this->input->post('productCategory'),
			'SellingPrice' => $this->input->post('sellingPrice'),
			'Status' => $this->input->post('productStatus')
	);

	if(!empty($_FILES['productImage']['name'])){
		$file_name_array = explode(".", $_FILES['productImage']['name']);
		$file_type = $file_name_array[1];
		$file_location = base_url()."uploads/product/".$current_time.".".$file_type;
		
		$data['ProductImage'] = $file_location;
	}
	
	//echo $data['city'];
	$result = $this->product_model->edit_product($id, $data);

	if($id > 0 && !empty($_FILES['productImage']['name'])){		
		$uploadPath = './uploads/product/';
		if (!file_exists($uploadPath)) {
			mkdir($uploadPath, 0777, true);
		}

		//Image
		$config['upload_path']          = $uploadPath;
		$config['max_size']             = 10000333;
		$config['allowed_types']        = 'png|jpg|bmp';
		$config['max_width']            = 102400;
		$config['max_height']           = 76800;
		$config['file_name'] 			= $current_time;
		$config['overwrite'] 			= TRUE;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);		
		if (!$this->upload->do_upload('productImage')){
				$error = array('error' => $this->upload->display_errors());
				//print_r($error);
		} else {
				$data = array('upload_data' => $this->upload->data());
				//print_r($data);
		}
	} else {
		//print_r($result);
	}
	redirect('ParmarOilMills/web/product/view/'.$id, 'refresh');
    
}


public function create()
{
    $data['title'] = 'Parmar Oil Mills';

    $this->form_validation->set_rules('name', 'Name', 'required|is_unique[Product.name]');

    if ($this->form_validation->run() === FALSE)
    {
        $this->load->view('parmaroilmills/templates/header');
		$this->load->view('parmaroilmills/templates/upper_menu');
        $this->load->view('parmaroilmills/product', $data);
        $this->load->view('parmaroilmills/templates/footer');

    } else {
		
		$current_time = now('Asia/Kolkata');
		$file_location = '';
		if(!empty($_FILES['productImage']['name'])){
			$file_name_array = explode(".", $_FILES['productImage']['name']);
			$file_type = $file_name_array[1];
			$file_location = base_url()."uploads/product/".$current_time.".".$file_type;
		}
		
		//Text data
		$data = array(
				'Name' => $this->input->post('name'),
				'Code' => $this->input->post('productCode'),
				'UnitOfMeasurement' => $this->input->post('unitOfMeasurement'),
				'ProductCategory' => $this->input->post('productCategory'),
				'SellingPrice' => $this->input->post('sellingPrice'),
				'Status' => $this->input->post('productStatus'),
				'ProductImage' => $file_location,
				'RecordCreatedBy' => $this->session->userdata('userid')
		);
		
		//echo $data['city'];
		$result = $this->product_model->add_product($data);
		
		if(empty($_FILES['productImage']['name'])){
			redirect('ParmarOilMills/web/landing_product', 'refresh');
			return;
		}

        if($result['id'] > 0){		
			$productId = $result['id'];
			$uploadPath = './uploads/product/';
			if (!file_exists($uploadPath)) {
				mkdir($uploadPath, 0777, true);
			}
		
			$new_name = $productId;
			
			//Image
			$config['upload_path']          = $uploadPath;
			$config['allowed_types']        = 'png|jpg|bmp';
			$config['max_size']             = 10000333;
			$config['max_width']            = 102400;
			$config['max_height']           = 76800;
			$config['file_name'] 			= $current_time;

			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('productImage')){
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
			} else {
					$data = array('upload_data' => $this->upload->data());
					//print_r($data);
					redirect('ParmarOilMills/web/landing_product', 'refresh');
			}
		} else {
			print_r($result);
		}
    }
}
}