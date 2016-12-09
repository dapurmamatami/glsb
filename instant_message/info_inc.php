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
		$im_title = mysql_escape_string($_POST[im_title]);
		$im_detail = mysql_escape_string($_POST[im_detail]);
		
		if($im_title!="")
		{
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into instant_message (im_title, im_detail, created_by, created_date) values (:im_title, :im_detail, :created_by, NOW())";
            $q = $pdo->prepare($sql);
			$q->bindValue(':im_title', $im_title);
			$q->bindValue(':im_detail', $im_detail);
			$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->execute();
            $id = $pdo->lastInsertId();
			//return $id;
			Database::disconnect();	
				
				
			//sucess show updated message
			$displayMsg = "added";
			$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);	  


		}
		else
		{
			//show error message
			$displayMsg = "Missing Email Subject";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}	
	
}

function update()
{
		$id = $_GET['id'];
		$email_subject = mysql_escape_string($_POST[email_subject]);
		$email_message = mysql_escape_string($_POST[email_message]);
		$attachement_path = mysql_escape_string($_POST[attachement_path]);
		
	if($id != '')
	{
		//update database
		updateAnnouncementDetail($id, $anno_title, $anno_date, $anno_description, $active_sw);
		
		
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
		deleteTableDetail('instant_message', 'im_id', $id);	
		
		
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
