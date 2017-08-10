<?php
class Route_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
		
		function deleteRouteBy($id) {
			$this->db->where( 'RouteID', $id );
			$this->db->delete('Route');

			if ($this->db->affected_rows() == '1') {
				return TRUE;
			} else {
				return FALSE;
			}
		}

		public function get_all_routes()
		{

			$result = $this->db->query('SELECT
										  Route.RouteID,
										  Route.RouteCode,
										  Route.RouteName,
										  Route.RecordCreationTime,
										  ApplicationUser.username
										FROM
										  Route
										LEFT JOIN
										  ApplicationUser
										ON
										  Route.RecordCreatedBy = ApplicationUser.UserId;');
			return $result->result_array();
		}
		
		public function get_route_with_id($id)
		{
			$query = $this->db->get_where('Route', array('RouteID' => $id));
			return $query->row_array();
		}
		
		public function edit_route($id, $data)
		{	
			$this->db->query('SET time_zone = "+05:30";');
			$this->db->where('RouteId', $id);
			$this->db->update('Route', $data);
			
			if($this->db->affected_rows() > 0){
				$response['Result'] = "Success";
			} else {
				$response['Result'] =  "No Records Updated";
			}
			$response['query'] = $this->db->last_query();
			return $response;
		}
		
		public function add_route($data)
		{	
			$this->db->query('SET time_zone = "+05:30";');
			if($this->db->insert('Route', $data)){
				$response['Result'] = "Success";
			} else {
				 $response['Result'] = $this->db->error();
				 $response['query'] = $this->db->last_query();
			}
			return $response;
		}
}