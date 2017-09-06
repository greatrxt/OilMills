<?php
class Location_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
		
		function deleteLocationBy($id) {
			log_message('debug', 'deleteLocationBy. - $id = ' . print_r($id, 1));
			
			$this->db->where( 'LocationID', $id );
			$this->db->delete('Location');

			log_message('debug', 'deleteLocationBy. - Query = ' . $this->db->last_query());
			
			if ($this->db->affected_rows() == '1') {
				log_message('debug', 'deleteLocationBy. - DELETED ');
				return TRUE;
			} else {
				log_message('debug', 'deleteLocationBy. - FALIED TO DELETE ');
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
			
			log_message('debug', 'edit_location. - $id = ' . print_r($id, 1) . '$data = ' . print_r($data, 1));
			
			$this->db->query('SET time_zone = "+05:30";');
			$this->db->where('LocationId', $id);
			$this->db->update('Location', $data);
			
			log_message('debug', 'edit_location. - Query = ' . $this->db->last_query());
			
			if($this->db->affected_rows() > 0){
				$response['Result'] = "Success";
			} else {
				$response['Result'] =  "No Records Updated";
			}
			$response['query'] = $this->db->last_query();
			log_message('debug', 'edit_location. - response = ' . print_r($response, 1));
			return $response;
		}
		
		public function add_location($data)
		{	
			log_message('debug', 'add_location. - $data = ' . print_r($data, 1));
			
			$this->db->query('SET time_zone = "+05:30";');
			if($this->db->insert('Location', $data)){
				$response['Result'] = "Success";
			} else {
				 $response['Result'] = $this->db->error();
				 $response['query'] = $this->db->last_query();
			}
			log_message('debug', 'edit_location. - Query = ' . $this->db->last_query());
			log_message('debug', 'edit_location. - response = ' . print_r($response, 1) );
			return $response;
		}
}