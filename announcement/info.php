<?php
function addForm()
{
		include '../main/lang_default.php';
?>
             
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
                                            <label for="input" class="col-sm-2 control-label"><?php echo $lang['NEW_ANNOUNCEMENT_ANNOUNCEMENT']; ?></label>
                                            <div class="col-sm-5">
                                              <input type="text" class="form-control" id="anno_title" >
                                            </div>
                                            </div>
                                            
                                           <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label"><?php echo $lang['NEW_ANNOUNCEMENT_ANNOUNCEMENT_DESCRIPTION']; ?></label>
                                            <div class="col-sm-8">
                                              <textarea class="form-control" id="anno_description"></textarea>
                                            </div>                                     
                                          </div>
      
                                          <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label"><?php echo $lang['NEW_ANNOUNCEMENT_ANNOUNCEMENT_DATE']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="anno_date" >
                                            </div> 
                                               
                                            <label for="input" class="col-sm-2 control-label"><?php echo $lang['NEW_ANNOUNCEMENT_ACTIVE']; ?></label>
                                            <div class="col-sm-2">
                                              <input name="active_sw" id="active_sw" type="radio" value="0" checked="checked"  />
											<?php echo $lang['RADIO_BUTTON_NO']; ?> &nbsp;&nbsp;&nbsp;&nbsp;
											<input name="active_sw" id="active_sw" type="radio" value="1" /> 
											<?php echo $lang['RADIO_BUTTON_YES']; ?>
                                            </div>
                                            
                                            <label for="input" class="col-sm-1 control-label">Sorting Number</label>
                                            <div class="col-sm-1">
                                              <input type="text" class="form-control" id="sorting_number" >
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
		
 $data = getAnnouncementDetailForm($id);
	
	 
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
        						<input type="button" value="<?php echo $lang['BUTTON_UPDATE']; ?>" id="buttonUpdate" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=update&id=<?php echo $id; ?>'"/>
	                  <?php } ?>
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
                                            <label for="input" class="col-sm-2 control-label"><?php echo $lang['NEW_ANNOUNCEMENT_ANNOUNCEMENT']; ?></label>
                                            <div class="col-sm-5">
                                              <input type="text" class="form-control" id="anno_title" value="<?php echo $data['anno_title']; ?>" >
                                            </div>
                                            </div>
                                            
                                            <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label"><?php echo $lang['NEW_ANNOUNCEMENT_ANNOUNCEMENT_DESCRIPTION']; ?></label>
                                            <div class="col-sm-8">
                                              <textarea class="form-control" id="anno_description"><?php echo $data['anno_description']; ?></textarea>
                                            </div> 
                                          
                                                                                        
                                          </div>
      
                                          <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label"><?php echo $lang['NEW_ANNOUNCEMENT_ANNOUNCEMENT_DATE']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="anno_date" value="<?php echo ($data['anno_date'] != "") ? "" . date("d-m-Y", strtotime($data['anno_date'])) . "" : ''; ?>" >
                                            </div>    
                                             <label for="input" class="col-sm-2 control-label"><?php echo $lang['NEW_ANNOUNCEMENT_ACTIVE']; ?></label>
                                            <div class="col-sm-2">
                                              <input name="active_sw" id="active_sw" type="radio" value="0" />
											<?php echo $lang['RADIO_BUTTON_NO']; ?> &nbsp;&nbsp;&nbsp;&nbsp;
											<input name="active_sw" id="active_sw" type="radio" value="1" checked="checked" /> 
											<?php echo $lang['RADIO_BUTTON_YES']; ?>
                                            </div>  
                                            
                                            <label for="input" class="col-sm-1 control-label">Sorting Number</label>
                                            <div class="col-sm-1">
                                              <input type="text" class="form-control" id="sorting_number" value="<?php echo $data['sorting_number']; ?>">
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

function showAnnouncementList()
{
	include '../main/lang_default.php';
?>
<script type="text/javascript">

$(document).ready(function () {
		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'anno_id', type: 'string'},
				{ name: 'anno_title', type: 'string'},
				{ name: 'anno_description', type: 'string'},
				{ name: 'anno_date', type: 'string'},
				{ name: 'active_sw_announcement', type: 'string'},
				{ name: 'sorting_number', type: 'string'}
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
				{ text: '', editable: false, datafield: 'anno_id', width: 80 ,cellsrenderer: linkrenderer},
				{ text: '<?php echo $lang['NEW_ANNOUNCEMENT_ANNOUNCEMENT']; ?>', editable: false, datafield: 'anno_title', width: 250 },
				{ text: '<?php echo $lang['NEW_ANNOUNCEMENT_ANNOUNCEMENT_DESCRIPTION']; ?>',editable: false, datafield: 'anno_description', width: 500 },
				{ text: '<?php echo $lang['NEW_ANNOUNCEMENT_ANNOUNCEMENT_DATE']; ?>',editable: false, datafield: 'anno_date', width: 150 },
				{ text: 'Status',editable: false, datafield: 'active_sw_announcement', width: 150 },
				{ text: 'Announcement Queue',editable: false, datafield: 'sorting_number', width: 150 }
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