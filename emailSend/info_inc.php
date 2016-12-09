<?php 
require_once('../Connections/mydbconn.php');
$mode = $_GET['mode'];


if($mode == 'add')
{
	
}


if($mode == 'edit')
{

	$module = $_GET['module'];
	$main_id = $_GET['main_id'];
	$group_mail = $_GET['group_mail'];
	$default_template = $_GET['default_template'];
	$get_subject = $_GET['get_subject'];
	$mailing_list_sw = $_GET['mailing_list_sw'];
	$thread_sw = $_GET['thread_sw'];
	

	
	if($module == 'fault_report')
	{
		$main_field = 'fault_id';
	
		if($group_mail == 1) 
		{
			mysql_select_db($database_mydbconn, $mydbconn);
			$query_RecordsetMain = "SELECT *, fault_report.created_by as main_user FROM fault_report left join user on fault_report.created_by = user.user_id where fault_report.fault_id = $main_id";
			$RecordsetMain = mysql_query($query_RecordsetMain, $mydbconn) or die(mysql_error());
			$row_RecordsetMain = mysql_fetch_assoc($RecordsetMain);
			$totalRows_RecordsetMain = mysql_num_rows($RecordsetMain);
			
			$fault_main_user_id = $row_RecordsetMain['main_user'];

		
			//$query_RecordsetEmailAll = "SELECT distinct(user.user_id), email FROM fault_report_detail left join user on fault_report_detail.created_by = user.user_id where fault_report_detail.fault_id = $main_id and fault_report_detail.created_by <> $fault_main_user_id group by user.user_id";
$query_RecordsetEmailAll = "SELECT distinct(user.user_id), email FROM fault_report_detail left join user on fault_report_detail.created_by = user.user_id where fault_report_detail.fault_id = $main_id and fault_report_detail.created_by <> $fault_main_user_id group by user.user_id";			
			$RecordsetEmailAll = mysql_query($query_RecordsetEmailAll, $mydbconn) or die(mysql_error());
			$row_RecordsetEmailAll = mysql_fetch_assoc($RecordsetEmailAll);
			$totalRows_RecordsetEmailAll = mysql_num_rows($RecordsetEmailAll);			
		}
		
		else
		{
			
			if($thread_sw ==1)
			{
				mysql_select_db($database_mydbconn, $mydbconn);
				$query_RecordsetMain = "SELECT *, fault_report.created_by as main_user FROM fault_report left join user on fault_report.created_by = user.user_id where fault_report.fault_id = $main_id";
				$RecordsetMain = mysql_query($query_RecordsetMain, $mydbconn) or die(mysql_error());
				$row_RecordsetMain = mysql_fetch_assoc($RecordsetMain);
				$totalRows_RecordsetMain = mysql_num_rows($RecordsetMain);					
			}
			else
			{
				mysql_select_db($database_mydbconn, $mydbconn);
				$query_RecordsetMain = "SELECT *, fault_report_detail.created_by as main_user FROM fault_report_detail left join user on fault_report_detail.created_by = user.user_id where fault_report_detail.fault_report_detail_id = $main_id";
				$RecordsetMain = mysql_query($query_RecordsetMain, $mydbconn) or die(mysql_error());
				$row_RecordsetMain = mysql_fetch_assoc($RecordsetMain);
				$totalRows_RecordsetMain = mysql_num_rows($RecordsetMain);				
			}
			

		}
		

	}
	
	if($module == 'cancel_booking')
	{
		//$main_field = 'facility_id';
		$cancel_start_date = $_GET['cancel_start_date'];
		$cancel_end_date = $_GET['cancel_end_date'];
	
		if($group_mail == 1) //by facility group
		{			
		
			$query_RecordsetEmailAll = "SELECT distinct(user.user_id), email FROM booking inner join facility on booking.facility_id = facility.facility_id inner join facility_group on facility_group.facility_group_id = facility.facility_group_id inner join user on booking.user_id = user.user_id where facility_group.facility_group_id = '".$main_id."' and FROM_UNIXTIME(booking_date) between '$cancel_start_date' and '$cancel_end_date' ";
			$RecordsetEmailAll = mysql_query($query_RecordsetEmailAll, $mydbconn) or die(mysql_error());
			$row_RecordsetEmailAll = mysql_fetch_assoc($RecordsetEmailAll);
			$totalRows_RecordsetEmailAll = mysql_num_rows($RecordsetEmailAll);			
		}
		
		else  //by facility
		{
			
			$query_RecordsetEmailAll = "SELECT distinct(user.user_id), email FROM booking inner join user on booking.user_id = user.user_id where booking.facility_id = '".$main_id."' and FROM_UNIXTIME(booking_date) between '$cancel_start_date' and '$cancel_end_date' ";
			$RecordsetEmailAll = mysql_query($query_RecordsetEmailAll, $mydbconn) or die(mysql_error());
			$row_RecordsetEmailAll = mysql_fetch_assoc($RecordsetEmailAll);
			$totalRows_RecordsetEmailAll = mysql_num_rows($RecordsetEmailAll);			

		}
		

	}
	
	
	

	
	if($default_template==1)
	{
		$query_RecordsetMessageTemplateDefault = "SELECT * from system_setting where setting_id =1";
		$RecordsetMessageTemplateDefault = mysql_query($query_RecordsetMessageTemplateDefault, $mydbconn) or die(mysql_error());
		$row_RecordsetMessageTemplateDefault = mysql_fetch_assoc($RecordsetMessageTemplateDefault);
		$totalRows_RecordsetMessageTemplateDefault = mysql_num_rows($RecordsetMessageTemplateDefault);
		
		if($get_subject == "Fault Report Annoucement")
		{
			$message_display = $row_RecordsetMessageTemplateDefault['fault_report_annoucement'];
			
		}

		if($get_subject == "Fault Report Warning")
		{
			$message_display = $row_RecordsetMessageTemplateDefault['fault_report_warning'];
			
		}	
		
		if($get_subject == "Cancelled Booking")
		{
			$message_display = $row_RecordsetMessageTemplateDefault['cancel_existing_booking_message'];
			
		}			

		if($get_subject == "Event")
		{
			$message_display = $row_RecordsetMessageTemplateDefault['header_for_news_event'];
			
		}		
	}

		$query_RecordsetMessageTemplate = "SELECT * from message_template";
		$RecordsetMessageTemplate = mysql_query($query_RecordsetMessageTemplate, $mydbconn) or die(mysql_error());
		$row_RecordsetMessageTemplate = mysql_fetch_assoc($RecordsetMessageTemplate);
		$totalRows_RecordsetMessageTemplate = mysql_num_rows($RecordsetMessageTemplate);		
}

