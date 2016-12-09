<?php
if(checkAccess($_SESSION['user_grp'], $current_folder, 'view_sw')){
  echo showUserList();
}else{
  echo "You dont have the permission to this action.";
}
?>
