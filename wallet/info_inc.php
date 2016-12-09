<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../main/session.php";
include "../main/functions.php";

include "../inc/pdoconfig.php";
include "../main/pdofunctions.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {

  case 'deletePending' :
    deletePending();
    break;
	
  case 'bankTransfer' :
    bankTransfer();
    break;	
	  
  case 'manualFlush' :
    manualFlush();
    break;

  case 'manualWithdraw' :
    manualWithdraw();
    break;
	
  case 'transferWallet' :
    transferWallet();
    break;
	
  case 'add' :
    add();
    break;
	
  case 'changeRequestStatus' :
    changeRequestStatus();
    break;
	
	case 'printReport' :
    printReport();
    break;
	
	case 'printReportAll' :
    printReportAll();
    break;	
	
	case 'addEWalletAdjustment' :
    addEWalletAdjustment();
    break;	
	
	case 'updatePendingWithdraw' :
    updatePendingWithdraw();
    break;
}


function transferWallet()
{
		
		
		$user_name = mysql_escape_string($_POST[user_name]);
		$amount = $_POST[amount];	
		$wallet_type_from = $_POST['wallet_type_from'];
		
		$user_name_to = mysql_escape_string($_POST[user_name_to]);
		$wallet_type_to = $_POST['wallet_type_to'];
		
		$remark = mysql_escape_string($_POST[remark]);
		
		$user_id = getCode('user', 'user_id', 'user_name', $user_name);
		$country_prefix = getCode('user', 'country_prefix', 'user_name', $user_name);
		$countryData = getCountry($country_prefix);
		$currency_name = $countryData[currency_name];
		
		$user_id_to = getCode('user', 'user_id', 'user_name', $user_name_to);

		$trans_date = date("Y-m-d");
		$trans_datetime = date("$trans_date H:i:s");
		
		if($user_id > 0 and $user_id_to > 0)
		{
			if($amount > 0)
			{				
				if(($user_id != $user_id_to) or ($wallet_type_from != $wallet_type_to and $user_id == $user_id_to))
				{						
					if(checkIfSameCountry($user_name, $user_name_to))
					{	
					
						$wallet_balance = walletBalance($wallet_type_from, $user_id);	
						
						
						if($wallet_balance >= $amount)
						{
							//walllet out
							$trans_description = 'Amount Transfer To ' . $user_name_to . '[' . $wallet_type_to . ']';							
							wallet($wallet_type_from, 20, $user_id, $trans_description, 0 , $amount, $user_name_to, $trans_datetime, 0, 0, $currency_name);
							
							//walllet out
							$trans_description = 'Amount Transfer From ' . $user_name . '[' . $wallet_type_from . ']';							
							wallet($wallet_type_to, 20, $user_id_to, $trans_description, $amount , 0, $user_name_to, $trans_datetime, 0, 0, $currency_name);


							$displayMsg = "added";
							$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
							echo json_encode($jsonArray);														
						}
						else
						{
							$displayMsg = "You don't have enough amount on this wallet. Your balance on this wallet is " . $wallet_balance;
							$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
							echo json_encode($jsonArray);								
						}


					}
					else
					{
						$displayMsg = "Sorry, you cannot transfer to different country member";
						$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
						echo json_encode($jsonArray);							
					}
					
				}
				else
				{
					$displayMsg = "Sorry, you cannot transfer to same person on same wallet type";
					$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
					echo json_encode($jsonArray);							
				}
						
			}
			else
			{
					
					$displayMsg = "Amount has to be greater than 0";
					$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
					echo json_encode($jsonArray);					
				
			}
				


		}
		else
		{
			$displayMsg = "Can't find this Member ID";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
			echo json_encode($jsonArray);
		}
}

