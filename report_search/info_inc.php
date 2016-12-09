<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../main/session.php";
include "../main/functions.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';


switch ($action) {
									
  case 'summary_report' :
    summary_report();
    break;	
	
	case 'yearly_report' :
    yearly_report();
    break;
					  
	
		
		
}


function summary_report()
{
  if($_POST)
  {
		$date_from = ($_POST['date_from'] != "") ? "" . date("Y-m-d", strtotime($_POST['date_from'])) . "" : NULL; 
		$date_to = ($_POST['date_to'] != "") ? "" . date("Y-m-d", strtotime($_POST['date_to'])) . "" : NULL;
		$report_type = $_POST['report_type'];
		$database_table = $_POST['database_table'];

		$report_name = 'export_data';
		
	
		
		if ($database_table == 'user')
		{
			if($report_type == 'excel')
			{
				header("location: excel_detail.php?date_from=$date_from&date_to=$date_to&report_name=$report_name&database_table=$database_table");
			}
			else if ($report_type == 'pdf')
			{	
				$exportName = 'member_list';
				header("Location: ../../cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/$exportName&aliasname=glsb&username=admin&password=&ParamDate_From=$date_from&ParamDate_To=$date_to");
			}
		}
		else if ($database_table == 'sorder')
		{
			if($report_type == 'excel')
			{
				header("location: excel_detail.php?date_from=$date_from&date_to=$date_to&report_name=$report_name&database_table=$database_table");
			}
			else if ($report_type == 'pdf')
			{	
				$exportName = 'order_history_all';
				header("Location: ../../cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/$exportName&aliasname=glsb&username=admin&password=&ParamDate_From=$date_from&ParamDate_To=$date_to");
			}
		}
		else if ($database_table == 'ewallet')
		{
			if($report_type == 'excel')
			{
				header("location: excel_detail.php?date_from=$date_from&date_to=$date_to&report_name=$report_name&database_table=$database_table");
			}
			else if ($report_type == 'pdf')
			{	
				$exportName = 'ewallet';
				header("Location: ../../cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/$exportName&aliasname=glsb&username=admin&password=&ParamDate_From=$date_from&ParamDate_To=$date_to");
			}
		}
		else if($database_table == 'ewallet_withdraw')
		{
			if($report_type == 'excel')
			{
				header("location: excel_detail.php?date_from=$date_from&date_to=$date_to&report_name=$report_name&database_table=$database_table");
			}
			else if ($report_type == 'pdf')
			{	
				$exportName = 'pending_monthly_payout';
				header("Location: ../../cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/$exportName&aliasname=glsb&username=admin&password=&ParamDate_From=$date_from&ParamDate_To=$date_to");
			}
		}
		else if ($database_table == 'user_by_earning')
		{
			if($report_type == 'excel')
			{
				header("location: excel_detail.php?date_from=$date_from&date_to=$date_to&report_name=$report_name&database_table=$database_table");
			}
			else if ($report_type == 'pdf')
			{	
				$exportName = 'list_of_member_earnings';
				header("Location: ../../cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/$exportName&aliasname=glsb&username=admin&password=&ParamDate_From=$date_from&ParamDate_To=$date_to");
			}
		}
  }
}

function yearly_report()
{
		$year_id = $_POST['year_id'];
		$report_type = $_POST['report_type'];
		$database_table = $_POST['database_table'];

		$report_name = 'export_data';

		if ($database_table == 'sales_product')
		{
			if($report_type == 'excel')
			{
				header("location: excel_detail.php?year_id=$year_id&report_name=$report_name&database_table=$database_table");
			}
			else if ($report_type == 'pdf')
			{	
				$exportName = 'sales_performance_report_product';
				header("Location: ../../cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/$exportName&aliasname=glsb&username=admin&password=&Paramyear_id=$year_id");
			}
		}

}





?>
