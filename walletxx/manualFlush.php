<?php
if(checkAccess($_SESSION['user_grp'], $current_folder, 'view_sw')){
	
  if($_SESSION['user_grp'] == 1)
  {
		if(checkStatusError())
		{
			echo "Temporary Unable. Please contact system administrator for this issue";
		}
		else
		{
			manualFlush($_GET[id],$_GET[displayMsg] );
		}	  
	  
  }
  else
  {
	   echo "You dont have the permission to this action.";	
  }
	
  
  
}else{
  echo "You dont have the permission to this action.";
}
?>