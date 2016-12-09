<?php
if(checkAccess($_SESSION['user_grp'], $current_folder, 'view_sw')){
  if($_SESSION['user_grp'] == 1)
  {
	  echo showWithdrawList($_GET[withdraw_status]);
  }

  
}else{
  echo "You dont have the permission to this action.";
}
?>
