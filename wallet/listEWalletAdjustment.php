<?php
if(checkAccess($_SESSION['user_grp'], $current_folder, 'view_sw')){
  echo showEWalletAdjustment();
}else{
  echo "You dont have the permission to this action.";
}
?>
