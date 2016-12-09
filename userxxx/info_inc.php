<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../main/session.php";
include "../main/functions.php";

include "../inc/pdoconfig.php";
include "../main/pdofunctions.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
  case 'add' :
    add();
    break;

  case 'update' :
    update();
    break;

  case 'approveUser' :
    approveUser();
    break;
				
  case 'delete' :
    delete();
    break;		
	  
  case 'cancel' :
    cancelPage();
    break;
	
	case 'resetPassword' :
    resetPassword();
    break;
  }
  
  
function add()
{
		$name = mysql_escape_string($_POST[name]);
		$ic_no = mysql_escape_string($_POST[ic_no]);
		$nationality_id = $_POST[nationality_id];
		$address1 = $_POST[address1];
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
		$random_password = createRandomPassword();
		$password = md5($random_password);
		$temp_password = $random_password;
		$user_group = $_POST[user_group];
		$remark = $_POST[remark];
		$sponsor_member_reg_no = mysql_escape_string($_POST[sponsor_member_reg_no]);
		
		$data = getCountry($country_id);
		$nationality_name = $data['nationality_name'];
		
		$data_state = getState($state_id);
		$state_prefix = $data_state['state_prefix'];
		
		$data_country = getCountry($country_id);
		$country_name = $data_country['country_name'];
		$prefix_name = $data_country['prefix_name'];
		
		$data_bank = getBank($bank_id);
		$bank_name = $data_bank['bank_name'];
		$bank_swift_code = $data_bank['bank_swift_code'];	
		
		$userUplineData = getUserDetailByMemberRegNo($sponsor_member_reg_no);
		$upline_id = $userUplineData[user_id];
		
		$login_id = $_SESSION['user_id'];
		if($login_id == '')
		{
			$login_id = 0;
		}
		
		if($name!="") {

			$member_reg_no = ($prefix_name);
			$characters = array_merge(range('0','9'));
			for ($i = 0; $i < 7; $i++) {
			$rand = mt_rand(0, count($characters)-1);
			$member_reg_no .= $characters[$rand];
			}      

			if(!checkUserName($user_name)) {
				
				if ($sponsor_member_reg_no == '0'){

					$current_manager_id = getCurrentManagerID();
					$upline_id = getManagerUserID($current_manager_id);
					
					$data_sponsor = getUserDetail($upline_id);
					$sponsor_member_reg_no = $data_sponsor['member_reg_no'];
					
					updateCurrentManagerID($current_manager_id);
					//$upline_id = 2;
					
				}
				
				if($upline_id > 0) {
					
					if(checkStatusIDUser($upline_id)){	
												
						$new_user_id = addUserRegistration($name, $ic_no, $nationality_id, $nationality_name, $address1, $postcode, $city, $state_id, $state_prefix, $country_id, $country_name, $prefix_name, $tel, $email, $bank_id, $bank_name, $bank_swift_code, $bank_account_no, $user_name, $password, $temp_password, $user_group, $remark, $member_reg_no, $sponsor_member_reg_no, $upline_id);
		
		
						$u_id = genID(user);
						$u_id = $u_id . '-' . $new_user_id;
														
								
						$sql = "SELECT upline_id_all, upline_id
								FROM user
								WHERE user_id = '$upline_id'
								";
						$result=dbQuery($sql);
						$row=dbFetchAssoc($result);
						$upline_id_all = $row[upline_id_all];
						$upline_id2 = $row[upline_id];
								
														
						$cart = array();
						$cart = array($upline_id_all, $new_user_id);
						$new_upline_id_all=implode(",",$cart);
														
														
						if($upline_id2 == 0)
						{
					
							$upline_id3 = 0;
						}
						else
						{
							$upline_id3 =  getCode('user', 'upline_id', 'user_id', $upline_id2);
						}
								
						if($upline_id3 == 0)
						{
							$upline_id4 = 0;
						}
						else
						{
							$upline_id4 =  getCode('user', 'upline_id', 'user_id', $upline_id3);
						}						
								
								
						$sql = "UPDATE user
								SET u_id='$u_id', upline_id_all = '$new_upline_id_all',upline_id2='$upline_id2', upline_id3='$upline_id3',upline_id4='$upline_id4',modified_by = '$login_id'
								where user_id = $new_user_id
								";
						dbQuery($sql);	
						
						//$dataMessage = getMessageTemplate('newmember');
						//$message_subject = $dataMessage[message_subject];
						//$message_content = $dataMessage[message_content];
						//$message_footer = $dataMessage[message_footer];
						$attachment_path = '';
						
						
						insertEmailSend('pendingmember', $attachment_path, $new_user_id, 0, '');
						
																		
						
						//sucess show updated message
						$displayMsg = "added";
						$jsonArray= array('id' => $u_id,'success' => 1, 'displayMsg' => $displayMsg); 
						echo json_encode($jsonArray);	
					}
					else
					{
					//sucess show updated message
					$displayMsg = "User Need Approved by Admin First";
					$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
					echo json_encode($jsonArray);	
					}
				
				}else{
					//sucess show updated message
					$displayMsg = "Sponsor Member ID Not Found!";
					$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
					echo json_encode($jsonArray);					
				}
				
			} else 
			{

				$displayMsg = "Sorry this user name has be taken!";
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);	
								
			}


		}
		else
		{
			//show error message
			$displayMsg = "Missing Info";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}	
	
}

