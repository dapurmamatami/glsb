<?php
function addUserForm()
{
?>
             
              <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
              <div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                        <div class="box-header with-border">
                          <h3 class="box-title"></h3> 	
										<div style="float: right;">								
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
                                            <input type="button" value="ADD" id="buttonAdd" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=add'"/>
                                  		<?php } ?>
                                            <input name="SubmitCancel" type="submit" class="btn btn-primary" id="SubmitCancel" value="Cancel" onClick="document.theForm.action='info_inc.php?action=cancel&id=<?php echo $id; ?>'" />	
										</div>
                         </div>                       
                                  <div class="nav-tabs-custom">
                                    <!--
                                    <ul class="nav nav-tabs">
                                      <li class="active"><a href="#detail" data-toggle="tab">Worker Details</a></li>	
                                    </ul>
                                    -->
                                   <div class="tab-content">
                                    
                                      <div class="active tab-pane" id="detail">
                                      
                                            <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-4">
                                              <input name="name" type="text" class="form-control" id="name" />
                                            </div>
                                            </div>
                                            
                                           	<div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">User Name</label>
                                            <div class="col-sm-4">
                                              <input type="text" name="user_name" id="user_name" class="form-control" />
                                            </div>                                     
											</div>
                                            
                                            <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Password</label>
                                            <div class="col-sm-4">
                                              <input type="password" name="password" id="password" class="form-control" />
                                            </div>                                     
											</div>
                                            
                                            <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">User Group</label>
                                            <div class="col-sm-2">
 												<select name="user_group" id="user_group" class="form-control">
												<?php 
                                                  
												$sql = "SELECT user_group_id, user_group_name FROM user_group where user_group_id <> 10 order by user_group_id asc";
												$result=dbQuery($sql);
													if(dbNumRows($result)>0)
													{
														echo "<option value=''></option>";
														
														while($row=dbFetchAssoc($result))
														{
														echo "<option value='$row[user_group_id]'>$row[user_group_name]</option>";
														}
													}
												?>
                                                </select>
                                            </div>                                     
											</div> 
                                            
                                            <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Remark</label>
                                            <div class="col-sm-4">
                                              <textarea name="remark" id="remark" class="form-control" rows="4"></textarea>
                                            </div>                                     
											</div>
                                      </div><!-- /.tab-pane -->
                                                                          
 
                                    </div><!-- /.tab-content -->
                                  </div><!-- /.nav-tabs-custom -->
                                </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
	
                  </div><!-- /.box-footer -->
               	
              </div><!-- /.box -->
		      </form>


<?php } ?>

