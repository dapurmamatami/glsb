<?php
if(checkAccess($_SESSION['user_grp'], $current_folder, 'view_sw')){
  echo showProductList();
}else{
  echo "You dont have the permission to this action.";
}
?>
