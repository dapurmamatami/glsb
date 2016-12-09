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
  
  case 'addMessage' :
    addMessage();
    break;

  case 'updateMessage' :
    updateMessage();
    break;

				
  case 'deleteMessage' :
    deleteMessage();
    break;		
	  
  case 'cancel' :
    cancelPage();
    break;
  }
  
  
function addMessage()
{
		$message_subject = $_POST[message_subject];
		$message_content = $_POST[message_content];
		$message_footer = $_POST[message_footer];
		
		if($message_subject!="")
		{
	
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into system_message_template (message_subject, message_content, message_footer, created_by, created_date) values (:message_subject, :message_content, :message_footer, :created_by, NOW())";
            $q = $pdo->prepare($sql);
			$q->bindValue(':message_subject', $message_subject);
			$q->bindValue(':message_content', $message_content);
			$q->bindValue(':message_footer', $message_footer);
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
			$displayMsg = "Missing Message Subject";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}	
	
}

function updateMessage()
{
		$message_id = $_POST['message_id'];
		$message_subject = $_POST[message_subject];
		$message_content = $_POST[message_content];
		$message_footer = $_POST[message_footer];
	
	if($message_id != '')
	{
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `system_message_template`  set `message_subject` = :message_subject, `message_content` = :message_content, `message_footer` = :message_footer, `modified_by` = :modified_by WHERE message_id = :message_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':message_id', $message_id);
			$q->bindValue(':message_subject', $message_subject);
			$q->bindValue(':message_content', $message_content);
			$q->bindValue(':message_footer', $message_footer);
			$q->bindValue(':modified_by', $_SESSION[user_id]);
			$update = $q->execute();
            
            Database::disconnect();
		
		
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
	$message_id = $_POST['message_id'];
	
	if($message_id != '')
	{
		//update database
		deleteTableDetail('system_message_template', 'message_id', $message_id);
		
		
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
