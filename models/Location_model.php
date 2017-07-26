<?php
class Location_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
		
		function deleteLocationBy($id) {
			$this->db->where( 'LocationID', $id );
			$this->db->delete('location');

			if ($this->db->affected_rows() == '1') {
				return TRUE;
			} else {
				return FALSE;
			}
		}

		public function get_all_locations()
		{
			//$query = $this->db->get('location');
			//SELECT location.LocationID, location.City, location.District, location.State, applicationuser.username FROM location left join applicationuser on location.RecordCreatedBy = applicationuser.UserId;
			/*$query = $this->db->select('location.LocationID, location.City, location.District, location.RecordCreationTime, location.State, applicationuser.username')
                  ->from('location')
                  ->join('applicationuser', 'applicationuser.UserId = location.RecordCreatedBy', 'left')
                  ->get();*/
			$result = $this->db->query('SELECT
										  location.LocationID,
										  location.City,
										  location.District,
										  location.State,
										  location.RecordCreationTime,
										  applicationuser.username
										FROM
										  location
										LEFT JOIN
										  applicationuser
										ON
										  location.RecordCreatedBy = applicationuser.UserId;');
			return $result->result_array();
		}
		
		public function get_location_with_id($id)
		{
			$query = $this->db->get_where('location', array('LocationID' => $id));
			return $query->row_array();
		}
		
		public function edit_location($id, $data)
		{	
			$this->db->where('LocationId', $id);
			$this->db->update('location', $data);
			
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
			if($this->db->insert('location', $data)){
				$response['Result'] = "Success";
			} else {
				 $response['Result'] = $this->db->error();
				 $response['query'] = $this->db->last_query();
			}
			return $response;
		}
}