function update()
{
		$id = $_GET['id'];
		
		$userData = getNewUserDetail($id);
		$original_user_name = $userData[user_name];
		
		$name = mysql_escape_string($_POST[name]);
		$ic_no = mysql_escape_string($_POST[ic_no]);
		$nationality_id = $_POST[nationality_id];
		$address1 = $_POST[address1];
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
		$temp_password = $_POST[password];
		$user_group = $_POST[user_group];
		$remark = $_POST[remark];
		
		$data = getCountry($country_id);
		$nationality_name = $data['nationality_name'];
		
		$data_state = getState($state_id);
		$state_prefix = $data_state['state_prefix'];
		
		$data_country = getCountry($country_id);
		$country_name = $data_country['country_name'];
		$prefix_name = $data_country['prefix_name'];
		
		$data_bank = getBank($bank_id);
		$bank_name = $data_bank['bank_name'];
		$bank_swift_code = $data_bank['bank_swift_code'];
		
	if($id != '')
	{

		if(!checkUserName($user_name) or $original_user_name <> '') {		
			//update database
			updateUserRegistrationDetail($id, $name, $ic_no, $nationality_id, $nationality_name, $address1, $postcode, $city, $state_id, $state_prefix, $country_id, $country_name, $prefix_name, $tel, $email, $bank_id, $bank_name, $bank_swift_code, $bank_account_no, $user_name, $password, $temp_password, $user_group, $remark);
			
			
			//sucess show updated message
			$displayMsg = "updated";
			$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);		
			
		}else{
			//sucess show updated message
			$displayMsg = "Sorry this user name has been taken";
			$jsonArray= array('id' => $id,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);				
		}
		
	}
	else
	{
		//show error message
		$displayMsg = "Missing Info";
		$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);			
	}
	
}


function approveUser()
{
	$id = $_GET['id'];
	
	if($id != '')
	{

 		$data = getNewUserDetail($id);	
		$user_id = $data[user_id];

		
		if($data[status_id] == 0) {

			
			updateUserStatus($user_id, 1);
			insertEmailSend('newmember', $attachment_path, $user_id, 0, $data['temp_password']);
			
			
			//sucess show updated message
			$displayMsg = "updated";
			$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
					
		} else { 
		
			//show error message
			$displayMsg = "Status Error while processing. Please refresh your page and try again";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);			
		}
		
		
				
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

 		$data = getNewUserDetail($id);	
		$user_id = $data[user_id];
		$status_id = $data[status_id];
		
		if($status_id == 0) { 
			//update database
			deleteTableDetail('user', 'user_id', $user_id);

			//sucess show deleted message
			$displayMsg = "deleted";
			//$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
			//echo json_encode($jsonArray);
			header("Location: index.php?view=detail&id=$id&displayMsg=$displayMsg");	
					
		}else{
			
			//show error message
			$displayMsg = "You only can delete pending member only";
			$jsonArray= array('id' => $id,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);			
			
		}
		
		
		
			
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

function resetPassword()
{
	$id = $_GET['id'];
	
	
	
	if($id != '')
	{
		$data = getNewUserDetail($id);	
		$user_id = $data[user_id];
		$u_id = $data[u_id];
		
		$random_password = createRandomPassword();
		$password = md5($random_password);
		$temp_password = $random_password;
		
		//update database
		insertEmailSend('forgotPassword', $attachment_path, $user_id, 0, $temp_password);
		
		
		//sucess show updated message
			$displayMsg = "updated";
			$jsonArray= array('id' => $u_id,'success' => 1, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
					
		} else { 
		
			//show error message
			$displayMsg = "Status Error while processing. Please refresh your page and try again";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);			
		}
	
}

?>
