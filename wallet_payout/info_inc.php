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
	
	case 'printReportAll' :
    printReportAll();
    break;
	
	case 'bankTransferSuccess' :
    bankTransferSuccess();
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
	
		$request_date = ($_POST['request_date'] != "") ? "" . date("Y-m-d", strtotime($_POST['request_date'])) . "" : NULL; 
		$user_id = mysql_escape_string($_POST[user_id]);
		$amount = mysql_escape_string($_POST[amount]);
		$remark = mysql_escape_string($_POST[remark]);

		$wallet_balance = walletBalance('acct_ewallet', $user_id);
		
		if($request_date!="")
		{
				if($wallet_balance >= $amount){
					
					$id = addWithdrawRequest($request_date, $user_id, $amount, $remark);
					
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
			$displayMsg = "Please input Request Date";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); 
			echo json_encode($jsonArray);
		}
}



function changeRequestStatus(){
	

		$status_id = $_GET[status_id];
		$request_id = $_POST[request_id];
		$user_id = $_POST[user_id];
		$amount = $_POST[amount];


		
		if($status_id!="") {
			
			updateWithdrawStatus($request_id, $status_id);
			
			if($status_id == 1) { // approve
				//deduct wallet
				$trans_description = 'Withdraw';
				$amount_in = 0;
				$amount_out = $amount;
				$register_user_name = '';
				$trans_datetime = date("Y-m-d h:i:s");
				$sod_id = 0;
				$forward_sw = 0;
				
				$setupData = getCompanySetupDetailForm(1);
				$manual_withdrawal_charge = $setupData[manual_withdrawal_charge];
				
				
				wallet('acct_ewallet', 19, $user_id, $trans_description, $amount_in, $amount_out, $register_user_name, $trans_datetime, $sod_id, $forward_sw);
				
				$trans_description = 'Withdraw Fee';
				
				wallet('acct_ewallet', 19, $user_id, $trans_description, $amount_in, $manual_withdrawal_charge, $register_user_name, $trans_datetime, $sod_id, $forward_sw);
				
				
			}
			

			$displayMsg = "updated";
			$jsonArray= array('id' => 1,'success' => 1, 'displayMsg' => $displayMsg); 
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

function bankTransferSuccess()
{
	updatePendingMonthlyPayout();
	
	header("Location: index.php?view=listPending");
}

?>
