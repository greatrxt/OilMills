<?php
class Route_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
		
		function deleteRouteBy($id) {
			$this->db->where( 'RouteID', $id );
			$this->db->delete('route');

			if ($this->db->affected_rows() == '1') {
				return TRUE;
			} else {
				return FALSE;
			}
		}

		public function get_all_routes()
		{

			$result = $this->db->query('SELECT
										  route.RouteID,
										  route.RouteCode,
										  route.RouteName,
										  route.RecordCreationTime,
										  applicationuser.username
										FROM
										  route
										LEFT JOIN
										  applicationuser
										ON
										  route.RecordCreatedBy = applicationuser.UserId;');
			return $result->result_array();
		}
		
		public function get_route_with_id($id)
		{
			$query = $this->db->get_where('route', array('RouteID' => $id));
			return $query->row_array();
		}
		
		public function edit_route($id, $data)
		{	
			$this->db->where('RouteId', $id);
			$this->db->update('route', $data);
			
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
			if($this->db->insert('route', $data)){
				$response['Result'] = "Success";
			} else {
				 $response['Result'] = $this->db->error();
				 $response['query'] = $this->db->last_query();
			}
			return $response;
		}
}