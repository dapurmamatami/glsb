<?php
if(checkAccess($_SESSION['user_grp'], $current_folder, 'view_sw')){
	
	$status_id = $_GET['status_id'];	
 	echo showListMember($status_id );
	
}else{
	
  	echo "You dont have the permission to this action.";
}
?>
