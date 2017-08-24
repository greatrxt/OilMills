<?php
class User_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_user_count(){
		$query_string = 'SELECT COUNT(UserId) AS count from ApplicationUser';
		$result = $this->db->query($query_string);
		return $result->row_array();
	}
	
	public function get_user_from_token($token){
		$this->db->where('key', $token);
		$query = $this->db->get('keys');
		$rowcount = $query->num_rows();
		$key_entry = $query->row_array();
		if($rowcount == 1){	
			$key_id = $key_entry['id'];
			$this->db->where('TokenId', $key_id);
			$query = $this->db->get('ApplicationUser');
			$app_user_rowcount = $query->num_rows();
			$application_user = $query->row_array();
			if($app_user_rowcount == 1){	
				return $application_user;
			}
		} 
		return null;
	}
	
	public function token_based_login($username, $password){
		$this->db->where('Username', $username);
		$this->db->where('Password', $password);
		$query = $this->db->get('ApplicationUser');
		$rowcount = $query->num_rows();
		$application_user = $query->row_array();
		$this->db->query('SET time_zone = "+05:30";');
		if($rowcount == 1){	
						
			if($application_user['Active'] != 1){
				$result['Result'] = 'Failed';
				$result['Message'] = 'User Inactive';
				return $result;
			}
					
			//check role ?? $application_user;
			$this->load->helper('string');
			$this->load->helper('date');
			
			$token = random_string('alnum', 40);
			
			$token_data = array(
				'key' => $token,
				'level' => 0,
				'ignore_limits' => 0,
				'date_created' => now('Asia/Kolkata')
			);
			
			if($application_user['TokenId'] == NULL){
				//Insert into keys table
				//Fetch ID of interted row 
				//update ApplicationUser table
				
				if($this->db->insert('keys', $token_data)){
					$key_id = $this->db->insert_id();
					
					$application_user_key = array(
						'TokenId' => $key_id
					);
					
					$this->db->where('UserId', $application_user['UserId']);
					$this->db->update('ApplicationUser', $application_user_key);
			
					if($this->db->affected_rows() > 0){

						if($application_user['Role'] == 'CUSTOMER'){
							$this->db->where('UserId', $application_user['UserId']);
							$query = $this->db->get('Customer');
							$rowcount = $query->num_rows();
							$customer = $query->row_array();
							if($rowcount == 1){	
								$result['CustomerId'] = $customer['CustomerId'];
								$result['Result'] = 'Success';
								$result['Role'] = $application_user['Role'];
								$result['Token'] = $token;
								$result['UserId'] = $application_user['UserId'];
								return $result;								
							} else {
								$result['Result'] = 'Failed';
								$result['Message'] = 'Could not find Customer linked to username';
								return $result;
							}
						} else if ($application_user['Role'] == 'ADMIN' ||
								$application_user['Role'] == 'SALES' ||
								$application_user['Role'] == 'OPERATIONS' ||
									strpos($application_user['Role'], 'SALES') ||
									strpos($application_user['Role'], 'OPERATIONS')){
							$this->db->where('UserId', $application_user['UserId']);
							$query = $this->db->get('Employee');
							$rowcount = $query->num_rows();
							$employee = $query->row_array();
							if($rowcount == 1){	
								$result['EmployeeId'] = $employee['EmployeeId'];
								$result['Result'] = 'Success';
								$result['Role'] = $application_user['Role'];
								$result['Token'] = $token;
								$result['UserId'] = $application_user['UserId'];
								return $result;								
							} else {
								$result['Result'] = 'Failed';
								$result['Message'] = 'Could not find Employee linked to username';
								return $result;
							}										
						}
						
					} else {
						$result['Result'] = 'Failed';
						$result['Message'] = 'Failed to update user table';
						return $result;
					}
				} else {
					$result['Result'] = 'Failed';
					$result['Message'] = 'Failed to insert token into keys';
					return $result;
				}
			} else {
				// fetch TokenId for user
				//UPDATE corresponding row in keys table
				$this->db->where('id', $application_user['TokenId']);
				$this->db->update('keys', $token_data);
				if($this->db->affected_rows() > 0){
					$result = array();
					if($application_user['Role'] == 'CUSTOMER'){
							$this->db->where('UserId', $application_user['UserId']);
							$query = $this->db->get('Customer');
							$rowcount = $query->num_rows();
							$customer = $query->row_array();
							if($rowcount == 1){	
								$result['CustomerId'] = $customer['CustomerId'];
								$result['Result'] = 'Success';
								$result['Role'] = $application_user['Role'];
								$result['Token'] = $token;
								$result['UserId'] = $application_user['UserId'];
								return $result;	
							} else {
								$result['Result'] = 'Failed';
								$result['Message'] = 'Could not find Customer linked to username';
								return $result;
							}
						} else if ($application_user['Role'] == 'ADMIN' ||
								$application_user['Role'] == 'SALES' ||
								$application_user['Role'] == 'OPERATIONS' ||
									strpos($application_user['Role'], 'SALES') ||
									strpos($application_user['Role'], 'OPERATIONS')){
							$this->db->where('UserId', $application_user['UserId']);
							$query = $this->db->get('Employee');
							$rowcount = $query->num_rows();
							$employee = $query->row_array();
							if($rowcount == 1){	
								$result['EmployeeId'] = $employee['EmployeeId'];
								$result['Result'] = 'Success';
								$result['Role'] = $application_user['Role'];
								$result['Token'] = $token;
								$result['UserId'] = $application_user['UserId'];
								return $result;		
							} else {
								$result['Result'] = 'Failed';
								$result['Message'] = 'Could not find Employee linked to username';
								return $result;
							}										
						} else {
							$result['Result'] = 'Failed';
							$result['Message'] = 'Invalid User Role - ' . $application_user['Role'];
							return $result;		
						}
						

				} else {
					$result['Result'] = 'Failed';
					$result['Role'] = $application_user['Role'];
					$result['Message'] = 'Failed to update user table';
					return $result;
				}
			}
			
		}
		$result['Result'] = 'Failed';
		$result['Message'] = 'Invalid Credentials';
		return $result;
	}
	
	public function get_user_id($username, $password){
		$this->db->where('Username', $username);
		$this->db->where('Password', $password);
		$query = $this->db->get('ApplicationUser');
		$rowcount = $query->num_rows();
		$application_user = $query->row_array();
		if($rowcount == 1){	
			return $application_user;
		}
		return null;
	}
	
	public function user_exists($username){
		$this->db->where('Username', $username);
		$query = $this->db->get('ApplicationUser');
		$rowcount = $query->num_rows();
		$application_user = $query->row_array();
		if($rowcount > 0){
			return $application_user;
		}
		return null;
	}
}
?>