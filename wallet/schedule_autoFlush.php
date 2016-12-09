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


$flush_date = date("Y-m-d");

autoFlush($flush_date);


function autoFlush($flush_date)
{

			$sql = "SELECT flush_date
					  FROM daily_flush
					  order by flush_date desc
					  limit 1
					 ";
			$result=dbQuery($sql);
			$row=dbFetchAssoc($result);
			$last_flush_date = $row['flush_date'];
			
			//$flush_date = date("Y-m-d", strtotime($flush_date));
			$flush_datetime = date("$flush_date H:i:s");	
			
			
			if($flush_date > $last_flush_date)
			{
				if(!checkStatusError())
				{
					$sql = "INSERT INTO daily_flush(flush_date, flush_datetime, 
							created_by, created_date)
							VALUES('$flush_date', '$flush_datetime', 
							$_SESSION[user_id], NOW())
							";
					dbQuery($sql);		
					
					$flush_id = mysql_insert_id();
		
					$sql = "SELECT *
							  FROM user
							  where user_id > 1
							 ";
					$result=dbQuery($sql);
					if(dbNumRows($result)>0)
					{
													   
					  while($row=dbFetchAssoc($result))
					  {
						  $user_id = $row['user_id'];
						  $user_name = $row['user_name'];
						  $pkg_id = $row['pkg_id'];
						  checkPairing($user_id, $user_name, $pkg_id, $flush_datetime, $flush_date, 1);
														 
					  }
					}		

					//update last date							
					updateLastDate('last_date', $flush_date);
														
					changeStatus('daily_flush', 'flush_id', $flush_id, 'status_id', 1);
										
		
					//$displayMsg = "updated";
					//$jsonArray= array('id' => 0,'success' => 1, 'displayMsg' => $displayMsg);
					//echo json_encode($jsonArray);							
				}
				else
				{
					$error_remark = 'checkStatus Error while schedule auto flush';
					errorStatus(1, $error_remark);
	
					//$displayMsg = "Error";
					//$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg);
					//echo json_encode($jsonArray);						
				}
				
			
			
			}
			else
			{
				$error_remark = 'Last Flush Date greater than running date:' . $flush_date;
				errorStatus(1, $error_remark);

				//$displayMsg = "Error";
				//$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg);
				//echo json_encode($jsonArray);					
			}


}

$_SESSION = array();

session_destroy();


?>