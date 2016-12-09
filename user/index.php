<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../inc/pdoconfig.php";
include "../inc/display_message.php";
include "../main/session.php";
include "../main/pdofunctions.php";
include "../main/functions.php";
include "../main/lang_default.php";
include "info.php";



$current_folder = basename(dirname($_SERVER['PHP_SELF']));
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';
$displayMsg = (isset($_GET['displayMsg']) && $_GET['displayMsg'] != '') ? $_GET['displayMsg'] : '';
$sub = (isset($_GET['sub']) && $_GET['sub'] != '') ? $_GET['sub'] : '';
$status_id = (isset($_GET['status_id']) && $_GET['status_id'] != '') ? $_GET['status_id'] : '';

switch($sub)
{
	case '1' :
	$content = 'list.php';
	$pageTitle =  'Member Listing Level 1';
	$pageDescription = '';  
	break;
	
	case '2' :
	$content = 'list.php';
	$pageTitle =  'Member Listing Level 2';
	$pageDescription = '';  
	break;
	
	case '3' :
	$content = 'list.php';
	$pageTitle =  'Member Listing Level 3';
	$pageDescription = '';  
	break;
}

switch($view)
{
  case 'detail' :
    $content = 'detail.php';		
		$pageTitle = 'Member Info';  	
		$pageDescription = 'Details';  
    break;
 
 
   case 'add' :
    $content = 'add.php';		
		$pageTitle = 'Add New Member';  	  
		$pageDescription = 'New Member Registration'; 
    break; 
	
   case 'genealogy_binary' :
    $content = 'genealogy_view_binary.php';		
		$pageTitle = 'Genealogy View';  	  
    break; 

   case 'treeview_binary' :
    $content = 'treeview_binary.php';		
		$pageTitle = 'Member Tree View';  	  
    break; 	
	
	case 'listMember' :
	if($status_id == 1)
	{
		$content = 'listMember.php';		
		$pageTitle = 'Member Listing';  	  
		$pageDescription = 'Member Information'; 
		break; 	
	}
	else if($status_id == 0)
	{
		$content = 'listMember.php';		
		$pageTitle = 'Pending Member Listing';  	  
		$pageDescription = 'Pending Member'; 
		break; 	
	}
	else if($status_id == 9)
	{
		$content = 'listMember.php';		
		$pageTitle = 'Suspend Accounts';  	  
		$pageDescription = 'Suspend Account'; 
		break; 	
	}
  default:
  
    $content = 'list.php';
    $pageTitle =  $pageTitle;
	$pageDescription = '';  

}


?>

<?php 
require_once '../main/template.php';

?>

<script src="js_inc.js"></script>