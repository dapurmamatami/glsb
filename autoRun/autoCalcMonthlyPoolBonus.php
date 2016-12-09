<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../inc/pdoconfig.php";
include "../main/pdofunctions.php";

//include "../main/session.php";
//include "../inc/paging.php";
//require_once ("../inc/validation.php"); 
include "../main/functions.php";


$today = date("Y-m-d");
$dateValidate = strtotime('-1 month', strtotime($today));
$year_id = date('Y', $dateValidate);
$month_id = date('m', $dateValidate);		
	

echo calcPoolBonus($year_id, $month_id);
//echo addAutoWithdrawRequest($year_id, $month_id);


echo "Run Sucessfully";


?>


