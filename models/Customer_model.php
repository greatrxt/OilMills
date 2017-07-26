<?php
class Customer_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
		
		function deleteCustomerBy($id) {
			$this->db->where( 'CustomerID', $id );
			$this->db->delete('customer');

			if ($this->db->affected_rows() == '1') {
				return TRUE;
			} else {
				return FALSE;
			}
		}

		public function get_all_customers()
		{
			$result = $this->db->query('SELECT
					  CustomerID,
					  NAME,
					  AREA,
					  location.City,
					  ContactNumber,
					  applicationuser.Username,
					  route.routename
						FROM
						  customer
						LEFT JOIN
						  applicationuser
						ON
						  customer.UserId = applicationuser.UserId
						LEFT JOIN
						  location
						ON
						  customer.location = location.LocationID
						LEFT JOIN
						  route
						ON
						  customer.route = route.RouteID');
			
			return $result->result_array();
		}
		
		public function get_customer_with_id($id)
		{
			//$query = $this->db->get_where('customer', array('CustomerID' => $id));
			//return $query->row_array();
			$result = $this->db->query('SELECT *
						FROM
						  customer
						LEFT JOIN
						  applicationuser
						ON
						  customer.RecordCreatedBy = applicationuser.UserId
						LEFT JOIN
						  location
						ON
						  customer.location = location.LocationID
						LEFT JOIN
						  route
						ON
						  customer.route = route.RouteID
                         WHERE
                         customer.CustomerId = "'. $id.'";');
			
			return $result->result_array();
		}
		
		public function edit_customer($id, $data)
		{	
			$this->db->where('CustomerId', $id);
			$this->db->update('customer', $data);
			
			if($this->db->affected_rows() > 0){
				$response['Result'] = "Success";
			} else {
				$response['Result'] =  "No Records Updated";
				$response['query'] = $this->db->last_query();
			}
			$response['query'] = $this->db->last_query();
			return $response;
		}
		
		public function add_customer($data)
		{	

			$this->db->trans_begin();
			
			$customer = array(
				'name' => $data['name'],
				'address' => $data['address'],
				'area' => $data['area'],
				'location' => $data['city'],
				'contactPerson' => $data['contactPerson'],
				'contactNumber' => $data['contactNumber'],
				'emailAddress' => $data['emailAddress'],
				'GSTNumberStatus' => $data['GSTNumberStatus'],
				'FSSAINumberStatus' => $data['FSSAINumberStatus'],
				'Route' => $data['Route'],
				'RecordCreatedBy' => 1
			);
			
			if (isset($data['GSTNumber']) 
				|| array_key_exists('GSTNumber', $data)) {
					$customer['GSTNumber'] = $data['GSTNumber'];
			}
			if (isset($data['FSSAINumber']) 
				|| array_key_exists('FSSAINumber', $data)) {
					$customer['FSSAINumber'] = $data['FSSAINumber'];
			}
			//1) Add to customer table 
			$customer_added = $this->db->insert('customer', $customer);
			
			if(!$customer_added){
					$response['Result'] = $this->db->error();
					$response['query'] = $this->db->last_query();
					$this->db->trans_rollback();
					return $response;
			}
			
			$customer_id = $this->db->insert_id();
			
			//2) Add applicationUser
			$application_user_added = false;
			
			$userActive = 0;
			if (isset($data['userActive']) 
				|| array_key_exists('userActive', $data)) {
				$userActive = 1;
			} 
			
			if(!empty($data['username']) AND !empty($data['password'])){
				$application_user = array(
						'Username' => $data['username'],
						'Password' => $data['password'],
						'Active' => 1,
						'Role' => 'CUSTOMER'
				);
				
				$application_user_added = $this->db->insert('applicationuser', $application_user);
				
				if($application_user_added){ //connect this user with customer
					$application_user_id = $this->db->insert_id();
					
					$customer = array(
						'UserId' => $application_user_id
					);
			
					$this->db->where('CustomerId', $customer_id);
					$this->db->update('customer', $customer);
					
					if($this->db->affected_rows() == 1){
						$this->db->trans_commit();
						$response['Result'] = "Success";
						return $response;
					} else {
						$application_user_added = false;
					}
					
				} else {
					$response['Result'] = $this->db->error();
					if($response['Result']['code']==1062) {
						$response['displayMessage'] = 'Username already exists';
					}
					$response['query'] = $this->db->last_query();
					$this->db->trans_rollback();
					return $response;
				}
				
			} else if ($userActive == 0){ // in case, user does not want to create application user during customer creation
				$application_user_added = true;
			}
			
			if ($customer_added && $application_user_added)
			{		$this->db->trans_commit();
					$response['Result'] = "Success";

			} else {
					$this->db->trans_rollback();
					$response['Result'] = $this->db->error();
					$response['query'] = $this->db->last_query();
					$response['message'] = 'customer_added = ' . $application_user_added . '' .$application_user_added ;
			}

			return $response;
		}
}