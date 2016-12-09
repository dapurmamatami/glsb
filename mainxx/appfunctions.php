<?php
//get data after add from product
function getUserDetailApp($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM user where user = '$id'";
        $q = $pdo->prepare($sql);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

function addSaleOrder($customer_id)
{
	
			$data = getUserDetailApp($id);
			
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into sorder (so_date, customer_id, so_customer_name, so_address,courier_sw,courier_amount,paid_by_ewallet_sw , created_by, created_date) values (NOW(), :customer_id, :so_customer_name, :so_address, :courier_sw, :courier_amount,:paid_by_ewallet_sw, :created_by, NOW())";
            $q = $pdo->prepare($sql);
			$q->bindValue(':customer_id', $_SESSION[user_id]);
			$q->bindValue(':so_customer_name', $data['name']);
			$q->bindValue(':so_address', $data['address1']);
			//$q->bindValue(':courier_sw', $courier_sw);
			//$q->bindValue(':courier_amount', $courier_amount);
			$q->bindValue(':courier_sw',!empty($courier_sw) ? $courier_sw : 0);
			$q->bindValue(':paid_by_ewallet_sw',!empty($paid_by_ewallet_sw) ? $paid_by_ewallet_sw : 0);
			$q->bindValue(':courier_amount',!empty($courier_amount) ? $courier_amount : 0);
			//$q->bindValue(':so_city', $so_city);
			//$q->bindValue(':so_postcode', $so_postcode);
			//$q->bindValue(':so_state', $so_state);
			//$q->bindValue(':so_country', $so_country);
			$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->execute();
            $id = $pdo->lastInsertId();
			
			
			//updateSaleOrderStatus($id, 1);
			
			return $id;
			Database::disconnect();			
}

//get data after add from product
function getProductDetailApp($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM product where product_code = '$id'";
        $q = $pdo->prepare($sql);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

function addSaleOrderDetailApp($so_id, $product_code, $product_name, $quantity)
{
			$data = getProductDetailApp($product_code);
		
			$amount = $quantity * $data['selling_price'];
			$product_bonus_pool = $quantity * $data['bonus_pool'];
			$order_pv = $quantity * $data['point_value'];
			
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into sorder_detail (so_id, product_id, product_code, product_name, unit_price, tax_percentage, unit_price_with_gst, quantity, amount,product_weight,total_weight,product_pv,order_pv, product_bonus_pool, product_cost, created_by, created_date) values (:so_id, :product_id, :product_code, :product_name, :unit_price, :tax_percentage, :unit_price_with_gst, :quantity, :amount,:product_weight,:total_weight,:product_pv,:order_pv,:product_bonus_pool,:product_cost, :created_by, NOW())";
            $q = $pdo->prepare($sql);
			$q->bindValue(':so_id',!empty($so_id) ? $so_id : 0);
			$q->bindValue(':product_id',!empty($data['product_id']) ? $data['product_id'] : 0);
			$q->bindValue(':product_code', $product_code);
			$q->bindValue(':product_name', $product_name);
			$q->bindValue(':unit_price',!empty($data['selling_price']) ? $data['selling_price'] : 0);
			$q->bindValue(':tax_percentage',!empty($tax_percentage) ? $tax_percentage : 0);
			$q->bindValue(':unit_price_with_gst',!empty($unit_price_with_gst) ? $unit_price_with_gst : 0);
			$q->bindValue(':quantity',!empty($quantity) ? $quantity : 0);
			$q->bindValue(':amount',!empty($amount) ? $amount : 0);
			$q->bindValue(':product_weight',!empty($data['weight_in_gram']) ? $data['weight_in_gram'] : 0);
			$q->bindValue(':total_weight',!empty($total_weight) ? $total_weight : 0);
			$q->bindValue(':product_pv',!empty($data['point_value']) ? $data['point_value'] : 0);
			$q->bindValue(':order_pv',!empty($order_pv) ? $order_pv : 0);
			$q->bindValue(':product_bonus_pool',!empty($product_bonus_pool) ? $product_bonus_pool : 0);
			$q->bindValue(':product_cost',!empty($data['selling_price']) ? $data['selling_price'] : 0);
			$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->execute();
            //$id = $pdo->lastInsertId();
			
			
			//updateSaleOrderStatus($id, 1);
			
			return $id;
			Database::disconnect();			
}
?>