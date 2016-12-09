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

$today_date = date("Y-m-d");
$yesterday_date = strtotime('-1 day', strtotime($today_date));
$bonus_date = date('Y-m-d', $yesterday_date);

autoDailyBonus($bonus_date);


function autoDailyBonus($bonus_date)
{

			require_once ("../sendsms/sms_send_include.php");

			$sql = "SELECT trans_date, acct_ewallet.user_id, SUM(amount_in) as total_amount_in, hpSend, user_name
          			FROM acct_ewallet inner join user on user.user_id = acct_ewallet.user_id
          			WHERE date(trans_date) = '$bonus_date' and hpSend <> ''
					group by user_id
					having COALESCE(SUM(amount_in), 0) > 0
					 ";
			$result=dbQuery($sql);
			$row=dbFetchAssoc($result);
			
			if(dbNumRows($result) > 0)
			{
				while($row=dbFetchAssoc($result))
				{
									$hpSend = $row[hpSend];
									$user_name = $row[user_name];
									$bonus_amount = $row[total_amount_in];
					
									//send sms
									if($hpSend != '')
									{
										$mysms = new sms();
										echo $mysms->session;
										$smsDescrption = 'Tahniah ' . $user_name . '! Pendapatan anda bagi ' . 	
														 $bonus_date . 
														 ' adalah sebanyak RM' . $bonus_amount;
										$APIresponse = $mysms->send ($hpSend, "rbs", "$smsDescrption", "0", "dipping");										
										//echo $APIresponse;											
									}						
				
				}
				
			}

		
}

$_SESSION = array();

session_destroy();


?>