<?php
//if(checkAccess($_SESSION['user_grp'], $current_folder, 'view_sw')){
//  getModule($_GET[id],$_GET[displayMsg] );
//}else{
//  echo "You dont have the permission to this action.";
//}



	if($_GET['view'] == 'detail')
	{
		getChangePassword($_GET[id],$_GET[displayMsg] );
	}


	if($_GET['view'] == 'reset')
	{
		
		if($_SESSION['user_grp'] == 1 or $_SESSION['user_grp'] == 2)
		{	
			getAdminChangePassword($_GET[id],$_GET[displayMsg] );
			
		}
		else
		{
			echo "You dont have the permission to this action.";
		}
				
	}
	



?>