if ((isset($_POST["btn_insert"])) && ($_POST["btn_insert"] == "form1")) {

	
	include ("../function/get_string_value.php");	


	if (isset($_POST['SubmitSend']) and $_GET['mode']=='edit') 
	{		
		if($mailing_list_sw ==1)
		{
			$mailing_list_id = $_POST['mailing_list_id'];
			
			mysql_select_db($database_mydbconn, $mydbconn);
			$query_RecordsetMailingList = "select * from mailing_list where mailing_list_id = $mailing_list_id";
			$RecordsetMailingList = mysql_query($query_RecordsetMailingList, $mydbconn) or die(mysql_error());
			$row_RecordsetMailingList = mysql_fetch_assoc($RecordsetMailingList);
			$totalRows_RecordsetMailingList = mysql_num_rows($RecordsetMailingList);
			
			$sent_to = $row_RecordsetMailingList['email_list'];
		
		}
		else
		{
			$sent_to = $_POST['send_to'];
		}
		
		
		$subject = $_POST['subject'];
		//$message = $_POST['message'];
		$message = str_replace("\n","<br />",$_POST['message']);

		$attachment_file = $_POST['attachment_file'];
		
		$i = 1;
		//include ("send.php");
		include ("send_bcc.php");
		
		
		
		if ($totalRows_RecordsetEmailAll > 0 and $fault_group_mail ==1111111)
		{
			$i = 2;
			
			do
			{
				
				$sent_to = $row_RecordsetEmailAll['email'];
				//include ("send.php");
				include ("send_bcc.php");
				$i++;
			
			}
			while ($row_RecordsetEmailAll = mysql_fetch_assoc($RecordsetEmailAll));
		}
		
		
	}


}
?>


