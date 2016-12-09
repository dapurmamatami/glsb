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
        						<input type="button" value="Add" id="buttonAdd" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=add'"/>
	                  <?php } ?>
										</div>
                         </div>                       
                                  <div class="nav-tabs-custom">
                      
                                    <ul class="nav nav-tabs">
                                      <li class="active"><a href="#detail" data-toggle="tab">Worker Details</a></li>	                                       
                                    </ul>
                        
                                    <div class="tab-content">
                                    
                                      <div class="active tab-pane" id="detail">
                                          <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Worker Name</label>
                                            <div class="col-sm-4">
                                              <input type="text" class="form-control" id="worker_name" >
                                            </div>
                                            
                                             <label for="inputName" class="col-sm-1 control-label">Nationality</label>
                                            <div class="col-sm-2">
                                              <select name='country_id' id='country_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM country
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[country_id]==$country_id){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[country_id]' $cSelect>$row[country_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>              
                                            <label for="inputName" class="col-sm-1 control-label">Join Date</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="join_date" value="<?php echo date('d-m-Y'); ?>">
                                            </div> 
                                            
                                                                                                                      
                                          </div>
                                          
                                           <div class="form-group">
                                           
                                           <label for="inputName" class="col-sm-2 control-label">Status</label>
                                            <div class="col-sm-2">
                                              <select name='status_id' id='status_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM worker_status
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
                                            
                                              <label for="inputEmail" class="col-sm-3 control-label">Permit</label>
                                            <div class="col-sm-2">
                                              <input name="permit_sw" id="permit_sw" type="radio" value="0" checked="checked" />
											No &nbsp;&nbsp;&nbsp;&nbsp;
											<input name="permit_sw" id="permit_sw" type="radio" value="1" /> 
											Yes
                                            </div>    
                                            
                                             <label for="inputEmail" class="col-sm-1 control-label">Permit Expired</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="permit_expiry_date" />
                                            </div>          
                                           </div>
                                                                                  
                                           <div class="form-group">
                                           
                                           <label for="inputName" class="col-sm-2 control-label">Bank Name</label>
                                            <div class="col-sm-2">
                                              <select name='bank_id' id='bank_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM bank
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[bank_id]==$bank_id){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[bank_id]' $cSelect>$row[bank_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>  
                                            
                                            <label for="inputEmail" class="col-sm-3 control-label">Bank Account Number</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="bank_account_no" >
                                            </div>
                                             <label for="inputExperience" class="col-sm-1 control-label">Daily Rate</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="daily_rate" >
                                            </div>
                                          
                                                                                   
                                          </div>
                                                                                                                         
                                          <div class="form-group">
                                            <label for="inputExperience" class="col-sm-2 control-label">Remark</label>
                                            <div class="col-sm-10">
                                              <textarea class="form-control" id="remark"></textarea>
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


<?php } //end of fuction add ?>



