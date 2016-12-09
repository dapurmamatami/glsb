<?php
function getModule()
{

  $sql = "select * from user_group_permission inner join system_module on 
					user_group_permission.module_id = system_module.module_id inner join user_group 
					on user_group_permission.user_group_id = user_group.user_group_id 
					where user_group_permission.user_group_id <> 0 order by system_module.module_id, user_group.user_group_id
         ";
  $result = dbQuery($sql);


  $sqlGroup = "select * from user_group
					where user_group.user_group_id <> 0
         ";
  $resultGroup = dbQuery($sqlGroup);			
?>

    <form action="" method="post" name="theForm" id="theForm">

				<div class="row">
					<div class="col-md-12">				
							<div class="widget box">
								<div class="widget-header" >	
								<h4><i class="icon-reorder"></i> </h4>	
										<div style="float: right;">								
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        <input name="SubmitUpdate" type="submit" class="btn btn-primary" id="SubmitUpdate" value="Update" onClick="document.theForm.action='info_inc.php?action=update&id=<?php echo $id; ?>'" />		
	                  <?php } ?>

										</div>
								</div>
								
								<div class="widget-content">
								



   
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr class="formblock_row1">
            <td colspan="6" align="right"></td>
          </tr>
          <tr>
            <td colspan="6" class=""></td>
          </tr>
          <tr class="formblock_row2 " id="viewrow1">
            <td width="15%" align="right" class="form_txt"><div align="center"><strong>Module </strong></div></td>
            <td width="15%" align="left" class="form_txt"><strong> Group </strong></td>
            <td width="10%" align="right" class="form_txt"><div align="center"><strong>View</strong></div></td>
            <td width="10%" align="right" class="form_txt"><div align="center"><strong>Add</strong></div></td>
            <td width="10%" align="right" class="form_txt"><div align="center"><strong>Edit</strong></div></td>
            <td width="10%" align="right" class="form_txt"><div align="center"><strong>Delete</strong></div></td>
          </tr>
          <?php while($row=dbFetchAssoc($result)) { ?>
          <tr class="formblock_row1 " id="viewrow1" <?php if($row['header_sw'] ==1) { ?>bgcolor="#CCCCCC" <?php } ?>>
            <td class="form_txt" align="right"><div align="center">
                <?php if($row['header_sw'] ==1) { echo $row['module_name']; } ?>
            </div></td>
            <td class="form_txt" align="left"><?php echo $row['user_group_name']; ?></td>
            <td align="right" class="form_txt"><div align="center">
                <input <?php if (!(strcmp($row['view_sw'],1))) {echo "checked=\"checked\"";} ?> name="view_sw[]" type="checkbox" id="view_sw" value="<?php echo $row['right_id']; ?>" />
            </div></td>
            <td align="right" class="form_txt"><div align="center">
                <input <?php if (!(strcmp($row['add_sw'],1))) {echo "checked=\"checked\"";} ?> name="add_sw[]" type="checkbox" id="add_sw" value="<?php echo $row['right_id']; ?>" />
            </div></td>
            <td align="right" class="form_txt"><div align="center">
                <input <?php if (!(strcmp($row['update_sw'],1))) {echo "checked=\"checked\"";} ?> name="update_sw[]" type="checkbox" id="update_sw" value="<?php echo $row['right_id']; ?>" />
            </div></td>
            <td align="right" class="form_txt"><div align="center">
                <input <?php if (!(strcmp($row['delete_sw'],1))) {echo "checked=\"checked\"";} ?> name="delete_sw[]" type="checkbox" id="delete_sw" value="<?php echo $row['right_id']; ?>" />
            </div></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <p>&nbsp;</p>





								</div>
							</div>
							<!--Forms -->
				
					</div>		
			</div>
				</div>
</form>
				<!-- /Page Content -->

<?php } ?>

