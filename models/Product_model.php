<?php
class Product_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	function deleteProductBy($id) {
		$this->db->where( 'ProductID', $id );
		$this->db->delete('Product');

		if ($this->db->affected_rows() == '1') {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function update_rates($products){
		$this->db->query('SET time_zone = "+05:30";');
		foreach ($products as $key => $value) {
			if($key == 'displayProductsTable_length')
				continue;
			
			$product = $this->get_product_with_id($key);
			if($product['SellingPrice'] == $value){
				continue;
			}
			$data = array(
						'SellingPrice' => $value,
						'LastPriceUpdateTime' => date("Y-m-d H:i:s")
						);
			$this->db->where('ProductId', $key);
			$this->db->update('Product', $data); 
		}
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
									  ApplicationUser.username
									FROM
									  Product
									LEFT JOIN
									  ApplicationUser
									ON
									  Product.RecordCreatedBy = ApplicationUser.UserId;');
		return $result->result_array();
	}
	
	public function get_product_with_id($id)
	{
		$query = $this->db->get_where('Product', array('ProductID' => $id));
		return $query->row_array();
	}
		
	public function edit_product($id, $data)
	{	
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
		return $response;
	}
	
	public function add_product($data)
	{	
		$this->db->query('SET time_zone = "+05:30";');
		if($this->db->insert('Product', $data)){
			$response['Result'] = "Success";
			$response['id'] = $this->db->insert_id();
		} else {
			 $response['Result'] = $this->db->error();
			 $response['query'] = $this->db->last_query();
			 $response['id'] = -1;
		}
		return $response;
	}
}