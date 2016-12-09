<?php
if(checkAccess($_SESSION['user_grp'], $current_folder, 'view_sw')){
	
	if($_GET[sub]=='myorder') {
		echo showList();
	}
	
	if($_GET[sub]=='AllOrder') {
		echo showList();
	}

	if($_GET[sub]=='pending') {
		echo showPendingList();
	}
	
	if($_GET[sub]=='downlineorder') {
		echo showDownlineList();
	}  
	
	if($_GET[sub]=='pendingdelivery') {
		echo showPendingDeliveryList();
	}  
	
}else{
	
  echo "You dont have the permission to this action.";
  
}
?>
