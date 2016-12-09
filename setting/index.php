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
$sub = (isset($_GET['sub']) && $_GET['sub'] != '') ? $_GET['sub'] : '';
$id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';
$displayMsg = (isset($_GET['displayMsg']) && $_GET['displayMsg'] != '') ? $_GET['displayMsg'] : '';

switch($sub)
{
  case 'email' :
    $content = 'detail.php';		
		$pageTitle = 'Email Setting';  	
		$pageDescription = 'Setting';  
    break;
 
 
   case 'delivery_charge' :
   
    $content = 'detail.php';		
		$pageTitle = 'Delivery Charge Setting';  	
		$pageDescription = 'Setting'; 
    break; 
	
	case 'country_setting' :
   
    $content = 'detail.php';		
		$pageTitle = 'Country Setting';  	
		$pageDescription = 'Setting'; 
    break; 
	
	case 'bank_setting' :
   
    $content = 'detail.php';		
		$pageTitle = 'Bank Setting';  	
		$pageDescription = 'Setting'; 
    break; 
      
  default:
    $content = 'list.php';
    $pageTitle =  'Listing';
	$pageDescription = '';  

}


?>

<?php 
require_once '../main/template.php';

?>

<script src="js_inc.js"></script>