<?php require_once('../Connections/mydbconn.php'); ?>
<?php
mysql_select_db($database_mydbconn, $mydbconn);
$query_RecordsetMessageTemplate = "select * from message_template";
$RecordsetMessageTemplate = mysql_query($query_RecordsetMessageTemplate, $mydbconn) or die(mysql_error());
$row_RecordsetMessageTemplate = mysql_fetch_assoc($RecordsetMessageTemplate);
$totalRows_RecordsetMessageTemplate = mysql_num_rows($RecordsetMessageTemplate);
?><?php 
require('info_inc.php');
require_once('../Connections/mydbconn.php');




?>


<?php include("../menu/menuxx.php"); ?>


<script type="text/javascript" src="ajax.js"></script>
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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <!--Table Layout-->
  <tr>
    <td height="22" colspan="4" valign="top"></td>
  </tr>
  <tr>
    <td width="15%" class="content_bg" height="269" valign="top"><br /><?php include("../menu/left_menuxx.php"); ?></td>
    <td width="5%" class="content_bg" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
    <td width="75%" valign="top"><table width="100%" class="content_bg">
      <tr>
        <td class="nav_path" height="30">&nbsp;</td>
      </tr>
      <tr>
        <td><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
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
                          <td colspan="4" align="right"><div id="txtMessage" align="center" class="form_validation_field_error_error_message">                      		<?php
						  	include('../function/system_message.php'); 
						    ?></div></td>
                        </tr>
                        <tr>
                          <td colspan="4" class=""></td>
                        </tr>
                        <tr class="formblock_row2 " id="viewrow1">
                          <td class="form_txt" align="right">To : </td>
                          <td align="left"><input name="send_to" type="text" id="send_to" value="<?php echo $row_RecordsetMain['email']; if($totalRows_RecordsetEmailAll>0 and $group_mail==1) { do { echo ","; echo $row_RecordsetEmailAll['email'];
						  
						  }
						  while($row_RecordsetEmailAll = mysql_fetch_assoc($RecordsetEmailAll)); }?>" size="80" /></td>
                          <td align="right" class="form_txt">&nbsp;</td>
                          <td align="left">&nbsp;</td>
                        </tr>
                        <tr class="formblock_row2 " id="viewrow1">
                          <td class="form_txt" align="right">Subject : </td>
                          <td align="left"><input name="subject" type="text" id="subject" size="50" /></td>
                          <td align="right" class="form_txt">&nbsp;</td>
                          <td align="left">&nbsp;</td>
                        </tr>
                        <tr class="formblock_row2 " id="viewrow1">
                          <td class="form_txt" align="right">Template : </td>
                          <td align="left"><select name="message_id" id="message_id" onchange="getMessage(this)">
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
                          <td align="right" class="form_txt">&nbsp;</td>
                          <td align="left">&nbsp;</td>
                        </tr>
                        <tr class="formblock_row2" id="viewrow2">
                          <td width="15%" align="right" valign="top" class="form_txt">Message :</td>
                          <td width="61%" align="left"><textarea name="message" cols="70" rows="10"  id="message"></textarea></td>
                          <td width="13%" align="right" class="form_txt">&nbsp;</td>
                          <td width="11%" align="left">&nbsp;</td>
                        </tr>
                      </tbody>
                  </table></td>
                </tr>
                <tr>
                  <td class="formblock_bleft">&nbsp;</td>
                  <td class="formblock_bbg" align="center"><input name="btn_insert" type="hidden" id="btn_insert" value="form1"/>
                    <input name="SubmitSend" type="submit" id="SubmitSend" value="Send Mail" /></td>
                  <td class="formblock_bright">&nbsp;</td>
                </tr>
              </tbody>
            </table>
        </form></td>
      </tr>
    </table></td>
    <td width="5%" class="content_bg" valign="top"><!--Table Layout-->&nbsp;</td>
  </tr>
  <tr>
    <td height="21" colspan="4" valign="top"><!--Table Layout-->&nbsp;</td>
  </tr>
</table>
<?php
mysql_free_result($RecordsetMessageTemplate);
?>
