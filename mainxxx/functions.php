<?php 

function logSession($uid, $module, $ip, $sid)
{
  if($uid!=""){
    $sql = "INSERT INTO user_log(user_id, module, user_ip,
            timestamp, session_id)
            VALUES($uid, '$module', '$ip', NOW(), '$sid')
           ";
    $result=dbQuery($sql);
    
    return mysql_insert_id();
  }
  /*
  $sql = "SELECT MAX(con_log_id) as mid
          FROM con_user_log
         ";
  $result=dbQuery($sql);
  $row=dbFetchAssoc($result);
  
  return  $row[mid];*/
}

function setSession($bool, $userName, $userID, $userGrp, $sid, $lid, $main_page, $full_mlm_sw, $company_id,$branch_id,$host, $logo, $alias, $validate_key, $version_no, $name, $lang, $u_id)
{
    $_SESSION['basic_is_logged_in'] = $bool; 
    $_SESSION['user_name'] = $userName;
    $_SESSION['user_id'] = $userID;
    $_SESSION['user_grp'] = $userGrp;
    $_SESSION['sid'] = $sid;
    $_SESSION['lid'] = $lid;
	$_SESSION['company_id'] = $company_id;
	$_SESSION['branch_id'] = $branch_id;
	$_SESSION['host'] = $host;
	$_SESSION['logo'] = $logo;
	$_SESSION['alias'] = $alias;
	$_SESSION['validate_key'] = $validate_key;
	$_SESSION['version_no'] = $version_no;
	$_SESSION['name'] = $name;
	$_SESSION['lang'] = $lang;
	$_SESSION['u_id'] = $u_id;

}


function setSessionxxxx($bool, $userName,$uID, $userID, $userGrp, $sid, $lid, $main_page, $full_mlm_sw, $company_id,$branch_id, $name)
{
    $_SESSION['basic_is_logged_in'] = $bool; 
    $_SESSION['user_name'] = $userName;
    $_SESSION['user_id'] = $userID;
	$_SESSION['u_id'] = $uID;
    $_SESSION['user_grp'] = $userGrp;
    $_SESSION['sid'] = $sid;
    $_SESSION['lid'] = $lid;
	$_SESSION['company_id'] = $company_id;
	$_SESSION['branch_id'] = $branch_id;
	$_SESSION['name'] = $name;
	//$_SESSION['pkg_name'] = $pkg_name;

}

function updateSession($lid, $module)
{
  $sql="SELECT con_module
        FROM con_user_log
        WHERE con_log_id = $lid
       ";
  $result = dbQuery($sql);
  if(dbNumRows($result)==1)
  {
    $row=dbFetchAssoc($result);
    if($row[con_module]==$module)
    {
      $sql="UPDATE con_user_log
            SET con_timestamp = NOW()
            WHERE con_log_id = $lid
           ";
      dbQuery($sql) or die("Log Error.");
    }
    else
    {
      $log_id = logSession($_SESSION[user_id], $module, $_SERVER['REMOTE_ADDR'], session_id());
      $_SESSION['lid'] = $log_id;
    }
  }
}

//check for access rights
function checkAccess($grp, $moduleFolder, $access)
{
  $sql = "SELECT module_id, module_name, module_folder
          FROM system_module
          WHERE module_folder = '$moduleFolder'
         ";
  $result = dbQuery($sql);
  if(dbNumRows($result)==1)
  {
    $row=dbFetchAssoc($result);
    $module_id = $row[module_id];
    $module_name =$row[module_name];
  }
	
	//date validate
	$system_today = date('Y-m-d');
	if($system_today > '2020-05-25')
	{
		$unallow_sw = 1;
	}
	else
	{
		$unallow_sw = 0;
	}	
  
  if($module_name!="")
  {
    $sql = "SELECT *
            FROM user_group_permission
            WHERE user_group_id = $grp
						AND $access = 1
            AND module_id = '$module_id'
           ";
    //echo $sql.'<BR>';
    $result = dbQuery($sql);
    if(dbNumRows($result)==1 and $unallow_sw == 0)
    {
       $bool = true;
    }
  }
  else
  {
    $bool = false;
  }
  return $bool;
}