function bankTransfer()
{
	$id = $_POST[id];
	$today_date = date("Y-m-d");
	require_once ("../sendsms/sms_send_include.php");
  
  	if($_POST)
  	{
    
			$sql = "Update acct_ewallet set withdraw_sw = 1, withdraw_date = '$today_date'
						WHERE withdraw_sw = 0 and type_id in (11,12)
					";
			dbQuery($sql);
		

			$sql = "SELECT trans_date, acct_ewallet.user_id, hpSend, user_name, amount_out, acct_ewallet.bank_name
          			FROM acct_ewallet inner join user on user.user_id = acct_ewallet.user_id
          			WHERE withdraw_date = '$today_date' and hpSend <> '' and type_id = 11
					group by user_id
					 ";
			$result=dbQuery($sql);
			$row=dbFetchAssoc($result);
			
			if(dbNumRows($result) > 0)
			{
				while($row=dbFetchAssoc($result))
				{
									$hpSend = $row[hpSend];
									$user_name = $row[user_name];
									$bonus_amount = $row[amount_out];
									$bank_name = $row[bank_name];
					
									//send sms
									if($hpSend != '')
									{
										$mysms = new sms();
										echo $mysms->session;
										$smsDescrption = 'Tahniah ' . $user_name . '! Bonus sehingga' . 	
														 $today_date . 
														 ' sebanyak RM' . $bonus_amount .
														 ' telah dikreditkan ke akaun ' . $bank_name .
														 ' anda. T.Kashi';
										$APIresponse = $mysms->send ($hpSend, "rbs", "$smsDescrption", "0", "dipping");										
										//echo $APIresponse;											
									}						
				
				}
				
			}
		
    
			$displayMsg = "updated";
			$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);	
  	}

}

function deletePending()
{
	$id = $_POST[id];
  
  	if($_POST)
  	{
    
		$sql = "Delete From acct_ewallet
						WHERE ewallet_id = '$id'
					";
		dbQuery($sql);
    
		$displayMsg = "deleted";
		$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);	
  	}

}

function add(){
	
		$data = getNewUserDetail($_SESSION['u_id']);
		$bank_id = $data['bank_id'];
		$bank_name = $data['bank_name'];
		$bank_account_no = $data['bank_account_no'];	
	
		$request_date = ($_POST['request_date'] != "") ? "" . date("Y-m-d", strtotime($_POST['request_date'])) . "" : NULL; 
		$user_id = mysql_escape_string($_POST[user_id]);
		$amount = mysql_escape_string($_POST[amount]);
		$remark = mysql_escape_string($_POST[remark]);


		$setupData = getCompanySetupDetailForm(1);
		$manual_withdrawal_charge = $setupData[manual_withdrawal_charge];
		$min_balance_to_keep = $setupData[min_balance_to_keep];

		$wallet_balance = walletAvailableBalance($user_id) - $manual_withdrawal_charge - $min_balance_to_keep;
		
		//$wallet_balance = walletBalance('acct_ewallet', $user_id);
		//$wallet_balance =  walletAvailableBalance($user_id);
		
		if($amount > 0)
		{
				if($wallet_balance >= $amount){
					
					$type_id = 1;
					$id = addWithdrawRequest($request_date, $user_id, $amount, $remark, $bank_id, $bank_name, $bank_account_no, $type_id);
					insertEmailSend('requestpayout', $file_name, $user_id, 0);
					
					//sucess show updated message
					$displayMsg = "added";
					$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
					echo json_encode($jsonArray);	  
	
				}
				else
				{
				
					//sucess show updated message
					$displayMsg = "Balance Not Enough";
					$jsonArray= array('id' => $id,'success' => 0, 'displayMsg' => $displayMsg); 
					echo json_encode($jsonArray);	
				}


		}
		else
		{
			//show error message
			$displayMsg = "Amount has to be greater than 0";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}
}



