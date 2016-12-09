<?php
include "../inc/pdoconfig.php";
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../main/session.php";
include "../main/functions.php";
include "../main/pdofunctions.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
  

  case 'update' :
    updatePassword();
    break;
		

  case 'updateAdmin' :
    updatePasswordAdmin();
    break;
		  
  case 'cancel' :
    cancelPage();
    break;
  }


function updatePassword()
{
	$id = $_SESSION[user_id];
  
  if($_POST)
  {
		$current_password = $_POST['current_password'];
		$check_password = md5($current_password);
		
		
		$new_password = $_POST['new_password'];
		$new_password_confirm = $_POST['new_password_confirm'];

		$password = md5($new_password);

		
		$sql = "SELECT password
						FROM user
						WHERE user_id = '$id';
					 ";
		$result=dbQuery($sql);	
		$row=dbFetchAssoc($result);
		$old_password = $row[password];	
		
		if($old_password == $check_password)
		{
				if($new_password == $new_password_confirm)
				{
						$sql = "UPDATE user
									SET password= '$password', temp_password = '',
									modified_by = $_SESSION[user_id]
									WHERE user_id = '$id'
								 ";
						dbQuery($sql);
						
						$displayMsg = "updated";
						$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
						echo json_encode($jsonArray);		
				
				}
				else
				{
						$displayMsg = "New Password Not Matched";
						$jsonArray= array('id' => $id,'success' => 0, 'displayMsg' => $displayMsg); 
						echo json_encode($jsonArray);				
				}
					
		}
		else
		{
				$displayMsg = "Current Password Not Correct";
				$jsonArray= array('id' => $id,'success' => 0, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);					
		}
				
  }

}


function updatePasswordAdmin()
{
	$id = $_GET[id];
  
  if($_POST)
  {
		$current_password = $_POST['current_password'];
		$check_password = md5($current_password);
		
		
		$new_password = $_POST['new_password'];
		$new_password_confirm = $_POST['new_password_confirm'];

		$password = md5($new_password);

		
		

				if($new_password == $new_password_confirm)
				{
						$sql = "UPDATE user
									SET password= '$password', temp_password = '$password',
									modified_by = $_SESSION[user_id]
									WHERE user_id = '$id'
								 ";
						dbQuery($sql);
						
						$displayMsg = "updated";
						$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
						echo json_encode($jsonArray);		
				
				}
				else
				{
						$displayMsg = "New Password Not Matched";
						$jsonArray= array('id' => $id,'success' => 0, 'displayMsg' => $displayMsg); 
						echo json_encode($jsonArray);				
				}
					


				
  }

}


function cancelPage()
{
  if($_POST)
  {
    header("Location:../main/index.php");
  }
}

?>
