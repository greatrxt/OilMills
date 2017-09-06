<?php
class Product_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	function deleteProductBy($id) {
		
		log_message('debug', 'deleteProductBy. - $id = ' . print_r($id, 1));
		
		$this->db->where( 'ProductID', $id );
		$this->db->delete('Product');

		log_message('debug', 'deleteProductBy. - Query = ' . $this->db->last_query());
		
		if ($this->db->affected_rows() == '1') {
			log_message('debug', 'deleteProductBy. - Product deleted ');
			return TRUE;
		} else {
			log_message('debug', 'deleteProductBy. - Failed');
			return FALSE;
		}
	}
	
	public function update_rates($products){
		$this->db->query('SET time_zone = "+05:30";');
		$ratesUpdated = false;
		foreach ($products as $key => $value) {
			if($key == 'displayProductsTable_length')
				continue;
			
			$product = $this->get_product_with_id($key);
			if($product['SellingPrice'] == $value){
				continue;
			}
			$data = array(
						'SellingPrice' => $value,
						'LastPriceUpdateTime' => date("Y-m-d H:i:s"),
						'PriceLastUpdatedBy' => $this->session->userdata('userid')
						);
			$this->db->where('ProductId', $key);
			$this->db->update('Product', $data); 
			log_message('debug', 'update_rates. - Query = ' . $this->db->last_query());
			$ratesUpdated = true;
		}
		
		return $ratesUpdated;
	}
		
	public function get_activated_products()
	{
		$result = $this->db->query('SELECT
									  *,
									  ApplicationUser.username
									FROM
									  Product
									LEFT JOIN
									  ApplicationUser
									ON
									  Product.RecordCreatedBy = ApplicationUser.UserId
									WHERE Product.Status = "Active";');
		return $result->result_array();
	}

	public function get_all_products()
	{
		$result = $this->db->query('SELECT
									  *,
									  
									  Product.RecordCreationTime,
									  t1.username as username,
									  t2.username as PriceLastUpdatedBy
									FROM
									  Product
									LEFT JOIN
									  ApplicationUser AS t1
									ON
									  Product.RecordCreatedBy = t1.UserId
									LEFT JOIN
									  ApplicationUser AS t2
									ON
									  Product.PriceLastUpdatedBy = t2.UserId;');
		return $result->result_array();
	}
	
	public function get_product_with_id($id)
	{
		$query = $this->db->get_where('Product', array('ProductID' => $id));
		return $query->row_array();
	}
		
	public function edit_product($id, $data)
	{	
		log_message('debug', 'edit_product. - $id = ' . print_r($id, 1) . '$data = ' . print_r($data, 1));
		
		$this->db->query('SET time_zone = "+05:30";');
		$this->db->where('ProductId', $id);
		$this->db->update('Product', $data);
		
		if($this->db->affected_rows() > 0){
			$response['id'] = $id;
			$response['Result'] = "Success";
		} else {
			$response['id'] = -1;
			$response['Result'] =  "No Records Updated";
		}
		$response['query'] = $this->db->last_query();
		log_message('debug', 'edit_product. - response = ' . print_r($response, 1) );
		return $response;
	}
	
	public function add_product($data)
	{	
		log_message('debug', 'add_product. - $data = ' . print_r($data, 1));	
		$this->db->query('SET time_zone = "+05:30";');
		if($this->db->insert('Product', $data)){
			$response['Result'] = "Success";
			$response['id'] = $this->db->insert_id();
		} else {
			 $response['Result'] = $this->db->error();
			 $response['query'] = $this->db->last_query();
			 $response['id'] = -1;
		}
		
		log_message('debug', 'add_product. - Query = ' . $this->db->last_query());
		
		log_message('debug', 'add_product. - response = ' . print_r($response, 1) );
		return $response;
	}
}