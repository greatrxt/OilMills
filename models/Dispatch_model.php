<?php
class Dispatch_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function get_routes_for_dispatch($id){
		$query_string = 'SELECT DISTINCT(Route.RouteId) AS RouteID, Route.RouteName
							FROM OrderEntries 
							LEFT JOIN SalesOrder ON OrderEntries.OrderId = SalesOrder.OrderId
							LEFT JOIN OrderEntries_Dispatch ON OrderEntries_Dispatch.OrderEntryId = OrderEntries.OrderEntryId
							LEFT JOIN Customer ON SalesOrder.CustomerId = Customer.CustomerId
							LEFT JOIN Route ON Customer.Route = Route.RouteId
							WHERE OrderEntries_Dispatch.DispatchID = '.$id;
		$result = $this->db->query($query_string);
		return $result->result_array();	
	}
	
	public function get_dispatch($id){
		$query_string = 'SELECT Product.Name as ProductName, SUM(OrderEntries.OrderQuantity) as OrderQuantity, Customer.Name as CustomerName, Route.RouteName, Route.RouteId
									FROM OrderEntries 
									LEFT JOIN Product ON OrderEntries.OrderedProductId = Product.ProductId
									LEFT JOIN SalesOrder ON OrderEntries.OrderId = SalesOrder.OrderId
									LEFT JOIN Customer ON SalesOrder.CustomerId = Customer.CustomerId
									LEFT JOIN Route ON Customer.Route = Route.RouteId
									LEFT JOIN OrderEntries_Dispatch ON OrderEntries_Dispatch.OrderEntryId = OrderEntries.OrderEntryId
									WHERE OrderEntries_Dispatch.DispatchID = '.$id.'
									GROUP BY CustomerName, ProductName
									ORDER BY RouteId';
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
						Product.ProductId,
						OrderEntries.OrderEntryId';
		
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
						RouteName,
						RouteId
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
		$parameters = '';
		$count = 0;
		foreach($orderEntryIds as $orderEntryId){
			$parameters = $parameters.$orderEntryId;
			$count++;
			if($count!=sizeof($orderEntryIds)){
				$parameters = $parameters.',';
			}
		}
	
		//$query_string = 'SELECT OrderEntryId, Product.Name, OrderEntries.OrderQuantity
			//						FROM OrderEntries 
				//					LEFT JOIN Product ON OrderEntries.OrderedProductId = Product.ProductId
					//				WHERE OrderEntries.OrderEntryId IN ('.$parameters.')';
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
		//return $query_string;	
		return $result->result_array();	
	}		

	public function get_all_dispatch(){

		/*$result = $this->db->query('SELECT Dispatch.DispatchId, SUM(OrderEntries.OrderQuantity) as Quantity, DispatchTime, count(distinct OrderEntries.OrderedProductId) as ProductCount
									FROM Dispatch 
									LEFT JOIN OrderEntries ON OrderEntries.DispatchId = Dispatch.DispatchId
									GROUP BY DispatchId');*/
									
		$query = $this->db->query('SELECT Dispatch.DispatchId, count(distinct OrderEntries.OrderedProductId) as ProductCount, SUM(OrderEntries.OrderQuantity) as Quantity,  DispatchTime
									FROM Dispatch 
									LEFT JOIN OrderEntries_Dispatch ON Dispatch.DispatchId = OrderEntries_Dispatch.DispatchId
									LEFT JOIN OrderEntries ON OrderEntries_Dispatch.OrderEntryId = OrderEntries.OrderEntryId
									GROUP BY Dispatch.DispatchId');
		return $query->result_array();	
	}
	
	public function confirm_dispatch($orderEntryIds, $customDispatch){
		
		$this->db->trans_begin();
		$dispatch = array(
			'DispatchedByUser' => $this->session->userdata('userid')
		);
		$this->db->query('SET time_zone = "+05:30";');
		$this->db->insert('Dispatch', $dispatch);
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
					
					if($this->db->insert_id() > 0){
						$count++;
					}
				}
			}
			
	/*		$this->db->where('OrderEntryId', $orderEntryId);
			$this->db->where('Status!=', 'PENDING_APPROVAL');
			$this->db->update('OrderEntries', $orderEntry);
			
			if($this->db->affected_rows() == 1){
				$count++;
			}*/
		}
		
		if($count > 0){
			$this->db->trans_commit();
			return $dispatch_id;
		} else {
			$this->db->trans_rollback();
		}
		return null;
	}
}