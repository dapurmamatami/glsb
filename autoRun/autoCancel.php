<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../inc/pdoconfig.php";
include "../main/pdofunctions.php";

//include "../inc/paging.php";
//require_once ("../inc/validation.php"); 
include "../main/functions.php";

echo autoCancelSOder();
echo autoCancelMember();
echo autoDeleteCancelSOder();

echo "Run Sucessfully";


?>


