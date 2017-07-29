<?php
class User_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
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