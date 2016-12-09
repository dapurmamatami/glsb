<?php
if(checkAccess($_SESSION['user_grp'], $current_folder, 'add_sw')){
	if(checkStatusError())
	{
		echo "Temporary Unable. Please contact system administrator for this issue";
	}
	else
	{
		addUserForm();
	}
  
}else{
  echo "You dont have the permission to this action.";
}
?>