function changeRequestStatus(){
	

		$status_id = $_GET[status_id];
		
		$request_id = $_POST[request_id];
		$user_id = $_POST[user_id];
		$amount = $_POST[amount];
		$type_id = $_POST[type_id];
		$remark = $_POST[remark];
		$bank_name = $_POST[bank_name];
		$bank_account_no = $_POST[bank_account_no];
		$reference_no = $_POST[reference_no];
		
		$request_date = $_POST[request_date];
		$dateValidate = strtotime('-1 month', strtotime($request_date));
		$showMonth = date('M', $dateValidate);
		$showYear = date('Y', $dateValidate);
		
		
		$dataMessage = getMessageTemplate('monthlypayout');
		$email_subject = $dataMessage[message_subject];
		$message_content = $dataMessage[message_content];
		if($type_id > 1)
		{
		$email_message = 'TAHNIAH! Anda telah diberikan pembayaran pendapatan terkumpul anda bagi bulan'. ' '. $showMonth . ' '. $showYear. ' ' . 'seperti berikut dan sila semak akaun bank anda.'. '<br />' . 'Jumlah Bayaran	:' . 'RM' . $amount . '.' . '<br />' . 'Bank	:' . $bank_name . '<br />' . 'Nombor Akaun	:'. $bank_account_no . '<br />' . 'Rujukan	:' . $reference_no . '<br />' . $message_content;
		}
		else
		{
		$email_message = 'Jumlah Bayaran	:' . 'RM' . $amount . '.' . '<br />' . 'Bank	:' . $bank_name . '<br />' . 'Nombor Akaun	:'. $bank_account_no . '<br />' . 'Rujukan	:' . $reference_no . '<br />' . $message_content;	
		}
		$email_message = str_replace("\n","<br />", $email_message);
		$email_message_footer = $dataMessage[message_footer];

		if($bank_name!='' and $bank_account_no != '') 
		{	
			if($reference_no != '')
			{
				if($status_id == 1) { // approve
					//deduct wallet
					
					$amount_in = 0;
					$amount_out = $amount;
					$register_user_name = '';
					$trans_datetime = date("Y-m-d h:i:s");
					$sod_id = 0;
					$forward_sw = 0;
					
					$setupData = getCompanySetupDetailForm(1);
					$manual_withdrawal_charge = $setupData[manual_withdrawal_charge];
					
					//$wallet_balance =  walletAvailableBalance($user_id);
					$wallet_balance = (!is_null(walletAvailableBalance($user_id))) ? walletAvailableBalance($user_id) : 0;
					$wallet_balance = $wallet_balance + $amount;
					if($wallet_balance >= $amount or $type_id == 2) { 
					
						updateWithdrawStatus($request_id, $status_id);
						
					
						if($type_id == 1) //manual withdraw
						{ 
						
	
							$trans_description = 'Withdraw' . ' ' . '(' .$reference_no . ')';
							
							wallet('acct_ewallet', 19, $user_id, $trans_description, $amount_in, $amount_out, $register_user_name, $trans_datetime, $sod_id, $forward_sw, 0 , $request_id);
							
							$trans_description = 'Withdraw Fee';
							
							wallet('acct_ewallet', 30, $user_id, $trans_description, $amount_in, $manual_withdrawal_charge, $register_user_name, $trans_datetime, $sod_id, $forward_sw,  0, $request_id);
													
						}
						else
						{
	
							//for pool bonus;
				
							//$trans_description = $remark;
							//wallet('acct_ewallet', 3, $user_id, $trans_description, $amount, 0, 0, $trans_datetime, 0, 0, 0, $request_id);
							
							$trans_description = 'Withdraw' . ' ' . '(' .$reference_no . ')';
							
							wallet('acct_ewallet', 19, $user_id, $trans_description, 0, $amount, 0, $trans_datetime, 0, 0, 0, $request_id);						
							
						}
						
						$displayMsg = "updated";
						$jsonArray= array('id' => 1,'success' => 1, 'displayMsg' => $displayMsg); 
						echo json_encode($jsonArray);	
	
						insertEmailSendPayout($email_subject, $email_message, $email_message_footer, NULL, $user_id, 0, NULL);
						
						
						
					} else {
						
						
	
						$displayMsg = "Not Sufficient Fund for this transaction";
						$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
						echo json_encode($jsonArray);					
						
					}
					
					
					
				}else{
					
	
					updateWithdrawStatus($request_id, $status_id);
	
					$displayMsg = "Rejected";
					$jsonArray= array('id' => 0,'success' => 1, 'displayMsg' => $displayMsg); 
					echo json_encode($jsonArray);						
				}
			
			
			}
			else
			{
				//show error message
				$displayMsg = "Please Insert Reference Number";
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);
			}
		}
		else
		{
			//show error message
			$displayMsg = "Missing Bank Info";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}
}

