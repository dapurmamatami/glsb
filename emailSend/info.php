<?php require_once('../Connections/mydbconn.php'); ?>
<?php require_once('../Connections/mydbconn.php'); ?>
<?php
$calendar_sw =1; 
mysql_select_db($database_mydbconn, $mydbconn);
$query_RecordsetMessageTemplate = "select * from message_template";
$RecordsetMessageTemplate = mysql_query($query_RecordsetMessageTemplate, $mydbconn) or die(mysql_error());
$row_RecordsetMessageTemplate = mysql_fetch_assoc($RecordsetMessageTemplate);
$totalRows_RecordsetMessageTemplate = mysql_num_rows($RecordsetMessageTemplate);

mysql_select_db($database_mydbconn, $mydbconn);
$query_RecordsetMailingList = "select * from mailing_list";
$RecordsetMailingList = mysql_query($query_RecordsetMailingList, $mydbconn) or die(mysql_error());
$row_RecordsetMailingList = mysql_fetch_assoc($RecordsetMailingList);
$totalRows_RecordsetMailingList = mysql_num_rows($RecordsetMailingList);
?><?php 
require('info_inc.php');

?>

<?php

require_once('../Connections/mydbconn.php');
// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make unified connection variable
$conn_mydbconn = new KT_connection($mydbconn, $database_mydbconn);

//Start log out user
  $logout = new tNG_Logout();
  $logout->setLogoutType("link");
  $logout->Execute();
//End log out user

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_mydbconn, "../");
//Grand Levels: Any
$restrict->Execute();
//End Restrict Access To Page

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_mydbconn, "../");
//Grand Levels: Any
$restrict->Execute();
//End Restrict Access To Page

$login_id = $_SESSION['kt_login_id'];

// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_mydbconn = new KT_connection($mydbconn, $database_mydbconn);

	
// Start trigger
$formValidation = new tNG_FormValidation();


$formValidation->addField("mailing_list_id", true, "int", "", "", "", "");
$formValidation->addField("email_message", true, "text", "", "", "", "");
$formValidation->addField("send_to", true, "text", "", "", "", "");
$formValidation->addField("subject", true, "text", "", "", "", "");





$tNGs->prepareValidation($formValidation);
// End trigger
?>
<?php 
require('../user/user_inc.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Email</title>
<style type="text/css">
body{
	background-repeat:no-repeat;
	font-family: Trebuchet MS, Lucida Sans Unicode, Arial, sans-serif;
	height:100%;
	background-color: #FFF;
	margin:0px;
	padding:0px;
}
select{
	width:150px;
}
</style>
<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript" src="caljavascript.js.php"></script>
<script type="text/javascript" src="../js/functions_inc.js"></script>
<script type="text/javascript">





var ajax = new sack();


	var currentClientID=false;
	function getMessage()
	{
		var message_id = document.getElementById('message_id').value.replace(/[^0-9]/g,'');
		//if(clientId.length==1 && clientId!=currentClientID){
			currentClientID = message_id
			ajax.requestFile = 'getMessage.php?message_id='+message_id;	// Specifying which file to get
			//ajax.requestFile = 'getClient.php?getClientId='+clientId;	
			ajax.onCompletion = createMessage;	// Specify function that will be executed after file has been found
			ajax.runAJAX();		// Execute AJAX function			
		//}
		
	}

function createMessage()
{
		var formObj = document.forms['form1'];	
		eval(ajax.response);
	
	
}

	
	
	function initFormEvents()
	{
		document.getElementById('message_id').onblur = getMessage;

	}
	

	window.onload = initFormEvents;


</script>
<link rel="stylesheet" type="text/css" href="../css/fancybuild.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="../function/date/calendar/calendar.css" media="screen"></LINK>
	<link rel="stylesheet" href="../css/query_list.css" />
	<script type="text/javascript" src="../js/query_list/script.js"></script>
	<script type="text/javascript" src="../js/query_list/packed.js"></script>
	<SCRIPT type="text/javascript" src="../function/date/calendar/calendar.js"></script>

<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>


<script type="text/javascript">
var ray={
ajax:function(st)
	{
		this.show('load');
	},
show:function(el)
	{
		this.getID(el).style.display='';
	},
getID:function(el)
	{
		return document.getElementById(el);
	}
}
</script>
<style type="text/css">
#load{
position:absolute;
z-index:1;
border:3px double #999;
background:#f7f7f7;
/*background:url(../image/Wait.gif)no-repeat;*/
width:650px;
height:400px;
margin-top:-150px;
margin-left:-150px;
top:40%;
left:40%;
text-align:center;
line-height:300px;
font-family:"Trebuchet MS", verdana, arial,tahoma;
font-size:18pt;
}
</style>
<div id="load" style="display:none;">Sending Email... Please wait</div>
	
