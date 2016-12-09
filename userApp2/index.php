<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../inc/pdoconfig.php";
include "../inc/display_message.php";
//include "../main/session.php";
//include "../main/sessionLogin.php";
include "../main/pdofunctions.php";
include "../main/functions.php";
include "../main/appfunctions.php";
//include "../main/lang_default.php";
include "info.php";



$current_folder = basename(dirname($_SERVER['PHP_SELF']));
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';
$displayMsg = (isset($_GET['displayMsg']) && $_GET['displayMsg'] != '') ? $_GET['displayMsg'] : '';
$sub = (isset($_GET['sub']) && $_GET['sub'] != '') ? $_GET['sub'] : '';

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
		$pageTitle = 'Member Info';  	  
		$pageDescription = 'Add New'; 
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
    $content = 'listMember.php';		
		$pageTitle = 'Member Info';  	  
		$pageDescription = ''; 
    break; 	
      
  default:
  
  
    $content = 'list.php';
    $pageTitle =  $pageTitle;
	$pageDescription = '';  

}


?>

<?php 
require_once '../main/templateMobile.php';

?>