<?php
function getUserDetailForm($id,$displayMsg)
{

  if(!checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){
    $ro="READONLY";
    $st="style='background-color: #CCFFCC; border-width: 0;'";
    $readonly=true;
  }else{
    $ro="";
    $st="";
    $readonly=false;
  }

	if($id == '')
	{
		$id = $_SESSION['user_id'];
	}
	
  $sql = "SELECT user_id, user_name,password, name, user_group, remark
          FROM user
          WHERE user_id = $id
         ";
  $result = dbQuery($sql);
  if(dbNumRows($result)==1)
  {
    $row=dbFetchAssoc($result);
    
    $name = $row[name];
		$user_name = $row[user_name];
    $password = $row[password];
		$user_group = $row[user_group];
		$remark = $row[remark];

	
?>



				<!--=== Page Content ===-->
				<!--=== Full Size Inputs ===-->
				<form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
				<div class="row">
					<div class="col-md-12">				
							<div class="widget box">
								<div class="widget-header" >	
								<h4><i class="icon-reorder"></i> User Info</h4>	
									<div style="float: right;">								
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
										<input name="button" type="submit" class="btn btn-primary" id="button" onclick="document.theForm.action='info_inc.php?action=resetPassword&amp;id=<?php echo $id; ?>'" value="Change Password"/>
<input type="button" value="Update" id="buttonAdd" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=update&id=<?php echo $id; ?>'"/>
											<?php } ?><?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'delete_sw')){ ?>
											<input name="buttonDelete" type="submit" class="btn btn-primary" id="buttonDelete" value="Delete" onClick="document.theForm.action='info_inc.php?action=delete&id=<?php echo $id; ?>'" />
										<?php } ?>
										</div>
								</div>


								
								<div class="widget-content">
									
										
									<div class="form-group">
										
										<label class="col-md-2 control-label">Name</label>
											<div class="col-md-6">
												<input name="name" type="text" class="form-control" id="name" value="<?php echo $name; ?>" />
											</div>
									</div>
									<div class="form-group">												
											<label class="col-md-2 control-label">User Name</label>
											<div class="col-md-6">
												<input name="user_name" type="text" class="form-control" id="user_name" value="<?php echo $user_name; ?>" disabled="disabled"/>
											</div>
									</div>
									<div class="form-group">	
										<label class="col-md-2 control-label">Password</label>
											<div class="col-md-6">
												<input name="password" type="password" class="form-control" id="password" value="<?php echo $password; ?>" readonly=readonly/>
											</div>
											
									</div>
									<div class="form-group">																															
											<label class="col-md-2 control-label">User Group</label>
	
										<div class="col-md-6">
										  <select class="form-control" name='user_group' id='user_group'>
                        <?php
          $sql = "SELECT user_group_id, user_group_name
                  FROM user_group
				  order by user_group_id desc
                 ";
          $result=dbQuery($sql);
          if(dbNumRows($result)>0)
          {
            while($row=dbFetchAssoc($result))
            {
                if($row[user_group_id]==$user_group){
                    $str2="SELECTED";
                }else{
                    $str2="";
                }
			  echo "<option value='$row[user_group_id]' $str2>$row[user_group_name]</option>";
            }
          }

        ?>
                                            </select>
										</div>
									</div>
										
										
									<div class="form-group">
											<label class="col-md-2 control-label">Remark  :</label>
											<div class="col-md-6">
												<textarea name="remark" class="form-control" id="remark"><?php echo $remark; ?></textarea>
											</div>
									</div>
										
							
									
								</div> <!-- end of widget-content -->
							</div> <!-- end of widget-header -->
							<!--Forms -->
				
					</div>		
					</div>
				</div>
				</form>
				<!-- /Page Content -->



<?php 

	}
	else
	{
		echo addUserForm();
	}

} //end of getUserDetailForm 

function showUserList()
{

?>
<script type="text/javascript">

$(document).ready(function () {
		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'user_id', type: 'string'},
				{ name: 'user_name', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'user_group_name', type: 'string'},
				{ name: 'remark', type: 'string'}
			],
			
			cache: false,
			url: 'data.php',
			filter: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
			},
			sort: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
			},
			root: 'Rows',
			pagesize: 50,
			beforeprocessing: function(data)
			{		
				if (data != null)
				{
					source.totalrecords = data[0].TotalRows;					
				}
			}
			};		
			var dataadapter = new $.jqx.dataAdapter(source, {
				loadError: function(xhr, status, error)
				{
					alert(error);
				}
			}
		);
		
	 	var linkrenderer = function (row, column, value) {
			if (value.indexOf('#') != -1) {
				value = value.substring(0, value.indexOf('#'));
			}
			var format = { target: '"_blank"' };
			var html = $.jqx.dataFormat.formatlink(value, format);
	
					//return "<a href='" + value + "' target='_blank'>Link Text</a>";
			return "<a href=index.php?view=detail&id=" + value + " >View</a>";
		}						

			
		$("#jqxgrid").jqxGrid(
		{	
			source: dataadapter,
			
			filterable: true,
			sortable: true,
			//autoheight: true,
			pageable: true,
			virtualmode: true,
			width: '98%',		
			rendergridrows: function(obj)
			{
				return obj.data;    
			},		
			columns: [ 
				{ text: '', editable: false, datafield: 'user_id', width: 80 ,cellsrenderer: linkrenderer},
				{ text: 'Name',editable: false, datafield: 'name', width: 150 },
				{ text: 'User Name', editable: false, datafield: 'user_name', width: 250 },
				{ text: 'User Group',editable: false, datafield: 'user_group_name', width: 150 }
			]
		});  
		
				
						
});

</script>

				<div class="box box-warning">
                  <div class="box-body">                                   
                    <div class="col-md-12">

							<div class="widget-content">
							
									<div id="jqxgrid">

									</div>
							</div>

					</div>
				</div>

<?php 
} // end of function showList

?>