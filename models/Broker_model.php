<?php
class Broker_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
		
		function deleteBrokerBy($id) {
			$this->db->where( 'BrokerID', $id );
			$this->db->delete('broker');

			if ($this->db->affected_rows() == '1') {
				return TRUE;
			} else {
				return FALSE;
			}
		}

		public function get_all_brokers()
		{
			$result = $this->db->query('SELECT BrokerID,
										  NAME,
										  address,
										  AREA,
										  location.City,
										  ContactPerson,
										  ContactNumber,
										  EmailAddress,
										  applicationuser.Username
										FROM
										  broker
										LEFT JOIN
										  applicationuser
										ON
										  broker.RecordCreatedBy = applicationuser.UserId
										LEFT JOIN
										  location
										ON
										  broker.location = location.LocationID;');
			return $result->result_array();
		}
		
		public function get_broker_with_id($id)
		{
			$query = $this->db->get_where('broker', array('BrokerID' => $id));
			return $query->row_array();
		}
		
		public function edit_broker($id, $data)
		{	
			$this->db->where('BrokerId', $id);
			$this->db->update('broker', $data);
			
			if($this->db->affected_rows() > 0){
				$response['Result'] = "Success";
			} else {
				$response['Result'] =  "No Records Updated";
				$response['query'] = $this->db->last_query();
			}
			$response['query'] = $this->db->last_query();
			return $response;
		}
		
		public function add_broker($data)
		{	
			if($this->db->insert('broker', $data)){
				$response['Result'] = "Success";
			} else {
				 $response['Result'] = $this->db->error();
				 $response['query'] = $this->db->last_query();
			}
			return $response;
		}
}