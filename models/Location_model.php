<?php
class Location_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
		
		function deleteLocationBy($id) {
			$this->db->where( 'LocationID', $id );
			$this->db->delete('Location');

			if ($this->db->affected_rows() == '1') {
				return TRUE;
			} else {
				return FALSE;
			}
		}

		public function get_all_locations()
		{
			$result = $this->db->query('SELECT
										  Location.LocationID,
										  Location.City,
										  Location.District,
										  Location.State,
										  Location.RecordCreationTime,
										  ApplicationUser.username
										FROM
										  Location
										LEFT JOIN
										  ApplicationUser
										ON
										  Location.RecordCreatedBy = ApplicationUser.UserId;');
			return $result->result_array();
		}
		
		public function get_location_with_id($id)
		{
			$query = $this->db->get_where('Location', array('LocationID' => $id));
			return $query->row_array();
		}
		
		public function edit_location($id, $data)
		{
			$this->db->query('SET time_zone = "+05:30";');
			$this->db->where('LocationId', $id);
			$this->db->update('Location', $data);
			
			if($this->db->affected_rows() > 0){
				$response['Result'] = "Success";
			} else {
				$response['Result'] =  "No Records Updated";
			}
			$response['query'] = $this->db->last_query();
			return $response;
		}
		
		public function add_location($data)
		{	
			$this->db->query('SET time_zone = "+05:30";');
			if($this->db->insert('Location', $data)){
				$response['Result'] = "Success";
			} else {
				 $response['Result'] = $this->db->error();
				 $response['query'] = $this->db->last_query();
			}
			return $response;
		}
}