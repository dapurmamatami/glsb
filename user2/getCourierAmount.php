<?php 
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../inc/pdoconfig.php";
include "../main/pdofunctions.php";

$total_weight = $_GET['total_weight'];
			

	//$stateName = 'abc';
	//$stateName = getArea($state);
		$courier_amount = getDeliveryCharge($total_weight);
		
																										
		if($courier_amount>0)
		{				
																			

			//echo "obj.options[obj.options.length] = new Option('$areaName','$areaName');\n";
			echo "obj.value = '$courier_amount'";



		}
		else
		{
			echo "obj.value = '0'";
   			//echo "obj.options[obj.options.length] = new Option('','');\n";
		}  

	


	
	
	
?> 