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
$status_id = (isset($_GET['status_id']) && $_GET['status_id'] != '') ? $_GET['status_id'] : '';

switch($view)
{
  case 'detail' :
    $content = 'detail.php';		
		$pageTitle = 'Sale Order Info';  	  
    break;
 
   case 'add' :
    $content = 'add.php';		
		$pageTitle = 'New Sale Order';  	 
		$pageDescription = 'Add New'; 
    break; 
	

  default:
    $content = 'list.php';
	
	if($_SESSION['user_grp'] == 10) {

		if($_GET[sub]=='myorder') {		
			$pageTitle = 'My Order History';
		}
		if($_GET[sub]=='downlineorder') {		
			$pageTitle = 'My Downline Order History';
		}
			
	}else{
		
		if($_GET[sub]=='AllOrder') {	
			if($status_id == 1) {
				$pageTitle = 'Order History - Pending';
			}else {
				$pageTitle = 'Order History';
			}
			
		}
		
		if($_GET[sub]=='pendingdelivery') {
				$pageTitle = 'Pending Delivery';
		}
		
		if($_GET[sub]=='downlineorder') {		
			$pageTitle = 'Downline Order History';
		}		
	}
	

}


?>

<?php 
require_once '../main/template.php';

?>
<?php if($_GET[view] == 'add') { ?>
<script src="js_inc.js"></script>
<?php } ?>
<?php if($_GET[view] == 'detail') { ?>
<script src="js_inc_update.js"></script>
<?php } ?>