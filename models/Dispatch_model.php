<?php
class Dispatch_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	/**
	For dashboard. Calculates total dispatch value for current date in INR
	*/
	public function get_orders_entries_dispatched_today_amount(){
		$this->db->query('SET time_zone = "+05:30";');
		$query_string = 'SELECT
						IFNULL(SUM(SellingPriceAtOrderTime * OrderEntries_Dispatch.DispatchQuantity), 0) AS total
						FROM
						OrderEntries_Dispatch
						LEFT JOIN
						OrderEntries
						ON OrderEntries_Dispatch.OrderEntryId = OrderEntries.OrderEntryId
						LEFT JOIN
						Dispatch
						ON Dispatch.DispatchId = OrderEntries_Dispatch.DispatchId
						WHERE 
						DATE(Dispatch.DispatchTime) = CURDATE()';
		
		$result = $this->db->query($query_string);
		return $result->row_array();	
	}

	public function get_order_entries_dispatched_for_current_month(){
		$this->db->query('SET time_zone = "+05:30";');
		$query_string = 'SELECT
						COUNT(DISTINCT(OrderEntries.OrderEntryId)) AS OrderEntryCount,
						COUNT(DISTINCT(OrderId)) AS OrderCount,
						IFNULL(SUM(SellingPriceAtOrderTime * OrderEntries_Dispatch.DispatchQuantity), 0) AS total
						FROM
						OrderEntries_Dispatch
						LEFT JOIN
						OrderEntries
						ON OrderEntries_Dispatch.OrderEntryId = OrderEntries.OrderEntryId
						LEFT JOIN
						Dispatch
						ON Dispatch.DispatchId = OrderEntries_Dispatch.DispatchId
						WHERE 
						(DispatchTime between  DATE_FORMAT(NOW() ,"%Y-%m-01") AND NOW() )';
		
		$result = $this->db->query($query_string);
		return $result->row_array();	
	}
	
	public function get_orders_entries_dispatched_today_count(){
		$this->db->query('SET time_zone = "+05:30";');
		$query_string = 'SELECT
						COUNT(DISTINCT(OrderEntries.OrderEntryId)) AS OrderEntryCount,
						COUNT(DISTINCT(OrderId)) AS OrderCount
						FROM
						OrderEntries_Dispatch
						LEFT JOIN
						Dispatch
						ON Dispatch.DispatchId = OrderEntries_Dispatch.DispatchId
						LEFT JOIN
						OrderEntries
						ON
						OrderEntries_Dispatch.OrderEntryId = OrderEntries.OrderEntryId
						WHERE 
						DATE(Dispatch.DispatchTime) = CURDATE()';
		
		$result = $this->db->query($query_string);
		return $result->row_array();	
	}
	
	public function get_routes_for_dispatch($id){
		$query_string = 'SELECT DISTINCT(Route.RouteId) AS RouteID, Route.RouteName
							FROM OrderEntries 
							LEFT JOIN SalesOrder ON OrderEntries.OrderId = SalesOrder.OrderId
							LEFT JOIN OrderEntries_Dispatch ON OrderEntries_Dispatch.OrderEntryId = OrderEntries.OrderEntryId
							LEFT JOIN Customer ON SalesOrder.CustomerId = Customer.CustomerId
							LEFT JOIN Route ON OrderEntries_Dispatch.RouteId = Route.RouteId
							WHERE OrderEntries_Dispatch.DispatchID = '.$id;
		$result = $this->db->query($query_string);
		return $result->result_array();	
	}
	
	public function get_dispatch_details($id){
		$this->db->where('DispatchId', $id);
		$query = $this->db->get('Dispatch');
		return $query->row_array();	
	}
	
	public function get_dispatch($id){
		$query_string = 'SELECT Product.Code, Product.Name as ProductName, Broker.Name as BrokerName, PaymentTerms, SellingPriceAtOrderTime, GROUP_CONCAT(DISTINCT(SalesOrder.OrderId) SEPARATOR ", OD") as OrderId,
									SUM(OrderEntries_Dispatch.DispatchQuantity) as DispatchQuantity, Customer.Name as CustomerName, Route.RouteName, Route.RouteId
									FROM OrderEntries 
									LEFT JOIN Product ON OrderEntries.OrderedProductId = Product.ProductId
									LEFT JOIN SalesOrder ON OrderEntries.OrderId = SalesOrder.OrderId
									LEFT JOIN Broker ON SalesOrder.LinkedBrokerId = Broker.BrokerId
									LEFT JOIN Customer ON SalesOrder.CustomerId = Customer.CustomerId
									LEFT JOIN OrderEntries_Dispatch ON OrderEntries_Dispatch.OrderEntryId = OrderEntries.OrderEntryId
									LEFT JOIN Route ON OrderEntries_Dispatch.RouteId = Route.RouteId
									WHERE OrderEntries_Dispatch.DispatchID = '.$id.'
									GROUP BY CustomerName, ProductName, SellingPriceAtOrderTime
									ORDER BY Route.RouteId';
		$result = $this->db->query($query_string);
		return $result->result_array();			
	}
	
	/**
	Calculates customer wise total - sums up order quantity for SAME products to get final product-wise order quantity for customer
	*/
	public function get_customer_product_wise_total($orderEntryIds){
		
		$parameters = '';
		$count = 0;
		foreach($orderEntryIds as $orderEntryId){
			$parameters = $parameters.$orderEntryId;
			$count++;
			if($count!=sizeof($orderEntryIds)){
				$parameters = $parameters.',';
			}
		}

		$query_string ='SELECT
						Customer.CustomerId AS CustomerId,
						Customer.Name AS CustomerName,
						Product.ProductId AS ProductId,
						Product.Name,
						SUM(OrderQuantity) as OrderQuantity,
						RouteName,
						Route.RouteId,
						(SUM(OrderEntries.OrderQuantity) - SUM(OrderEntries_Dispatch.DispatchQuantity)) AS Balance
						FROM
						OrderEntries
						LEFT JOIN
						Production
						ON
						Production.ProductionId = OrderEntries.ProductionId
						LEFT JOIN
						SalesOrder
						ON
						OrderEntries.OrderId = SalesOrder.OrderId
						LEFT JOIN
						Customer
						ON
						SalesOrder.CustomerId = Customer.CustomerId
						LEFT JOIN
						Route
						ON
						Customer.Route = Route.RouteId
						LEFT JOIN
						Product
						ON
						OrderEntries.OrderedProductId = Product.ProductId
						LEFT JOIN
						OrderEntries_Dispatch
						ON
						OrderEntries_Dispatch.OrderEntryId = OrderEntries.OrderEntryId
						LEFT JOIN
						Dispatch
						ON
						OrderEntries_Dispatch.DispatchID = Dispatch.DispatchId
						WHERE
						(OrderEntries.Status = "APPROVED" ||
						OrderEntries.Status = "PARTIALLY_DISPATCHED") &&
						OrderEntries.OrderEntryId IN ('.$parameters.')
						GROUP BY
						Customer.CustomerId,
						Product.ProductId';
		
		$result = $this->db->query($query_string);
		return $result->result_array();	
	}
	
	/**
	Calculates customer wise total - sums up order quantity for DIFFERENT products to get final order quantity for customer
	*/
	public function get_customer_for($orderEntryIds){
		$parameters = '';
		$count = 0;
		foreach($orderEntryIds as $orderEntryId){
			$parameters = $parameters.$orderEntryId;
			$count++;
			if($count!=sizeof($orderEntryIds)){
				$parameters = $parameters.',';
			}
		}

		$query_string = 'SELECT
						COUNT(DISTINCT(Product.Name)) AS ProductCount,
						Customer.CustomerId,
						Customer.Name AS CustomerName,
						SUM(OrderQuantity) as OrderQuantity,
						(SUM(OrderQuantity) - SUM(OrderEntries_Dispatch.DispatchQuantity)) AS Balance,
						RouteName,
						Route.RouteId
						FROM
						OrderEntries
						LEFT JOIN
						SalesOrder
						ON
						OrderEntries.OrderId = SalesOrder.OrderId
						LEFT JOIN
						Customer
						ON
						SalesOrder.CustomerId = Customer.CustomerId
						LEFT JOIN
						Route
						ON
						Customer.Route = Route.RouteId
						LEFT JOIN
						Product
						ON
						OrderEntries.OrderedProductId = Product.ProductId
						LEFT JOIN
						OrderEntries_Dispatch
						ON
						OrderEntries_Dispatch.OrderEntryId = OrderEntries.OrderEntryId
						WHERE
						(OrderEntries.Status = "APPROVED" ||
						OrderEntries.Status = "PARTIALLY_DISPATCHED") &&
						OrderEntries.OrderEntryId IN ('.$parameters.')
						GROUP BY
						Customer.CustomerId
						ORDER BY
						OrderEntries.OrderId';
		$result = $this->db->query($query_string);
		//return $query_string;	
		return $result->result_array();	
	}
	
	public function get_dispatch_estimate($orderEntryIds){
		log_message('debug', 'get_dispatch_estimate. - $orderEntryIds = ' . print_r($orderEntryIds, 1));
		$parameters = '';
		$count = 0;
		foreach($orderEntryIds as $orderEntryId){
			$parameters = $parameters.$orderEntryId;
			$count++;
			if($count!=sizeof($orderEntryIds)){
				$parameters = $parameters.',';
			}
		}

		$query_string = 'SELECT
						OrderEntries.OrderEntryId,
						OrderEntries.OrderId,
						ApplicationUser.Username,
						SalesOrder.PaymentTerms,
						Product.ProductId AS ProductId,
						Product.Name AS ProductName,
						Customer.CustomerId AS CustomerId,
						Customer.Name AS CustomerName,
						Broker.Name AS BrokerName,
						SellingPriceAtOrderTime,
						OrderQuantity,
						ProductionTime,
						OrderTime,
						OrderEntries.Status,
						OrderEntries.ProductionId,
						(OrderEntries.OrderQuantity - SUM(OrderEntries_Dispatch.DispatchQuantity)) AS Balance
						FROM
						OrderEntries
						LEFT JOIN
						Production
						ON
						Production.ProductionId = OrderEntries.ProductionId
						LEFT JOIN
						SalesOrder
						ON
						OrderEntries.OrderId = SalesOrder.OrderId
						LEFT JOIN
						Customer
						ON
						SalesOrder.CustomerId = Customer.CustomerId
						LEFT JOIN
						Product
						ON
						OrderEntries.OrderedProductId = Product.ProductId
						LEFT JOIN
						Broker
						ON
						SalesOrder.LinkedBrokerId = Broker.BrokerId
						LEFT JOIN
						ApplicationUser
						ON
						SalesOrder.OrderPlacedByUser = ApplicationUser.UserId
						LEFT JOIN
						OrderEntries_Dispatch
						ON
						OrderEntries_Dispatch.OrderEntryId = OrderEntries.OrderEntryId
						LEFT JOIN
						Dispatch
						ON
						OrderEntries_Dispatch.DispatchID = Dispatch.DispatchId
						WHERE
						(OrderEntries.Status = "APPROVED" ||
						OrderEntries.Status = "PARTIALLY_DISPATCHED") &&
						OrderEntries.OrderEntryId IN ('.$parameters.')
						GROUP BY OrderEntries.OrderEntryId
						ORDER BY
						OrderEntries.OrderId';
		$result = $this->db->query($query_string);
		
		log_message('debug', 'get_dispatch_estimate. - Query = ' . $this->db->last_query());
		log_message('debug', 'get_dispatch_estimate. - Query Result = ' . print_r($result->result_array(), 1));
		
		//return $query_string;	
		return $result->result_array();	
	}		

	public function get_all_dispatch(){

		$query = $this->db->query('SELECT Dispatch.DispatchId, count(distinct OrderEntries.OrderedProductId) as ProductCount, SUM(OrderEntries_Dispatch.DispatchQuantity) as Quantity,  DispatchTime, ApplicationUser.Username
									FROM Dispatch 
									LEFT JOIN OrderEntries_Dispatch ON Dispatch.DispatchId = OrderEntries_Dispatch.DispatchId
									LEFT JOIN ApplicationUser ON Dispatch.DispatchedByUser = ApplicationUser.UserId
									LEFT JOIN OrderEntries ON OrderEntries_Dispatch.OrderEntryId = OrderEntries.OrderEntryId
									GROUP BY Dispatch.DispatchId');
		return $query->result_array();	
	}
	
	public function confirm_dispatch($orderEntryIds, $customDispatch){
		
		log_message('debug', 'confirm_dispatch. $orderEntryIds = ' . print_r($orderEntryIds, 1). ', $customDispatch = '. print_r($orderEntryIds, 1));
		
		$this->db->trans_begin();
		$dispatch = array(
			'DispatchedByUser' => $this->session->userdata('userid')
		);
		$this->db->query('SET time_zone = "+05:30";');
		$this->db->insert('Dispatch', $dispatch);
		log_message('debug', 'confirm_dispatch. - Query = ' . $this->db->last_query());
		//return $this->db->last_query();
		$dispatch_id = $this->db->insert_id();
		$count = 0;
		foreach($orderEntryIds as $orderEntryId){	
			
			$query = $this->db->query('SELECT OrderEntries.OrderEntryId, OrderQuantity, Customer.Route, SalesOrder.CustomerId, SUM(OrderEntries_Dispatch.DispatchQuantity) AS TotalDispatchQuantity
										from OrderEntries 
										LEFT JOIN OrderEntries_Dispatch
										ON OrderEntries.OrderEntryId = OrderEntries_Dispatch.OrderEntryId
										LEFT JOIN SalesOrder
										ON OrderEntries.OrderId = SalesOrder.OrderId
										LEFT JOIN Customer
										ON SalesOrder.CustomerId = Customer.CustomerId
										LEFT JOIN Route
										ON Customer.Route = Route.RouteId
										WHERE (OrderEntries.Status = "APPROVED" ||
										OrderEntries.Status = "PARTIALLY_DISPATCHED")
										&& OrderEntries.OrderEntryId = '.$orderEntryId);
			
			log_message('debug', 'confirm_dispatch. - Query = ' . $this->db->last_query());
			if($query->num_rows() > 0) {
				$orderEntry = $query->result_array()[0];
				if(($orderEntry['OrderQuantity'] - $orderEntry['TotalDispatchQuantity']) > 0){
					
					$dispatchQuantity = $orderEntry['OrderQuantity'] - $orderEntry['TotalDispatchQuantity'];
					$routeId = $orderEntry['Route'];
					$customer_id = $orderEntry['CustomerId'];
					
					$customDispatchQuantity = $customDispatch['customDispatchQuantity'];
					$customRoute = $customDispatch['customRoute'];
					
					if(isset($customDispatchQuantity[$orderEntryId])){
						$dispatchQuantity = $customDispatchQuantity[$orderEntryId];						
					}
					
					$this->db->where('OrderEntryId', $orderEntryId);
					
					if(($orderEntry['OrderQuantity'] - $orderEntry['TotalDispatchQuantity']) > $dispatchQuantity){
						$this->db->update('OrderEntries', array('Status' => 'PARTIALLY_DISPATCHED'));
					} else if(($orderEntry['OrderQuantity'] - $orderEntry['TotalDispatchQuantity']) == $dispatchQuantity){
						$this->db->update('OrderEntries', array('Status' => 'DISPATCHED'));
					}
					log_message('debug', 'confirm_dispatch. - Query = ' . $this->db->last_query());
					if(isset($customRoute[$customer_id])){
						$routeId = $customRoute[$customer_id];
					}
					
					$order_entry_dispatch = array(
						'DispatchID' => $dispatch_id,
						'OrderEntryId' => $orderEntryId,
						'DispatchQuantity' => $dispatchQuantity,
						'RouteId' => $routeId
					);
					
					$this->db->insert('OrderEntries_Dispatch', $order_entry_dispatch);
					log_message('debug', 'confirm_dispatch. - Query = ' . $this->db->last_query());
					if($this->db->insert_id() > 0){
						$count++;
					}
				}
			}
			
		}
		
		if($count > 0){
			$this->db->trans_commit();
			log_message('debug', 'confirm_dispatch. trans_commit. $dispatch_id = '.$dispatch_id);
			return $dispatch_id;
		} else {
			log_message('debug', 'confirm_dispatch. ROLLBACK. ');
			$this->db->trans_rollback();
		}
		
		return null;
	}
	
	/**
	* Used for fetching user details for notiication
	*/
	public function get_user_details_for_dispatch_id($dispatch_id){
		$query_string = 'SELECT GROUP_CONCAT(DISTINCT(CONCAT("OD", SalesOrder.OrderId))) AS OrderId, ApplicationUser.UserId, ApplicationUser.FirebaseInstanceToken FROM OrderEntries_Dispatch 
							LEFT JOIN OrderEntries
							ON OrderEntries.OrderEntryId = OrderEntries_Dispatch .OrderEntryId
							LEFT JOIN SalesOrder
							ON SalesOrder.OrderId = OrderEntries.OrderId
							LEFT JOIN ApplicationUser
							ON ApplicationUser.UserId = SalesOrder.OrderPlacedByUser
							WHERE DispatchId = '.$dispatch_id.'
							GROUP BY
							ApplicationUser.UserId';
		$result = $this->db->query($query_string);
		return $result->result_array();	
	}
}