function checkDateFrom()
{

  $sql = "SELECT start_date
          FROM period_month where status_id = 0 order by period_id limit 1
         ";
  $result = dbQuery($sql);	
  $row=dbFetchAssoc($result);
	
	$date_from = $row[start_date];
	return $date_from;
}

function checkDateTo()
{

  $sql = "SELECT end_date
          FROM period_month where status_id = 0 order by period_id desc limit 1
         ";
  $result = dbQuery($sql);	
  $row=dbFetchAssoc($result);
	
	$date_to = $row[end_date];
	return $date_to;
}

function getSOID($userID)
{

 	//$getTable = $tableName;
	
  $sql = "SELECT so_id_seq
          FROM user
          WHERE user_id = '$userID'
         ";
  $result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$seq_id = $row[so_id_seq];		
	
	return $seq_id;

}

function updateSOID($userID, $currentID)
{

 	//$getTable = $tableName;
	$seq_id_next = $currentID + 1;
	
  $sql = "UPDATE user
            SET so_id_seq = $seq_id_next
            WHERE user_id = '$userID'
         ";
  dbQuery($sql);	

}

function getClaimID($userID)
{

 	//$getTable = $tableName;
	
  $sql = "SELECT claim_id_seq
          FROM user
          WHERE user_id = '$userID'
         ";
  $result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$seq_id = $row[claim_id_seq];		
	
	return $seq_id;

}

function updateClaimID($userID, $currentID)
{

 	//$getTable = $tableName;
	$seq_id_next = $currentID + 1;
	
  $sql = "UPDATE user
            SET claim_id_seq = $seq_id_next
            WHERE user_id = '$userID'
         ";
  dbQuery($sql);	

}

function getARID($companyID, $catID)
{

 	//$getTable = $tableName;
	
  $sql = "SELECT $catID as ar_id
          FROM company
          WHERE company_id = '$companyID'
         ";
  $result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$seq_id = $row[ar_id];		
	
	return $seq_id;

}

function updateARID($companyID, $catID, $currentID)
{

 	//$getTable = $tableName;
	$seq_id_next = $currentID + 1;
	
  $sql = "UPDATE company
            SET $catID = $seq_id_next
            WHERE company_id = '$companyID'
         ";
  dbQuery($sql);	

}

function getNewID($tableName)
{

 	$getTable = $tableName;
	
  $sql = "SELECT $getTable
          FROM company
          WHERE company_id = 1
         ";
  $result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$seq_id = $row[$tableName];		
	
	return $seq_id;

}

function updateNewID($tableName, $currentID)
{

 	$getTable = $tableName;
	$seq_id_next = $currentID + 1;
	
  $sql = "UPDATE company
            SET $getTable = $seq_id_next
            WHERE company_id = 1
         ";
  dbQuery($sql);	

}

function getID($tableName)
{

 	$getTable = $tableName;
	
  $sql = "SELECT $getTable
          FROM seq_id
          WHERE seq_id = 1
         ";
  $result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$seq_id = $row[$tableName];		
	
	return $seq_id;

}

function updateID($tableName, $currentID)
{

 	$getTable = $tableName;
	$seq_id_next = $currentID + 1;
	
  $sql = "UPDATE seq_id
            SET $getTable = $seq_id_next
            WHERE seq_id = 1
         ";
  dbQuery($sql);	

}

function getCode($tableName, $fieldName, $idName, $id)
{

	
  $sql = "SELECT $fieldName
          FROM $tableName
          WHERE $idName = '$id'
         ";
  $result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$code_name = $row[$fieldName];		
	
	return $code_name;

}

function getDepartment($id)
{

	
  $sql = "SELECT department_code
          FROM user left join master_department_code on user.department_id = master_department_code.department_id
          WHERE user_id = '$id'
         ";
  $result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$department_code = $row[department_code];		
	
	return $department_code;

}

