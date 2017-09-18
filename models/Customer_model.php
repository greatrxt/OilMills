<?php
class Customer_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
		
		public function get_customer_count(){
			$query_string = 'SELECT COUNT(CustomerId) AS count from Customer';
			$result = $this->db->query($query_string);
			return $result->row_array();
		}
		
		function deleteCustomerBy($id) {

			log_message('debug', 'deleteCustomerBy. - $id = ' . print_r($id, 1));
		
			$query = $this->db->get_where('Customer', array('CustomerId' => $id));
			$customer_data =  $query->row_array();
			
			log_message('debug', 'deleteCustomerBy. - Query = ' . $this->db->last_query());
			
			if(empty($customer_data)){
				$response['Result'] =  "Customer not found";
				log_message('debug', 'deleteCustomerBy. - Customer not found ');				
				return $response;
			}
			
			$application_user_id = $customer_data['UserId'];
			
			$this->db->delete('Customer', array('CustomerID' => $id));
			$customers_deleted = $this->db->affected_rows();
			
			log_message('debug', 'deleteCustomerBy. - Query = ' . $this->db->last_query());
			
			$username_deleted = true;
			
			if($application_user_id != NULL){
				//delete keys
				$username_deleted = false;
				
				$application_user_query = $this->db->get_where('ApplicationUser', array('UserId' => $application_user_id));
				
				$application_user =  $application_user_query->row_array();
				
				log_message('debug', 'deleteCustomerBy. - Query = ' . $this->db->last_query());
				
				log_message('debug', 'deleteCustomerBy. - $application_user = ' . print_r($application_user, 1));
				
				$this->db->delete('ApplicationUser', array('UserId' => $application_user_id));
				log_message('debug', 'deleteCustomerBy. - Query = ' . $this->db->last_query());
				
				if($this->db->affected_rows() == 1) $username_deleted = true;
				
				if($application_user['TokenId']!=null){
					$username_deleted = false;
					$this->db->delete('keys', array('id' => $application_user['TokenId']));
					if($this->db->affected_rows() == 1) $username_deleted = true;
				} 
				
				log_message('debug', 'deleteCustomerBy. - Query = ' . $this->db->last_query());
			}
			
			if ($customers_deleted == '1') {
				log_message('debug', 'deleteCustomerBy. - CUSTOMER DELETED ');
				return TRUE;
			} else {
				log_message('debug', 'deleteCustomerBy. - FALIED TO DELETE CUSTOMER ');
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
			log_message('debug', 'edit_customer. - $id = ' . print_r($id, 1) . '$data = ' . print_r($data, 1));

			$this->db->trans_begin();
			$this->db->query('SET time_zone = "+05:30";');
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
			
			log_message('debug', 'edit_customer. - Query = ' . $this->db->last_query());
			
			//if($this->db->affected_rows() > 0){
						//2) Add/edit applicationUser
			$query = $this->db->get_where('Customer', array('CustomerId' => $id));
			$customer_data =  $query->row_array();
			
			log_message('debug', 'edit_customer. - Query = ' . $this->db->last_query());
			
			if(empty($customer_data)){
				$response['Result'] =  "Unknown Error. ";
				log_message('debug', 'edit_customer. - Error = ' . print_r($customer_data, 1));
				return $response;
			}
			
			$application_user_id = $customer_data['UserId'];
			
			$application_user_exists = false;
			if($application_user_id != NULL){
				$application_user_exists = true;
			}
			
			$role_string = 'CUSTOMER';
			
			$application_user = array();
			if(!empty($data['username']) 
				AND !empty($data['password'])){
				 
				$application_user['Username'] = $data['username'];
				$application_user['Password'] = $data['password'];
				$application_user['Role'] = $role_string;
			}
			
							
			$userActive = 0;
			if (isset($data['userActive']) 
				|| array_key_exists('userActive', $data)) {
				$userActive = 1;
			} else {
				$application_user['TokenId'] = NULL;
			}
			
			$application_user['Active'] = $userActive;
			
			log_message('debug', 'edit_customer. - application_user = ' . print_r($application_user, 1));			
			if($application_user_exists){
				$this->db->where('UserId', $application_user_id);
				$this->db->update('ApplicationUser', $application_user);
				log_message('debug', 'edit_customer. - Query = ' . $this->db->last_query());
				
			} else 	if(!empty($data['username']) 
				AND !empty($data['password'])){
				$this->db->insert('ApplicationUser', $application_user);
				$application_user_id = $this->db->insert_id();
				log_message('debug', 'edit_customer. - Query = ' . $this->db->last_query());
			}
			
			$this->db->query('DELETE FROM `keys`
				USING `keys` 
				LEFT JOIN ApplicationUser ON(ApplicationUser.TokenId = keys.id)
				WHERE ApplicationUser.TokenId IS NULL');
			
			log_message('debug', 'edit_customer. - Query = ' . $this->db->last_query());
			
			if(!$application_user_exists){ //connect this user with customer
					
				$customer = array(
					'UserId' => $application_user_id
				);			
				$this->db->where('CustomerId', $id);
				$this->db->update('Customer', $customer);	
				log_message('debug', 'edit_customer. - Query = ' . $this->db->last_query());				
			}
			 
			
			$this->db->trans_commit();
			$response['Result'] = "Success";
			log_message('debug', 'edit_customer. - Success');
			return $response;
		}
		
		public function add_customer($data)
		{	
			log_message('debug', 'add_customer. - $data = ' . print_r($data, 1));
			$this->db->trans_begin();
			$this->db->query('SET time_zone = "+05:30";');
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
			log_message('debug', 'add_customer. - Query = ' . $this->db->last_query());
			
			if(!$customer_added){
					$response['Result'] = $this->db->error();
					$response['query'] = $this->db->last_query();
					$this->db->trans_rollback();
					log_message('debug', 'add_customer. - Customer not added. Rolling back. '. print_r($response, 1));
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
				log_message('debug', 'add_customer. - Query = ' . $this->db->last_query());
				if($application_user_added){ //connect this user with customer
					$application_user_id = $this->db->insert_id();
					
					$customer = array(
						'UserId' => $application_user_id
					);
			
					$this->db->where('CustomerId', $customer_id);
					$this->db->update('Customer', $customer);
					log_message('debug', 'add_customer. - Query = ' . $this->db->last_query());
					
					if($this->db->affected_rows() == 1){
						$this->db->trans_commit();
						$response['Result'] = "Success";
						log_message('debug', 'add_customer. - Success');
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
					log_message('debug', 'add_customer. - Rollback'. print_r($response, 1));
					return $response;
				}
				
			} else if ($userActive == 0){ // in case, user does not want to create application user during customer creation
				$application_user_added = true;
			}
			
			if ($customer_added && $application_user_added)
			{		$this->db->trans_commit();
					$response['Result'] = "Success";
					log_message('debug', 'add_customer. - Success');

			} else {
					$this->db->trans_rollback();
					$response['Result'] = $this->db->error();
					$response['query'] = $this->db->last_query();
					$response['message'] = 'customer_added = ' .$application_user_added ;
					log_message('debug', 'add_customer. - Rollback'.print_r($response, 1));
			}

			return $response;
		}
}