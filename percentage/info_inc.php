<?php
//include "../inc/dbconfig.php";
//include "../inc/dbfunctions.php";
//include "../main/session.php";
//include "../main/functions.php";
include "../inc/pdoconfig.php";
include "../main/session.php";
include "../main/functions.php";
include "../main/pdofunctions.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
  
  case 'addPercentage' :
    addPercentage();
    break;

  case 'updatePercentage' :
    updatePercentage();
    break;

				
  case 'deletePercentage' :
    deletePercentage();
    break;		
	  
  case 'cancel' :
    cancelPage();
    break;
  }
  
  
function addPercentage()
{
		$app_id = $_POST[app_id];
		$total_sales_from = $_POST[total_sales_from];
		$total_sales_to = $_POST[total_sales_to];
		$total_percentage = $_POST[total_percentage];
		$total_percentage2 = $_POST[total_percentage2];
		
		if($total_sales_from!="")
		{
	
			//add database
			$id = addPercentageDetail($app_id, $total_sales_from, $total_sales_to, $total_percentage, $total_percentage2);	
				
				
			//sucess show updated message
			$displayMsg = "added";
			$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);	 
		}
		else
		{
			//show error message
			$displayMsg = "Missing Message Subject";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}	
	
}

function updatePercentage()
{
		$id = $_POST['percentage_id'];
		$app_id = $_POST[app_id];
		$total_sales_from = $_POST[total_sales_from];
		$total_sales_to = $_POST[total_sales_to];
		$total_percentage = $_POST[total_percentage];
		$total_percentage2 = $_POST[total_percentage2];
	
	if($id != '')
	{
		//update database
		updatePercentageDetail($id, $app_id, $total_sales_from, $total_sales_to, $total_percentage, $total_percentage2);
		
		
		//sucess show updated message
		$displayMsg = "updated";
		$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);				
	}
	else
	{
		//show error message
		$displayMsg = "Missing Info";
		$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);			
	}
	
}


function deletePercentage()
{
	$percentage_id = $_POST['percentage_id'];
	
	if($percentage_id != '')
	{
		//update database
		deleteTableDetail('uw_comm_percentage', 'percentage_id', $percentage_id);
		
		
		//sucess show deleted message
		$displayMsg = "deleted";
		$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);			
	}
	else
	{
		//show error message
		$displayMsg = "Missing Info";
		$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);			
	}
	
}

?>
