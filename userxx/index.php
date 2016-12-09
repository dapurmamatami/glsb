<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../inc/display_message.php";
include "../main/session.php";

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
		$pageTitle = 'User Info';  	  
    break;
 
   case 'add' :
    $content = 'add.php';		
		$pageTitle = 'New Registration';  	  
    break; 

   case 'oneTimePowerLeg' :
    $content = 'oneTimePowerLeg.php';		
		$pageTitle = 'New Registration';  	  
    break; 
	
   case 'freeupgrade' :
    $content = 'freeupgrade.php';		
		$pageTitle = 'Free Upgrade';  	  
    break; 

   case 'stockistupgrade' :
    $content = 'stockistupgrade.php';		
		$pageTitle = 'Stockist Upgrade';  	  
    break; 
		
   case 'genealogy' :
    $content = 'genealogy_view.php';		
		$pageTitle = 'Genealogy View';  	  
    break; 		
	
   case 'genealogy_binary' :
    $content = 'genealogy_view_binary.php';		
		$pageTitle = 'Genealogy View';  	  
    break; 

   case 'treeview_binary' :
    $content = 'treeview_binary.php';		
		$pageTitle = 'Member Tree View';  	  
    break; 			

   case 'genealogy_universal' :
    $content = 'genealogy_view_universal.php';		
		$pageTitle = 'Genealogy Universal View';  	  
    break; 		

   case 'treeview_universal_list' :
    $content = 'treeview_universal_list.php';		
		$pageTitle = 'Universal Tree View';  	  
    break; 

   case 'treeview_universal' :
    $content = 'treeview_universal.php';		
		$pageTitle = 'Universal Tree View';  	  
    break; 
					      
  default:
    $content = 'list.php';
	if($_SESSION['user_grp'] == 1)
	{
		$pageTitle = 'Direct Sponsor (Admin Mode)';
	}
	else
	{
		$pageTitle = 'Direct Sponsor';
	}
    

}


?>

<?php 
require_once '../main/template.php';

?>
<?php if($view == 'add') { ?>

<?php } else { ?>
<script src="js_update_inc.js"></script>
<?php } ?>