<?php
function getDetailForm($id,$displayMsg)
{
	
  $data = getWorkerDetail($id);
	
	 
		if ($data != ""){
	
?>


<script type="text/javascript">

$(document).ready(function () {    
          
	$('input:radio[name=permit_sw]:nth(<?php echo $data['permit_sw']; ?>)').attr('checked',true);  


			var id = '<?php echo $_GET['id']; ?>';
			// another jqxgrid
			var source =
			{
				datatype: "json",
				datafields: [
					{ name: 'history_id'},
					{ name: 'request_amount', type: 'string'},						
					{ name: 'request_by', type: 'string'},			
				],
				
				cache: false,
				url: 'dataWorkerWages.php?id=' + id,
				filter: function()
				{
					// update the grid and send a request to the server.
					$("#jqxgrid-WorkerWages").jqxGrid('updatebounddata', 'filter');
				},
				sort: function()
				{
					// update the grid and send a request to the server.
					$("#jqxgrid-WorkerWages").jqxGrid('updatebounddata', 'sort');
				},
				root: 'Rows',
				pagesize: 150,
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
	
				
			$("#jqxgrid-WorkerWages").jqxGrid(
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
                        var offset = $("#jqxgrid-WorkerWages").offset();
                        $("#popupWindowWorkerWagesAdd").jqxWindow('open');
                        $("#popupWindowWorkerWagesAdd").jqxWindow('move', offset.left + 30, offset.top + 30);
                    });									
				},			
				<?php } ?>					
				columns: [
					<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
		   			{ text: '', datafield: 'Edit', columntype: 'button',pinned: true , width: 40, cellsrenderer: function () {
						 return "Edit";
					  }, buttonclick: function (row) {
						 // open the popup window when the user clicks a button.
											
						 editrow = row;
						 var offset = $("#jqxgrid-WorkerWages").offset();
						 //$("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 60, y: parseInt(offset.top) + 60 } });
						 // get the clicked row's data and initialize the input fields.
						 var dataRecord = $("#jqxgrid-WorkerWages").jqxGrid('getrowdata', editrow);
						 $("#history_id").val(dataRecord.history_id);
						 $("#request_amount").val(dataRecord.request_amount);
						 $("#request_by").val(dataRecord.request_by);
	
						 // show the popup window.
						 $("#popupWindowWorkerWagesDetail").jqxWindow('open');
						 $("#popupWindowWorkerWagesDetail").jqxWindow('move', offset.left + 30, offset.top + 30);
					 }
					},		
					<?php } ?>
					
					<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'delete_sw')){ ?>
 				{ text: '',width: 30, datafield: 'Delete', columntype: 'button',pinned: true , cellsrenderer: function () {
                     return "X";
                 }, buttonclick: function (row) {


								var agree=confirm("Are you sure you want to remove this record?");

								if (agree)
								{

                     editrow = row;                    
                     var dataRecord = $("#jqxgrid-WorkerWages").jqxGrid('getrowdata', editrow);
											
											var form_data = {
												//id: $("#id").val(),
												history_id: dataRecord.history_id,
												is_ajax: 1
											};
												
												$.ajax({
													type: "POST",
													url: "info_inc.php?action=deleteWorkerWagesHistory&id="+id,
													data: form_data,
													dataType: "json",  
													
													success: function(response) {
													
														var id = response["id"];
														var success = response["success"];
														var displayMsg = response["displayMsg"];
														
														if (success == '1') {
															window.location.href = "index.php?view=detail&id="+id;
														}
														else {

					
															document.getElementById("errMsg").innerHTML=displayMsg;
															document.getElementById("displayMsg").innerHTML="";
															
															setTimeout(function() {
																$("#displayMsg").fadeOut().empty();
															}, 100);
															
														}
														
													
													
													}
													   
													
												});        
									}
									else
									{
										return false;
									}
             }
        },				
				<?php } ?>																	 
					{ text: 'Request by', editable: false, datafield: 'request_by', width: 250 },
					{ text: 'Request Amount', editable: false, datafield: 'request_amount', width: 250 },
				]
			});  


            // create jqxWindow.
            $("#popupWindowWorkerWagesAdd").jqxWindow({ resizable: false,  autoOpen: false, width: 210, height: 280,cancelButton: $("#Cancel"), });
			$("#popupWindowWorkerWagesDetail").jqxWindow({ resizable: false,  autoOpen: false, width: 210, height: 280,cancelButton: $("#Cancel"), });
						
});

</script>               
              <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
              <div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                     
                                  <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                      <li class="active"><a href="#detail" data-toggle="tab">Worker Details</a></li>
                                      <li><a href="#worker_wages" data-toggle="tab">Worker Wages</a></li>	
                                   
                                    </ul>
                                    
                                    <div class="tab-content">
                                    
                                      <div class="active tab-pane" id="detail">
                                      
                                        <div class="box-header with-border">
                                          <h3 class="box-title"></h3> 	
                                                        <div style="float: right;">								
                                                        <?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
                                                        <input type="button" value="Approve" id="buttonApprove" class="btn btn-primary" onclick="document.theForm.action='info_inc.php?action=approve&status_id=1&amp;id=<?php echo $id; ?>'"/>
