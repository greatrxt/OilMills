<?php
class Production_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_production_details_for_current_date(){
		$query_string = 'SELECT COUNT(DISTINCT(OrderId)) AS orderCount, IFNULL(SUM(SellingPriceAtOrderTime * OrderQuantity), 0) AS value FROM `OrderEntries` 
							LEFT JOIN `Production` 
							ON OrderEntries.ProductionId = Production.ProductionId 
							WHERE DATE(ProductionTime) = CURDATE()';
		$result = $this->db->query($query_string);
		return $result->row_array();							
	}
	
	public function get_production_details_for_current_month(){
		$query_string = 'SELECT COUNT(DISTINCT(OrderId)) AS orderCount, IFNULL(SUM(SellingPriceAtOrderTime * OrderQuantity), 0) AS value FROM `OrderEntries` 
							LEFT JOIN `Production` 
							ON OrderEntries.ProductionId = Production.ProductionId 
							WHERE ProductionTime between  DATE_FORMAT(NOW() ,"%Y-%m-01") AND NOW()';
		$result = $this->db->query($query_string);
		return $result->row_array();							
	}
	
	
	public function get_production_time($id){
		$query_string = 'SELECT ProductionTime from Production WHERE Production.ProductionId = '.$id;
		$result = $this->db->query($query_string);
		return $result->row_array();			
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
		
		log_message('debug', 'confirm_production. - $orderEntryIds = ' . print_r($orderEntryIds, 1));
		
		$this->db->trans_begin();
		$production = array(
			'SentForProductionByUser' => $this->session->userdata('userid')
		);
		$this->db->query('SET time_zone = "+05:30";');
		$this->db->insert('Production', $production);
		$production_id = $this->db->insert_id();
		log_message('debug', 'confirm_production. - Query = ' . $this->db->last_query());
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
				log_message('debug', 'confirm_production. - Query = ' . $this->db->last_query());
		}
		
		if($count > 0){
			$this->db->trans_commit();
			log_message('debug', 'confirm_production. - trans_commit');
		} else {
			log_message('debug', 'confirm_production. - trans_rollback');
			$this->db->trans_rollback();
		}
		
		log_message('debug', '$production_id. = '.$production_id);
		
		return $production_id;
	}
}