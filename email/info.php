<?php
function addForm()
{
	include '../main/lang_default.php';
?>

    <script type="text/javascript">
        $(document).ready(function () {						
		
			
			
        });
    </script>
              
              <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
              <div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                        <div class="box-header with-border">
                          <h3 class="box-title"></h3> 	
										<div style="float: right;">								
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        						<input type="button" value="<?php echo $lang['BUTTON_ADD']; ?>" id="buttonAdd" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=add'"/>
	                  <?php } ?>
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
                                            <label for="input" class="col-sm-2 control-label"><?php echo $lang['NEW_SEND_EMAIL_EMAIL_SUBJECT']; ?></label>
                                            <div class="col-sm-8">
                                              <textarea class="form-control" id="email_subject"></textarea>
                                            </div> 
                                          	</div>
                                            
                                            <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label"><?php echo $lang['NEW_SEND_EMAIL_EMAIL_MESSAGE']; ?></label>
                                            <div class="col-sm-8">
                                              <textarea class="form-control" id="email_message"></textarea>
                                            </div>                                     
                                          	</div>
                                            
                                            <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label"><?php echo $lang['NEW_SEND_EMAIL_ATTACHMENT_PATH']; ?></label>
                                            <div class="col-sm-8">
                                              <textarea class="form-control" id="attachment_path"></textarea>
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
function getDetailForm($id,$displayMsg)
{
	include '../main/lang_default.php';
		
 $data = getEmailDetail($id);
	
	 
		if ($data != ""){
	
  
	
?>
<script type="text/javascript">

$(document).ready(function () {    
          
	$('input:radio[name=active_sw]:nth(<?php echo $data['active_sw']; ?>)').attr('checked',true);  

});

</script> 
              
              <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
              <div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                        <div class="box-header with-border">
                          <h3 class="box-title"></h3> 	
										<div style="float: right;">								
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        						<input type="button" value="<?php echo $lang['BUTTON_DELETE']; ?>" id="buttonDelete" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=delete&id=<?php echo $id; ?>'"/>
	                  <?php } ?>                      
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
                                            <label for="input" class="col-sm-2 control-label"><?php echo $lang['NEW_SEND_EMAIL_EMAIL_SUBJECT']; ?></label>
                                            <div class="col-sm-8">
                                              <textarea class="form-control" id="email_subject"><?php echo $data['email_subject']; ?></textarea>
                                            </div> 
                                          	</div>
                                            
                                            <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label"><?php echo $lang['NEW_SEND_EMAIL_EMAIL_MESSAGE']; ?></label>
                                            <div class="col-sm-8">
                                              <textarea class="form-control" id="email_message"><?php echo $data['email_message']; ?></textarea>
                                            </div>                                     
                                          	</div>
                                            
                                            <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label"><?php echo $lang['NEW_SEND_EMAIL_ATTACHMENT_PATH']; ?></label>
                                            <div class="col-sm-8">
                                              <textarea class="form-control" id="attachment_path"><?php echo $data['attachment_path']; ?></textarea>
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
		      


<?php }
else {
	addForm(); 
	}
	
}
	
?>

<?php

function showList()
{
	include '../main/lang_default.php';
?>
<script type="text/javascript">

$(document).ready(function () {
		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'email_id', type: 'string'},
				{ name: 'email_subject', type: 'string'},
				{ name: 'email_message', type: 'string'},
				{ name: 'attachment_path', type: 'string'},
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
				{ text: '', editable: false, datafield: 'email_id', width: 80 ,cellsrenderer: linkrenderer},
				{ text: '<?php echo $lang['NEW_SEND_EMAIL_EMAIL_SUBJECT']; ?>', editable: false, datafield: 'email_subject', width: 300 },
				{ text: '<?php echo $lang['NEW_SEND_EMAIL_EMAIL_MESSAGE']; ?>',editable: false, datafield: 'email_message', width: 300 },
				{ text: '<?php echo $lang['NEW_SEND_EMAIL_ATTACHMENT_PATH']; ?>',editable: false, datafield: 'attachment_path', width: 300 },
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