function setModuleLog($module_name, $staff_id, $module_event, $remark, $main_id)
{

	
  if($module_name!=""){
	
    $name = getCode('user', 'name', 'user_id', $staff_id);
		
		$sql = "INSERT INTO user_module_log(log_date, user_id, staff_name, module_name, module_event, remark, main_id,
            created_by, created_date)
            VALUES(NOW(), '$staff_id', '$name','$module_name','$module_event','$remark','$main_id', '$staff_id', NOW())
           ";
    $result=dbQuery($sql);
    
    //return mysql_insert_id();
  }

}

function validateDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') == $date;
}

function archiveData($tableName, $fieldName, $fieldValue, $valueID)
{

	
  $sql = "UPDATE $tableName
            SET archive_sw = $valueID
            WHERE $fieldName = '$fieldValue'
         ";
  dbQuery($sql);	

}

function createRandomPassword() {
   	//$chars = "abcdefghijkmnopqrstuvwxyz023456789";
	  $chars = "abcdefgdjkmnprstuvwxyz023456789";
    srand((double)microtime()*1000000);

    $i = 0;
    $pass = '' ;

    while ($i <= 7) {

        //$num = rand() % 33;
				$num = rand() % 39;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;

    }

    return $pass;

}

function genID($prefix)
{
	$getID = uniqid($prefix);
	return $getID;
	
}

function sendPassword($sent_to, $temp_password)
{
		require("../email/class.phpmailer.php");		
		//$sent_to = 'yapcheeyen@gmail.com';
		//$subject = $_POST[subject];
		//$attachment_path = $_POST[attachment_path];
		//$message = str_replace("\n","<br />",$_POST['message']);
		$subject = 'Password Reset';
		$message2 = 'Temporary Passwod : ' . $temp_password;
		
		$message = str_replace("\n","<br />",$message2);

		

		$sql = "Select * FROM system_setting WHERE setting_id = 1
					 ";
		$result=dbQuery($sql);
		$row=dbFetchAssoc($result);
		$host_name = $row['host_name'];
		$host_user_name = $row['host_user_name'];
		$host_password = $row['host_password'];
		$host_mail_from = $row['host_mail_from'];
		$host_mail_from_name = $row['host_mail_from_name'];
		$host_port = $row['host_port'];
		$notify_send_to = $row['notify_send_to'];		
		
	
  
		if($host_name!="")
		{

						
								$mail = new PHPMailer();
								
								
								$mail->IsSMTP();                                      // set mailer to use SMTP
								$mail->Host = $host_name;  // specify main and backup server
								$mail->SMTPAuth = true;     // turn on SMTP authentication
								$mail->Username = $host_user_name;  // SMTP username
								$mail->Password = $host_password; // SMTP password
								$mail->Port = $host_port;
								
								$mail->From = $host_mail_from;
								$mail->FromName = $host_mail_from_name;
								
								//$sent_to = $row['email'];	
								$emails = $sent_to;
								
								$emails = explode(',', $emails);
								$emails = array_map('trim', $emails);
								
								foreach ($emails as $email){
										$mail->AddAddress($email);
								}

								
								
								
								//$mail->AddAddress($sent_to);
								//$mail->AddAddress("cyyap@efreightech.com");                  // name is optional
								$mail->AddReplyTo($host_mail_from, "Information");
								
								$mail->WordWrap = 50;                                 // set word wrap to 50 characters


                
								//$file_name = 'attachment/' . $_FILES['file']['name'];
								//$mail->AddAttachment($file_name);
								
												 // add attachments
								$mail->IsHTML(true);                                  // set email format to HTML
								
								$mail->Subject = $subject;
								//$mail->Body    = $message;
								
								//$mail->AddEmbeddedImage('../images/logo.jpg', 'my-photo', '../images/logo.jpg');
								// set the required font and size for html-mails
								//$htmlfont = "<font face=\"Calibri\" size=\"3\">";
								$htmlfont = "<span style='size=\"3\"; FONT-FAMILY: Calibri'>";
								
								// preformat the html-message
								$htmlmessage = $htmlfont.$message."<br /><br />".$message."</span>";
								
								//$mail->Body    = 'Embedded Image: <img src="cid:my-photo"> '; $htmlmessage;		
								$mail->Body    = $htmlmessage;	
								
								//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
								
								if(!$mail->Send())
								{
									 echo "Message could not be sent. <p>";
									 echo "Mailer Error: " . $mail->ErrorInfo;
									 exit;
								}	
								
								
								return true;

				//header("location: ../email/index.php?view=add");
		
	
		}
		else
		{
			$displayMsg = "Missing Host Name";
			$jsonArray= array('id' => 0,'success' => 0, 'displayMsg' => $displayMsg); //*1 value is named LastID
			echo json_encode($jsonArray);
		}
}



