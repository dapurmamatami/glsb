<?php
function addCustomerForm()
{
?>
    <script type="text/javascript">
        $(document).ready(function () {
				$('#date_start').datepicker({ dateFormat: 'yy-mm-dd' });
				$('#date_end').datepicker({ dateFormat: 'yy-mm-dd' });


			var source =
			{
				datatype: "json",
				datafields: [
					{ name: 'customer_id'},
					{ name: 'customer_type_name'},
					{ name: 'customer_code', type: 'string'},
					{ name: 'tel', type: 'string'},
					{ name: 'fax', type: 'string'},
					{ name: 'remark'}
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
				showstatusbar: true,
				<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'add_sw')){ ?>
				renderstatusbar: function (statusbar) {
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");
                    container.append(addButton);
                    statusbar.append(container);	
					addButton.jqxButton({  width: 60, height: 20 });
                    addButton.click(function (event) {
                        var offset = $("#jqxgrid").offset();
                        $("#popupWindowBidderAdd").jqxWindow('open');
                        $("#popupWindowBidderAdd").jqxWindow('move', offset.left + 30, offset.top + 30);
                    });									
				},			
				<?php } ?>					
				columns: [ 
					{ text: '', editable: false, datafield: 'customer_id', width: 60 ,cellsrenderer: linkrenderer},
					{ text: 'Invoice Date', editable: false, datafield: '', width: 150 },
					{ text: 'Invoice No', editable: false, datafield: 'customer_name', width: 150 },
					{ text: 'Ref No', editable: false, datafield: 'customer_name3', width: 250 },
					{ text: 'Invoice Amount', editable: false, datafield: 'customer_type_name', width: 130 }
				]
			});  


            // create jqxWindow.
            $("#popupWindowBidderAdd").jqxWindow({ resizable: false,  autoOpen: false, width: 210, height: 280,cancelButton: $("#Cancel"), });
		



			var source =
			{
				datatype: "json",
				datafields: [
					{ name: 'customer_id'},
					{ name: 'customer_type_name'},
					{ name: 'customer_code', type: 'string'},
					{ name: 'tel', type: 'string'},
					{ name: 'fax', type: 'string'},
					{ name: 'remark'}
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
	
				
			$("#jqxgrid2").jqxGrid(
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
				showstatusbar: true,
				<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'add_sw')){ ?>
				renderstatusbar: function (statusbar) {
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");
                    container.append(addButton);
                    statusbar.append(container);	
					addButton.jqxButton({  width: 60, height: 20 });
                    addButton.click(function (event) {
                        var offset = $("#jqxgrid2").offset();
                        $("#popupWindowBidderAdd2").jqxWindow('open');
                        $("#popupWindowBidderAdd2").jqxWindow('move', offset.left + 30, offset.top + 30);
                    });									
				},			
				<?php } ?>					
				columns: [ 
					{ text: '', editable: false, datafield: 'customer_id', width: 60 ,cellsrenderer: linkrenderer},
					{ text: 'Payment Date', editable: false, datafield: 'customer_name', width: 150 },
					{ text: 'Ref No', editable: false, datafield: 'customer_name3', width: 250 },
					{ text: 'Payment Amount', editable: false, datafield: 'customer_type_name', width: 130 }
				]
			});  


            // create jqxWindow.
            $("#popupWindowBidderAdd2").jqxWindow({ resizable: false,  autoOpen: false, width: 210, height: 280,cancelButton: $("#Cancel"), });




			var source =
			{
				datatype: "json",
				datafields: [
					{ name: 'customer_id'},
					{ name: 'customer_type_name'},
					{ name: 'customer_code', type: 'string'},
					{ name: 'tel', type: 'string'},
					{ name: 'fax', type: 'string'},
					{ name: 'remark'}
				],
				
				cache: false,
				url: 'data.php',
				filter: function()
				{
					// update the grid and send a request to the server.
					$("#jqxgrid3").jqxGrid('updatebounddata', 'filter');
				},
				sort: function()
				{
					// update the grid and send a request to the server.
					$("#jqxgrid3").jqxGrid('updatebounddata', 'sort');
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
	
				
			$("#jqxgrid3").jqxGrid(
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
				showstatusbar: true,
				<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'add_sw')){ ?>
				renderstatusbar: function (statusbar) {
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");
                    container.append(addButton);
                    statusbar.append(container);	
					addButton.jqxButton({  width: 60, height: 20 });
                    addButton.click(function (event) {
                        var offset = $("#jqxgrid3").offset();
                        $("#popupWindowBidderAdd3").jqxWindow('open');
                        $("#popupWindowBidderAdd3").jqxWindow('move', offset.left + 30, offset.top + 30);
                    });									
				},			
				<?php } ?>					
				columns: [ 
					{ text: '', editable: false, datafield: 'customer_id', width: 60 ,cellsrenderer: linkrenderer},
					{ text: 'Progress Date', editable: false, datafield: 'customer_name', width: 150 },
					{ text: 'Ref No', editable: false, datafield: 'customer_name3', width: 250 },
					{ text: 'Remark', editable: false, datafield: 'customer_type_name', width: 130 }
				]
			});  


            // create jqxWindow.
            $("#popupWindowBidderAdd3").jqxWindow({ resizable: false,  autoOpen: false, width: 210, height: 280,cancelButton: $("#Cancel"), });		

        });
    </script>
           
              <div class="box box-info">


                  
                  <div class="box-body">                                   
                    <div class="col-md-12">
                                  <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                      <li class="active"><a href="#detail" data-toggle="tab">Project Details</a></li>	
                                      <li><a href="#invoice" data-toggle="tab">Invoice</a></li>
                                      <li><a href="#payment" data-toggle="tab">Payment</a></li>
                                      <li><a href="#settings" data-toggle="tab">Progress</a></li>
                                    </ul>
                                    <div class="tab-content">
                                    
                                      <div class="active tab-pane" id="detail">
                                        <form class="form-horizontal">
                                          <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Project Name</label>
                                            <div class="col-sm-3">
                                              <input type="email" class="form-control" id="inputName" placeholder="Name">
                                            </div>
                                            <label for="inputName" class="col-sm-2 control-label">Project Short Name</label>
                                            <div class="col-sm-2">
                                              <input type="email" class="form-control" id="inputName" placeholder="Name">
                                            </div> 
                                            
                                            <label for="inputName" class="col-sm-1 control-label">Status</label>
                                            <div class="col-sm-2">
                                              <select name='status_id' id='status_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM project_status
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[status_id]==$status_id){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[status_id]' $cSelect>$row[status_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>                                                                                        
                                          </div>
                                          <div class="form-group">
                                                  
                                            <label for="inputEmail" class="col-sm-2 control-label">EOT Claim</label>
                                            <div class="col-sm-3">
                                              <input name="eot_claim" id="eot_claim" type="radio" value="0" checked="checked" />
											Applied &nbsp;&nbsp;&nbsp;&nbsp;
											<input name="eot_claim" id="eot_claim" type="radio" value="1" /> 
											Granted
                                            </div>  
                                                                                      
                                            <label for="inputEmail" class="col-sm-2 control-label">Period Start</label>
                                            <div class="col-sm-2">
                                              <input type="date_start" class="form-control" id="date_start" >
                                            </div>
                                            
                                            <label for="inputEmail" class="col-sm-1 control-label">Period_End</label>
                                            <div class="col-sm-2">
                                              <input type="date_end" class="form-control" id="date_end" >
                                            </div>
                                                                                   
                                          </div>
                                          <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Project Team Leader</label>
                                            <div class="col-sm-3">
                                              <select name='pm_id' id='pm_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM user where user_group = 3
																	 ";
														$result=dbQuery($sql);	
														
														echo "<option value='0'></option>";												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[user_id]==$apm_id){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[user_id]' $cSelect>$row[name]</option>";
															}
														}
									
													?>
          </select>
                                            </div>
                                            <label for="inputName" class="col-sm-2 control-label">Project Assistant</label>
                                            <div class="col-sm-3">
                                              <select name='pm_id' id='pm_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM user where user_group = 3
																	 ";
														$result=dbQuery($sql);	
														
														echo "<option value='0'></option>";												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[user_id]==$apm_id){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[user_id]' $cSelect>$row[name]</option>";
															}
														}
									
													?>
          </select>
                                            </div>                                            
                                          </div>
                                          
                                          <div class="form-group">
                                            <label for="inputExperience" class="col-sm-2 control-label">Site Address</label>
                                            <div class="col-sm-10">
                                              <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                            </div>
                                          </div>    

                                       	  <div class="form-group">
                                            <label for="inputExperience" class="col-sm-2 control-label">Site Tel</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                            </div>

                                            <label for="inputExperience" class="col-sm-2 control-label">Site Fax</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                            </div>
                                            <label for="inputExperience" class="col-sm-2 control-label">Site Contact Person</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                            </div>                                            
                                          </div>
                                                                                                                                                                       
                                          <div class="form-group">
                                            <label for="inputExperience" class="col-sm-2 control-label">Remark</label>
                                            <div class="col-sm-10">
                                              <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                            </div>
                                          </div>


                                          <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                              <button type="submit" class="btn btn-danger">Add</button>
                                            </div>
                                          </div>
                                        </form>
                                      </div><!-- /.tab-pane -->
                                                                          
                                      <div class="tab-pane" id="invoice">
                                        <!-- Post -->
                                        <div class="post">
                                        
                                        <form action="" method="post" name="theBidderFormAdd" id="theBidderFormAdd">
                                                    <div id="popupWindowBidderAdd">
                                                   		 <div>
                                                                    Add Record</div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                        Invoice Date:</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='inputField' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>                                                                
                                                                    <div>
                                                                        Invoice No:</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='inputField' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Ref No:</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='inputField' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Invoice Amount:</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='inputField' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>                                                                    
                                                                    <div style='margin-top:5px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="Save" value="Save" /><input id="Cancel" type="button" value="Cancel" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>	                                        
                                            <div id="jqxgrid">
        
                                            </div>
                                        </div><!-- /.post -->
                                      </div><!-- /.tab-pane -->
                                      <div class="tab-pane" id="payment">
                                        <!-- Post -->
                                        <div class="post">
                                        
                                        <form action="" method="post" name="theBidderFormAdd2" id="theBidderFormAdd2">
                                                    <div id="popupWindowBidderAdd2">
                                                   		 <div>
                                                                    Add Record</div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                        Payment Date:</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='inputField' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Ref No:</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='inputField' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Payment Amount:</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='inputField' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>                                                                    
                                                                    <div style='margin-top:5px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="Save" value="Save" /><input id="Cancel" type="button" value="Cancel" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>	                                        
                                            <div id="jqxgrid2">
        
                                            </div>
                                        </div><!-- /.post -->
                                      </div><!-- /.tab-pane -->
                    
                                      <div class="tab-pane" id="settings">
                                        <!-- Post -->
                                        <div class="post">
                                        
                                        <form action="" method="post" name="theBidderFormAdd3" id="theBidderFormAdd3">
                                                    <div id="popupWindowBidderAdd3">
                                                   		 <div>
                                                                    Add Record</div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                        Progress Date:</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='inputField' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Ref No:</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='inputField' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Remark:</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='inputField' type="text" class="jqx-input" style="width: 200px; height: 53px;" />
                                                                    </div>                                                                    
                                                                    <div style='margin-top:5px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="Save" value="Save" /><input id="Cancel" type="button" value="Cancel" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>	                                        
                                            <div id="jqxgrid3">
        
                                            </div>
                                        </div><!-- /.post -->
                                      </div><!-- /.tab-pane -->
                                    </div><!-- /.tab-content -->
                                  </div><!-- /.nav-tabs-custom -->
                                </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
	
                  </div><!-- /.box-footer -->
               	
              </div><!-- /.box -->

				
