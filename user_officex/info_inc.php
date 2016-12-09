<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";

include "../inc/pdoconfig.php";
include "../main/session.php";
include "../main/functions.php";
include "../main/pdofunctions.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
  
  case 'add' :
    addUser();
    break;

  case 'update' :
    updateUser();
    break;
		
  case 'resetPassword' :
    resetPassword();
    break;		
		
  case 'delete' :
    delete();
    break;		
	  
  case 'cancel' :
    cancelPage();
    break;
  }

			
function addUser()
{
			
	$name = $_POST[name];
	$user_name = $_POST[user_name];
	$password = md5($_POST[password]);
	$user_group = $_POST[user_group];
	$temp_password = '';
	$remark = mysql_escape_string($_POST[remark]);
  
	if($user_name!="")
	{
	  if(!checkUserName($user_name))
	  {
	
		$sql = "INSERT INTO user(name, user_name, password, user_group, temp_password, status_id, remark, created_by, created_date)
				VALUES('$name', '$user_name', '$password', '$user_group', '$password', '1', '$remark', $_SESSION[user_id], NOW())";
				dbQuery($sql);
				$mid = mysql_insert_id();
				
				$remark = 'New User -' . mysql_escape_string($name);
				setModuleLog('User', $_SESSION[user_id], 'Add',  $remark, $mid);		
						
				
				$displayMsg = "added";
				$jsonArray= array('id' => $mid,'success' => 1, 'displayMsg' => $displayMsg); //*1 value is named LastID
				echo json_encode($jsonArray);
	
			
	  }
	  else
	  {
	
			  $displayMsg = 'Duplicate User Name';
			  $jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
			  echo json_encode($jsonArray);
	
	  }
	}
	else
	{
		  $displayMsg = "Missing User Name";
		  $jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
		  echo json_encode($jsonArray);
	}
	}


function updateUser()
{
	$id = $_GET[id];
  
  if($_POST)
  {
	
		$name = $_POST[name];
		$user_name = $_POST[user_name];
		//$password = md5($_POST[password]);
		$user_group = $_POST[user_group];
		//$temp_password = $_POST[temp_password];
		$remark = mysql_escape_string($_POST[remark]);
    
    $sql = "UPDATE user
            SET name = '$name', user_group = $user_group,
            remark = '$remark', modified_by = $_SESSION[user_id]
            WHERE user_id = $id
           ";
    dbQuery($sql);

		$remark = 'Update User -' . mysql_escape_string($name);
		setModuleLog('User', $_SESSION[user_id], 'update',  $remark, $id);	
		
		    
		$displayMsg = "updated";
		$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);	
  }

}


function resetPassword()
{
		$id = $_GET[id];
	

		header("Location: ../password/index.php?view=reset&id=$id");
						
}

function delete()
{
	$id = $_GET['id'];
	
	
	if($id != '')
	{
		//update database
		deleteTableDetail('user', 'user_id', $id);	
		
		
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


function cancelPage()
{
  if($_POST)
  {
    header("Location: index.php?view=list");
  }
}



?>