function checkUserStatusError()
{
  $sql = "SELECT user_name
          FROM user
          WHERE status_id = 0
		  limit 1
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

function checkUserGenealogyAccess()
{
  $sql = "SELECT user_name
          FROM user
          WHERE user_id = $_SESSION[user_id]
		  limit 1
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


function walletWithdraw($wallet_type, $type_id, $user_id, $trans_description, $amount_in, $amount_out, $register_user_name, $trans_datetime, $bank_id, $bank_name, $bank_account_no, $bank_account_holder)
{
	$sql = "INSERT INTO $wallet_type(trans_date,type_id, user_id, trans_description, amount_in,amount_out,
			register_user_name, bank_id, bank_name, bank_account_no, bank_account_holder, created_by, created_date)
			VALUES('$trans_datetime', $type_id, '$user_id','$trans_description', '$amount_in','$amount_out',
			'$register_user_name','$bank_id','$bank_name','$bank_account_no','$bank_account_holder', $_SESSION[user_id], NOW())
		   ";
	dbQuery($sql);	
	
	$wallet_id = mysql_insert_id();
	
	return $wallet_id;
}

function walletBalance($wallet_type, $user_id)
{
  	$sql = "SELECT COALESCE(SUM(amount_in), 0) - COALESCE(SUM(amount_out), 0) as wallet_balance
          FROM $wallet_type
          WHERE user_id = '$user_id' and forward_sw = 0
         ";
  	$result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$wallet_balance = $row[wallet_balance];		
	
	return $wallet_balance;	
}

function walletAvailableBalance($user_id)
{
  	$sql = "SELECT COALESCE(SUM(amount_in), 0) - COALESCE(SUM(amount_out), 0) as wallet_balance
          FROM acct_ewallet
          WHERE user_id = '$user_id' and forward_sw = 0
         ";
  	$result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$wallet_balance = $row[wallet_balance];	
	
  	$sql = "SELECT COALESCE(SUM(amount), 0) as total_amount
          FROM acct_ewallet_withdraw_request
          WHERE user_id = '$user_id' and status_id = 0 and type_id = 1
         ";
  	$result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$total_amount = $row[total_amount];		
	
	$available_balance = $wallet_balance - $total_amount;
	return $available_balance;	
}

function withdrawRequestAmount($user_id, $status_id)
{
  	$sql = "SELECT sum(amount) as total_amount
          FROM acct_ewallet_withdraw_request
          WHERE user_id = '$user_id' and status_id = $status_id
         ";
  	$result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$total_amount = $row[total_amount];		
	
	return $total_amount;	
}

function checkMinStockistPkgPrice()
{
  	$sql = "SELECT COALESCE(pkg_price, 0) - COALESCE(stockist_commission, 0) as minPrice
          FROM product_package
          order by pkg_price asc
		  limit 1
         ";
  	$result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$minPrice = $row[minPrice];		
	
	return $minPrice;		
}

function checkPkgPrice($pkg_id, $west_sw)
{
  	if($west_sw == 1)
	{
		$sql = "SELECT COALESCE(pkg_price_west, 0) as pkgPrice, pkg_point, sponsor_bonus, stockist_commission, pkg_name
          		FROM product_package
		 	 	where pkg_id = $pkg_id
		  		limit 1
         		";	
	}
	else
	{
		$sql = "SELECT COALESCE(pkg_price, 0) as pkgPrice, pkg_point, sponsor_bonus, stockist_commission, pkg_name
          		FROM product_package
		 	 	where pkg_id = $pkg_id
		  		limit 1
         		";		
	}
	

  	$result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$pkgPrice = $row[pkgPrice];	
	$pkgPoint = $row[pkg_point];	
	$pkgPoint = $row[pkg_point];
	$sponsorBonus = $row[sponsor_bonus];
	$stockistCommission = $row[stockist_commission];
	$pkgName = $row[pkg_name];
	
	//return $pkgPrice;	
	return array('pkgPrice' => $pkgPrice, 'pkgPoint' => $pkgPoint, 'sponsorBonus' => $sponsorBonus, 'stockistCommission' => $stockistCommission, 'pkgName' => $pkgName);			
}

function checkRepurchasePrice($id)
{
  	$sql = "SELECT repurchase_price
			From setting_default
			where id = $id
		    limit 1
           ";
  	$result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$repurchase_price = $row[repurchase_price];		
	
	return $repurchase_price;		
}

function calcTotalBonus($wallet_type, $type_id, $user_id, $in_out)
{
  	$sql = "SELECT COALESCE(sum($in_out),0) as total_bonus
			From $wallet_type
			where user_id = $user_id and type_id = $type_id
           ";
  	$result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$total_bonus = $row[total_bonus];		
	
	return $total_bonus;		
}

function getTotalLeg($memid,$leg){
  $sql="select user_id, pkg_point from user left join product_package on user.pkg_id = product_package.pkg_id where 
        upline_id='".$memid."' and placement_side='".$leg."'";
    
  $res=mysql_query($sql);
  
  global $total;
   
    
  //$total=$total+mysql_num_rows($res);
  $row=mysql_fetch_array($res);
 
     $pkg_point = $row['pkg_point'];
	 $total=$total+$pkg_point;
	 
	 if($row['user_id']!=''){
       getTotalLeg ($row['user_id'],'Left');
       getTotalLeg ($row['user_id'],'Right');
      }

    return $total;

}  

function getTotalLegxxxxxxx($memid,$leg){
  $sql="select user_id from user where 
        upline_id='".$memid."' and placement_side='".$leg."'";
    
  $res=mysql_query($sql);
  
  global $total;
   
    
  $total=$total+mysql_num_rows($res);
  $row=mysql_fetch_array($res);
 
     if($row['user_id']!=''){
       getTotalLeg ($row['user_id'],'Left');
       getTotalLeg ($row['user_id'],'Right');
      }

    return $total;

}  

function checkPoint($user_id)
{

  	$sql = "SELECT COALESCE(SUM(left_point), 0) as total_left_point,
			COALESCE(SUM(right_point), 0) as total_right_point
          FROM acct_point
          WHERE user_id = $user_id
         ";
  	$resultTotal=dbQuery($sql);
	$row=dbFetchAssoc($resultTotal);
	$total_left_point = $row['total_left_point'];
	$total_right_point = $row['total_right_point'];
	
  	$sql = "SELECT COALESCE(SUM(pair_point), 0) as total_pair_point
          FROM acct_point_pairing
          WHERE user_id = $user_id
         ";
  	$resultTotal=dbQuery($sql);
	$row=dbFetchAssoc($resultTotal);
	$total_pair_point = $row['total_pair_point'];	
	
	$balance_left_point = abs($total_left_point - $total_pair_point);
	$balance_right_point = abs($total_right_point - $total_pair_point);
	
	
	return array('balance_left_point' => $balance_left_point, 'balance_right_point' => $balance_right_point, 'total_left_point' => $total_left_point, 'total_right_point' => $total_right_point);	
}

function checkDailyPairPoint($user_id, $pairing_date)
{

	
  	$sql = "SELECT COALESCE(SUM(pair_point), 0) as total_pair_point
          FROM acct_point_pairing
          WHERE user_id = $user_id and pairing_date = '$pairing_date'
         ";
  	$resultTotal=dbQuery($sql);
	$row=dbFetchAssoc($resultTotal);
	$total_daily_pair_point = $row['total_pair_point'];	
	
	
	return $total_daily_pair_point;	
}

function changeStatus($tableName, $tableIDName, $id, $fieldName, $fieldValue)
{
	 $sql = "UPDATE $tableName
				SET $fieldName = $fieldValue
				WHERE $tableIDName = $id
			 ";
	 dbQuery($sql);	
}

function errorStatus($status_id, $remark)
{
	 $sql = "UPDATE validate_data
				SET error_status = $status_id, error_remark = '$remark'
				WHERE id = 1
			 ";
	 dbQuery($sql);	
}

function updateLastDate($fieldName, $fieldValue)
{
	 $sql = "UPDATE validate_data
				SET $fieldName = '$fieldValue'
				WHERE id = 1
			 ";
	 dbQuery($sql);	
}

function checkLastDate($inputDate)
{
	  $sql = "SELECT *
			  FROM validate_data
			  WHERE id = 1 and last_date <= '$inputDate'
			  limit 1
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

function checkStatusError()
{
	
  $sql = "SELECT user_name
          FROM user
          WHERE status_id = 0
		  limit 1
         ";
  $resultUser=dbQuery($sql);
  
  $sql = "SELECT status_id
          FROM user_pkg_change
          WHERE status_id = 0
		  limit 1
         ";
  $resultPkgChange=dbQuery($sql);
  

  $sql = "SELECT status_id
          FROM repurchase
          WHERE status_id = 0
		  limit 1
         ";
  $resultRepurchase=dbQuery($sql);
  
  $sql = "SELECT status_id
          FROM daily_flush
          WHERE status_id = 0
		  limit 1
         ";
  $resultDailyFlush=dbQuery($sql);  

  $sql = "SELECT status_id
          FROM topup
          WHERE status_id = 0
		  limit 1
         ";
  $resultTopUp=dbQuery($sql);
        

  $sql = "SELECT status_id
          FROM user
		  group by upline_id
		  having count(user_id) > 2
		  limit 1
         ";
  $resultBinary=dbQuery($sql);
  

  $sql = "SELECT user_id
          FROM user_pool
		  group by upline_id
		  having count(user_id) > 2
		  limit 1
         ";
  $resultUniversalBinary=dbQuery($sql);
  

  $sql = "SELECT status_id
          FROM acct_ewallet_withdraw
		  where status_id = 0
		  limit 1
         ";
  $resultWithdrawStatus=dbQuery($sql);  


  $sql = "SELECT error_status
          FROM validate_data
		  where error_status = 1
		  and id = 1
         ";
  $resultErrorStatus=dbQuery($sql);  


  $sql = "SELECT * 
			FROM  `user` 
			WHERE placement_side =  'Left'
			GROUP BY upline_id
			HAVING COUNT( user_id ) >1
         ";
  $resultLeftCheck=dbQuery($sql);  

  $sql = "SELECT * 
			FROM  `user` 
			WHERE placement_side =  'Right'
			GROUP BY upline_id
			HAVING COUNT( user_id ) >1
         ";
  $resultRightCheck=dbQuery($sql);  
          
    
  if(dbNumRows($resultUser)>0 or dbNumRows($resultPkgChange)>0 or dbNumRows($resultRepurchase)>0 or dbNumRows($resultDailyFlush)>0or dbNumRows($resultTopUp)>0 or dbNumRows($resultBinary)>0 or dbNumRows($resultUniversalBinary)>0 or dbNumRows($resultWithdrawStatus)>0 or dbNumRows($resultErrorStatus) > 0 or dbNumRows($resultLeftCheck) > 0 or dbNumRows($resultRightCheck) > 0)
  {
    return true;
  }
  else
  {
    return false;
  }	
}


function checkPairing($user_id, $user_name, $pkg_id, $trans_datetime, $trans_date, $auto_flush)
{
	
	//$max_daily_point = getCode('product_package', 'max_daily_point', 'pkg_id', $pkg_id);
	//$max_daily_point = 100;
  	$sql = "SELECT max_daily_point
          FROM product_package
          WHERE pkg_id = $pkg_id
		  limit 1
         ";
  	$resultPkg=dbQuery($sql);
	$row=dbFetchAssoc($resultPkg);	
	$max_daily_point = $row['max_daily_point'];
	
	$checkPoint = checkPoint($user_id);
	$balance_left_point = $checkPoint['balance_left_point'];
	$balance_right_point = $checkPoint['balance_right_point'];
	
	if($balance_left_point > 0 and $balance_right_point > 0)
	{
	
		if($balance_left_point > $balance_right_point)
		{
			$pair_point = $balance_right_point;
		}
		else
		{
			$pair_point = $balance_left_point;
		}
		
		$actual_pair_point = $pair_point;
	
		$total_daily_pair_point = checkDailyPairPoint($user_id, $trans_date);
		$balance_max_daily_point = $max_daily_point - $total_daily_pair_point;
		
		if($balance_max_daily_point >= $pair_point)
		{
			$total_pair_point = $pair_point;
		}
		else
		{
			
			$total_pair_point = $balance_max_daily_point;
		}
		
		if($total_pair_point > 0 and $max_daily_point > $total_daily_pair_point and $auto_flush ==0)
		{
								
				$total_bonus = $total_pair_point * 15;
				
				$sql = "INSERT INTO acct_point_pairing(pairing_date,pairing_datetime, user_id,user_name, pair_point, total_bonus,
						created_by, created_date)
						VALUES('$trans_date', '$trans_datetime', '$user_id','$user_name','$total_pair_point', '$total_bonus', 
						$_SESSION[user_id], NOW())
						";
				dbQuery($sql);
				$pairing_id = mysql_insert_id();
				
							
				
				$bonus_description = 'Pairing Bonus';
				$pair_bonus = $total_bonus;
				
				wallet('acct_ewallet', 3, $user_id, $bonus_description, $pair_bonus, 0, $user_name, $trans_datetime);
				
				$bonus_description = '10% into M-Wallet';
				$pair_bonus_deduct = 0.1 * $total_bonus;
				wallet('acct_ewallet', 3, $user_id, $bonus_description, 0, $pair_bonus_deduct, $user_name, $trans_datetime);
				wallet('acct_mwallet', 4, $user_id, $bonus_description, $pair_bonus_deduct, 0, $user_name, $trans_datetime);		
		
		}
		else // Flush
		{
				$total_bonus = 0;
				
				$sql = "INSERT INTO acct_point_pairing(pairing_date, pairing_datetime, user_id,user_name, pair_point, total_bonus,
						flush_sw, created_by, created_date)
						VALUES('$trans_date', '$trans_datetime', '$user_id','$user_name','$actual_pair_point', '$total_bonus', 
						1, $_SESSION[user_id], NOW())
						";
				dbQuery($sql);
				$pairing_id = mysql_insert_id();
		}		
	}
	

	

}

function insertProductSelect($user_id, $product_id, $quantity, $input_date, $new_register_sw, $input_datetime, $rWalletID, $remark)
{

	$sql = "INSERT INTO product_select(user_id, product_id, quantity, select_date, new_register_sw, select_datetime,
			rwallet_id, remark,
			created_by, created_date)
			VALUES('$user_id','$product_id','$quantity', '$input_date', $new_register_sw, '$input_datetime', 
			'$rWalletID', '$remark',
			$_SESSION[user_id], NOW())
			 ";
	dbQuery($sql);	
}
