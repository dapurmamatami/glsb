<?php
//include "../inc/dbconfig.php";
//include "../inc/dbfunctions.php";
//include "../main/session.php";
//include "../main/functions.php";

include "../inc/pdoconfig.php";
include "../main/pdofunctions.php";
include "../main/session.php";
include "../main/functions.php";


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
  }
  
  
function add()
{
		$anno_title = mysql_escape_string($_POST[anno_title]);
		$anno_date = ($_POST['anno_date'] != "") ? "" . date("Y-m-d", strtotime($_POST['anno_date'])) . "" : NULL; 
		$anno_description = $_POST[anno_description];
		$active_sw = mysql_escape_string($_POST[active_sw]);
		$sorting_number = $_POST[sorting_number];


		if($anno_title!="")
		{
				
				$id = addAnnouncementDetail($anno_title, $anno_date, $anno_description, $active_sw, $sorting_number);
				
				//sucess show updated message
				$displayMsg = "added";
				$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);	  


		}
		else
		{
			//show error message
			$displayMsg = "Missing Announcement Title";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}	
	
}

function update()
{
		$id = $_GET['id'];
		$anno_title = mysql_escape_string($_POST[anno_title]);
		$anno_date = ($_POST['anno_date'] != "") ? "" . date("Y-m-d", strtotime($_POST['anno_date'])) . "" : NULL;
		$anno_description = $_POST[anno_description];
		$active_sw = mysql_escape_string($_POST[active_sw]);
		$sorting_number = $_POST[sorting_number];
		
	if($id != '')
	{
		//update database
		updateAnnouncementDetail($id, $anno_title, $anno_date, $anno_description, $active_sw, $sorting_number);
		
		
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
		deleteTableDetail('announcement', 'anno_id', $id);	
		
		
		//sucess show deleted message
		$displayMsg = "deleted";
		//$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
		//echo json_encode($jsonArray);
		header("Location: index.php?view=detail&id=$id&displayMsg=$displayMsg");				
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
