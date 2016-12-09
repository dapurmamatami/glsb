<?php require_once('../Connections/mydbconn.php'); ?>
<?php require_once('../Connections/mydbconn.php'); ?>
<?php include ('../function/config.php'); ?>
<?php

$iuser_RecordsetEmployee = "-1";
if (isset($_SESSION['kt_login_id'])) {
  $iuser_RecordsetEmployee = (get_magic_quotes_gpc()) ? $_SESSION['kt_login_id'] : addslashes($_SESSION['kt_login_id']);
}
mysql_select_db($database_mydbconn, $mydbconn);
$query_RecordsetEmployee = sprintf("select * from employee where user_id = '%s'", $iuser_RecordsetEmployee);
$RecordsetEmployee = mysql_query($query_RecordsetEmployee, $mydbconn) or die(mysql_error());
$row_RecordsetEmployee = mysql_fetch_assoc($RecordsetEmployee);
$totalRows_RecordsetEmployee = mysql_num_rows($RecordsetEmployee);

mysql_select_db($database_mydbconn, $mydbconn);
$query_RecordsetReport = "SELECT * FROM rpt_main WHERE rpt_category = 'item' and rpt_visible_sw = 1 and rpt_variable=0";
$RecordsetReport = mysql_query($query_RecordsetReport, $mydbconn) or die(mysql_error());
$row_RecordsetReport = mysql_fetch_assoc($RecordsetReport);
$totalRows_RecordsetReport = mysql_num_rows($RecordsetReport);

mysql_select_db($database_mydbconn, $mydbconn);
$query_RecordsetCustomer = "SELECT * FROM customer where type_id =1 ORDER BY customer_name";
$RecordsetCustomer = mysql_query($query_RecordsetCustomer, $mydbconn) or die(mysql_error());
$row_RecordsetCustomer = mysql_fetch_assoc($RecordsetCustomer);
$totalRows_RecordsetCustomer = mysql_num_rows($RecordsetCustomer);

mysql_select_db($database_mydbconn, $mydbconn);
$query_RecordsetItem = "select * from item order by item_name";
$RecordsetItem = mysql_query($query_RecordsetItem, $mydbconn) or die(mysql_error());
$row_RecordsetItem = mysql_fetch_assoc($RecordsetItem);
$totalRows_RecordsetItem = mysql_num_rows($RecordsetItem);

if ($row_RecordsetEmployee['branch_restricted_sw'] == 0)
{
mysql_select_db($database_mydbconn, $mydbconn);
$query_RecordsetBranch = "select * from company_branch";
$RecordsetBranch = mysql_query($query_RecordsetBranch, $mydbconn) or die(mysql_error());
$row_RecordsetBranch = mysql_fetch_assoc($RecordsetBranch);
$totalRows_RecordsetBranch = mysql_num_rows($RecordsetBranch);
}
else
{
$branch_id = $row_RecordsetEmployee['branch_id'];

mysql_select_db($database_mydbconn, $mydbconn);
$query_RecordsetBranch = "select * from company_branch where branch_id =$branch_id";
$RecordsetBranch = mysql_query($query_RecordsetBranch, $mydbconn) or die(mysql_error());
$row_RecordsetBranch = mysql_fetch_assoc($RecordsetBranch);
$totalRows_RecordsetBranch = mysql_num_rows($RecordsetBranch);


}

$iuser_RecordsetUserBranch = "-1";
if (isset($_SESSION['kt_login_id'])) {
  $iuser_RecordsetUserBranch = (get_magic_quotes_gpc()) ? $_SESSION['kt_login_id'] : addslashes($_SESSION['kt_login_id']);
}
mysql_select_db($database_mydbconn, $mydbconn);
$query_RecordsetUserBranch = sprintf("select branch_id as user_branch from employee where user_id = '%s'", $iuser_RecordsetUserBranch);
$RecordsetUserBranch = mysql_query($query_RecordsetUserBranch, $mydbconn) or die(mysql_error());
$row_RecordsetUserBranch = mysql_fetch_assoc($RecordsetUserBranch);
$totalRows_RecordsetUserBranch = mysql_num_rows($RecordsetUserBranch);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formSelect")) {


	$date_from = $_POST["date_from"];
	$date_to = $_POST["date_to"];
	$report_name = $_POST['report_name'];
	$branch_id = $_POST['branch_id'];
	
	// DB Connection here
	 header("location: excel_detail.php?date_from=$date_from&date_to=$date_to&report_name=$report_name&branch_id=$branch_id");

}

