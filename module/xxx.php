<?php

include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../default_main/session.php";

for ($x=1; $x<=3; $x++)
{
		  
			for ($i=1; $i<=15; $i++)
			{
				$sql = "INSERT INTO user_group_permission(user_group_id,module_id, add_sw, update_sw, delete_sw, view_sw)
							VALUES('$x','$i','1','1','1','1')
					 		";
				dbQuery($sql);		
			
			}
		

			
			
}

				$sql = "UPDATE user_group_permission SET header_sw=1 WHERE user_group_id = 1";
				$result = mysql_query($sql);

echo "done";

?>