<input type="button" value="Update" id="buttonUpdate" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=update&id=<?php echo $id; ?>'"/>
                                      <?php } ?>
                                                        <?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
                                                <input type="button" value="Delete" id="buttonDelete" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=delete&id=<?php echo $id; ?>'"/>
                                      <?php } ?>                      
                                          </div>
                                        </div>  

                                          <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Worker ID</label>
                                            <div class="col-sm-3">
                                              <?php echo $data['worker_id']; ?>
                                              
                                            </div>				                          
                                          </div>                                      
                                          <div class="form-group">
                                           <label for="inputName" class="col-sm-2 control-label">Worker Name</label>
                                            <div class="col-sm-4">
                                              <input type="text" class="form-control" id="worker_name" value="<?php echo $data['worker_name']; ?>" >
                                            </div>
                                            
                                             <label for="inputName" class="col-sm-1 control-label">Nationality</label>
                                            <div class="col-sm-2">
                                              <select name='country_id' id='country_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM country
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[country_id]==$data['country_id']){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[country_id]' $cSelect>$row[country_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>              
                                            <label for="inputName" class="col-sm-1 control-label">Join Date</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="join_date" value="<?php echo ($data['join_date'] != "") ? "" . date("d-m-Y", strtotime($data['join_date'])) . "" : ''; ?>">
                                            </div>                                                                                     
                                          </div>
                                          <div class="form-group">
                                          
                                           <label for="inputName" class="col-sm-2 control-label">Status</label>
                                            <div class="col-sm-2">
                                              <select name='status_id' id='status_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM worker_status
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[status_id]==$data['status_id']){
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
                                            
                                              <label for="inputEmail" class="col-sm-3 control-label">Permit</label>
                                            <div class="col-sm-2">
                                              <input name="permit_sw" id="permit_sw" type="radio" value="0" checked="checked" />
											No &nbsp;&nbsp;&nbsp;
											<input name="permit_sw" id="permit_sw" type="radio" value="1" /> 
											Yes
                                            </div>    
                                            
                                             <label for="inputEmail" class="col-sm-1 control-label">Permit Expired</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="permit_expiry_date" value="<?php echo ($data['permit_expiry_date'] != "") ? "" . date("d-m-Y", strtotime($data['permit_expiry_date'])) . "" : ''; ?>">
                                            </div>          
                                                                                  
                                          </div>



                                       	  <div class="form-group">
                                           <label for="inputName" class="col-sm-2 control-label">Bank Name</label>
                                            <div class="col-sm-2">
                                              <select name='bank_id' id='bank_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM bank
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[bank_id]==$data['bank_id']){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[bank_id]' $cSelect>$row[bank_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>  
                                            
                                            <label for="inputEmail" class="col-sm-3 control-label">Bank Account Number</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="bank_account_no" value="<?php echo $data['bank_account_no']; ?>" >
                                            </div>
                                             <label for="inputExperience" class="col-sm-1 control-label">Daily Rate</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="daily_rate" value="<?php echo $data['daily_rate']; ?>" >
                                            </div>
                                          </div>
                                                                                                              
                                          <div class="form-group">
                                            <label for="inputExperience" class="col-sm-2 control-label">Remark</label>
                                            <div class="col-sm-10">
                                              <textarea class="form-control" id="remark"><?php echo $data['remark']; ?></textarea>
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label for="inputExperience" class="col-sm-2 control-label">Picture</label>
                                            <div class="col-sm-2">
                                              <input type="button" value="Upload" id="buttonUpload" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=upload&id=<?php echo $id; ?>'"/>
                                            </div>
                                          </div>
                                                                             
                                      </div><!-- /.tab-pane -->
                                       
                                      <div class="tab-pane" id="worker_wages">
                                        <!-- Post -->
                                        <div class="post">
                                        
                                         <div id="jqxgrid-WorkerWages">
        
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
		      </form>
              
              
<script type="text/javascript">

$(document).ready(function () {


			//$('#purchase_date').datepicker({ dateFormat: 'dd-mm-yy' });      

            $('#buttonWorkerWagesAdd').on('click', function () {
                $('#theWorkerWagesFormAdd').jqxValidator('validate');
            });
			
            // initialize validator.
            $('#theWorkerWagesFormAdd').jqxValidator({
                rules: [
						 { input: '#request_amount_add', message: 'Required', action: 'keyup, blur', rule: 'required' },
									   
					   ]
            });
			
			//validate success & submit				
			$('#theWorkerWagesFormAdd').bind('validationSuccess', function (event) { 
					
			var action = $("#theWorkerWagesFormAdd").attr('action');
							
			var form_data = {
				request_amount: $("#request_amount_add").val(),
				request_by: $("#request_by_add").val(),

				is_ajax: 1
			};
				
				$.ajax({
					type: "POST",
					url: action,
					data: form_data,
					dataType: "json",
					
					success: function(response) {
					
						var id = response["id"];
						var success = response["success"];
						var displayMsg = response["displayMsg"];
		
			
						if (success == 1) {
						
							
							window.location.href = "index.php?view=detail&id="+id+'&displayMsg='+displayMsg;
		
						} else {
		
							
							document.getElementById("errMsg").innerHTML=displayMsg;
							document.getElementById("errMsg").innerHTML='<div class="alert alert-danger fade in" >' + displayMsg + '</div>';
							document.getElementById("displayMsg").innerHTML="";
							
							setTimeout(function() {
								$("#displayMsg").fadeOut().empty();
							}, 100);
							
						}
					}
				});
			
			}); 
			//end of validate sucess and submit		
			
 			$('#buttonWorkerWagesDetailUpdate').on('click', function () {
                $('#theWorkerWagesDetailFormUpdate').jqxValidator('validate');
            });
			
            // initialize validator.
            $('#theWorkerWagesDetailFormUpdate').jqxValidator({
                rules: [
						 { input: '#request_amount', message: 'Required', action: 'keyup, blur', rule: 'required' },
									   
					   ]
            });
			
			//validate success & submit				
			$('#theWorkerWagesDetailFormUpdate').bind('validationSuccess', function (event) { 
					
			var action = $("#theWorkerWagesDetailFormUpdate").attr('action');
							
			var form_data = {
				request_amount: $("#request_amount").val(),
				request_by: $("#request_by").val(),
				history_id: $("#history_id").val(),

				is_ajax: 1
			};
				
				$.ajax({
					type: "POST",
					url: action,
					data: form_data,
					dataType: "json",
					
					success: function(response) {
					
						var id = response["id"];
						var success = response["success"];
						var displayMsg = response["displayMsg"];
		
			
						if (success == 1) {
						
							
							//window.location.href = "index.php?view=detail&id="+id+'&displayMsg='+displayMsg;
							window.location.href = "index.php?view=detail&id="+id;
							
		
						} else {
		
							
							document.getElementById("errMsg").innerHTML=displayMsg;
							document.getElementById("errMsg").innerHTML='<div class="alert alert-danger fade in" >' + displayMsg + '</div>';
							document.getElementById("displayMsg").innerHTML="";
							
							setTimeout(function() {
								$("#displayMsg").fadeOut().empty();
							}, 100);
							
						}
					}
				});
			
			}); 
			//end of validate sucess and submit					
}); 
			
</script>

 										<div class="tab-pane" id="worker_wages">
                                        <!-- Post -->
                                        <div class="post">
                                        
                                        <form action="" method="post" name="theWorkerWagesFormAdd" id="theWorkerWagesFormAdd">
                                                    <div id="popupWindowWorkerWagesAdd">
                                                   		 <div>
                                                                    Add Record</div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                        Request Amount:</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='request_amount_add' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Request by:</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='request_by_add' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                                                                                   
                                                                    <div style='margin-top:5px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonWorkerWagesAdd" value="Add" onclick="document.theWorkerWagesFormAdd.action='info_inc.php?action=addWagesHistory&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="Cancel" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>	
                                        
                                        <form action="" method="post" name="theWorkerWagesDetailFormUpdate" id="theWorkerWagesDetailFormUpdate">
                                                    <div id="popupWindowWorkerWagesDetail">
                                                   		 <div>
                                                                    Add Record</div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                        Request Amount:</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='request_amount' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Request by:</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='request_by' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    
                                                                    <input id='history_id' type="hidden" class="jqx-input" style="width: 200px; height: 23px;" />                                                               
                                                                    <div style='margin-top:5px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonWorkerWagesDetailUpdate" value="Update" onclick="document.theWorkerWagesDetailFormUpdate.action='info_inc.php?action=updateDetailWorkerWagesHistory&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="Cancel" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>	                                                                                                      
                                             <div id="jqxgrid-WorkerWages">
        
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
                                                    
<?php 
}
		else 
		{
	 		"No Record Found";
		}
	
}
	
