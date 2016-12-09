<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../inc/display_message.php";
include "../main/session.php";
include "../main/functions.php";
include "../inc/pdoconfig.php";
include "../main/pdofunctions.php";

include "info.php";

$current_folder = basename(dirname($_SERVER['PHP_SELF']));
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';
$displayMsg = (isset($_GET['displayMsg']) && $_GET['displayMsg'] != '') ? $_GET['displayMsg'] : '';
$wallet = (isset($_GET['wallet']) && $_GET['wallet'] != '') ? $_GET['wallet'] : '';

switch($view)
{


	case 'list' :
		$content = 'list.php';		
		$pageTitle = 'Monthly Payout List';  	  
		$pageDescription = ''; 
    break; 

	case 'listPending' :
		$content = 'listPending.php';		
		$pageTitle = 'Monthly Payout Pending';  	  
		$pageDescription = ''; 
    break; 
			      
  default:
 


}


?>

<?php 
require_once '../main/template.php';

?>

