<?php
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
		$pageTitle = 'Worker Info';  	  
    break;
 
   case 'add' :
    $content = 'add.php';		
		$pageTitle = 'New Worker';  	  
    break; 
	
	case 'listexpiry' :
    $content = 'listexpiry.php';		
	$pageTitle = 'Permit Expiring Soon';  	  
    break; 

  default:
    $content = 'list.php';
    $pageTitle = 'Worker Listing';

}


?>

<?php 
require_once '../main/template.php';

?>
<script src="js_inc.js"></script>
