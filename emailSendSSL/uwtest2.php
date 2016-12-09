<?php
include "../inc/pdoconfig.php";
include "../main/pdofunctions.php";
//include "../main/session.php";
include "../main/functions.php";

require 'PHPMailerAutoload.php';

echo autoSendEmail();	
echo 'Done';

function getSystemSetting($id){
	
	if ($id != ''){
    	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM system_setting where setting_id = 1";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
  
  		 
		
		return $data;
		
	}
}

function autoSendEmailToAll() 
{
	
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM email where send_sw = 0 and email_mass_sw = 1";
        $q = $pdo->prepare($sql);
        $q->execute();
        //$data = $q->fetch(PDO::FETCH_ASSOC);
						        
  		while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
			

			$sql = "SELECT * FROM user where email <>''";
			$q2 = $pdo->prepare($sql);
			$q2->execute();	
			
			while ($row2 = $q2->fetch(PDO::FETCH_ASSOC)) {
				
				sendEmail($row2[email], $row['email_subject'], $row['email_message'], $row['attachment_path']);
				updateSendEmail($row[email_id], 1); 				
			}
				    	
		
		}
		
		Database::disconnect();
				
}

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
			
			
			
			sendEmail($row[email], $row['email_subject'], $row['email_message'], $row['attachment_path'], $row['user_temp_password'], $row['user_name']);
			updateSendEmail($row[email_id], 1);    	
		
		}
		
		Database::disconnect();
				
}
			
function sendEmail($email, $subject, $message, $attachment_path, $user_temp_password, $user_name) {
	
	if($user_temp_password !='')
	{
		$message = $message . '<br>' . 'Username : ' . $user_name . '<br>' . 'Password : ' . $user_temp_password;
	}

	$mail = new PHPMailer;
	
	//$mail->SMTPDebug = 3;  
	//$data = getSystemSetting (1); 
	                      // Enable verbose debug output


	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'dime84.dizinc.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'noreply@uwontech.com';                 // SMTP username
	$mail->Password = 'uwonnoreply123';                           // SMTP password
	$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;  
		
	$mail->setFrom('info@uwontech.com', 'Mailer');
	$mail->addAddress($email, 'System Test');     // Add a recipient
	$mail->addAddress('');               // Name is optional
	$mail->addReplyTo('cyyap@uwontech.com', 'Information');
	$mail->addCC('');
	$mail->addBCC('');
	
	//$mail->addAttachment('');         // Add attachments
	if($attachment_path <> '') {
		$attachment_path = '../upload_glsb/' . $attachment_path;
		$mail->addAttachment($attachment_path);         // Add attachments
		$mail->addAttachment('');    // Optional name		
	}
	

	$mail->isHTML(true);                                  // Set email format to HTML
	
	$mail->Subject = $subject;
	//$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	$mail->Body    = $message;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
	if(!$mail->send()) {
		//echo 'Message could not be sent.';
		//echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		//echo 'Message has been sent';
	}
	
	
}