?>

<?php

function showList()
{

?>
<script type="text/javascript">

$(document).ready(function () {
		
		status_id = '<?php echo $_GET[status_id]; ?>';
		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'worker_id', type: 'string'},
				{ name: 'worker_id2', type: 'string'},
				{ name: 'worker_name', type: 'string'},
				{ name: 'status_name', type: 'string'},
				{ name: 'remark', type: 'string'},
				{ name: 'daily_rate', type: 'string'}
			],
			
			cache: false,
			url: 'data.php?status_id='+status_id,
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
				{ text: '', editable: false, datafield: 'worker_id', width: 80 ,cellsrenderer: linkrenderer},
				{ text: 'Worker ID', editable: false, datafield: 'worker_id2', width: 100 },
				{ text: 'Worker Name', editable: false, datafield: 'worker_name', width: 250 },
				{ text: 'Status',editable: false, datafield: 'status_name', width: 100 },
				{ text: 'Daily Rate',editable: false, datafield: 'daily_rate', width: 100 },
				{ text: 'Remark',editable: false, datafield: 'remark', width: 250 },
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

<?php

function showExpiryList()
{

?>
<script type="text/javascript">

$(document).ready(function () {
		
		status_id = '<?php echo $_GET[status_id]; ?>';
		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'worker_id', type: 'string'},
				{ name: 'worker_id2', type: 'string'},
				{ name: 'worker_name', type: 'string'},
				{ name: 'permit_expiry_date', type: 'string'},
				{ name: 'join_date', type: 'string'},
			],
			
			cache: false,
			url: 'dataExpiry.php?status_id='+status_id,
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
				{ text: '', editable: false, datafield: 'worker_id', width: 80 ,cellsrenderer: linkrenderer},
				{ text: 'Worker ID', editable: false, datafield: 'worker_id2', width: 100 },
				{ text: 'Worker Name', editable: false, datafield: 'worker_name', width: 250 },
				{ text: 'Join Date',editable: false, datafield: 'join_date', width: 100 },
				{ text: 'Permit Expired',editable: false, datafield: 'permit_expiry_date', width: 150 },
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