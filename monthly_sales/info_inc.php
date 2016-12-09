<?php
include "../inc/pdoconfig.php";
include "../main/session.php";
include "../main/functions.php";
include "../main/pdofunctions.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
  case 'add' :
    add();
    break;

  case 'update' :
    update();
    break;

				
  case 'delete' :
    delete();
    break;		
	  
  case 'cancel' :
    cancelPage();
    break;
	
	case 'printReport' :
    printReport();
    break;	
  }
  
  
function add()
{
		$type_id = $_POST[type_id];
		$customer_id = $_POST[customer_id];
		$call_date = ($_POST['call_date'] != "") ? "" . date("Y-m-d", strtotime($_POST['call_date'])) . "" : NULL;
		$call_by = $_POST[call_by];
		$call_by_name = mysql_escape_string($_POST[call_by_name]);
		$remark = mysql_escape_string($_POST[remark]);

		if($type_id!="")
		{
	
				$id = addCustomerCallDetail($type_id, $customer_id, $call_date, $call_by, $call_by_name, $remark);
				
			
				
				//sucess show updated message
				$displayMsg = "added";
				$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);	  


		}
		else
		{
			//show error message
			$displayMsg = "Missing Type";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}	
	
}

function update()
{
		$id = $_GET['id'];
		
		$type_id = $_POST[type_id];
		$customer_id = $_POST[customer_id];
		$call_date = ($_POST['call_date'] != "") ? "" . date("Y-m-d", strtotime($_POST['call_date'])) . "" : NULL;
		$call_by = $_POST[call_by];
		$call_by_name = mysql_escape_string($_POST[call_by_name]);
		$remark = mysql_escape_string($_POST[remark]);
		
	if($id != '')
	{
		
		//update database
		updateCustomerCallDetail($id, $type_id, $customer_id, $call_date, $call_by, $call_by_name, $remark);
		
		
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


function delete()
{
	$id = $_GET['id'];
	
	
	if($id != '')
	{
		//update database
		deleteTableDetail('customer_call', 'call_id', $id);
		
		
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

function printReport()
{
 
		$main_id = $_GET['id'];
		$report_name = 'monthly_sales';

		

			
		header("Location: ../../cgi-bin/repwebserver.dll/execute.pdf?reportname=\monthly_sales/$report_name&aliasname=glsb$rpt_alias&username=admin&password=&Parammain_id=$main_id");		
		

}

?>