<?php } ?>

<?php
function getCustomerDetailForm($id,$displayMsg)
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

	
  $sql = "SELECT *
          FROM customer
          WHERE customer_id = $id
         ";
  $result = dbQuery($sql);
  if(dbNumRows($result)==1)
  {
    $row=dbFetchAssoc($result);
    
		$customer_name = $row[customer_name];
		$customer_name3 = $row[customer_name3];
		$customer_code = $row[customer_code];
		$customer_parent_code = $row[customer_parent_code];
		$reg_no = $row[reg_no];
		$gst_no = $row[gst_no];

		$customer_type_id = $row[customer_type_id];
		$address1 = $row[address1];
		$address2 = $row[address2];
		$address3 = $row[address3];
		$address4 = $row[address4];
		$address5 = $row[address5];
		$city = $row[city];
		$state = $row[state];
		$postcode = $row[postcode];
		$country = $row[country];
		$tel = $row[tel];
		$fax = $row[fax];
		$remark = $row[remark];
		$duty_check = $row[duty_check];

		$contact_person  = $row['contact_person'];
		$email  = $row['email'];
		$sales_id  = $row['sales_id'];
		$tmb_name  = $row['user_tmb_name'];
		$cust_region_id  = $row['cust_region_id'];
		
		//$tmb_sw  = $row['tmb_sw'];


	
?>
<script type="text/javascript">
$(document).ready(function () {
				
				var customer_type_id = '<?php echo $customer_type_id; ?>';
				
				if(customer_type_id == 2)
				{
						document.getElementById('customer_type_id1').checked = false;
						document.getElementById('customer_type_id2').checked = true;				
				}
				else
				{
						document.getElementById('customer_type_id1').checked = true;
						document.getElementById('customer_type_id2').checked = false;				
				}


});
</script>
											 
				<!--=== Page Content ===-->
				<!--=== Full Size Inputs ===-->
				<form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
				<div class="row">
					<div class="col-md-12">				
							<div class="widget box">
								<div class="widget-header" >	
								<h4><i class="icon-reorder"></i> Customer/Vendor </h4>	
										<div style="float: right;">			
												
				              <?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'delete_sw')){ ?>
                      <input name="buttonDelete" type="button" class="btn btn-primary" id="buttonDelete" value="Delete" onclick="document.theForm.action='info_inc.php?action=delete&amp;id=<?php echo $id; ?>'" />
                      <?php } ?>
                      <?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        <input type="button" value="Update" id="buttonAdd" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=update&id=<?php echo $id; ?>'"/>
				
				<?php } ?>
									</div>
								</div>

								<div class="widget-content">
									
									<div class="form-group">

											<label class="col-md-2 control-label"> Type:</label>
											<div class="col-md-4">
											  <input name="customer_type_id" id="customer_type_id1" type="radio" value="1"/>
											Customer 
											<input name="customer_type_id" id="customer_type_id2" type="radio" value="2" />
											Vendor</div>
											
											
										</div>
																				
											<div class="form-group">
										
											<label class="col-md-2 control-label">Name 1:</label>
											<div class="col-md-9">
												<input name="customer_name" type="text" class="form-control" id="customer_name" value="<?php echo $customer_name; ?>" />
											</div>

											<label class="col-md-2 control-label">Name 3 (Trading Name):</label>
											<div class="col-md-9">
												<input name="customer_name3" type="text" class="form-control" id="customer_name3" value="<?php echo $customer_name3; ?>" />
											</div>
																																
											<label class="col-md-2 control-label">Customer/Vendor No:</label>
											<div class="col-md-2">
												<input type="text" name="customer_code" id="customer_code" value="<?php echo $customer_code; ?>" class="form-control" />
											</div>
											<label class="col-md-2 control-label">Duty Check:</label>
											<div class="col-md-1">
												<input type="text" name="duty_check" id="duty_check" value="<?php echo $duty_check; ?>" class="form-control" />
											</div>											
											<label class="col-md-2 control-label">Link to parent :</label>
											<div class="col-md-2">
												<input type="text" name="customer_parent_code" id="customer_parent_code" value="<?php echo $customer_parent_code; ?>" class="form-control" />
											</div>																		
								</div>
								<div class="form-group">
											<label class="col-md-2 control-label">Street 1:</label>
											<div class="col-md-9">
												<input name="address1" type="text" class="form-control" id="address1" value="<?php echo $address1; ?>" />
											</div>
								</div>
								<div class="form-group">			
											<label class="col-md-2 control-label">Street 2:</label>
											<div class="col-md-9">
												<input name="address2" type="text" class="form-control" id="address2" value="<?php echo $address2; ?>" />
											</div>

											<label class="col-md-2 control-label">Street 3:</label>
											<div class="col-md-9">
												<input name="address3" type="text" class="form-control" id="address3" value="<?php echo $address3; ?>" />
											</div>

											<label class="col-md-2 control-label">Street 4:</label>
											<div class="col-md-9">
												<input name="address4" type="text" class="form-control" id="address4" value="<?php echo $address4; ?>" />
											</div>
										
											<label class="col-md-2 control-label">Street 5:</label>
											<div class="col-md-9">
												<input name="address5" type="text" class="form-control" id="address5" value="<?php echo $address5; ?>" />
											</div>																																	
											
											<label class="col-md-2 control-label">PostCode :</label>
											<div class="col-md-2">
												<input type="text" name="postcode" id="postcode" value="<?php echo $postcode; ?>" class="form-control" />
											</div>
											<label class="col-md-2 control-label">City :</label>
											<div class="col-md-2">
												<input type="text" name="city" id="city" value="<?php echo $city; ?>" class="form-control" />
											</div>																		
											<label class="col-md-1 control-label">Region :</label>
											<div class="col-md-2">
												<input name="state" type="text" class="form-control" id="state" value="<?php echo $state; ?>" />
											</div>	
																					
	
											<label class="col-md-2 control-label">Country :</label>
											<div class="col-md-2">
												<input type="text" name="country" id="country" value="<?php echo $country; ?>" class="form-control" />
											</div>
											<label class="col-md-2 control-label">Tel :</label>
											<div class="col-md-2">
												<input type="text" name="tel" id="tel" value="<?php echo $tel; ?>" class="form-control" />
											</div>																		
											<label class="col-md-1 control-label">Fax :</label>
											<div class="col-md-2">
												<input name="fax" type="text" class="form-control" id="fax" value="<?php echo $fax; ?>" />
											</div>	
												
												
										</div>

									<div class="form-group">
											<label class="col-md-2 control-label">Sales Person (TMB Name):</label>
											<div class="col-md-2">
											  <input name="tmb_name" type="text" class="form-control" id="tmb_name" value="<?php echo $tmb_name; ?>" />
											</div>
											<label class="col-md-2 control-label">Region ID:</label>
											<div class="col-md-2">
											  <input name="cust_region_id" type="text" class="form-control" id="cust_region_id" value="<?php echo $cust_region_id; ?>" />
											</div>											
									</div>							
																			
										<div class="form-group">						

											<label class="col-md-2 control-label">Remark :</label>
											<div class="col-md-9">
												<textarea name="remark" class="form-control" id="remark"><?php echo $remark; ?></textarea>
											</div>
	
											
																																										
																			
										</div>
										
										
							
									
								</div>
							</div>
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
		echo addCustomerForm();
	}

} //end of getUserDetailForm 

