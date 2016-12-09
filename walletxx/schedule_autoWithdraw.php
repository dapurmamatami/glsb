<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
//include "../main/session.php";
include "../main/functions.php";

//$today_date = date("Y-m-d");
//$yesterday_date = strtotime('-1 day', strtotime($today_date));
//$flush_date = date('Y-m-d', $yesterday_date);


session_name("moet");
session_start(); 
$_SESSION['user_id'] = 0;

$withdraw_date = date("Y-m-d");

autoWithdraw($withdraw_date);

function autoWithdraw($withdraw_date)
{
			$sql = "SELECT withdraw_date
			  		FROM acct_ewallet_withdraw
			  		order by withdraw_date desc
			 		limit 1
			 		";
			$result=dbQuery($sql);

			$row=dbFetchAssoc($result);
			$last_withdraw_date = $row['withdraw_date'];
			
			//$withdraw_date = $_POST['withdraw_date'];
			$withdraw_date = date("Y-m-d", strtotime($withdraw_date));
			$withdraw_datetime = date("$withdraw_date H:i:s");	
			
			
			if($withdraw_date > $last_withdraw_date)
			{
				
				$sql = "INSERT INTO acct_ewallet_withdraw(withdraw_date, withdraw_datetime, 
						created_by, created_date)
						VALUES('$withdraw_date', '$withdraw_datetime', 
						$_SESSION[user_id], NOW())
						";
				dbQuery($sql);		
				
				$withdraw_id = mysql_insert_id();
	
				$sql = "SELECT acct_ewallet.user_id, COALESCE(SUM(amount_in), 0) - COALESCE(SUM(amount_out), 0) as wallet_balance, bank.bank_id, bank.bank_name, user.bank_account_no, user.bank_account_holder
					  FROM acct_ewallet inner join user on user.user_id = acct_ewallet.user_id
					  left join bank on bank.bank_id = user.bank_id
					  where acct_ewallet.trans_date < '$withdraw_date' and user.bank_id > 0 and user.bank_account_no <> ''
					  group by acct_ewallet.user_id
					  having COALESCE(SUM(amount_in), 0) - COALESCE(SUM(amount_out), 0) > 50
					 ";
				$result=dbQuery($sql);	
				if(dbNumRows($result)>0)
				{
												   
				  while($row=dbFetchAssoc($result))
				  {
					  $user_id = $row['user_id'];
					  $bank_id = $row['bank_id'];
					  $bank_name = $row['bank_name'];
					  $bank_account_no = $row['bank_account_no'];
					  $bank_account_holder = $row['bank_account_holder'];
					  $wallet_balance = $row['wallet_balance'];
					
					  $withdraw_amount = $wallet_balance - 3;
					  $bank_charge = 3;
					  
					  walletWithdraw('acct_ewallet', 11, $user_id, 'Auto Withdraw From E-Wallet', 0, $withdraw_amount, '', $withdraw_datetime, $bank_id, $bank_name, $bank_account_no, $bank_account_holder);	
					  walletWithdraw('acct_ewallet', 12, $user_id, 'Auto Withdraw Bank Charges', 0, $bank_charge, '', $withdraw_datetime, $bank_id, $bank_name, $bank_account_no, $bank_account_holder);						  												 
				  }
				}		

				//update last date							
				updateLastDate('last_date', $withdraw_date);
									
				changeStatus('acct_ewallet_withdraw', 'withdraw_id', $withdraw_id, 'status_id', 1);
									
	
				//$displayMsg = "updated";
				//$jsonArray= array('id' => 0,'success' => 1, 'displayMsg' => $displayMsg);
				//echo json_encode($jsonArray);					
				
			}
			else
			{
				$error_remark = 'Last Withdraw Date greater than running date:' . $withdraw_date;
				errorStatus(1, $error_remark);
								
				//$displayMsg = "Sorry, withdraw date cannot be earlier than last withdraw date";
				//$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg);
				//echo json_encode($jsonArray);					
			}


}


$_SESSION = array();

session_destroy();

?>