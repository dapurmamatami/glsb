<?php
if(checkAccess($_SESSION['user_grp'], $current_folder, 'add_sw')){
  otherReport();
}else{
  echo "You dont have the permission to this action.";
}
?>