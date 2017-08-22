<?php
class Production_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_production($id){
		$query_string = 'SELECT Product.Name, SUM(OrderEntries.OrderQuantity) as Quantity, GROUP_CONCAT(DISTINCT(OrderId) SEPARATOR ", OD") as OrderId
									FROM OrderEntries 
									LEFT JOIN Product ON OrderEntries.OrderedProductId = Product.ProductId
									WHERE OrderEntries.ProductionId = '.$id.'
									GROUP BY Product.Name';
		$result = $this->db->query($query_string);
		return $result->result_array();			
	}
	
	public function get_production_estimate($orderEntryIds){
		$parameters = '';
		$count = 0;
		foreach($orderEntryIds as $orderEntryId){
			$parameters = $parameters.$orderEntryId;
			$count++;
			if($count!=sizeof($orderEntryIds)){
				$parameters = $parameters.',';
			}
		}
	
		$query_string = 'SELECT Product.Name, SUM(OrderEntries.OrderQuantity) as Quantity
									FROM OrderEntries 
									LEFT JOIN Product ON OrderEntries.OrderedProductId = Product.ProductId
									WHERE OrderEntries.OrderEntryId IN ('.$parameters.')
									GROUP BY Product.Name';
		$result = $this->db->query($query_string);
		//return $query_string;	
		return $result->result_array();	
	}	
	
	public function get_all_production(){
		$result = $this->db->query('SELECT Production.ProductionId, SUM(OrderEntries.OrderQuantity) as Quantity, ProductionTime, count(distinct OrderEntries.OrderedProductId) as ProductCount, ApplicationUser.Username
									FROM Production 
									LEFT JOIN OrderEntries ON OrderEntries.ProductionId = Production.ProductionId
									LEFT JOIN ApplicationUser ON Production.SentForProductionByUser = ApplicationUser.UserId
									GROUP BY ProductionId');
		return $result->result_array();	
	}
	
	public function confirm_production($orderEntryIds){
		
		$this->db->trans_begin();
		$production = array(
			'SentForProductionByUser' => $this->session->userdata('userid')
		);
		$this->db->query('SET time_zone = "+05:30";');
		$this->db->insert('Production', $production);
		$production_id = $this->db->insert_id();
		$count = 0;
		foreach($orderEntryIds as $orderEntryId){
				$orderEntry = array(
					'ProductionId' => $production_id
				);
				$this->db->where('OrderEntryId', $orderEntryId);
				$this->db->where('Status!=', 'PENDING_APPROVAL');
				$this->db->update('OrderEntries', $orderEntry);
				
				if($this->db->affected_rows() == 1){
					$count++;
				}
		}
		
		if($count > 0){
			$this->db->trans_commit();
		} else {
			$this->db->trans_rollback();
		}
	}
}