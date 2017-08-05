<?php
class Employee_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
		
		function deleteEmployeeBy($id) {

			$query = $this->db->get_where('Employee', array('EmployeeId' => $id));
			$employee_data =  $query->row_array();
			
			if(empty($employee_data)){
				$response['Result'] =  "Employee not found";
				return $response;
			}
			
			$application_user_id = $employee_data['UserId'];
			
			$this->db->delete('Employee', array('EmployeeID' => $id));
			$employees_deleted = $this->db->affected_rows();
			
			if($application_user_id != NULL){
				$this->db->delete('ApplicationUser', array('UserId' => $application_user_id));
			}
			
			if ($employees_deleted == '1') {
				return TRUE;
			} else {
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
			$this->db->trans_begin();
			
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
			
			//2) Add/edit applicationUser
			$query = $this->db->get_where('Employee', array('EmployeeID' => $id));
			$employee_data =  $query->row_array();
			
			if(empty($employee_data)){
				$response['Result'] =  "Unknown Error. ";
				return $response;
			}
			
			$application_user_id = $employee_data['UserId'];
			
			$application_user_exists = false;
			if($application_user_id != NULL){
				$application_user_exists = true;
			}
				
			$userActive = 0;
			if (isset($data['userActive']) 
				|| array_key_exists('userActive', $data)) {
				$userActive = 1;
			} 
			
			$role_string = $data['role'][0];
			if(sizeof($data['role']) == 2){	//In case multiple roles have been selected - Sales + Operations
				$role_string = $data['role'][0].','.$data['role'][1];
			}
			
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
			} else if(!empty($data['username']) 
				AND !empty($data['password'])) {
				$this->db->insert('ApplicationUser', $application_user);
				$application_user_id = $this->db->insert_id();
			}
			
			if(!$application_user_exists){ //connect this user with employee
					
				$employee = array(
					'UserId' => $application_user_id
				);			
				$this->db->where('EmployeeId', $id);
				$this->db->update('Employee', $employee);					
			}
			 
			
			$this->db->trans_commit();
			$response['Result'] = $this->db->last_query();

			return $response;
		}
		
		public function add_employee($data)
		{	

			$this->db->trans_begin();
			
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
			
			if(!$employee_added){
					$response['Result'] = $this->db->error();
					$response['query'] = $this->db->last_query();
					$this->db->trans_rollback();
					return $response;
			}
			
			$employee_id = $this->db->insert_id();
			
			//2) Add applicationUser
			$application_user_added = false;
			
			$userActive = 0;
			if (isset($data['userActive']) 
				|| array_key_exists('userActive', $data)) {
				$userActive = 1;
			} 
			
			$role_string = $data['role'][0];
			if(sizeof($data['role']) == 2){	//In case multiple roles have been selected - Sales + Operations
				$role_string = $data['role'][0].','.$data['role'][1];
			}
			
			if(!empty($data['username']) AND !empty($data['password'])){
				$application_user = array(
						'Username' => $data['username'],
						'Password' => $data['password'],
						'Active' => 1,
						'Role' => $role_string
				);
				
				$application_user_added = $this->db->insert('ApplicationUser', $application_user);
				
				if($application_user_added){ //connect this user with employee
					$application_user_id = $this->db->insert_id();
					
					$employee = array(
						'UserId' => $application_user_id
					);
			
					$this->db->where('EmployeeId', $employee_id);
					$this->db->update('Employee', $employee);
					
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
				
			} else if ($userActive == 0){ // in case, user does not want to create application user during employee creation
				$application_user_added = true;
			}
			
			if ($employee_added && $application_user_added)
			{		$this->db->trans_commit();
					$response['Result'] = "Success";

			} else {
					$this->db->trans_rollback();
					$response['Result'] = $this->db->error();
					$response['query'] = $this->db->last_query();
					$response['message'] = 'employee_added = ' . $application_user_added . '' .$application_user_added ;
			}

			return $response;
		}
}