function printReport()
{
	
		$main_id = $_GET['id'];
		$report_name = 'pending_monthly_payout';
		$user_id = $_SESSION['user_id'];
		$date_from = ($_POST['date_from'] != "") ? "" . date("Y-m-d", strtotime($_POST['date_from'])) . "" : NULL; 
		$date_to = ($_POST['date_to'] != "") ? "" . date("Y-m-d", strtotime($_POST['date_to'])) . "" : NULL;
		
			
		header("Location: ../../cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/$report_name&aliasname=glsb&username=admin&password=&Parammain_id=$main_id&Paramuser_id=$user_id&ParamDate_From=$date_from&ParamDate_To=$date_to");		
}

function printReportAll()
{
		if($_GET['wallet'] == 'ewallet'){
			
		$main_id = $_GET['id'];
		$report_name = 'statement';
		$user_id = $_SESSION['user_id'];
		$month_id = $_POST['month_id'];
		$year_id = $_POST['year_id'];		
			
		header("Location: ../../cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/$report_name&aliasname=glsb&username=admin&password=&Paramuser_id=$user_id&Parammonth_id=$month_id&Paramyear_id=$year_id");		
		}
		
		else if($_GET['wallet'] == 'ewalletWithdraw')
		{
			
		$main_id = $_GET['id'];
		$report_name = 'ewallet_withdraw';
		$user_id = $_SESSION['user_id'];
		$date_from = ($_POST['date_from'] != "") ? "" . date("Y-m-d", strtotime($_POST['date_from'])) . "" : NULL; 
		$date_to = ($_POST['date_to'] != "") ? "" . date("Y-m-d", strtotime($_POST['date_to'])) . "" : NULL;
		
			
		header("Location: ../../cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/$report_name&aliasname=glsb&username=admin&password=&Parammain_id=$main_id&Paramuser_id=$user_id&ParamDate_From=$date_from&ParamDate_To=$date_to");
		}
		
}

function addEWalletAdjustment()
{
		$member_reg_no = $_POST[member_reg_no];
		
		$dataMember = getUserDetailByMemberRegNo($member_reg_no);
		$user_id = $dataMember['user_id'];
		
		$trans_description = $_POST[trans_description];
		$amount = $_POST[amount];
		$amount_in = $_POST[amount_in];
		$amount_out = $_POST[amount_out];


		if($member_reg_no!='')
		{
			if($user_id > 0)
			{
				if($amount > 0)
				{
					$amount_in = $amount;
					$amount_out = 0;
				}
				else
				{
					$amount_in = 0;
					$amount_out = -($amount);
				}
				
				wallet('acct_ewallet', 20, $user_id, $trans_description, $amount_in, $amount_out, 0, 0, 0, 0, 0, 0);				
				//sucess show updated message
				$displayMsg = "added";
				$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);
			}
			else
			{
				//show error message
				$displayMsg = "Member Don't Not Exist";
				$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
				echo json_encode($jsonArray);	
			}	  
		}
		else
		{
			//show error message
			$displayMsg = "Missing Member Registration Number";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}	
	
}

function updatePendingWithdraw()
{
	$id = $_POST[request_id];
	$reference_no =  mysql_escape_string($_POST[reference_no]);
  
  	if($id != '' && $reference_no !='')
	{
		//update database
		$sql = "UPDATE acct_ewallet_withdraw_request
				SET 
				reference_no = '$reference_no',
				modified_by = $_SESSION[user_id]
				WHERE request_id = $id
				";
		dbQuery($sql);	
		
		
		//sucess show updated message
		$displayMsg = "updated";
		$jsonArray= array('id' => $id,'success' => 1, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);				
	}
	else
	{
		//show error message
		$displayMsg = "Please Input Reference No";
		$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
		echo json_encode($jsonArray);			
	}

}

?>
