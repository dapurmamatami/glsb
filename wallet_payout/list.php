<?php
if(checkAccess($_SESSION['user_grp'], $current_folder, 'view_sw')){
  if($_SESSION['user_grp'] != 10)
  {
	  echo showPayoutList();
  }
  
}else{
  echo "You dont have the permission to this action.";
}
?>
