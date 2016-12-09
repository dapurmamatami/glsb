<?php
require("class.phpmailer.php");
include "../inc/pdoconfig.php";
include "../main/pdofunctions.php";



echo autoSendEmail();	
echo 'Done';		

function updateSendEmail($email_id, $send_sw) 
{
			//update database
			$pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE email set send_sw = :send_sw, send_date = NOW() WHERE email_id = :email_id";
            $q = $pdo->prepare($sql);
			$q->bindValue(':email_id', $email_id);
			$q->bindValue(':send_sw', $send_sw);
			$update = $q->execute();
            
            Database::disconnect();
}


function autoSendEmail() 
{
	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM email inner join user on email.user_id = user.user_id where send_sw = 0 and mass_email_sw = 0 and email <>''";
        $q = $pdo->prepare($sql);
        $q->execute();
        //$data = $q->fetch(PDO::FETCH_ASSOC);
						        
  		while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
			
			
			$message = $row[email_message];
			$message_footer = $row[email_message_footer];
			
			//$message_original = str_replace("\r\n","<br />",$message);	
			//$message_original = mysql_real_escape_string($message_original);		
			$message_original = str_replace("\n","<br />",$message);	
			$message_footer_original = str_replace("\n","<br />",$message_footer);
			
			sendEmail($row[email], $row['email_subject'], $message_original, $row['attachment_path'], $row['user_temp_password'], 
					$row['user_name'], $row['name'], $message_footer_original);
					
			updateSendEmail($row[email_id], 1);    	
		
		}
		
		Database::disconnect();
				
}
			
function sendEmail($email, $subject, $message, $attachment_path, $user_temp_password, $user_name, $name, $message_footer_original) {
	
	
		//$data2 = getSystemSetting(1); 
		$mail = new PHPMailer();
		
		
		
		//$message = "Testing Only";
		
		$mail->IsSMTP();                                      // set mailer to use SMTP
		$mail->Host = '110.4.45.39';  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = 'admin@golestary.com.my';  // SMTP username
		$mail->Password = 'GLSBpass123'; // SMTP password
		$mail->Port = '587';
		
		$mail->From = 'admin@golestary.com.my';
		$mail->FromName = 'GLSB';
		
		$emails = $email;
		
		$emails = explode(',', $emails);
		$emails = array_map('trim', $emails);
		
		foreach ($emails as $email){
				$mail->AddAddress($email);
		}


		$emails_cc = 'yapcheeyen@gmail.com';
		
		$emails_cc = explode(',', $emails_cc);
		$emails_cc = array_map('trim', $emails_cc);
		
		foreach ($emails_cc as $email_cc){
				$mail->AddBCC($email_cc);
		}		
		
		//$mail->AddAddress($sent_to);
		//$mail->AddAddress("cyyap@efreightech.com");                  // name is optional
		$mail->AddReplyTo('admin@golestary.com.my', "Information");
		
		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
		//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    // optional name
		
		//$mail->AddAttachment($attachment_path);
		
						 // add attachments
		$mail->IsHTML(true);                                  // set email format to HTML
		
		$mail->Subject = $subject;
		//$mail->Body    = $message;
		

		// set the required font and size for html-mails
		//$htmlfont = "<font face=\"Calibri\" size=\"3\">";
		$htmlfont = "<span style='size=\"3\"; FONT-FAMILY: Calibri'>";
		
		// preformat the html-message
		$htmlmessage = $htmlfont.$message."</span>";
		
		$htmlmessage = str_replace("\\","",$htmlmessage);
		$mail->Body    = $htmlmessage;		
		
		//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
		
		if(!$mail->Send())
		{
			 echo "Message could not be sent. <p>";
			 echo "Mailer Error: " . $mail->ErrorInfo;
			 exit;
		}
	
}		
?>