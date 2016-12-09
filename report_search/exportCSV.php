<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";

// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=withdraw-pending.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('Name', 'Bank Name', 'Account No', 'Amount'));

// fetch the data
$getProject = $_GET['projects'];
$sql = "select bank_holder_name, bank_name, bank_account_no, amount_out  FROM acct_ewallet_withdraw inner join acct_ewallet on acct_ewallet_withdraw.withdraw_id = acct_ewallet.withdraw_id where acct_ewallet_withdraw.status_id = 0
       ";
$result=dbQuery($sql);	
                
while 
($row = mysql_fetch_assoc($result)) 
fputcsv($output, $row);
//$rows = mysql_query('SELECT field1,field2,field3 FROM table');

// loop over the rows, outputting them



?>