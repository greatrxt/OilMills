<?php
class Product_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
		
		function deleteProductBy($id) {
			$this->db->where( 'ProductID', $id );
			$this->db->delete('product');

			if ($this->db->affected_rows() == '1') {
				return TRUE;
			} else {
				return FALSE;
			}
		}

		public function get_all_products()
		{
			//$query = $this->db->get('product');
			//SELECT product.ProductID, product.City, product.District, product.State, applicationuser.username FROM product left join applicationuser on product.RecordCreatedBy = applicationuser.UserId;
			/*$query = $this->db->select('product.ProductID, product.City, product.District, product.RecordCreationTime, product.State, applicationuser.username')
                  ->from('product')
                  ->join('applicationuser', 'applicationuser.UserId = product.RecordCreatedBy', 'left')
                  ->get();*/
			$result = $this->db->query('SELECT
										  *,
										  applicationuser.username
										FROM
										  product
										LEFT JOIN
										  applicationuser
										ON
										  product.RecordCreatedBy = applicationuser.UserId;');
			return $result->result_array();
		}
		
		public function get_product_with_id($id)
		{
			$query = $this->db->get_where('product', array('ProductID' => $id));
			return $query->row_array();
		}
		
		public function edit_product($id, $data)
		{	
			$this->db->where('ProductId', $id);
			$this->db->update('product', $data);
			
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
			if($this->db->insert('product', $data)){
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