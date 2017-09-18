<?php
class Employee_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
		
		public function get_employee_count(){
			$query_string = 'SELECT COUNT(EmployeeId) AS count from Employee';
			$result = $this->db->query($query_string);
			return $result->row_array();
		}
		
		function deleteEmployeeBy($id) {

			log_message('debug', 'deleteEmployeeBy. - $id = ' . print_r($id, 1));
			$this->db->trans_begin();
			
			$query = $this->db->get_where('Employee', array('EmployeeId' => $id));
			$employee_data =  $query->row_array();
			
			log_message('debug', 'deleteEmployeeBy. - Query = ' . $this->db->last_query());
			
			if(empty($employee_data)){
				$response['Result'] =  "Employee not found";
				log_message('debug', 'deleteEmployeeBy. - Employee not found ');	
				return $response;
			}
			
			$application_user_id = $employee_data['UserId'];
			
			$this->db->delete('Employee', array('EmployeeID' => $id));
			$employees_deleted = $this->db->affected_rows();
			log_message('debug', 'deleteEmployeeBy. - Query = ' . $this->db->last_query());
			
			$username_deleted = true;
			
			if($application_user_id != NULL){
				//delete keys
				$username_deleted = false;
				
				$application_user_query = $this->db->get_where('ApplicationUser', array('UserId' => $application_user_id));
				
				$application_user =  $application_user_query->row_array();
				
				log_message('debug', 'deleteEmployeeBy. - Query = ' . $this->db->last_query());
				
				log_message('debug', 'deleteEmployeeBy. - $application_user = ' . print_r($application_user, 1));
				
				$this->db->delete('ApplicationUser', array('UserId' => $application_user_id));
				log_message('debug', 'deleteEmployeeBy. - Query = ' . $this->db->last_query());
				
				if($this->db->affected_rows() == 1) $username_deleted = true;
				
				if($application_user['TokenId']!=null){
					$username_deleted = false;
					$this->db->delete('keys', array('id' => $application_user['TokenId']));
					if($this->db->affected_rows() == 1) $username_deleted = true;
				} 
				
				log_message('debug', 'deleteEmployeeBy. - Query = ' . $this->db->last_query());
			}
			
			if ($employees_deleted == '1' && $username_deleted) {
				$this->db->trans_commit();
				log_message('debug', 'deleteEmployeeBy. - EMPLOYEE DELETED ');
				return TRUE;
			} else {
				log_message('debug', 'deleteEmployeeBy. - FAILED TO DELETE EMPLOYEE ');
				$this->db->trans_rollback();
				return FALSE;
			}
		}

		public function get_all_employees()
		{
			$result = $this->db->query('SELECT
										  EmployeeID,
										  NAME,
										  department,
										  designation,
										  AREA,
										  Employee.RecordCreationTime,
										  Location.City,
										  ApplicationUser.Username
										FROM
										  Employee
										LEFT JOIN
										  ApplicationUser
										ON
										  Employee.UserId = ApplicationUser.UserId
										LEFT JOIN
										  Location
										ON
										  Employee.location = Location.LocationID');
			
			return $result->result_array();
		}
		
		public function get_employee_with_id($id)
		{
			//$query = $this->db->get_where('employee', array('EmployeeID' => $id));
			//return $query->row_array();
			$result = $this->db->query('SELECT *
						FROM
						  Employee
						LEFT JOIN
						  ApplicationUser
						ON
						  Employee.UserId = ApplicationUser.UserId
						LEFT JOIN
						  Location
						ON
						  Employee.location = Location.LocationID
                         WHERE
                         Employee.EmployeeId = "'. $id.'";');
			
			return $result->result_array();
		}
		
		public function edit_employee($id, $data)
		{	
			log_message('debug', 'edit_employee. - $id = ' . print_r($id, 1) . '$data = ' . print_r($data, 1));
			
			$this->db->trans_begin();
			$this->db->query('SET time_zone = "+05:30";');
			$employee = array(
				'name' => $data['name'],
				'address' => $data['address'],
				'area' => $data['area'],
				'location' => $data['city'],
				'department' => $data['department'],
				'designation' => $data['designation']
			);

			//1) Edit employee table 
			$this->db->where('EmployeeId', $id);
			$this->db->update('Employee', $employee);
			
			log_message('debug', 'edit_employee. - Query = ' . $this->db->last_query());
			
			//2) Add/edit applicationUser
			$query = $this->db->get_where('Employee', array('EmployeeID' => $id));
			$employee_data =  $query->row_array();
			
			log_message('debug', 'edit_employee. - Query = ' . $this->db->last_query());
			
			if(empty($employee_data)){
				$response['Result'] =  "Unknown Error. ";
				log_message('debug', 'edit_employee. - Error = ' . print_r($employee_data, 1));
				return $response;
			}
			
			$application_user_id = $employee_data['UserId'];
			
			$application_user_exists = false;
			if($application_user_id != NULL){
				$application_user_exists = true;
			}
				
			$userActive = 0;
			$application_user = array();
			
			if(isset($data['userActive']) 
				|| array_key_exists('userActive', $data)) {
				$userActive = 1;
			
				$role_string = $data['role'][0];
				if(sizeof($data['role']) == 2){	//In case multiple roles have been selected - Sales + Operations
					$role_string = $data['role'][0].','.$data['role'][1];
				}		
			} else {
				$application_user['TokenId'] = NULL;
			}
			
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
			} else if(!empty($data['username']) 
				AND !empty($data['password'])) {
				$this->db->insert('ApplicationUser', $application_user);
				$application_user_id = $this->db->insert_id();
			}
			
			$this->db->query('DELETE FROM `keys`
				USING `keys` 
				LEFT JOIN ApplicationUser ON(ApplicationUser.TokenId = keys.id)
				WHERE ApplicationUser.TokenId IS NULL');
			
			log_message('debug', 'edit_customer. - Query = ' . $this->db->last_query());
			
			log_message('debug', 'edit_employee. - Query = ' . $this->db->last_query());
			
			if(!$application_user_exists){ //connect this user with employee
					
				$employee = array(
					'UserId' => $application_user_id
				);			
				$this->db->where('EmployeeId', $id);
				$this->db->update('Employee', $employee);					
			}
			 
			log_message('debug', 'edit_employee. - Query = ' . $this->db->last_query());
			
			$this->db->trans_commit();
			$response['Result'] = $this->db->last_query();
			
			log_message('debug', 'edit_employee. - Query = ' . print_r($response, 1));
			
			return $response;
		}
		
		public function add_employee($data)
		{	
			log_message('debug', 'add_employee. - $data = ' . print_r($data, 1));
			
			$this->db->trans_begin();
			$this->db->query('SET time_zone = "+05:30";');
			$employee = array(
				'name' => $data['name'],
				'address' => $data['address'],
				'area' => $data['area'],
				'location' => $data['city'],
				'department' => $data['department'],
				'designation' => $data['designation'],
				'RecordCreatedBy' => $this->session->userdata('userid')
			);
			
			//1) Add to employee table 
			$employee_added = $this->db->insert('Employee', $employee);
			log_message('debug', 'add_employee. - Query = ' . $this->db->last_query());
			
			if(!$employee_added){
					$response['Result'] = $this->db->error();
					$response['query'] = $this->db->last_query();
					$this->db->trans_rollback();
					log_message('debug', 'add_employee. - Employee not added. Rolling back. '. print_r($response, 1));
					return $response;
			}
			
			$employee_id = $this->db->insert_id();
			
			//2) Add applicationUser
			$application_user_added = false;
			
			$userActive = 0;
			if (isset($data['userActive']) 
				|| array_key_exists('userActive', $data)) {
				$userActive = 1;

				$role_string = $data['role'][0];
				if(sizeof($data['role']) == 2){	//In case multiple roles have been selected - Sales + Operations
					$role_string = $data['role'][0].','.$data['role'][1];
				}
			} 
			
			if(!empty($data['username']) AND !empty($data['password'])){
				$application_user = array(
						'Username' => $data['username'],
						'Password' => $data['password'],
						'Active' => 1,
						'Role' => $role_string
				);
				
				$application_user_added = $this->db->insert('ApplicationUser', $application_user);
				log_message('debug', 'add_employee. - Query = ' . $this->db->last_query());
				if($application_user_added){ //connect this user with employee
					$application_user_id = $this->db->insert_id();
					
					$employee = array(
						'UserId' => $application_user_id
					);
			
					$this->db->where('EmployeeId', $employee_id);
					$this->db->update('Employee', $employee);
					log_message('debug', 'add_employee. - Query = ' . $this->db->last_query());
					if($this->db->affected_rows() == 1){
						$this->db->trans_commit();
						$response['Result'] = "Success";
						log_message('debug', 'add_employee. - Success');
						return $response;
					} else {
						$application_user_added = false;
						log_message('debug', 'add_employee. - $application_user_added = false;');
					}
					
				} else {
					$response['Result'] = $this->db->error();
					if($response['Result']['code']==1062) {
						$response['displayMessage'] = 'Username already exists';
					}
					$response['query'] = $this->db->last_query();
					$this->db->trans_rollback();
					log_message('debug', 'add_employee. - Employee not added. Rolling back. '. print_r($response, 1));
					return $response;
				}
				
			} else if ($userActive == 0){ // in case, user does not want to create application user during employee creation
				$application_user_added = true;
			}
			
			if ($employee_added && $application_user_added)
			{		$this->db->trans_commit();
					log_message('debug', 'add_employee. - Success');
					$response['Result'] = "Success";

			} else {
					$this->db->trans_rollback();
					$response['Result'] = $this->db->error();
					$response['query'] = $this->db->last_query();
					$response['message'] = 'employee_added = '.$application_user_added ;
			}

			log_message('debug', 'add_employee. - '. print_r($response, 1));
			return $response;
		}
}