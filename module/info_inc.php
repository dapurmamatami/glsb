<?php
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../main/session.php";
include "../main/functions.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
  

  case 'update' :
    updateModule();
    break;
		
	  
  case 'cancel' :
    cancelPage();
    break;
  }


function updateModule()
{
	$id = $_GET[id];
  
  if($_POST)
  {
	
  	if (!empty($_POST['view_sw'])) {
     	foreach($_POST['view_sw'] as $v) {
		
				$right_id = mysql_real_escape_string(implode(',', $_POST['view_sw']));
				//$iphoto_id = $_POST['checkbox'];
				
				$sql = "UPDATE user_group_permission SET view_sw=1 WHERE right_id in ($right_id) and user_group_id <> 0";
				$result = mysql_query($sql);
				
				$sql = "UPDATE user_group_permission SET view_sw=0 WHERE right_id not in ($right_id) and user_group_id <> 0";
				$result = mysql_query($sql);				

				
			}
		}
		
  		 if (!empty($_POST['add_sw'])) {
     		 foreach($_POST['add_sw'] as $v) {
		
				$right_id = mysql_real_escape_string(implode(',', $_POST['add_sw']));
				//$iphoto_id = $_POST['checkbox'];
				
				$sql = "UPDATE user_group_permission SET add_sw=1 WHERE right_id in ($right_id) and user_group_id <> 0";
				$result = mysql_query($sql);
				  
				$sql = "UPDATE user_group_permission SET add_sw=0 WHERE right_id not in ($right_id) and user_group_id <> 0";
				$result = mysql_query($sql);
								  
				
			}
		}

  		 if (!empty($_POST['update_sw'])) {
     		 foreach($_POST['update_sw'] as $v) {
		
				$right_id = mysql_real_escape_string(implode(',', $_POST['update_sw']));
				//$iphoto_id = $_POST['checkbox'];
				
				$sql = "UPDATE user_group_permission SET update_sw=1 WHERE right_id in ($right_id) and user_group_id <> 0";
				$result = mysql_query($sql);
				  
				$sql = "UPDATE user_group_permission SET update_sw=0 WHERE right_id not in ($right_id) and user_group_id <> 0";
				$result = mysql_query($sql);
								  
				
			}
		}
		
  		 if (!empty($_POST['delete_sw'])) {
     		 foreach($_POST['delete_sw'] as $v) {
		
				$right_id = mysql_real_escape_string(implode(',', $_POST['delete_sw']));
				//$iphoto_id = $_POST['checkbox'];
				
				$sql = "UPDATE user_group_permission SET delete_sw=1 WHERE right_id in ($right_id) and user_group_id <> 0";
				$result = mysql_query($sql);
				  
				$sql = "UPDATE user_group_permission SET delete_sw=0 WHERE right_id not in ($right_id) and user_group_id <> 0";
				$result = mysql_query($sql);
								  
					
				
			}
		}	

									
		header("Location: index.php?view=detail&id=1&displayMsg=updated");
  }

}



function cancelPage()
{
  if($_POST)
  {
    header("Location: index.php?view=list");
  }
}

?>
