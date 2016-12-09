<?php include("../menu/menu.php"); ?>
<?php require_once('../Connections/mydbconn.php'); ?>
<?php
mysql_select_db($database_mydbconn, $mydbconn);
$query_RecordsetSorderType = "select * from sorder_type group by major_type_id";
$RecordsetSorderType = mysql_query($query_RecordsetSorderType, $mydbconn) or die(mysql_error());
$row_RecordsetSorderType = mysql_fetch_assoc($RecordsetSorderType);
$totalRows_RecordsetSorderType = mysql_num_rows($RecordsetSorderType);
?>
<?php include ('../function/config.php'); ?>
<?php

	

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formSelect")) {

	$myhost = $row_RecordsetSystem['host'];
	$reportname = $_POST["report_name"];
	$reportname2 = $_POST["report_name2"];
	$myalias = $row_RecordsetSystem['alias'];
	$date_from = $_POST["date_from"];
	$date_to = $_POST["date_to"];
	
	$major_type_id = $_POST["major_type_id"];
	$monthly_sw = $_POST["monthly_sw"];

		//foreach($_POST['checkbox'] as $v) 
	//{
	if (isset($_POST['Submit1'])) 
	{	
		$insertGoTo = "http://$myhost/cgi-bin/repwebserver.dll/execute.pdf?reportname=\\commission/cash_back&aliasname=$myalias&username=admin&password=&ParamDate_from=$date_from&ParamDate_To=$date_to&ParamMajor_type_id=$major_type_id&ParamMonthly_sw=$monthly_sw" ;
		if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		
		}
		header(sprintf("Location: %s", $insertGoTo));
	
	}	
	


		
}


?>


<link rel="stylesheet" type="text/css" href="../css/fancybuild.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="../function/date/calendar/calendar.css" media="screen"></LINK>
	<SCRIPT type="text/javascript" src="../function/date/calendar/calendar.js"></script>


<body>
<br>
<table width="900" align="center" class="a_lineall">
  <tr>
    <td class="a_Query_Title">Bonus Report  </td>
  </tr>
  <tr>
    <td><form id="formSelect" name="formSelect" target="_blank" method="post" action="">
      <br />
      <p>&nbsp;</p>
      <table width="692" border="0" align="center">
        <tr class="a_fonts12bold">
          <td width="183">&nbsp;</td>
          <td width="183">&nbsp;</td>
          <td width="236">&nbsp;</td>
          <td width="72">&nbsp;</td>
        </tr>
        <tr>
          <td>Date</td>
          <td><input name="date_from" type="text" id="date_from" value="<?php echo date("Y-m-01"); ?>" size="12">
            <span class="a_fonts9">
            <input name="button22232" type="button" onClick="displayCalendar(document.forms[0].date_from,'yyyy-mm-dd',this,false)" value="Cal" />
            </span></td>
          <td><input name="date_to" type="text" id="date_to" value="<?php echo date("Y-m-d"); ?>" size="12">
            <span class="a_fonts9">
            <input name="button222322" type="button" onClick="displayCalendar(document.forms[0].date_to,'yyyy-mm-dd',this,false)" value="Cal" />
            </span></td>
          <td><input name="Submit1" type="submit" id="Submit1" value="Preview" /></td>
        </tr>
        <tr>
          <td>Program</td>
          <td><select name="major_type_id" class="form_txtbox_short" id="major_type_id">
            <?php
do {  
?>
            <option value="<?php echo $row_RecordsetSorderType['major_type_id']?>"><?php echo $row_RecordsetSorderType['short_name']?></option>
            <?php
} while ($row_RecordsetSorderType = mysql_fetch_assoc($RecordsetSorderType));
  $rows = mysql_num_rows($RecordsetSorderType);
  if($rows > 0) {
      mysql_data_seek($RecordsetSorderType, 0);
	  $row_RecordsetSorderType = mysql_fetch_assoc($RecordsetSorderType);
  }
?>
          </select></td>
          <td>&nbsp;</td>
          <td><input name="MM_insert" type="hidden" id="MM_insert" value="formSelect"></td>
        </tr>
        <tr>
          <td>Payment Status </td>
          <td><select name="status_id" id="status_id">
            <option value="2" <?php if (!(strcmp(2, 2))) {echo "selected=\"selected\"";} ?>>All</option>
            <option value="1" <?php if (!(strcmp(1, 2))) {echo "selected=\"selected\"";} ?>>Paid</option>
            <option value="0" <?php if (!(strcmp(0, 2))) {echo "selected=\"selected\"";} ?>>Unpaid</option>
          </select></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>No of Bonus </td>
          <td><select name="monthly_sw" id="monthly_sw">
            <option value="0" <?php if (!(strcmp(0, 0))) {echo "selected=\"selected\"";} ?>>1st</option>
            <option value="1" <?php if (!(strcmp(1, 0))) {echo "selected=\"selected\"";} ?>>Monthly</option>
          </select></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <p>&nbsp;</p>
    </form></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html><?php
mysql_free_result($RecordsetSorderType);

mysql_free_result($RecordsetReport);

mysql_free_result($RecordsetReportBranch);

mysql_free_result($RecordsetEmployee);
?>
