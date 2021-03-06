<?php
class Order_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	/**
	For Dashboard
	*/
	public function get_pending_approval_orders_entries(){
		$query_string = 'SELECT
						COUNT(OrderEntries.OrderEntryId) AS OrderEntryCount,
						COUNT(DISTINCT(OrderEntries.OrderId)) AS OrderCount,
						COUNT(DISTINCT(SalesOrder.CustomerId)) AS CustomerCount
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
						WHERE
						OrderEntries.Status = "PENDING_APPROVAL"';
		
		$result = $this->db->query($query_string);
		return $result->row_array();	
	}

	
	public function get_approved_and_pending_dispatch_orders_entries(){
		$query_string = 'SELECT
						COUNT(OrderEntries.OrderEntryId) AS OrderEntryCount,
						COUNT(DISTINCT(OrderEntries.OrderId)) AS OrderCount,
						COUNT(DISTINCT(SalesOrder.CustomerId)) AS CustomerCount
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
						WHERE
						OrderEntries.Status = "APPROVED"
						|| OrderEntries.Status = "PARTIALLY_DISPATCHED"';
		
		$result = $this->db->query($query_string);
		return $result->row_array();	
	}
	
	public function get_rejected_orders_entries_count(){
		$query_string = 'SELECT
					COUNT(OrderEntries.OrderEntryId) AS count
					FROM
					OrderEntries
					WHERE
					OrderEntries.Status = "REJECTED"';
		
		$result = $this->db->query($query_string);
		return $result->row_array();	
	}
	
	public function get_approved_orders_entries_count(){
		$query_string = 'SELECT
					COUNT(OrderEntries.OrderEntryId) AS count
					FROM
					OrderEntries
					WHERE
					OrderEntries.Status = "APPROVED"';
		
		$result = $this->db->query($query_string);
		return $result->row_array();	
	}

	public function get_approved_and_partially_dispatched_orders_entries_count(){
		$query_string = 'SELECT
					COUNT(OrderEntries.OrderEntryId) AS count
					FROM
					OrderEntries
					WHERE
					OrderEntries.Status = "APPROVED"
					|| OrderEntries.Status = "PARTIALLY_DISPATCHED"';
		
		$result = $this->db->query($query_string);
		return $result->row_array();	
	}
	
	public function get_orders_received_today(){
		$this->db->query('SET time_zone = "+05:30";');
		$query_string = 'SELECT
						COUNT(DISTINCT(OrderEntries.OrderId)) AS count,
						SUM(SellingPriceAtOrderTime * OrderQuantity) AS value
						FROM
						OrderEntries
						LEFT JOIN
						SalesOrder
						ON 
						OrderEntries.OrderId = SalesOrder.OrderId
						WHERE
						DATE(RecordCreationTime) = CURDATE()';
		
		$result = $this->db->query($query_string);
		return $result->row_array();		
	}
	
	public function reviewOrdersWithCustomRates($orderIds, $custom_rates, $status){
		foreach($orderIds as $orderId)
		{
			$this->db->query('SET time_zone = "+05:30";');
			$this->db->where('OrderEntryId', $orderId);
			if(isset($custom_rates[$orderId])){
				$this->db->set('SellingPriceAtOrderTime', $custom_rates[$orderId]);
			}
			$this->db->set('ApprovedByUser', $this->session->userdata('userid'));
			$this->db->set('ApprovalTime', 'NOW()', FALSE);
			$this->db->update('OrderEntries', array('Status' => $status));
		}
	}
	
	public function reviewOrders($orderIds, $status){
		foreach($orderIds as $orderId)
		{
			$this->db->query('SET time_zone = "+05:30";');
			$this->db->where('OrderEntryId', $orderId);
			$this->db->set('ApprovalTime', 'NOW()', FALSE);
			$this->db->set('ApprovedByUser', $this->session->userdata('userid'));
			$this->db->update('OrderEntries', array('Status' => $status));
		}
	}
	
	public function close_order_entries($entryIds){
		foreach($entryIds as $entryId)
		{
			$this->db->where('OrderEntryId', $entryId);
			$this->db->update('OrderEntries', array('Status' => 'CLOSED'));
		}
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
	
	public function get_all_orders_and_order_entries(){
			$result = $this->db->query('SELECT
										OrderEntryId,
										OrderEntries.OrderId,
										ApplicationUser.Username,
										SalesOrder.PaymentTerms,
										Product.Name AS ProductName,
										Customer.Name AS CustomerName,
										Broker.Name AS BrokerName,
										SellingPriceAtOrderTime,
										OrderQuantity,
										OrderTime,
										OrderEntries.Status
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
										ORDER BY
										OrderEntries.OrderId');
			
			return $result->result_array();		
	}
	
		/**
	Get all REJECTED order entries
	*/
	public function get_all_rejected_order_entries(){
			$result = $this->db->query('SELECT
										OrderEntryId,
										OrderEntries.OrderId,
										ApplicationUser.Username,
										SalesOrder.PaymentTerms,
										Product.Name AS ProductName,
										Customer.Name AS CustomerName,
										Broker.Name AS BrokerName,
										SellingPriceAtOrderTime,
										OrderQuantity,
										ProductionTime,
										OrderTime,
										OrderEntries.Status,
										OrderEntries.ProductionId
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
										WHERE
										OrderEntries.Status = "REJECTED"
										ORDER BY
										OrderEntries.OrderId');
			
			return $result->result_array();		
	}
	/**
	Get all APPROVED order entries
	*/
	public function get_all_closed_and_dispatched_order_entries(){
			
			$query = $this->db->query('SELECT
						OrderEntries.OrderEntryId,
						OrderEntries.OrderId,
						OrderedByUser.Username AS OrderBy,
						ApprovedByUser.Username AS ApprovedBy,
						SalesOrder.PaymentTerms,
						Product.Name AS ProductName,
						Customer.Name AS CustomerName,
						Broker.Name AS BrokerName,
						SellingPriceAtOrderTime,
						OrderQuantity,
						OrderEntries.ProductionId,
						ProductionTime,
						Dispatch.DispatchID,
						Dispatch.DispatchTime,
						OrderEntries_Dispatch.DispatchQuantity,
						OrderTime,
						OrderEntries.Status
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
						ApplicationUser AS OrderedByUser
						ON
						SalesOrder.OrderPlacedByUser = OrderedByUser.UserId
						LEFT JOIN
						ApplicationUser AS ApprovedByUser
						ON
						OrderEntries.ApprovedByUser = ApprovedByUser.UserId
						LEFT JOIN
						OrderEntries_Dispatch
						ON
						OrderEntries.OrderEntryId = OrderEntries_Dispatch.OrderEntryId
						LEFT JOIN
						Dispatch
						ON
						OrderEntries_Dispatch.DispatchID = Dispatch.DispatchId
						WHERE
						OrderEntries.Status = "DISPATCHED" ||
						OrderEntries.Status = "CLOSED" ||
						OrderEntries.Status = "PARTIALLY_DISPATCHED"
						ORDER BY
						OrderEntries.OrderEntryId');
			
			return $query->result_array();		
	}
	
	
	/**
	Get all APPROVED order entries with Balance left for dispatch ( in case of partial dispatch )
	*/
	public function get_all_approved_partially_dispatched_order_entries_with_balance(){

			$query = $this->db->query('SELECT
						OrderEntries.OrderEntryId,
						OrderEntries.OrderId,
						OrderedByUser.Username AS OrderBy,
						ApprovedByUser.Username AS ApprovedBy,
						SalesOrder.PaymentTerms,
						Product.Name AS ProductName,
						Customer.Name AS CustomerName,
						Broker.Name AS BrokerName,
						SellingPriceAtOrderTime,
						OrderQuantity,
						OrderEntries.ProductionId,
						ProductionTime,
						ApprovedByUser,
						Dispatch.DispatchID,
						Dispatch.DispatchTime,
						OrderEntries_Dispatch.DispatchQuantity,
						OrderTime,
						OrderEntries.Status,
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
						ApplicationUser AS OrderedByUser
						ON
						SalesOrder.OrderPlacedByUser = OrderedByUser.UserId
						LEFT JOIN
						ApplicationUser AS ApprovedByUser
						ON
						OrderEntries.ApprovedByUser = ApprovedByUser.UserId
						LEFT JOIN
						OrderEntries_Dispatch
						ON
						OrderEntries_Dispatch.OrderEntryId = OrderEntries.OrderEntryId
						LEFT JOIN
						Dispatch
						ON
						OrderEntries_Dispatch.DispatchID = Dispatch.DispatchId
						WHERE
						OrderEntries.Status = "APPROVED" ||
						OrderEntries.Status = "PARTIALLY_DISPATCHED"
						GROUP BY OrderEntries.OrderEntryId
						ORDER BY
						OrderEntries.OrderEntryId');
			
			return $query->result_array();		
	}
	
	public function get_all_orders_and_order_entries_pending_approval(){
			$result = $this->db->query('SELECT
										OrderEntryId,
										OrderEntries.OrderId,
										ApplicationUser.Username,
										SalesOrder.PaymentTerms,
										Product.Name AS ProductName,
										Customer.Name AS CustomerName,
										Broker.Name AS BrokerName,
										SellingPriceAtOrderTime,
										OrderQuantity,
										OrderTime,
										OrderEntries.Status
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
										WHERE
										OrderEntries.Status = "PENDING_APPROVAL"
										ORDER BY
										OrderEntries.OrderId');
			
			return $result->result_array();		
	}
	
	public function get_order_entries($id){
		$result = $this->db->query('SELECT
					  OrderEntryId,
					  Product.Name AS ProductName,
					  SellingPriceAtOrderTime,
					  OrderQuantity,
					  OrderEntries.Status
						FROM
						  OrderEntries
						LEFT JOIN
						  Product
						ON
						  OrderEntries.OrderedProductId = Product.ProductId
						WHERE OrderId = "'.$id.'"
						ORDER BY
						OrderEntries.OrderId');
			
			return $result->result_array();
	}
	
	public function get_all_orders(){
		$result = $this->db->query('SELECT
					  OrderID,
					  Customer.Name AS CustomerName,
					  Broker.Name AS BrokerName,
					  PaymentTerms,
					  SalesOrder.RecordCreationTime
						FROM
						  SalesOrder
						LEFT JOIN
						  Customer
						ON
						  SalesOrder.CustomerId = Customer.CustomerId
						LEFT JOIN
						  Broker
						ON
						  SalesOrder.LinkedBrokerId = Broker.BrokerId');
			
			return $result->result_array();
	}
	
	public function get_last_n_orders($n){
		$result = $this->db->query('SELECT
					  OrderID,
					  Customer.Name AS CustomerName,
					  Broker.Name AS BrokerName,
					  PaymentTerms,
					  SalesOrder.RecordCreationTime
						FROM
						  SalesOrder
						LEFT JOIN
						  Customer
						ON
						  SalesOrder.CustomerId = Customer.CustomerId
						LEFT JOIN
						  Broker
						ON
						  SalesOrder.LinkedBrokerId = Broker.BrokerId
						ORDER BY OrderId DESC
						LIMIT '.$n);
			
			return $result->result_array();
	}
	
	public function get_orders_for_customer($id){
		$result = $this->db->query('SELECT
					  OrderID,
					  Customer.Name AS CustomerName,
					  Broker.Name AS BrokerName,
					  PaymentTerms,
					  SalesOrder.RecordCreationTime
						FROM
						  SalesOrder
						LEFT JOIN
						  Customer
						ON
						  SalesOrder.CustomerId = Customer.CustomerId
						LEFT JOIN
						  Broker
						ON
						  SalesOrder.LinkedBrokerId = Broker.BrokerId
						 WHERE SalesOrder.CustomerId = "'.$id.'"');
			
			return $result->result_array();
	}	
	
	public function get_orders_for_user($id){
		$result = $this->db->query('SELECT
					  OrderID,
					  Customer.Name AS CustomerName,
					  Broker.Name AS BrokerName,
					  PaymentTerms,
					  SalesOrder.RecordCreationTime
						FROM
						  SalesOrder
						LEFT JOIN
						  Customer
						ON
						  SalesOrder.CustomerId = Customer.CustomerId
						LEFT JOIN
						  Broker
						ON
						  SalesOrder.LinkedBrokerId = Broker.BrokerId
						WHERE SalesOrder.OrderPlacedByUser = "'.$id.'"');
			
			return $result->result_array();
	}	
	
	public function get_last_n_orders_for_user($id, $n){
		$result = $this->db->query('SELECT
					  OrderID,
					  Customer.Name AS CustomerName,
					  Broker.Name AS BrokerName,
					  PaymentTerms,
					  SalesOrder.RecordCreationTime
						FROM
						  SalesOrder
						LEFT JOIN
						  Customer
						ON
						  SalesOrder.CustomerId = Customer.CustomerId
						LEFT JOIN
						  Broker
						ON
						  SalesOrder.LinkedBrokerId = Broker.BrokerId
						WHERE SalesOrder.OrderPlacedByUser = "'.$id.'"
						ORDER BY OrderId DESC
						LIMIT '.$n);
			
			return $result->result_array();
	}

	public function place_order($data, $order_placed_by_application_user){
		//Order  	 --- CustomerId OrderPlacedByUser LinkedBrokerId PaymentTerms
		//OrderEntry --- OrderedProductId SellingPriceAtOrderTime OrderQuantity
		$this->db->trans_begin();
		$this->db->query('SET time_zone = "+05:30";');
		$order = array(
			'CustomerId' => $data['CustomerId'],
			'OrderPlacedByUser' => $order_placed_by_application_user['UserId'],
			'PaymentTerms' => $data['PaymentTerms']
		);				
		
		if($data['LinkedBrokerId'] > 0){
			$order['LinkedBrokerId'] = $data['LinkedBrokerId'];
		}

		
		if($this->db->insert('SalesOrder', $order)){
			$order_id = $this->db->insert_id();
			
			$order_entries_json = $data['ProductList'];
			$order_entries = array();
			
			$i = 0;
			foreach($order_entries_json as $order_entry_json){
				$order_entries[$i] = array(
					'OrderId' => $order_id,
					'OrderedProductId' => $order_entry_json['OrderedProductId'],
					'SellingPriceAtOrderTime' => $order_entry_json['SellingPriceAtOrderTime'],
					'OrderQuantity' => $order_entry_json['OrderQuantity'],
				);
				$i = $i + 1;
			}
			
			$this->db->insert_batch('OrderEntries', $order_entries);
			if($this->db->affected_rows() > 0){
				$this->db->trans_commit();
				$result['Result'] = 'Success';
				return $result;
			} else {
				$this->db->trans_rollback();
				$result['Result'] = 'Failed';
				$result['Message'] = 'Failed to insert order entries';
				return $result;
			}
			
		} else {
				$this->db->trans_rollback();
				$result['Result'] = 'Failed';
				$result['Message'] = 'Failed to insert order entries';
				return $result;
		}
	}
}
?>