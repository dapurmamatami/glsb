<?php
function getChangePassword()
{

  $sql = "select * from user_group_permission inner join system_module on 
					user_group_permission.module_id = system_module.module_id inner join user_group 
					on user_group_permission.user_group_id = user_group.user_group_id 
					where user_group_permission.user_group_id <> 0 order by system_module.module_id, user_group.user_group_id
         ";
  $result = dbQuery($sql);
	

?>
</br>
<h1>Change Password<br />
  <br />
</h1>
<?php displayMsg($_GET[displayMsg]); ?>

<div id="content">
<div class="standard">
	<div id="errMsg" name="errMsg" class="error_msg">
	</div>
    <form action="" method="post" name="theUpdateForm" id="theUpdateForm">
    <div class="buttons">
      <div class="right">
        <input type="button" value="Update" id="buttonUpdate" class="button" onClick="document.theUpdateForm.action='info_inc.php?action=update&id=<?php echo $id; ?>'"/>
        <input name="SubmitCancel" type="submit" class="button" id="SubmitCancel" value="Cancel" onClick="document.theUpdateForm.action='info_inc.php?action=cancel&id=<?php echo $id; ?>'" />
      </div>
    </div>	
   
      <table width="38%" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="36%">&nbsp;</td>
          <td width="64%">&nbsp;</td>
        </tr>
        <tr>
          <td>Current Password </td>
          <td><span class="a_fonts_error">
            <input name="current_password" type="password" id="current_password" maxlength="12" class="txtbox-220"/>
          </span></td>
        </tr>
        <tr>
          <td>New Password </td>
          <td><span class="a_fonts_error">
            <input name="new_password" type="password" id="new_password" maxlength="12" class="txtbox-220"/>
          </span></td>
        </tr>
        <tr>
          <td>New Password Again </td>
          <td><span class="a_fonts_error">
            <input name="new_password_confirm" type="password" id="new_password_confirm" maxlength="12" class="txtbox-220"/>
          </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <p>&nbsp;</p>
    </form>

	</div>
</div>
<?php } ?>

<?php
function getAdminChangePassword()
{

	$id = $_GET['id'];

  $sql = "select * from user where user_id = '$id'
         ";
  $result = dbQuery($sql);
  if(dbNumRows($result)==1)
  {
    $row=dbFetchAssoc($result);
    
    $user_name = $row[user_name];
		

				
?>
</br>
<h1>Reset Password<br />
  <br />
</h1>
<?php displayMsg($_GET[displayMsg]); ?>

<div id="content">
<div class="standard">
	<div id="errMsg" name="errMsg" class="error_msg">
	</div>
    <form action="" method="post" name="theUpdateAdminForm" id="theUpdateAdminForm">
    <div class="buttons">
      <div class="right">
        <input type="button" value="Update" id="buttonUpdateAdmin" class="button" onClick="document.theUpdateAdminForm.action='info_inc.php?action=updateAdmin&id=<?php echo $id; ?>'"/>
        <input name="SubmitCancel" type="submit" class="button" id="SubmitCancel" value="Cancel" onClick="document.theUpdateAdminForm.action='info_inc.php?action=cancel&id=<?php echo $id; ?>'" />
      </div>
    </div>	
   
      <table width="38%" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="36%">&nbsp;</td>
          <td width="64%">&nbsp;</td>
        </tr>
        <tr>
          <td>User Name </td>
          <td><span class="a_fonts_error">
            <input name="user_name" type="text" class="txtbox-220" id="user_name" value="<?php echo $user_name; ?>" maxlength="12"readonly=readonly/>
          </span></td>
        </tr>
        <tr>
          <td>New Password </td>
          <td><span class="a_fonts_error">
            <input name="new_password" type="password" id="new_password" maxlength="12" class="txtbox-220"/>
          </span></td>
        </tr>
        <tr>
          <td>New Password Again </td>
          <td><span class="a_fonts_error">
            <input name="new_password_confirm" type="password" id="new_password_confirm" maxlength="12" class="txtbox-220"/>
          </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <p>&nbsp;</p>
    </form>

	</div>
</div>
<?php } 
		else
		
		{
			echo "Sorry";
		}
		
}
?>
