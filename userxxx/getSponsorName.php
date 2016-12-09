<?php 
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";

$member_reg_no = $_GET['member_reg_no'];
			
	
if(isset($_GET['member_reg_no'])){  
		
	//$stateName = 'abc';
	//$stateName = getArea($state);
		$sql = "SELECT name FROM user where member_reg_no = '$member_reg_no'";
		$result=dbQuery($sql);	
		
																										
		if(dbNumRows($result)>0)
		{				
																			
				while($row=dbFetchAssoc($result))
				{ 
					//$version_id = $row['version_id'];
					$sponsor_name = mysql_escape_string($row['name']);
					
					//echo "obj.options[obj.options.length] = new Option('$areaName','$areaName');\n";
					echo "obj.value = '$sponsor_name'";


				};

		}
		else
		{
			echo "obj.value = ''";
   			//echo "obj.options[obj.options.length] = new Option('','');\n";
		}  

}
else
{
	echo "obj.value = ''";
}
			


	
	
	
?> 