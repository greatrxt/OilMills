<?php
class Customer_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
		
		function deleteCustomerBy($id) {

			$query = $this->db->get_where('Customer', array('CustomerId' => $id));
			$customer_data =  $query->row_array();
			
			if(empty($customer_data)){
				$response['Result'] =  "Customer not found";
				return $response;
			}
			
			$application_user_id = $customer_data['UserId'];
			
			$this->db->delete('Customer', array('CustomerID' => $id));
			$customers_deleted = $this->db->affected_rows();
			
			if($application_user_id != NULL){
				$this->db->delete('ApplicationUser', array('UserId' => $application_user_id));
			}
			
			if ($customers_deleted == '1') {
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
					  Location.City,
					  ContactNumber,
					  ApplicationUser.Username,
					  Route.routename
						FROM
						  Customer
						LEFT JOIN
						  ApplicationUser
						ON
						  Customer.UserId = ApplicationUser.UserId
						LEFT JOIN
						  Location
						ON
						  Customer.location = Location.LocationID
						LEFT JOIN
						  Route
						ON
						  Customer.Route = Route.RouteID');
			
			return $result->result_array();
		}
		
		public function get_customer_with_id($id)
		{
			//$query = $this->db->get_where('customer', array('CustomerID' => $id));
			//return $query->row_array();
			$result = $this->db->query('SELECT *
						FROM
						  Customer
						LEFT JOIN
						  ApplicationUser
						ON
						  Customer.UserId = ApplicationUser.UserId
						LEFT JOIN
						  Location
						ON
						  Customer.location = Location.LocationID
						LEFT JOIN
						  Route
						ON
						  Customer.route = Route.RouteID
                         WHERE
                         Customer.CustomerId = "'. $id.'";');
			
			return $result->result_array();
		}
		
		public function edit_customer($id, $data)
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
				'RecordCreatedBy' => $this->session->userdata('userid')
			);
			
			if (isset($data['GSTNumber']) 
				|| array_key_exists('GSTNumber', $data)) {
					$customer['GSTNumber'] = $data['GSTNumber'];
			}
			if (isset($data['FSSAINumber']) 
				|| array_key_exists('FSSAINumber', $data)) {
					$customer['FSSAINumber'] = $data['FSSAINumber'];
			}
			
			$this->db->where('CustomerId', $id);
			$this->db->update('Customer', $customer);
			
			//if($this->db->affected_rows() > 0){
						//2) Add/edit applicationUser
			$query = $this->db->get_where('Customer', array('CustomerId' => $id));
			$customer_data =  $query->row_array();
			
			if(empty($customer_data)){
				$response['Result'] =  "Unknown Error. ";
				return $response;
			}
			
			$application_user_id = $customer_data['UserId'];
			
			$application_user_exists = false;
			if($application_user_id != NULL){
				$application_user_exists = true;
			}
				
			$userActive = 0;
			if (isset($data['userActive']) 
				|| array_key_exists('userActive', $data)) {
				$userActive = 1;
			} 
			
			$role_string = 'CUSTOMER';
			
			$application_user = array();
			if(!empty($data['username']) 
				AND !empty($data['password'])){
				 
				$application_user['Username'] = $data['username'];
				$application_user['Password'] = $data['password'];
				$application_user['Role'] = $role_string;
			}
			
			$application_user['Active'] = $userActive;
						
			if($application_user_exists){
				$this->db->where('UserId', $application_user_id);
				$this->db->update('ApplicationUser', $application_user);
			} else 	if(!empty($data['username']) 
				AND !empty($data['password'])){
				$this->db->insert('ApplicationUser', $application_user);
				$application_user_id = $this->db->insert_id();
			}
			
			if(!$application_user_exists){ //connect this user with customer
					
				$customer = array(
					'UserId' => $application_user_id
				);			
				$this->db->where('CustomerId', $id);
				$this->db->update('Customer', $customer);					
			}
			 
			
			$this->db->trans_commit();
			$response['Result'] = "Success";
			
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
				'RecordCreatedBy' => $this->session->userdata('userid')
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
			$customer_added = $this->db->insert('Customer', $customer);
			
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
				
				$application_user_added = $this->db->insert('ApplicationUser', $application_user);
				
				if($application_user_added){ //connect this user with customer
					$application_user_id = $this->db->insert_id();
					
					$customer = array(
						'UserId' => $application_user_id
					);
			
					$this->db->where('CustomerId', $customer_id);
					$this->db->update('Customer', $customer);
					
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