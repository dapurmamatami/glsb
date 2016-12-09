<?php
if(checkAccess($_SESSION['user_grp'], $current_folder, 'view_sw')){
  getDetailForm($_GET[id],$_GET[displayMsg] );
}else{
  echo "You dont have the permission to this action.";
}
?>