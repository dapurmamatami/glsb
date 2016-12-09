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
  
  case 'addStock' :
    addStock();
    break;

  case 'updateStock' :
    updateStock();
    break;

				
  case 'deleteMessage' :
    deleteMessage();
    break;		
	  
  case 'cancel' :
    cancelPage();
    break;
	
	case 'printReportAll' :
    printReportAll();
    break;
  }
  
  
function addStock()
{
		$stock_date = ($_POST['stock_date'] != "") ? "" . date("Y-m-d", strtotime($_POST['stock_date'])) . "" : NULL; 
		$stock_description = mysql_escape_string($_POST[stock_description]);
		$product_id = $_POST[product_id];
		$qty_in = $_POST[qty_in];
		$qty_out = $_POST[qty_out];
		
		if($stock_date!="")
		{
	
			//($product_id, $qty_in, $qty_out, $forward_sw, $adjust_sw, $so_id);
			
			//$id = addStockHistory($stock_date, $stock_description, $product_id, $qty_in, $qty_out);	
			insertStockHistory($product_id, $qty_in, $qty_out, 0, 1, 0, $stock_description);	
				
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

function updateStock()
{
		$stock_id = $_POST['stock_id'];
		$stock_date = ($_POST['stock_date'] != "") ? "" . date("Y-m-d", strtotime($_POST['stock_date'])) . "" : NULL; 
		$stock_description = mysql_escape_string($_POST[stock_description]);
		$product_id = $_POST[product_id];
		$qty_in = $_POST[qty_in];
		$qty_out = $_POST[qty_out];
		
	if($stock_id != '')
	{
		
		//update database
		updateStockHistory($stock_id, $stock_date, $stock_description, $product_id, $qty_in, $qty_out);
		
		
		//sucess show updated message
		$displayMsg = "updated";
		$jsonArray= array('id' => $message_id,'success' => 1, 'displayMsg' => $displayMsg); 
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


function deleteMessage()
{
	$stock_id = $_POST['stock_id'];
	
	if($stock_id != '')
	{
		//update database
		deleteTableDetail('stock_history', 'stock_id', $stock_id);
		
		
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

function printReportAll()
{
 
		$report_name = $_GET['report_name'];

		

			
		header("Location: ../../cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/$report_name&aliasname=glsb$rpt_alias&username=admin&password=&Parammain_id=$main_id");		
		

}

?>
