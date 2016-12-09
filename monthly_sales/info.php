<?php
function addForm()
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
                                            <label for="inputName" class="col-sm-2 control-label">Type</label>
                                            <div class="col-sm-2">
                                              <select name='type_id' id='type_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM customer_call_type
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[type_id]==$type_id){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[type_id]' $cSelect>$row[type_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>
                                          	</div>
                                            
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Customer</label>
                                            <div class="col-sm-3">
                                              <select name='customer_id' id='customer_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM customer
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[customer_id]==$customer_id){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[customer_id]' $cSelect>$row[firstname]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>
                                          	</div>
                                             
                                            <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Call Date</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="call_date" >
                                            </div>  
                                            </div>
                                            
                                            <div class="form-group">                                            
                                            <label for="inputName" class="col-sm-2 control-label">Call By</label>
                                            <div class="col-sm-4">
                                              <input type="text" class="form-control" id="call_by_value" value="<?php echo $_SESSION['name'] ?>" disabled="disabled">
                                              <input type="hidden" class="form-control" id="call_by" value="<?php echo $_SESSION['user_id'] ?>">
                                              <input type="hidden" class="form-control" id="call_by_name" value="<?php echo $_SESSION['name'] ?>">
                                            </div>
                                          	</div>
                                          
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Remark</label>
                                            <div class="col-sm-4">
                                              <textarea id="remark" class="form-control" ></textarea>
                                            </div>
                                            </div>
                                          
                                          <div class="form-group">
                                                                                      
                                          </div>
                                   
                                      </div><!-- /.tab-pane -->
                                                                          
 
                                    </div><!-- /.tab-content -->
                                  </div>
                                  <!-- /.nav-tabs-custom -->
                                </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
	
                  </div><!-- /.box-footer -->
               	
              </div><!-- /.box -->
		      </form>


<?php } //end of fuction add ?>


<?php
function getDetailForm($id)
{
 	
 $data = getCustomerCallDetailForm($id);
	
	 
		if ($data != ""){
?>
              
              <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
              <div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                        <div class="box-header with-border">
                          <h3 class="box-title"></h3> 	
										<div style="float: right;">								
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        						<input type="button" value="UPDATE" id="buttonUpdate" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=update&id=<?php echo $id; ?>'"/>
	                  <?php } ?>
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        						<input type="button" value="DELETE" id="buttonDelete" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=delete&id=<?php echo $id; ?>'"/>
	                  <?php } ?>                      
										</div>
                         </div>                       
                                  <div class="tab-content">
                                    
                                      <div class="active tab-pane" id="detail">
                                      <div class="form-group">
                                      </div>
                                         <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Type</label>
                                            <div class="col-sm-2">
                                              <select name='type_id' id='type_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM customer_call_type
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[type_id]==$data['type_id']){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[type_id]' $cSelect>$row[type_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>
                                          	</div>
                                            
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Customer</label>
                                            <div class="col-sm-3">
                                              <select name='customer_id' id='customer_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM customer
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[customer_id]==$data['customer_id']){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[customer_id]' $cSelect>$row[firstname]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>
                                          	</div>
                                             
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Call Date</label>
                                            <div class="col-sm-4">
                                              <input type="text" class="form-control" id="call_date" value="<?php echo ($data['call_date'] != "") ? "" . date("d-m-Y", strtotime($data['call_date'])) . "" : ''; ?>">
                                            </div> 
                                            </div>
                                            
                                            <div class="form-group">                                            
                                            <label for="inputName" class="col-sm-2 control-label">Call By</label>
                                            <div class="col-sm-4">
                                              <input type="text" class="form-control" id="call_by_value" value="<?php echo $_SESSION['name'] ?>" disabled="disabled">
                                              <input type="hidden" class="form-control" id="call_by" value="<?php echo $_SESSION['user_id'] ?>">
                                              <input type="hidden" class="form-control" id="call_by_name" value="<?php echo $_SESSION['name'] ?>">
                                            </div>
                                          	</div>
                                          
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Remark</label>
                                            <div class="col-sm-4">
                                              <textarea id="remark" class="form-control" ><?php echo $data['remark'] ?></textarea>
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

?>
<script type="text/javascript">

$(document).ready(function () {
		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'monthly_sales_id', type: 'string'},
				{ name: 'monthly_sales_date', type: 'string'},
				{ name: 'user_id', type: 'string'},
				{ name: 'total_personal_sales', type: 'string'},
				{ name: 'total_group_sales', type: 'string'},
				{ name: 'personal_sales_comm_percentage', type: 'string'},
				{ name: 'personal_sales_comm_amount', type: 'string'},
				{ name: 'group_sales_comm_percentage', type: 'string'},
				{ name: 'group_sales_comm_amount', type: 'string'},
				{ name: 'additional_sales', type: 'string'},
				{ name: 'additional_comm_percentage', type: 'string'},
				{ name: 'additional_comm_amount', type: 'string'},
				{ name: 'member_reg_no', type: 'string'},
				{ name: 'name', type: 'string'},
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
			editable: true,
			columnsresize: true,
			//autoheight: true,
			pageable: true,
			virtualmode: true,
			width: '98%',		
			rendergridrows: function(obj)
			{
				return obj.data;    
			},		
			columns: [
				//{ text: '', editable: false, datafield: 'monthly_sales_id', width: 80 ,cellsrenderer: linkrenderer},
				{ text: 'Month', editable: true, datafield: 'monthly_sales_date', width: 100 },
				{ text: 'Member Number', editable: true, datafield: 'member_reg_no', width: 130 },
				{ text: 'Name', editable: true, datafield: 'name', width: 160 },
				{ text: 'Personal Sales',editable: true, datafield: 'total_personal_sales', width: 130 },
				{ text: 'Group Sales',editable: true, datafield: 'total_group_sales', width: 130 },
				{ text: 'Personal Sales Comm %', editable: true, datafield: 'personal_sales_comm_percentage', width: 180 },
				{ text: 'Personal Sales Comm Amt',editable: true, datafield: 'personal_sales_comm_amount', width: 180 },
				{ text: 'Group Sales Comm %',editable: true, datafield: 'group_sales_comm_percentage', width: 180 },
				{ text: 'Group Sales Comm amut',editable: true, datafield: 'group_sales_comm_amount', width: 180 },
				{ text: 'Additional Sales',editable: true, datafield: 'additional_sales', width: 130 },
				{ text: 'Additional Comm %',editable: true, datafield: 'additional_comm_percentage', width: 180 },
				{ text: 'Additional Comm Amt',editable: true, datafield: 'additional_comm_amount', width: 180 },
			]
		}); 		
});

</script>

				<div class="box box-warning">
                  <div class="box-body">                                   
                    <div class="col-md-12">

							<div class="widget-content">
                            
                            <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
                             <input type="submit" value="Print" id="buttonPrint" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=printReport&id=<?php echo $id; ?>'" formtarget="_blank"/>
                            </form>
							
									<div id="jqxgrid">

									</div>
							</div>

					</div>
				</div>

<?php 
} // end of function showList

?>

