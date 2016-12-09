<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../inc/pdoconfig.php";
include "../inc/display_message.php";
include "../main/session.php";
include "../main/pdofunctions.php";

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
		$pageTitle = 'User Info';  	  
    break;
 
   case 'add' :
    $content = 'add.php';		
	$pageTitle = 'Add New Staff';  	
	$pageDescription = 'Add New Admin/Manager';  	  
    break; 
      
  default:
    $content = 'list.php';
    $pageTitle = 'User listing';

}


?>

<?php 
require_once '../main/template.php';

?>
<script src="js_inc.js"></script>
