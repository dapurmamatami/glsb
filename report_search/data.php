<?php
include('../inc/dbconfig.php'); 

$connect = mysql_connect($dbHost, $dbUser, $dbPass)
or die('Could not connect: ' . mysql_error());
//Select The database
$bool = mysql_select_db($dbName, $connect);
if ($bool === False){
   print "can't find $database";
}

// get data and store in a json array
$id = $_GET['id'];

	$query = "SELECT sorder.*, customer_name, sorder_type.type_name as order_type, sorder_status.status_name as order_status FROM sorder left join customer on sorder.customer_id = customer.customer_id left join sorder_type on sorder.type_id = sorder_type.type_id left join sorder_status on sorder.status_id = sorder_status.status_id order by so_id desc";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	$dbNumRows = mysql_num_rows($result);
	
	if($dbNumRows > 0)
	{
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$dataList[] = array(
				'so_id' => $row['so_id'],
				'customer_name' => $row['customer_name'],
				'so_date' => $row['so_date'],
				'order_status' => $row['order_status'],
				'total_month' => $row['total_month'],
				'order_type' => $row['order_type'],
				'amount' => $row['amount'],
				'invoice_date' => $row['invoice_date'],
				'ref1' => $row['ref1'],
				'remark' => $row['remark']
				);
		}
	 
		echo json_encode($dataList);	
	}
	else
	{
		echo "Nothing";
	
	}
	


?>