if ((isset($_POST["MM_insert2"])) && ($_POST["MM_insert2"] == "form2")) {

	$report_name = $_POST['report_name2'];
	$customer_id = $_POST['customer_id2'];
	
	// DB Connection here
	 header("location: excel_detail.php?report_name=$report_name&customer_id=$customer_id");

}
if ((isset($_POST["MM_insert3"])) && ($_POST["MM_insert3"] == "form3")) {

	$report_name = 6;
	$customer_id = $_POST['customer_id3'];
	$date_from = $_POST["date_from3"];
	$date_to = $_POST["date_to3"];
	
	// DB Connection here
	 header("location: excel_detail.php?report_name=$report_name&customer_id=$customer_id&$date_from&date_to=$date_to");

}
?>
<?php include("../menu/menu.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="../css/fancybuild.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="../function/date/calendar/calendar.css" media="screen"></LINK>
	<SCRIPT type="text/javascript" src="../function/date/calendar/calendar.js"></script>
</head>

<body>
<br>
<table width="785" align="center" class="box_table">
  <tr>
    <td class="a_Title_Report">Export to Excel  </td>
  </tr>
  <tr>
    <td><form action=""  method="post" name="formSelect" id="formSelect">
      <br />
      <table width="80%" border="0" align="center">
        <tr class="a_fonts12bold">
          <td>Select Report
            <input type="hidden" name="MM_insert" value="formSelect" /></td>
          <td>Branch</td>
          <td>Date From</td>
          <td>Date To</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><select name="report_name" id="report_name">
              <option value="1">AR Collection</option>
              <option value="2">AP Payment</option>
              <option value="3">Petty Cash</option>
          </select></td>
          <td><select name="branch_id" id="branch_id">
              <?php
do {  
?>
              <option value="<?php echo $row_RecordsetBranch['branch_id']?>"<?php if (!(strcmp($row_RecordsetBranch['branch_id'], $row_RecordsetUserBranch['user_branch']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RecordsetBranch['branch_name']?></option>
              <?php
} while ($row_RecordsetBranch = mysql_fetch_assoc($RecordsetBranch));
  $rows = mysql_num_rows($RecordsetBranch);
  if($rows > 0) {
      mysql_data_seek($RecordsetBranch, 0);
	  $row_RecordsetBranch = mysql_fetch_assoc($RecordsetBranch);
  }
?>
          </select></td>
          <td><input name="date_from" type="text" class="a_txtbox_main" id="date_from" value="<?php echo date("Y-m-01"); ?>" size="12" />
              <span class="a_fonts9">
              <input name="button" type="button" onclick="displayCalendar(document.forms[0].date_from,'yyyy-mm-dd',this,false)" value="Cal" />
            </span></td>
          <td><input name="date_to" type="text" class="a_txtbox_main" id="date_to" value="<?php echo date('Y-m-d') ; ?>" size="12" />
              <span class="a_fonts9">
              <input name="button2" type="button" onclick="displayCalendar(document.forms[0].date_to,'yyyy-mm-dd',this,false)" value="Cal" />
            </span></td>
          <td><input type="image" src="../image/excel_icon.jpg" name="image2" width="30" height="30" /></td>
        </tr>
      </table>
      <p>&nbsp;</p>
      </form></td>
  </tr>
  <tr>
    <td class="a_Title_Report">By Customer </td>
  </tr>
  <tr>
    <td><form id="form2" name="form2" method="post" action="">
      <table width="80%" border="1" align="center">
        <tr class="a_fonts12bold">
          <td width="27%">Select Report </td>
          <td width="65%">Customer</td>
          <td width="8%"><input type="hidden" name="MM_insert2" value="form2" /></td>
        </tr>
        <tr>
          <td><select name="report_name2" id="report_name2">
            <option value="4">Worker Data</option>
          </select>
          </td>
          <td><select name="customer_id2" class="a_DropDown" id="customer_id2">
            <option value=""></option>
            <?php
do {  
?>
            <option value="<?php echo $row_RecordsetCustomer['customer_id']?>"><?php echo $row_RecordsetCustomer['customer_name']?></option>
            <?php
} while ($row_RecordsetCustomer = mysql_fetch_assoc($RecordsetCustomer));
  $rows = mysql_num_rows($RecordsetCustomer);
  if($rows > 0) {
      mysql_data_seek($RecordsetCustomer, 0);
	  $row_RecordsetCustomer = mysql_fetch_assoc($RecordsetCustomer);
  }
?>
          </select></td>
          <td><input type="image" src="../image/excel_icon.jpg" name="image" width="30" height="30"></td>
        </tr>
      </table>
      <p>&nbsp;</p>
    </form>
    </td>
  </tr>
  <tr>
    <td class="a_Title_Report">Hostel </td>
  </tr>
  <tr>
    <td><form action="" method="post" name="form3" id="form3">
      <table border="0" align="center">
        <tr class="a_fonts12bold">
          <td>Select Customer
            <input type="hidden" name="MM_insert3" value="formSelect3" /></td>
          <td>Date From</td>
          <td>Date To</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><select name="customer_id3" class="a_DropDown" id="customer_id3">
              <?php
do {  
?>
              <option value="<?php echo $row_RecordsetCustomer['customer_id']?>"><?php echo $row_RecordsetCustomer['customer_name']?></option>
              <?php
} while ($row_RecordsetCustomer = mysql_fetch_assoc($RecordsetCustomer));
  $rows = mysql_num_rows($RecordsetCustomer);
  if($rows > 0) {
      mysql_data_seek($RecordsetCustomer, 0);
	  $row_RecordsetCustomer = mysql_fetch_assoc($RecordsetCustomer);
  }
?>
          </select></td>
          <td><input name="date_from3" type="text" class="a_txtbox_main" id="date_from3" value="<?php echo date("Y-m-01"); ?>" size="12" />
              <span class="a_fonts9">
              <input name="button4" type="button" onclick="displayCalendar(document.forms[0].date_from,'yyyy-mm-dd',this,false)" value="Cal" />
            </span></td>
          <td><input name="date_to3" type="text" class="a_txtbox_main" id="date_to3" value="<?php echo date('Y-m-d') ; ?>" size="12" />
              <span class="a_fonts9">
              <input name="button23" type="button" onclick="displayCalendar(document.forms[0].date_to,'yyyy-mm-dd',this,false)" value="Cal" />
            </span></td>
          <td><input type="image" src="../image/excel_icon.jpg" name="image3" width="30" height="30" />
            <input name="MM_insert3" type="hidden" id="MM_insert3" value="form3" /></td>
          </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html><?php
mysql_free_result($RecordsetReport);

mysql_free_result($RecordsetCustomer);

mysql_free_result($RecordsetItem);

mysql_free_result($RecordsetBranch);

mysql_free_result($RecordsetUserBranch);
?>
