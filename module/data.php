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

	$query = "SELECT product.*, type_name FROM product left join product_type on product.type_id = product_type.type_id where sell_sw = 1";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	$dbNumRows = mysql_num_rows($result);
	
	if($dbNumRows > 0)
	{
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$dataList[] = array(
				'product_id' => $row['product_id'],
				'product_name' => $row['product_name'],
				'type_name' => $row['type_name'],
				'unit_price' => $row['unit_price'],
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