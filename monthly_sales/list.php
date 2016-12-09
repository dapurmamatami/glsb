<?php
if(checkAccess($_SESSION['user_grp'], $current_folder, 'view_sw')){
	if ($_GET['sub'] == 'pending')
  	{
		echo showListPending();
	}
	else
	{
 	 	echo showList();
	}
}else{
  echo "You dont have the permission to this action.";
}
?>
