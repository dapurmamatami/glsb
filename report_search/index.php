<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../inc/display_message.php";
include "../main/session.php";
include "../inc/pdoconfig.php";
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
		$pageTitle = 'PO Info';  	  
		
    break;
 
   case 'add' :
    $content = 'add.php';		
		$pageTitle = 'Export Data'; 
    break;
	
	case 'add2' :
    $content = 'add2.php';		
		$pageTitle = 'Export Data';  	  
    break;  
      
  default:
    $content = 'list.php';
    $pageTitle = '';

}


?>

<?php 
require_once '../main/template.php';

?>
<script src="js_inc.js"></script>
