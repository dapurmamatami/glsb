<?php
function addForm()
{
	//$lang_file = 'lang.my.php';
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
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_CODE']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="product_code" >
                                             </div>
                                              
                                            <label for="inputName" class="col-sm-3 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_CATEGORY']; ?></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="product_category">
                                            </div> 
                                          </div>
                                             
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_NAME']; ?></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="product_name" >
                                             </div>
                                              
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_SHORT_NAME']; ?></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="product_short_name">
                                            </div> 
                                          </div>
                                          
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_SELLING_PRICE']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="selling_price">
                                             </div>
                                              
                                            <label for="inputName" class="col-sm-3 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_COST']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="cost_of_good_sold">
                                            </div>
                                          </div>
                                            
                                            
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_BONUS']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="bonus_pool">
                                             </div>
                                             
                                               <label for="inputName" class="col-sm-3 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_PROFIT']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="profit">
                                            </div> 
                                            </div>
                                            
                                             <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_COMM_LEVEL1']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="comm_level1">
                                            </div> 
                                            
                                             <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_COMM_LEVEL2']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="comm_level2">
                                            </div>
                                             
                                             <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_COMM_LEVEL3']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="comm_level3">
                                            </div> 
                                          </div>
                                                                                                                                                             
                                         <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_POINT']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="point_value">
                                            </div> 
                                            
                                             <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_GST']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="gst_rate_type">
                                            </div>
                                             
                                             <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_GST_RATE']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="gst_rate">
                                            </div> 
                                          </div>
                                          
                                          <div class="form-group">
                                             <label for="inputName" class="col-sm-2 control-label">Weight (gram)</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="weight_in_gram">
                                            </div>                                           
                                          </div>
                                          
										  <?php $companySetupData = getCompanySetupDetailForm(1); 
										  		$personal_comm_sw = $companySetupData['personal_comm_sw'];
										  if($personal_comm_sw == 1) { ?>	
								
                                          <div class="form-group">
                                             <label for="inputName" class="col-sm-2 control-label">Personal Commission</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="personal_comm">
                                            </div>                                           
                                          </div>
                                          <?php } else { ?>
                                          	<input type="hidden" class="form-control" id="personal_comm" value="0">
                                          <?php } ?>
                                                                                                                              
                                          <div class="form-group">
                                             <label for="inputName" class="col-sm-2 control-label">Product Description</label>
                                            <div class="col-sm-4">
                                              <textarea class="form-control" id="product_description"></textarea>
                                            </div>                                           
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
 include '../main/lang_default.php';	
 $data = getProductDetail($id);
 	
	
	 
		if ($data != ""){
?>
<script type="text/javascript">

$(document).ready(function () {  
	$('#jqxFileUpload').jqxFileUpload({ width: 300, uploadUrl: 'imageUpload.php?id=<?php echo $_GET['id']; ?>', fileInputName: 'fileToUpload' });

	$('#jqxFileUpload').on('uploadEnd', function (event) {
		//var args = event.args;
		//var fileName = args.file;
	   // alert(fileName);
	   window.location.href = "index.php?view=detail&id=<?php echo $_GET['id']; ?>";
	});  
	
		<?php 
		$setupData = getCompanySetupDetailForm(1);
		$commission_period_sw = $setupData[commission_period_sw];
		
		if($commission_period_sw ==  1) { ?>
		
		var id = '<?php echo $_GET['id']; ?>';
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'rate_id', type: 'string'},
				{ name: 'period_name', type: 'string'},
				{ name: 'p_comm_level1', type: 'string'},
				{ name: 'p_comm_level2', type: 'string'},
				{ name: 'p_comm_level3', type: 'string'},
				{ name: 'p_personal_comm', type: 'string'},
			],
			
			cache: false,
			url: 'dataProductCommRate.php?id=' + id,
			filter: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid-ProductCommRate").jqxGrid('updatebounddata', 'filter');
			},
			sort: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid-ProductCommRate").jqxGrid('updatebounddata', 'sort');
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

			
		$("#jqxgrid-ProductCommRate").jqxGrid(
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
                        var offset = $("#jqxgrid-ProductCommRate").offset();
                        $("#popupWindowSubMaterialAdd").jqxWindow('open');
                        $("#popupWindowSubMaterialAdd").jqxWindow('move', offset.left + 10, offset.top + 20);
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
						 var offset = $("#jqxgrid-ProductCommRate").offset();
						 //$("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 60, y: parseInt(offset.top) + 60 } });
						 // get the clicked row's data and initialize the input fields.
						 var dataRecord = $("#jqxgrid-ProductCommRate").jqxGrid('getrowdata', editrow);
						 $("#rate_id").val(dataRecord.rate_id);
						 $("#period_id").val(dataRecord.period_id);	
						 $("#p_comm_level1").val(dataRecord.p_comm_level1);	
						 $("#p_comm_level2").val(dataRecord.p_comm_level2);
						 $("#p_comm_level3").val(dataRecord.p_comm_level3);
						 $("#p_personal_comm").val(dataRecord.p_personal_comm);

	
						 // show the popup window.
						 $("#popupWindowSubMaterialDetail").jqxWindow('open');
						 $("#popupWindowSubMaterialDetail").jqxWindow('move', offset.left + 30, offset.top + 30);
					 }
					},		
			<?php } ?>	
				{ text: 'Period Name', editable: false, datafield: 'period_name', width: 100 },
				{ text: 'Product Commission Level 1',editable: false, datafield: 'p_comm_level1', width: 200 },
				{ text: 'Product Commission Level 2',editable: false, datafield: 'p_comm_level2', width: 200 },
				{ text: 'Product Commission Level 3',editable: false, datafield: 'p_comm_level3', width: 200 },
				{ text: 'Product Personal Commission',editable: false, datafield: 'p_personal_comm', width: 230 },
			]
		});  
		
			// create jqxWindow.
            $("#popupWindowSubMaterialAdd").jqxWindow({ resizable: false,  autoOpen: false, width: 210, height: 360,cancelButton: $("#Cancel"), });
			$("#popupWindowSubMaterialDetail").jqxWindow({ resizable: false,  autoOpen: false, width: 210, height: 300,cancelButton: $("#Cancel"), }); 						

			//add  
			$('#buttonMaterialEstimateAdd').on('click', function () {
                $('#theMaterialEstimateFormAdd').jqxValidator('validate');
            });
			
            // initialize validator.
            $('#theMaterialEstimateFormAdd').jqxValidator({
                rules: [
						{ input: '#p_comm_level1_add', message: 'Required', action: 'keyup, blur', rule: 'required' },
						{ input: '#p_comm_level2_add', message: 'Required', action: 'keyup, blur', rule: 'required' },
					   ]
            });
			
			//validate success & submit				
			$('#theMaterialEstimateFormAdd').bind('validationSuccess', function (event) { 
					
			
			var action = $("#theMaterialEstimateFormAdd").attr('action');
							
			var form_data = {
				period_id: $("#period_id_add option:selected").val(),
				p_comm_level1: $("#p_comm_level1_add").val(),
				p_comm_level2: $("#p_comm_level2_add").val(),
				p_comm_level3: $("#p_comm_level3_add").val(),
				p_personal_comm: $("#p_personal_comm_add").val(),
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
			
			//update
			$('#buttonSubMaterialUpdate').on('click', function () {
                $('#theSubMaterialDetailFormUpdate').jqxValidator('validate');
            });
			
            // initialize validator.
            $('#theSubMaterialDetailFormUpdate').jqxValidator({
                rules: [
						 { input: '#p_comm_level1', message: 'Required', action: 'keyup, blur', rule: 'required' },
						 { input: '#p_comm_level2', message: 'Required', action: 'keyup, blur', rule: 'required' },
					   ]
            });
			
			//validate success & submit				
			$('#theSubMaterialDetailFormUpdate').bind('validationSuccess', function (event) { 
					
			var action = $("#theSubMaterialDetailFormUpdate").attr('action');
							
			var form_data = {
				rate_id: $("#rate_id").val(),
				p_comm_level1: $("#p_comm_level1").val(),
				p_comm_level2: $("#p_comm_level2").val(),
				p_comm_level3: $("#p_comm_level3").val(),
				p_personal_comm: $("#p_personal_comm").val(),
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
			<?php } ?>	
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
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_CODE']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="product_code" value="<?php echo $data['product_code']; ?>">
                                             </div>
                                              
                                            <label for="inputName" class="col-sm-3 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_CATEGORY']; ?></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="product_category" value="<?php echo $data['product_category']; ?>">
                                            </div> 
                                          </div>
                                             
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_NAME']; ?></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="product_name" value="<?php echo $data['product_name']; ?>">
                                             </div>
                                              
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_SHORT_NAME']; ?></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="product_short_name" value="<?php echo $data['product_short_name']; ?>">
                                            </div> 
                                          </div>
                                          
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_SELLING_PRICE']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="selling_price" value="<?php echo $data['selling_price']; ?>">
                                             </div>
                                              
                                            <label for="inputName" class="col-sm-3 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_COST']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="cost_of_good_sold" value="<?php echo $data['cost_of_good_sold']; ?>">
                                            </div>
                                          </div>
                                            
                                            
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_BONUS']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="bonus_pool" value="<?php echo $data['bonus_pool']; ?>">
                                             </div>
                                             
                                               <label for="inputName" class="col-sm-3 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_PROFIT']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="profit" value="<?php echo $data['profit']; ?>">
                                            </div> 
                                            </div>
                                            
                                             <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_COMM_LEVEL1']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="comm_level1" value="<?php echo $data['comm_level1']; ?>">
                                            </div> 
                                            
                                             <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_COMM_LEVEL2']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="comm_level2" value="<?php echo $data['comm_level2']; ?>">
                                            </div>
                                             
                                             <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_COMM_LEVEL3']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="comm_level3" value="<?php echo $data['comm_level3']; ?>">
                                            </div> 
                                          </div>
                                                                                                                                                             
                                         <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_POINT']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="point_value" value="<?php echo $data['point_value']; ?>">
                                            </div> 
                                            
                                             <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_GST']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="gst_rate_type" value="<?php echo $data['gst_rate_type']; ?>">
                                            </div>
                                             
                                             <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_PRODUCT_PRODUCT_GST_RATE']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="gst_rate" value="<?php echo $data['gst_rate']; ?>">
                                            </div> 
                                          </div>
										
                                          <div class="form-group">
                                             <label for="inputName" class="col-sm-2 control-label">Weight (gram)</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="weight_in_gram" value="<?php echo $data['weight_in_gram']; ?>">
                                          </div>
                                          </div>
    
    									  <?php $companySetupData = getCompanySetupDetailForm(1); 
										  		$personal_comm_sw = $companySetupData['personal_comm_sw'];
										  if($personal_comm_sw == 1) { ?>	
								
                                          <div class="form-group">
                                             <label for="inputName" class="col-sm-2 control-label">Personal Commission</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="personal_comm" value="<?php echo $data['personal_comm']; ?>">
                                            </div>                                           
                                          </div>
                                          <?php } else { ?>
                                          	<input type="hidden" class="form-control" id="personal_comm" value="0">
                                          <?php } ?>
                                                                                
                                          <div class="form-group">
                                             <label for="inputName" class="col-sm-2 control-label">Product Description</label>
                                            <div class="col-sm-4">
                                              <textarea class="form-control" id="product_description"><?php echo $data['product_description']; ?></textarea>
                                            </div>                                           
                                          </div>
                                     </form>     
                                     </div><!-- /.tab-pane -->
                                     <?php if($commission_period_sw ==  1) { ?>
                                     ADD PRODUCT COMMISSION RATE
                                     <form action="" method="post" name="theMaterialEstimateFormAdd" id="theMaterialEstimateFormAdd">
                                                    <div id="popupWindowSubMaterialAdd">
                                                   		 <div>
                                                                    Add Record</div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                    	Period Name:</div>
                                                                    <div style='margin-top:7px;'>
                                                                    	<select id="period_id_add" name="period_name" class="form-control">
                                                                        <?php
																		$sql = "SELECT * FROM commission_period where period_id not in (select period_id from product_comm_rate where product_id = $id) ";
																		
																		$result=dbQuery($sql);												
																				
																		if(dbNumRows($result)>0)
																		{
																			while($row=dbFetchAssoc($result))
																			{
																				if($row[period_id]==$period_id)
																				{
																					$cSelect="SELECTED";
																				}
																				else
																				{
																					$cSelect="";
																				}
																					echo "<option value='$row[period_id]' $cSelect>$row[period_name]</option>"; 
																			}
																		}
																		?>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div style="margin-top: 5px; clear: both;">
                                                                        Product Commission Level 1:</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='p_comm_level1_add' name='p_comm_level1' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Product Commission Level 2:</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='p_comm_level2_add' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Product Commission Level 3:</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='p_comm_level3_add' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Product Personal Commission:</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='p_personal_comm_add' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                                           
                                                                    <div style='margin-top:5px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonMaterialEstimateAdd" value="Add" onclick="document.theMaterialEstimateFormAdd.action='info_inc.php?action=addProductCommRate&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="Cancel" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>	
                                        
                                     <form action="" method="post" name="theSubMaterialDetailFormUpdate" id="theSubMaterialDetailFormUpdate">
                                                    <div id="popupWindowSubMaterialDetail">
                                                   		 <div>
                                                                    Add Record</div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                        Product Commission Level 1:</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='p_comm_level1' name='p_comm_level1' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Product Commission Level 2:</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='p_comm_level2' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Product Commission Level 3:</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='p_comm_level3' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Product Personal Commission:</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='p_personal_comm' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    
                                                                    <input id='rate_id' type="hidden" class="jqx-input" style="width: 200px; height: 23px;" /> 
                                                                                          
                                                                    <div style='margin-top:5px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonSubMaterialUpdate" value="Update" onclick="document.theSubMaterialDetailFormUpdate.action='info_inc.php?action=updateProductCommRate&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="Cancel" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>     
             							<div id="jqxgrid-ProductCommRate"></div>
                                        <?php } ?>
                                    </div><!-- /.tab-content -->
                                  </div>
                                  <!-- /.nav-tabs-custom -->
                                </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
	
                  </div><!-- /.box-footer -->
               	
              </div><!-- /.box -->
		      </form>	
				<div id="jqxFileUpload"></div> 
				<?php if($data['file_name'] != '') { ?>
                <img src="<?php echo $data['file_name']; ?>"/>
                <?php } ?>      
		      


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
				{ name: 'product_id', type: 'string'},
				{ name: 'product_code', type: 'string'},
				{ name: 'product_category', type: 'string'},
				{ name: 'product_name', type: 'string'},
				{ name: 'product_short_name', type: 'string'},
				{ name: 'selling_price', type: 'string'},
				{ name: 'profit', type: 'string'},
				{ name: 'point_value', type: 'string'},
				{ name: 'profit_percentage', type: 'string'},
				{ name: 'balance', type: 'string'},
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
				{ text: '', editable: false, datafield: 'product_id', width: 80 ,cellsrenderer: linkrenderer},
				{ text: '<?php echo $lang['NEW_PRODUCT_PRODUCT_CODE']; ?>', editable: false, datafield: 'product_code', width: 100 },
				{ text: '<?php echo $lang['NEW_PRODUCT_PRODUCT_CATEGORY']; ?>',editable: false, datafield: 'product_category', width: 150 },
				{ text: '<?php echo $lang['NEW_PRODUCT_PRODUCT_NAME']; ?>',editable: false, datafield: 'product_name', width: 150 },
				{ text: '<?php echo $lang['NEW_PRODUCT_PRODUCT_SHORT_NAME']; ?>', editable: false, datafield: 'product_short_name', width: 150 },
				{ text: '<?php echo $lang['NEW_PRODUCT_PRODUCT_SELLING_PRICE']; ?>',editable: false, datafield: 'selling_price', width: 100 },
				{ text: 'PV',editable: false, datafield: 'point_value', width: 70 },
				{ text: 'Profit RM',editable: false, datafield: 'profit', width: 70 },
				{ text: 'Profit %',editable: false, datafield: 'profit_percentage', width: 100, cellsformat: 'c2' },
				{ text: 'Stock Available',editable: false, datafield: 'balance', width: 150 },
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