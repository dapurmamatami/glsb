<?php
//include "../inc/dbconfig.php";
//include "../inc/dbfunctions.php";
//include "../inc/display_message.php";
//include "../main/session.php";

include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../inc/pdoconfig.php";
include "../inc/display_message.php";
include "../main/session.php";
include "../main/pdofunctions.php";


//include "../inc/paging.php";
//require_once ("../inc/validation.php"); 
include "../main/functions.php";
include "info.php";

$current_folder = basename(dirname($_SERVER['PHP_SELF']));
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';
$displayMsg = (isset($_GET['displayMsg']) && $_GET['displayMsg'] != '') ? $_GET['displayMsg'] : '';

switch($view)
{
  case 'detail' :
    $content = 'detail.php';		
		$pageTitle = 'Staff Info';  	  
		$pageDescription = 'Admin/Manager Details';
    break;
 
   case 'add' :
    $content = 'add.php';		
		$pageTitle = 'New Staff'; 
		$pageDescription = 'Add New Admin/Manager'; 	  
    break; 

  default:
    $content = 'list.php';
    $pageTitle = 'Staff Listing';
	$pageDescription = 'Admin/Manager Listing';

}


?>

<?php 
require_once '../main/template.php';

?>
<script src="js_inc2.js"></script>
