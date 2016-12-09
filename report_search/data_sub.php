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

	$query = "SELECT * from sorder_detail where so_id = $id";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	$dbNumRows = mysql_num_rows($result);
	
	if($dbNumRows > 0)
	{
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$dataList[] = array(
				'sod_id' => $row['sod_id'],
				'weight' => $row['weight'],
				'cert_no' => $row['cert_no'],
				'amount' => $row['amount'],
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