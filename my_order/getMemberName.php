<?php 
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";

$member_reg_no = $_GET['member_reg_no'];
			
	
if(isset($_GET['member_reg_no'])){  
		
	//$stateName = 'abc';
	//$stateName = getArea($state);
		$sql = "SELECT name, address1, postcode,city, state_name, country_name  FROM user left join state on state.state_id = user.state_id where member_reg_no = '$member_reg_no'";
		$result=dbQuery($sql);	
		
																										
		if(dbNumRows($result)>0)
		{				
																			
				while($row=dbFetchAssoc($result))
				{ 
					//$version_id = $row['version_id'];
					$sponsor_name = mysql_escape_string($row['name']);
					$full_address = mysql_escape_string($row['address1']) . '\n' . 
									mysql_escape_string($row['postcode']) . ' ' . 
									mysql_escape_string($row['city']) . ' ' . 
									mysql_escape_string($row['state_name']) . '\n' .
									mysql_escape_string($row['country_name'])
									;
					
					//echo "obj.options[obj.options.length] = new Option('$areaName','$areaName');\n";
					//echo "obj.value = '$sponsor_name'";
					echo "obj.value = '$full_address'";


				};

		}
		else
		{
			echo "obj.value = ''";
			//echo "obj2.value = ''";
   			//echo "obj.options[obj.options.length] = new Option('','');\n";
		}  

}
else
{
	echo "obj.value = ''";
}
			


	
	
	
?> 