function showCustomerList()
{

?>
<script type="text/javascript">

$(document).ready(function () {

		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'pkg_id'},
				{ name: 'pkg_name', type: 'string'},
				{ name: 'pkg_price', type: 'string'},
				{ name: 'pkg_price_west', type: 'string'},
				{ name: 'product_qty', type: 'string'},
				{ name: 'sponsor_bonus', type: 'string'},
				{ name: 'max_daily_point', type: 'string'},
				{ name: 'stockist_commission', type: 'string'},
				{ name: 'pkg_point', type: 'string'}			
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
				{ text: 'Package Name', editable: false, datafield: 'pkg_name', width: 130 },
				{ text: 'Package Price', editable: false, datafield: 'pkg_price', width: 120 },
				{ text: 'Package Price (West)', editable: false, datafield: 'pkg_price_west', width: 150 },
				{ text: 'Product Qty', editable: false, datafield: 'product_qty', width: 100 },
				{ text: 'Package Point', editable: false, datafield: 'pkg_point', width: 120 },
				{ text: 'Sponsor Bonus',editable: false, datafield: 'sponsor_bonus', width: 120 },
				{ text: 'Max Daily Point', editable: false, datafield: 'max_daily_point', width: 120 },
				{ text: 'Stockist Commission', editable: false, datafield: 'stockist_commission', width: 160 }
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