<?php echo $tNGs->displayValidationRules();?>
</head>
<body>
<table class="main_table" width="1200" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
    <tr>
      <td width="1200" height="372" valign="top">
          <div align="center">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <!--Table Layout-->
              <tr>
                <td height="22" colspan="3" valign="top"></td>
              </tr>
              <tr>
                <td width="15%" height="269" valign="top" class=""><!--DWLayoutEmptyCell-->&nbsp;</td>
<td width="70%" valign="top"><br />
                  <br />
                  <table width="100%" height="40" border="0" align="center" >
                      <tr>
                        <td height="36" class="a_Query">Email</td>
                      </tr>
                  </table>
				  <?php if($admin_view_sw==1) { ?>
                  <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return ray.ajax()">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                        <tr>
                          <td class="formblock_tleft" >&nbsp;</td>
                          <td class="formblock_tbg" >Send Mail </td>
                          <td class="formblock_tright" >&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="3" class="formblock_content"></td>
                        </tr>
                        <tr>
                          <td colspan="3" class="formblock_content"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                              <tbody>
                                <tr class="formblock_row1">
                                  <td colspan="3" align="right"><div id="txtMessage" align="center" class="form_validation_field_error_error_message">
                                      <?php
						  	include('../function/system_message.php'); 
						    ?>
                                  </div></td>
                                </tr>
                                <tr>
                                  <td colspan="3" class=""></td>
                                </tr>
								<?php if($mailing_list_sw == 0) { ?>
                                <tr class="formblock_row2 " id="viewrow1">
                                  <td class="form_txt" align="right">&nbsp;</td>
                                  <td class="form_txt" align="right"><div align="left">To : </div></td>
                                  <td align="left"><input name="send_to" type="text" class="form_txtbox_long" id="send_to" value="<?php if($module == "fault_report") { 
							
							if($totalRows_RecordsetMain > 0)
							{
								$main_user_id = $row_RecordsetMain['main_user'];
								
								$query_RecordsetEmailProfileMain = "SELECT profile_email from user_profile where user_id=$main_user_id and profile_email is not NULL";
								$RecordsetEmailProfileMain = mysql_query($query_RecordsetEmailProfileMain, $mydbconn) or die(mysql_error());
								$row_RecordsetEmailProfileMain = mysql_fetch_assoc($RecordsetEmailProfileMain);
								$totalRows_RecordsetEmailProfileMain = mysql_num_rows($RecordsetEmailProfileMain);	
								
								$data_main_profile = array();		
								
								if($row_RecordsetMain['email'] != NULL)
								{
									echo $row_RecordsetMain['email'];								
								}
								
								
								if($totalRows_RecordsetEmailProfileMain > 0)
								{
									do
									{
										$data_main_profile[] = array($row_RecordsetEmailProfileMain['profile_email']);
									}
									while($row_RecordsetEmailProfileMain = mysql_fetch_assoc($RecordsetEmailProfileMain));
									
								
								}
								
								foreach($data_main_profile as $dmp)
								{
									$main_profile_email = implode(',', $dmp);
									echo ',';
									echo $main_profile_email;
								}										
													
							}
														
							
							
							if($totalRows_RecordsetEmailAll>0 and $group_mail==1) { 
							
							$data = array();
							
							do 
							{ 
							
								$user_id = $row_RecordsetEmailAll['user_id'];
								
								$query_RecordsetEmailProfile = "SELECT profile_email from user_profile where user_id=$user_id and profile_email is not NULL";
								$RecordsetEmailProfile = mysql_query($query_RecordsetEmailProfile, $mydbconn) or die(mysql_error());
								$row_RecordsetEmailProfile = mysql_fetch_assoc($RecordsetEmailProfile);
								$totalRows_RecordsetEmailProfile = mysql_num_rows($RecordsetEmailProfile);	
								
								if($row_RecordsetEmailAll['email'] != NULL)
								{
									$data[] = array($row_RecordsetEmailAll['email']);
								}								
								
								if($totalRows_RecordsetEmailProfile > 0)
								{
									$date_profile = array();
									
									do
									{
									
										if($row_RecordsetEmailProfile['profile_email'] != NULL)
										{
											$data_profile[] = array($row_RecordsetEmailProfile['profile_email']);
										}
								
									}
									while($row_RecordsetEmailProfile = mysql_fetch_assoc($RecordsetEmailProfile));
									

								
								}
															

							//echo ","; echo $row_RecordsetEmailAll['email'];
						  
						  }
						  while($row_RecordsetEmailAll = mysql_fetch_assoc($RecordsetEmailAll)); } } 

							foreach($data as $d)
							{
								$master_email = implode(',', $d);
								echo ',';
								echo $master_email;
							}
							
							foreach($data_profile as $dp)
							{
								$profile_email = implode(',', $dp);
								echo ',';
								echo $profile_email;
							}							

						  
						  if($module == "cancel_booking") {  do {  echo $row_RecordsetEmailAll['email'];
						  
						  }
						  while($row_RecordsetEmailAll = mysql_fetch_assoc($RecordsetEmailAll)); } ?>" /></td>
                                </tr>
								<?php } ?>
								<?php if($mailing_list_sw == 1) { ?>
                                <tr class="formblock_row2 " id="viewrow1">
                                  <td class="form_txt" align="right">&nbsp;</td>
                                  <td class="form_txt" align="right"><div align="left">Mailing List </div></td>
                                  <td align="left"><select name="mailing_list_id" class="form_combobox_small" id="mailing_list_id">
                                    <?php
do {  
?>
                                    <option value="<?php echo $row_RecordsetMailingList['mailing_list_id']?>"><?php echo $row_RecordsetMailingList['mailing_group_name']?></option>
                                    <?php
} while ($row_RecordsetMailingList = mysql_fetch_assoc($RecordsetMailingList));
  $rows = mysql_num_rows($RecordsetMailingList);
  if($rows > 0) {
      mysql_data_seek($RecordsetMailingList, 0);
	  $row_RecordsetMailingList = mysql_fetch_assoc($RecordsetMailingList);
  }
?>
                                  </select></td>
                                </tr>
								<?php } ?>
								<?php if($default_template <> 1) { ?>
                                <tr class="formblock_row2 " id="viewrow1">
                                  <td class="form_txt" align="right">&nbsp;</td>
                                  <td class="form_txt" align="right"><div align="left">Template : </div></td>
                                  <td align="left"><select name="message_id" class="form_combobox_small" id="message_id" onchange="getMessage(this)">
                                    <option value="0"></option>
                                    <?php
do {  
?>
                                    <option value="<?php echo $row_RecordsetMessageTemplate['message_id']?>"><?php echo $row_RecordsetMessageTemplate['message_subject']?></option>
                                    <?php
} while ($row_RecordsetMessageTemplate = mysql_fetch_assoc($RecordsetMessageTemplate));
  $rows = mysql_num_rows($RecordsetMessageTemplate);
  if($rows > 0) {
      mysql_data_seek($RecordsetMessageTemplate, 0);
	  $row_RecordsetMessageTemplate = mysql_fetch_assoc($RecordsetMessageTemplate);
  }
?>
                                  </select></td>
                                </tr>
								<?php } ?>
                                <tr class="formblock_row2 " id="viewrow1">
                                  <td class="form_txt" align="right">&nbsp;</td>
                                  <td class="form_txt" align="right"><div align="left">Subject : </div></td>
                                  <td align="left"><input name="subject" type="text" class="form_txtbox_long" id="subject" value="<?php echo $get_subject; ?>"/></td>
                                </tr>
                                <tr class="formblock_row2" id="viewrow2">
                                  <td align="right" valign="top" class="form_txt">&nbsp;</td>
                                  <td align="right" valign="top" class="form_txt"><div align="left">Attachement</div></td>
                                  <td align="left"><input name="attachment_path" type="file" id="attachment_path" size="68" onchange="CheckAttachment()" /></td>
                                </tr>
                                <tr class="formblock_row2" id="viewrow2">
                                  <td width="9%" align="right" valign="top" class="form_txt">&nbsp;</td>
                                  <td width="13%" align="right" valign="top" class="form_txt"><div align="left">Message :</div></td>
                                  <td width="78%" align="left"><textarea name="message" class="form_txtarea"  id="message"><?php  echo $message_display; ?></textarea></td>
                                </tr>
                              </tbody>
                          </table></td>
                        </tr>
                        <tr>
                          <td class="formblock_bleft">&nbsp;</td>
                          <td class="formblock_bbg" align="center"><input name="btn_insert" type="hidden" id="btn_insert" value="form1"/>
                              <input type="button" value="Back" onclick="history.go(-1);return false;" />
                          <input name="SubmitSend" type="submit" id="SubmitSend" value="Send Mail" /></td>
                          <td class="formblock_bright">&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>
          </form>        <?php } ?>        </td>
                <td width="15%" class="" valign="top"><!--Table Layout-->
                  &nbsp;</td>
              </tr>
              <tr>
                <td height="21" colspan="3" valign="top"><!--Table Layout-->
                  &nbsp;</td>
              </tr>
            </table>
          
        <p>&nbsp; </p></td>
    </tr>
    <tr>
      <td height="1" valign="middle" bgcolor="#CCCCCC"><div align="center"></div></td>
    </tr>
</body>
</html>	
