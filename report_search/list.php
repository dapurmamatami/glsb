<?php
if(checkAccess($_SESSION['user_grp'], $current_folder, 'view_sw')){
	$rpt = $_GET['rpt'];
	

	if($rpt == 'exportExcel')
	{
		echo otherReport();
	} 
			 
}else{
  echo "You dont have the permission to this action.";
}
?>
