<?php
class Route_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
		
		function deleteRouteBy($id) {
			log_message('debug', 'deleteRouteBy. - $id = ' . print_r($id, 1));
			
			$this->db->where( 'RouteID', $id );
			$this->db->delete('Route');

			log_message('debug', 'deleteRouteBy. - Query = ' . $this->db->last_query());
			
			if ($this->db->affected_rows() == '1') {
				log_message('debug', 'deleteRouteBy. - Route delete');
				return TRUE;
			} else {
				log_message('debug', 'deleteRouteBy. - failed to delete');
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
			log_message('debug', 'edit_route. - $id = ' . print_r($id, 1) . '$data = ' . print_r($data, 1));
			
			$this->db->query('SET time_zone = "+05:30";');
			$this->db->where('RouteId', $id);
			$this->db->update('Route', $data);
			
			if($this->db->affected_rows() > 0){
				$response['Result'] = "Success";
			} else {
				$response['Result'] =  "No Records Updated";
			}
			$response['query'] = $this->db->last_query();
			log_message('debug', 'edit_route. - response = ' . print_r($response, 1));
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
			log_message('debug', 'add_route. - Query = ' . $this->db->last_query());
			log_message('debug', 'add_route. - response = ' . print_r($response, 1));
			return $response;
		}
}