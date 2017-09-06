<?php
class Broker_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
		
		function deleteBrokerBy($id) {
			log_message('debug', 'deleteBrokerBy. - $id = ' . print_r($id, 1));
			
			$this->db->where( 'BrokerID', $id );
			$this->db->delete('Broker');
			
			log_message('debug', 'deleteBrokerBy. - Query = ' . $this->db->last_query());
			
			if ($this->db->affected_rows() == '1') {
				log_message('debug', 'deleteBrokerBy. - BROKER DELETED ');
				return TRUE;
			} else {
				log_message('debug', 'deleteBrokerBy. - FALIED TO DELETE BROKER ');
				return FALSE;
			}
		}

		public function get_broker_count(){
			$query_string = 'SELECT COUNT(BrokerId) AS count from Broker';
			$result = $this->db->query($query_string);
			return $result->row_array();
		}
		
		public function get_all_brokers()
		{
			$result = $this->db->query('SELECT BrokerID,
										  NAME,
										  address,
										  AREA,
										  Location.City,
										  ContactPerson,
										  ContactNumber,
										  EmailAddress,
										  ApplicationUser.Username
										FROM
										  Broker
										LEFT JOIN
										  ApplicationUser
										ON
										  Broker.RecordCreatedBy = ApplicationUser.UserId
										LEFT JOIN
										  Location
										ON
										  Broker.location = Location.LocationID;');
			return $result->result_array();
		}
		
		public function get_broker_with_id($id)
		{
			$query = $this->db->get_where('Broker', array('BrokerID' => $id));
			return $query->row_array();
		}
		
		public function edit_broker($id, $data)
		{	
			log_message('debug', 'edit_broker. - $id = ' . print_r($id, 1) . '$data = ' . print_r($data, 1));
			
			$this->db->where('BrokerId', $id);
			$this->db->update('Broker', $data);
			
			if($this->db->affected_rows() > 0){
				$response['Result'] = "Success";
			} else {
				$response['Result'] =  "No Records Updated";
				$response['query'] = $this->db->last_query();
			}
			
			$response['query'] = $this->db->last_query();
			log_message('debug', 'edit_broker. - response = ' . print_r($response, 1));
			return $response;
		}
		
		public function add_broker($data)
		{	
			log_message('debug', 'add_broker. - $data = ' . print_r($data, 1));
			
			$this->db->query('SET time_zone = "+05:30";');
			if($this->db->insert('Broker', $data)){
				$response['Result'] = "Success";
			} else {
				 $response['Result'] = $this->db->error();
				 $response['query'] = $this->db->last_query();
			}
			log_message('debug', 'add_broker. - Query = ' . $this->db->last_query());
			log_message('debug', 'add_broker. - response = ' . print_r($response, 1));
			return $response;
		}
}