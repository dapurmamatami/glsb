<?php
include "../inc/pdoconfig.php";
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../main/session.php";
include "../main/functions.php";
include "../main/pdofunctions.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
  
	
	case 'printReportAll' :
    printReportAll();
    break;	


}
  
  



function printReportAll()
{
		$this_year = date("Y");
 		$user_id = $_SESSION['user_id'];
		$report_name = 'total_income';
		header("Location: ../../cgi-bin/repwebserver.dll/execute.pdf?reportname=\sorder/$report_name&aliasname=glsb$rpt_alias&username=admin&password=&Paramuser_id=$user_id&Paramthis_year=$this_year");		
		

}






?>
