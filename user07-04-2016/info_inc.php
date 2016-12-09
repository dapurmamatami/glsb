<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";

include "../inc/pdoconfig.php";
include "../main/session.php";
include "../main/functions.php";
include "../main/pdofunctions.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
  
  case 'add2' :
    addUser2();
    break;

  case 'update' :
    updateUser();
    break;
		
  case 'resetPassword' :
    resetPassword();
    break;		
		
  case 'delete' :
    deleteUser();
    break;		
	  
  case 'cancel' :
    cancelPage();
    break;
  }

			
function addUser2()
{
			
		$name = mysql_escape_string($_POST[name]);
		$ic_no = mysql_escape_string($_POST[ic_no]);
		$nationality_id = $_POST[nationality_id];
		$address1 = mysql_escape_string($_POST[address1]);
		$postcode = mysql_escape_string($_POST[postcode]);
		$city = mysql_escape_string($_POST[city]);		
		$state_id = $_POST[state_id];
		$country_id = $_POST[country_id];
		$tel = mysql_escape_string($_POST[tel]);
		$email = mysql_escape_string($_POST[email]);
		$bank_id = $_POST[bank_id];
		$bank_account_no = mysql_escape_string($_POST[bank_account_no]);
		$user_name = mysql_escape_string($_POST[user_name]);
		//$password = md5($_POST[password]);
		$password = md5($_POST[password]);
		$temp_password = '';
		$user_group = $_POST[user_group];
		$remark = mysql_escape_string($_POST[remark]);
		
		$data = getCountry($country_id);
		$nationality_name = $data['nationality_name'];
		
		$data_state = getState($state_id);
		$state_prefix = $data_state['state_prefix'];
		
		$data_country = getCountry($country_id);
		$country_name = $data_country['country_name'];
		$prefix_name = $data_country['prefix_name'];
		
		$data_bank = getBank($bank_id);
		$bank_name = $data_bank['bank_name'];
		$bank_switf_code = $data_bank['bank_switf_code'];
		

  
  if($user_name!="")
  {
    if(!checkUserName($user_name))
		//if($user_name == "abc")
    {

			//$id = addUserRegistration($name, $ic_no, $nationality_id, $nationality_name, $address1, $postcode, $city, $state_id, $state_prefix, $country_id, $country_name, $prefix_name, $tel, $email, $bank_id, $bank_name, $bank_switf_code, $bank_account_no, $user_name, $password, $password, $user_group, $remark);
			
			//add database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "Insert into user ( created_by, created_date) values ( :created_by, NOW())";
            $q = $pdo->prepare($sql);

			$q->bindValue(':created_by', $_SESSION[user_id]);
			$q->execute();
            $id = $pdo->lastInsertId();
		
			Database::disconnect();	

			$displayMsg = "added";
			$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);		  
			//exit;
			//header('Location: index.php?view=detail&id='.$mid);
			//echo "success";

		  
    }
    else
    {

			$displayMsg = 'Duplicate User Name';
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
			echo json_encode($jsonArray);	
	
			
				//return $response;
				//header('Location: index.php?view=detail&id=1');

			

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
  
  if($_POST)
  {

		$password = md5($_POST[password]);
    
    $sql = "UPDATE user
            SET password = '$password', modified_by = $_SESSION[user_id]
            WHERE user_id = $id
           ";
    dbQuery($sql);
    
		$displayMsg = "updated";
		$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);	
  }

}

function deleteUser()
{
	$id = $_GET[id];
  
  if($_POST)
  {
    
		$sql = "UPDATE user
										SET status_id= '-1', delete_sw = '1',delete_by = $_SESSION[user_id],
										modified_by = $_SESSION[user_id]
						WHERE user_id = '$id'
					";
		dbQuery($sql);
		
		$name = getCode('User', 'name', 'user_id', $id);
		
		$remark = 'Delete User -' . mysql_escape_string($name);
		setModuleLog('User', $_SESSION[user_id], 'Delete',  $remark, $id);			
    
		$displayMsg = "deleted";
		header('Location: index.php?view=add&id='.$id.'&displayMsg='.$displayMsg.'');
  }

}


function cancelPage()
{
  if($_POST)
  {
    header("Location: index.php?view=list");
  }
}

function checkUserName($user_name)
{
  $sql = "SELECT user_name
          FROM user
          WHERE user_name = '$user_name'
         ";
  $result=dbQuery($sql);
  if(dbNumRows($result)>0)
  {
    return true;
  }
  else
  {
    return false;
  }
}


?>
