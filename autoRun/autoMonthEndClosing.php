<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../inc/pdoconfig.php";
include "../main/pdofunctions.php";

//include "../inc/paging.php";
//require_once ("../inc/validation.php"); 
include "../main/functions.php";


$today = date("Y-m-d");
$dateValidate = strtotime('-1 month', strtotime($today));
$year_id = date('Y', $dateValidate);
$month_id = date('m', $dateValidate);		
	

echo monthEndClosingWallet('acct_ewallet', $year_id, $month_id);
addClosing($today, 1, 1, 0, '');


echo "Run Sucessfully";


?>


