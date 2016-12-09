<?php
require("class.phpmailer.php");
require_once('../Connections/mydbconn.php');

mysql_select_db($database_mydbconn, $mydbconn);
$query_RecordsetMailSetting = "SELECT * FROM system_setting WHERE setting_id = 1";
$RecordsetMailSetting = mysql_query($query_RecordsetMailSetting) or die(mysql_error());
$row_RecordsetMailSetting = mysql_fetch_assoc($RecordsetMailSetting);

$host_name = $row_RecordsetMailSetting['host_name'];
$host_user_name = $row_RecordsetMailSetting['host_user_name'];
$host_password = $row_RecordsetMailSetting['host_password'];
$host_mail_from = $row_RecordsetMailSetting['host_mail_from'];
$host_mail_from_name = $row_RecordsetMailSetting['host_mail_from_name'];
$host_port = $row_RecordsetMailSetting['host_port'];
$notify_send_to = $row_RecordsetMailSetting['notify_send_to'];

		include ("../function/seq_id.php");
		
		$result  = 'update seq_id set email_id= "'.$email_id_next.'" WHERE seq_id=1';
		$Resulttable = mysql_query($result) or die(mysql_error());	
		
	/**	$insertSQL = sprintf("INSERT INTO email (email_id, email_subject,email_message, created_by, created_date) VALUES (%s, %s,%s,%s,%s)",
						GetSQLValueString($email_id_seq, "int"),
						GetSQLValueString($subject, "text"),
						GetSQLValueString($message, "text"),
						GetSQLValueString($login_id, "int"),
						GetSQLValueString($today, "date"));
			**/

		$insertSQL ="INSERT INTO email (email_id, email_subject,email_message, created_by, created_date)
              VALUES($email_id_seq, '$subject', '$message', $login_id, '$today')";
			
		$Result1 = mysql_query($insertSQL) or die(mysql_error());	

		
		if (!empty($_FILES['attachment_path']['name'])) 
		{
			$upload_image_sw = 0;
			$table_name = "email";
			$table_id = "email_id";
			$table_id_value = $email_id_seq;
			require ("../function/upload_update.php");
		}

		mysql_select_db($database_mydbconn, $mydbconn);
		$query_RecordsetAttachment = "SELECT attachment_path FROM email WHERE email_id = $email_id_seq";
		$RecordsetAttachment = mysql_query($query_RecordsetAttachment) or die(mysql_error());
		$row_RecordsetAttachment = mysql_fetch_assoc($RecordsetAttachment);
		
		$attachment_path = "../upload_files/email/" . $row_RecordsetAttachment['attachment_path'];

	
$mail = new PHPMailer();


$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = $host_name;  // specify main and backup server
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = $host_user_name;  // SMTP username
$mail->Password = $host_password; // SMTP password
$mail->Port = $host_port;

$mail->From = $host_mail_from;
$mail->FromName = $host_mail_from_name;

//
$mail->AddAttachment($attachment_path);

$emails = $sent_to;

$emails = explode(',', $emails);
$emails = array_map('trim', $emails);

//add To
$mail->AddAddress($host_mail_from);

foreach ($emails as $email){
    //$mail->AddAddress($email);
		//change all To bcc as well 
		$mail->AddBCC($email);
}


$emails_cc = $notify_send_to;
		
$emails_cc = explode(',', $emails_cc);
$emails_cc = array_map('trim', $emails_cc);
		
foreach ($emails_cc as $email_cc){
		$mail->AddBCC($email_cc);
}		

//$mail->AddAddress($sent_to);
//$mail->AddAddress("cyyap@efreightech.com");                  // name is optional
$mail->AddReplyTo($host_mail_from, "Information");

$mail->WordWrap = 50;                                 // set word wrap to 50 characters
//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name

//$mail->AddAttachment($attachment_path);

         // add attachments
$mail->IsHTML(true);                                  // set email format to HTML

$mail->Subject = $subject;
//$mail->Body    = $message;


  // set the required font and size for html-mails
  $htmlfont = "<font face=\"Calibri\" size=\"2\">";
  
  // preformat the html-message
  $htmlmessage = $htmlfont.$message."</font>";
	
	$mail->Body    = $htmlmessage;


//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}


header("location: ../main/index.php?page=main&sub=main");
//echo "Message has been sent";
?>