<?php
require_once('../Connections/mydbconn.php');
require("../email/class.phpmailer.php");
			
function sendEmail($sent_to, $main_module, $sub, $id)
{

		
				
		//$sent_to = 'support@bizappsolution.com';
		//$subject = $_POST[subject];
		//$message = str_replace("\n","<br />",$_POST['message']);
		//$sent_to = 'yapcheeyen@gmail.com';



		//mysql_select_db($database_mydbconn, $mydbconn);
		$query_RecordsetSetting = "Select * FROM system_setting WHERE setting_id = 1";
		$RecordsetSetting = mysql_query($query_RecordsetSetting) or die(mysql_error());
		$row_RecordsetSetting = mysql_fetch_assoc($RecordsetSetting);
		$totalRows_RecordsetSetting = mysql_num_rows($RecordsetSetting);
	
		$host_name = $row_RecordsetSetting['host_name'];
		$host_user_name = $row_RecordsetSetting['host_user_name'];
		$host_password = $row_RecordsetSetting['host_password'];
		$host_mail_from = $row_RecordsetSetting['host_mail_from'];
		$host_mail_from_name = $row_RecordsetSetting['host_mail_from_name'];
		$host_port = $row_RecordsetSetting['host_port'];
		$notify_send_to = $row_RecordsetSetting['notify_send_to'];		
		$market_approve_message = $row_RecordsetSetting['market_approve_message'];
		$market_reject_message = $row_RecordsetSetting['market_reject_message'];
		
  
		if($host_name!="")
		{
			

				
				if($sent_to != '')
				{														
							if($main_module == 'market')
							{
								$query_RecordsetGET = "Select * FROM market WHERE market_id = $id";
								$RecordsetGET = mysql_query($query_RecordsetGET) or die(mysql_error());
								$row_RecordsetGET = mysql_fetch_assoc($RecordsetGET);
								//$totalRows_RecordsetGET = mysql_num_rows($RecordsetGET);
								$market_title = $row_RecordsetGET['market_title'];
								$price_range = $row_RecordsetGET['price_range'];
								
								if($sub == 'approve')
								{
									$subject = 'Ads Approved';
									$message_original = $market_approve_message;								
								}
								
								if($sub == 'reject')
								{
									$subject = 'Ads Rejected';
									$message_original = $market_reject_message;								
								}


											$message = $message_original . 
																					"
																					<br /><br /> <br /><table>
											<tr>
												<td>Ads Information </td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>Title</td>
												<td>: " . $market_title. "</td>
											</tr>
											<tr>
												<td>Price Range </td>
												<td>: " . $price_range . "</td>
											</tr>
										
										</table>";	
																		
						
							}
							
															

							$mail = new PHPMailer();
							
							
							$mail->IsSMTP();                                      // set mailer to use SMTP
							$mail->Host = $host_name;  // specify main and backup server
							$mail->SMTPAuth = true;     // turn on SMTP authentication
							$mail->Username = $host_user_name;  // SMTP username
							$mail->Password = $host_password; // SMTP password
							$mail->Port = $host_port;
							
							$mail->From = $host_mail_from;
							$mail->FromName = $host_mail_from_name;
							
							$sent_to = $sent_to;	
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
							
							$mail->Body    = $htmlmessage;		
							
							//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
							
							if(!$mail->Send())
							{
								 echo "Message could not be sent. <p>";
								 echo "Mailer Error: " . $mail->ErrorInfo;
								 exit;
							}
							
							//return true;
				
				}				
		


	
		}
		else
		{

		}
		
}



?>
