<?php

	require '../inc/pdofunctions.php';
	
	
	//getCustomerDetails(1);

            $eachNAPIC = getCustomerDetails(2);

            if(count($eachNAPIC)>0){
				foreach ($eachNAPIC as $napic){
					echo "Yes";	
					echo $napic[customer_name];
					echo $napic[customer_code];
				}
			}
				
					
	//example 1 loop whole table
	$stmt = $db->query('SELECT * FROM customer');
	 
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		//echo $row['customer_id'].' '.$row['customer_name']; //etc...
		//echo "<br>";
	}

	
	//example 2 get specific record
    /*** The SQL SELECT statement ***/
    $sql = "SELECT * FROM customer where customer_id = 2";

    /*** fetch into an PDOStatement object ***/
    $stmt = $db->query($sql);

    /*** echo number of columns ***/
    $obj = $stmt->fetch(PDO::FETCH_OBJ);

    /*** loop over the object directly ***/
    //echo $obj->customer_id.'<br />';
    //echo $obj->customer_name.'<br />';

?>