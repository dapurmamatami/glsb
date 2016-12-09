<?php
if(checkAccess($_SESSION['user_grp'], $current_folder, 'view_sw')){
  if($_SESSION['user_grp'] == 1)
  {
	  echo showUserWalletList();
  }
  else
  {
	  echo showUserWalletList();
  }
  
}else{
  echo "You dont have the permission to this action.";
}
?>
