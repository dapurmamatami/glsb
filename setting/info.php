<?php
function getDetailForm($id)
{
	include '../main/lang_default.php';
		
	$data = getEmailSettingDetailForm($id);
	
	 
		if ($data != ""){
?>
  
              <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
              <div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                       
                                  <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                    </ul>
                                    
                                    <div class="tab-content">
                                    
                                      <div class="active tab-pane" id="detail">
                                      
							 <div class="box-header with-border">
                          <h3 class="box-title"></h3> 	
										<div style="float: right;">								
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        						<input type="button" value="<?php echo $lang['BUTTON_UPDATE']; ?>" id="buttonUpdate" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=updateEmail&id=<?php echo $id; ?>'"/>
	                  <?php } ?>
								                    
										</div>
                         </div>                                                             
                                      
                                      		<div class="form-group">
                                            </div>
                                        
                                        	<div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_EMAIL_SETTING_HOST_NAME']; ?></label>
                                            <div class="col-sm-4">
                                              <input type="text" class="form-control" id="host_name" value="<?php echo $data['host_name']; ?>">
                                             </div>
                                             </div>
                                            <div class="form-group">  
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_EMAIL_SETTING_HOST_USER_NAME']; ?></label>
                                            <div class="col-sm-4">
                                              <input type="text" class="form-control" id="host_user_name" value="<?php echo $data['host_user_name']; ?>">
                                            </div> 
                                            </div>
                                            <div class="form-group">  
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_EMAIL_SETTING_HOST_PASSWORD']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="password" class="form-control" id="host_password" value="<?php echo $data['host_password']; ?>">
                                            </div> 
                                          </div>
                                             
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_EMAIL_SETTING_HOST_PORT']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="host_port" value="<?php echo $data['host_port']; ?>">
                                             </div>
                                          </div>
                                          
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_EMAIL_SETTING_HOST_MAIL_FROM']; ?></label>
                                            <div class="col-sm-4">
                                              <input type="text" class="form-control" id="host_mail_from" value="<?php echo $data['host_mail_from']; ?>">
                                             </div>
                                             </div>
                                             <div class="form-group"> 
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_EMAIL_SETTING_HOST_MAIL_FROM']; ?></label>
                                            <div class="col-sm-4">
                                              <input type="text" class="form-control" id="host_mail_from_name" value="<?php echo $data['host_mail_from_name']; ?>">
                                            </div>
                                           	</div>
                                             <div class="form-group">
                                             <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_EMAIL_SETTING_NOTIFY_SEND_TO']; ?></label>
                                            <div class="col-sm-4">
                                              <input type="text" class="form-control" id="notify_send_to" value="<?php echo $data['notify_send_to']; ?>">
                                            </div>
                                          </div>
                                      </div><!-- /.tab-pane -->

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


<?php }
else {
	echo 'No Record Found';
	}
	
}
	
?>

<?php

function DeliveryChargeSettingForm()
{
include '../main/lang_default.php';
?>
<script type="text/javascript">			

$(document).ready(function () {
		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'delivery_charge_id', type: 'string'},
				{ name: 'weight_from_gram', type: 'string'},
				{ name: 'weight_to_gram', type: 'string'},
				{ name: 'delivery_charge', type: 'string'},
			],
			
			cache: false,
			url: 'dataDeliveryCharge.php',
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
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'><?php echo $lang['BUTTON_ADD']; ?></span></div>");
                    container.append(addButton);
                    statusbar.append(container);	
					addButton.jqxButton({  width: 60, height: 20 });
                    addButton.click(function (event) {
                        var offset = $("#jqxgrid").offset();
                        $("#popupWindowMessageAdd").jqxWindow('open');
                        $("#popupWindowMessageAdd").jqxWindow('move', offset.left + 30, offset.top + 30);
                    });									
				},			
				<?php } ?>				
			columns: [ 
					<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
		   			{ text: '', datafield: 'Edit', columntype: 'button',pinned: true , width: 40, cellsrenderer: function () {
						 return "<?php echo $lang['EDIT']; ?>";
					  }, buttonclick: function (row) {
						 // open the popup window when the user clicks a button.
											
						 editrow = row;
						 var offset = $("#jqxgrid").offset();
						 //$("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 60, y: parseInt(offset.top) + 60 } });
						 // get the clicked row's data and initialize the input fields.
						 var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
						 $("#delivery_charge_id").val(dataRecord.delivery_charge_id);
						 $("#weight_from_gram").val(dataRecord.weight_from_gram);
						 $("#weight_to_gram").val(dataRecord.weight_to_gram);
						 $("#delivery_charge").val(dataRecord.delivery_charge);
	
						 // show the popup window.
						 $("#popupWindowMessageDetail").jqxWindow('open');
						 $("#popupWindowMessageDetail").jqxWindow('move', offset.left + 30, offset.top + 30);
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
                     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
											
											var form_data = {
												//id: $("#id").val(),
												delivery_charge_id: dataRecord.delivery_charge_id,
												is_ajax: 1
											};
												
												$.ajax({
													type: "POST",
													url: "info_inc.php?action=deleteDeliveryCharge&id="+id,
													data: form_data,
													dataType: "json",  
													
													success: function(response) {
													
														var id = response["id"];
														var success = response["success"];
														var displayMsg = response["displayMsg"];
														
														if (success == '1') {
															window.location.href = "index.php?view=detail&sub=delivery_charge&id="+id+'&displayMsg='+displayMsg;
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
				
				{ text: '<?php echo $lang['NEW_DELIVERY_CHARGE_WEIGHT_FROM']; ?>', editable: true, datafield: 'weight_from_gram', width: 150 },
				{ text: '<?php echo $lang['NEW_DELIVERY_CHARGE_WEIGHT_TO']; ?>',editable: true, datafield: 'weight_to_gram', width: 150 },
				{ text: '<?php echo $lang['NEW_DELIVERY_CHARGE_DELIVERY_CHARGE']; ?>',editable: true, datafield: 'delivery_charge', width: 150 }
			]
		});  
		
			// create jqxWindow.
            $("#popupWindowMessageAdd").jqxWindow({ resizable: false,  autoOpen: false, width: 220, height: 250,cancelButton: $("#Cancel"), });
			$("#popupWindowMessageDetail").jqxWindow({ resizable: false,  autoOpen: false, width: 220, height: 250,cancelButton: $("#Cancel"), });							
	});			

</script>
													<form action="" method="post" name="theMessageFormAdd" id="theMessageFormAdd">
                                                    <div id="popupWindowMessageAdd">
                                                   		 <div>
                                                                    <?php echo $lang['ADD_RECORD']; ?></div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                        <?php echo $lang['NEW_DELIVERY_CHARGE_WEIGHT_FROM']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='weight_from_gram_add' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                       <?php echo $lang['NEW_DELIVERY_CHARGE_WEIGHT_TO']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='weight_to_gram_add' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                       <?php echo $lang['NEW_DELIVERY_CHARGE_DELIVERY_CHARGE']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='delivery_charge_add' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                                                                                   
                                                                    <div style='margin-top:7px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonMessageAdd" value="<?php echo $lang['BUTTON_ADD']; ?>" onclick="document.theMessageFormAdd.action='info_inc.php?action=addDeliveryCharge&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="<?php echo $lang['BUTTON_CANCEL']; ?>" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>
                                        
													<form action="" method="post" name="theMessageDetailFormUpdate" id="theMessageDetailFormUpdate">
                                                    <div id="popupWindowMessageDetail">
                                                   		 <div>
                                                                   <?php echo $lang['ADD_RECORD']; ?></div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                        <?php echo $lang['NEW_DELIVERY_CHARGE_WEIGHT_FROM']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='weight_from_gram' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        <?php echo $lang['NEW_DELIVERY_CHARGE_WEIGHT_TO']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='weight_to_gram' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                       <?php echo $lang['NEW_DELIVERY_CHARGE_DELIVERY_CHARGE']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='delivery_charge' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                         
                                                                   <input id='delivery_charge_id' type="hidden" class="jqx-input" style="width: 200px; height: 23px;" />                                                          
                                                                    <div style='margin-top:7px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonMessageUpdate" value="<?php echo $lang['BUTTON_UPDATE']; ?>" onclick="document.theMessageDetailFormUpdate.action='info_inc.php?action=updateDeliveryCharge&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="<?php echo $lang['BUTTON_CANCEL']; ?>" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>	                                                                 	                                         
                                             <div id="jqxgrid">
        
                                            </div>                            

<script type="text/javascript">

$(document).ready(function () {


            $('#buttonMessageAdd').on('click', function () {
               $('#theMessageFormAdd').jqxValidator('validate');
            });
			
            // initialize validator.
            $('#theMessageFormAdd').jqxValidator({
                rules: [
						 { input: '#delivery_charge_add', message: 'Required', action: 'keyup, blur', rule: 'required' },
									   
					   ]
            });
			
			//validate success & submit				
			$('#theMessageFormAdd').bind('validationSuccess', function (event) { 
					
			var action = $("#theMessageFormAdd").attr('action');
							
			var form_data = {
				weight_from_gram: $("#weight_from_gram_add").val(),
				weight_to_gram: $("#weight_to_gram_add").val(),
				delivery_charge: $("#delivery_charge_add").val(),

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
						
							
							window.location.href = "index.php?view=detail&sub=delivery_charge&id="+id+'&displayMsg='+displayMsg;
		
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
			
			
			$('#buttonMessageUpdate').on('click', function () {
                $('#theMessageDetailFormUpdate').jqxValidator('validate');
            });
			
            // initialize validator.
            $('#theMessageDetailFormUpdate').jqxValidator({
                rules: [
						 { input: '#delivery_charge', message: 'Required', action: 'keyup, blur', rule: 'required' },
									   
					   ]
            });
			
			//validate success & submit				
			$('#theMessageDetailFormUpdate').bind('validationSuccess', function (event) { 
					
			var action = $("#theMessageDetailFormUpdate").attr('action');
							
			var form_data = {
				delivery_charge_id: $("#delivery_charge_id").val(),
				weight_from_gram: $("#weight_from_gram").val(),
				weight_to_gram: $("#weight_to_gram").val(),
				delivery_charge: $("#delivery_charge").val(),

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
							window.location.href = "index.php?view=detail&sub=delivery_charge&id="+id+'&displayMsg='+displayMsg;
							
		
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
<?php 
} // end of function showList
?>

<?php
function CountrySettingForm()
{
include '../main/lang_default.php';
?>
<script type="text/javascript">			

$(document).ready(function () {
		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'country_id', type: 'string'},
				{ name: 'country_name', type: 'string'},
				{ name: 'prefix_name', type: 'string'},
				{ name: 'nationality_name', type: 'string'},
			],
			
			cache: false,
			url: 'dataCountrySetting.php',
			filter: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid-CountrySetting").jqxGrid('updatebounddata', 'filter');
			},
			sort: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid-CountrySetting").jqxGrid('updatebounddata', 'sort');
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

			
		$("#jqxgrid-CountrySetting").jqxGrid(
		{	
			source: dataadapter,
			
			filterable: true,
			sortable: true,
			editable: true,
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
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'><?php echo $lang['BUTTON_ADD']; ?></span></div>");
                    container.append(addButton);
                    statusbar.append(container);	
					addButton.jqxButton({  width: 60, height: 20 });
                    addButton.click(function (event) {
                        var offset = $("#jqxgrid-CountrySetting").offset();
                        $("#popupWindowCountryAdd").jqxWindow('open');
                        $("#popupWindowCountryAdd").jqxWindow('move', offset.left + 30, offset.top + 30);
                    });									
				},			
				<?php } ?>				
			columns: [ 
					<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
		   			{ text: '', datafield: 'Edit', columntype: 'button',pinned: true , width: 40, cellsrenderer: function () {
						 return "<?php echo $lang['EDIT']; ?>";
					  }, buttonclick: function (row) {
						 // open the popup window when the user clicks a button.
											
						 editrow = row;
						 var offset = $("#jqxgrid-CountrySetting").offset();
						 //$("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 60, y: parseInt(offset.top) + 60 } });
						 // get the clicked row's data and initialize the input fields.
						 var dataRecord = $("#jqxgrid-CountrySetting").jqxGrid('getrowdata', editrow);
						 $("#country_id").val(dataRecord.country_id);
						 $("#country_name").val(dataRecord.country_name);
						 $("#prefix_name").val(dataRecord.prefix_name);
						 $("#nationality_name").val(dataRecord.nationality_name);
	
						 // show the popup window.
						 $("#popupWindowCountryDetail").jqxWindow('open');
						 $("#popupWindowCountryDetail").jqxWindow('move', offset.left + 30, offset.top + 30);
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
                     var dataRecord = $("#jqxgrid-CountrySetting").jqxGrid('getrowdata', editrow);
											
											var form_data = {
												//id: $("#id").val(),
												country_id: dataRecord.country_id,
												is_ajax: 1
											};
												
												$.ajax({
													type: "POST",
													url: "info_inc.php?action=deleteCountry&id="+id,
													data: form_data,
													dataType: "json",  
													
													success: function(response) {
													
														var id = response["id"];
														var success = response["success"];
														var displayMsg = response["displayMsg"];
														
														if (success == '1') {
															window.location.href = "index.php?view=detail&sub=country_setting&id="+id+'&displayMsg='+displayMsg;
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
				
				{ text: '<?php echo $lang['NEW_COUNTRY_SETTING_COUNTRY_NAME']; ?>', editable: true, datafield: 'country_name', width: 150 },
				{ text: '<?php echo $lang['NEW_COUNTRY_SETTING_COUNTRY_PREFIX']; ?>',editable: true, datafield: 'prefix_name', width: 150 },
				{ text: '<?php echo $lang['NEW_COUNTRY_SETTING_COUNTRY_NATIONALITY']; ?>',editable: true, datafield: 'nationality_name', width: 150 }
			]
		});  
		
			// create jqxWindow.
            $("#popupWindowCountryAdd").jqxWindow({ resizable: false,  autoOpen: false, width: 220, height: 250,cancelButton: $("#Cancel"), });
			$("#popupWindowCountryDetail").jqxWindow({ resizable: false,  autoOpen: false, width: 220, height: 250,cancelButton: $("#Cancel"), });							
	});			

</script>
													<form action="" method="post" name="theCountryFormAdd" id="theCountryFormAdd">
                                                    <div id="popupWindowCountryAdd">
                                                   		 <div>
                                                                    <?php echo $lang['ADD_RECORD']; ?></div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                        <?php echo $lang['NEW_COUNTRY_SETTING_COUNTRY_NAME']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='country_name_add' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        <?php echo $lang['NEW_COUNTRY_SETTING_COUNTRY_PREFIX']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='prefix_name_add' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                       <?php echo $lang['NEW_COUNTRY_SETTING_COUNTRY_NATIONALITY']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='nationality_name_add' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                                                                                   
                                                                    <div style='margin-top:7px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonCountryAdd" value="<?php echo $lang['BUTTON_ADD']; ?>" onclick="document.theCountryFormAdd.action='info_inc.php?action=addCountry&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="<?php echo $lang['BUTTON_CANCEL']; ?>" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>
                                        
													<form action="" method="post" name="theCountryDetailFormUpdate" id="theCountryDetailFormUpdate">
                                                    <div id="popupWindowCountryDetail">
                                                   		 <div>
                                                                    <?php echo $lang['ADD_RECORD']; ?></div>
                                                                <div style="overflow: hidden;">
                                                                   <div>
                                                                        <?php echo $lang['NEW_COUNTRY_SETTING_COUNTRY_NAME']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='country_name' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        <?php echo $lang['NEW_COUNTRY_SETTING_COUNTRY_PREFIX']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='prefix_name' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                       <?php echo $lang['NEW_COUNTRY_SETTING_COUNTRY_NATIONALITY']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='nationality_name' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                         
                                                                   <input id='country_id' type="hidden" class="jqx-input" style="width: 200px; height: 23px;" />                                                          
                                                                    <div style='margin-top:7px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonCountryUpdate" value="<?php echo $lang['BUTTON_UPDATE']; ?>" onclick="document.theCountryDetailFormUpdate.action='info_inc.php?action=updateCountry&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="<?php echo $lang['BUTTON_CANCEL']; ?>" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>	                                                                 	                                         
                                             <div id="jqxgrid-CountrySetting">
        
                                            </div>                            

<script type="text/javascript">

$(document).ready(function () {


            $('#buttonCountryAdd').on('click', function () {
               $('#theCountryFormAdd').jqxValidator('validate');
            });
			
            // initialize validator.
            $('#theCountryFormAdd').jqxValidator({
                rules: [
						 { input: '#country_name_add', message: 'Required', action: 'keyup, blur', rule: 'required' },									   
					   ]
            });
			
			//validate success & submit				
			$('#theCountryFormAdd').bind('validationSuccess', function (event) { 
					
			var action = $("#theCountryFormAdd").attr('action');
							
			var form_data = {
				country_name: $("#country_name_add").val(),
				prefix_name: $("#prefix_name_add").val(),
				nationality_name: $("#nationality_name_add").val(),

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
						
							
							window.location.href = "index.php?view=detail&sub=country_setting&id="+id+'&displayMsg='+displayMsg;
		
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
			
			
			$('#buttonCountryUpdate').on('click', function () {
                $('#theCountryDetailFormUpdate').jqxValidator('validate');
            });
			
            // initialize validator.
            $('#theCountryDetailFormUpdate').jqxValidator({
                rules: [
						 { input: '#country_name', message: 'Required', action: 'keyup, blur', rule: 'required' },
									   
					   ]
            });
			
			//validate success & submit				
			$('#theCountryDetailFormUpdate').bind('validationSuccess', function (event) { 
					
			var action = $("#theCountryDetailFormUpdate").attr('action');
							
			var form_data = {
				country_id: $("#country_id").val(),
				country_name: $("#country_name").val(),
				prefix_name: $("#prefix_name").val(),
				nationality_name: $("#nationality_name").val(),

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
							window.location.href = "index.php?view=detail&sub=country_setting&id="+id+'&displayMsg='+displayMsg;
							
		
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
<?php 
} // end of function showList
?>

<?php

function BankSettingForm()
{
include '../main/lang_default.php';
?>
<script type="text/javascript">			

$(document).ready(function () {
		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'bank_id', type: 'string'},
				{ name: 'bank_name', type: 'string'},
				{ name: 'bank_swift_code', type: 'string'},
				{ name: 'country_name', type: 'string'},
				{ name: 'country_id', type: 'string'},
			],
			
			cache: false,
			url: 'dataBankSetting.php',
			filter: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid-BankSetting").jqxGrid('updatebounddata', 'filter');
			},
			sort: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid-BankSetting").jqxGrid('updatebounddata', 'sort');
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

			
		$("#jqxgrid-BankSetting").jqxGrid(
		{	
			source: dataadapter,
			
			filterable: true,
			sortable: true,
			editable: true,
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
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'><?php echo $lang['BUTTON_ADD']; ?></span></div>");
                    container.append(addButton);
                    statusbar.append(container);	
					addButton.jqxButton({  width: 60, height: 20 });
                    addButton.click(function (event) {
                        var offset = $("#jqxgrid-BankSetting").offset();
                        $("#popupWindowBankAdd").jqxWindow('open');
                        $("#popupWindowBankAdd").jqxWindow('move', offset.left + 30, offset.top + 30);
                    });									
				},			
				<?php } ?>				
			columns: [ 
					<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
		   			{ text: '', datafield: 'Edit', columntype: 'button',pinned: true , width: 40, cellsrenderer: function () {
						 return "<?php echo $lang['EDIT']; ?>";
					  }, buttonclick: function (row) {
						 // open the popup window when the user clicks a button.
											
						 editrow = row;
						 var offset = $("#jqxgrid-BankSetting").offset();
						 //$("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 60, y: parseInt(offset.top) + 60 } });
						 // get the clicked row's data and initialize the input fields.
						 var dataRecord = $("#jqxgrid-BankSetting").jqxGrid('getrowdata', editrow);
						 $("#bank_id").val(dataRecord.bank_id);
						 $("#bank_name").val(dataRecord.bank_name);
						 $("#bank_swift_code").val(dataRecord.bank_swift_code);
						 $("#country_id").val(dataRecord.country_id);
	
						 // show the popup window.
						 $("#popupWindowBankDetail").jqxWindow('open');
						 $("#popupWindowBankDetail").jqxWindow('move', offset.left + 30, offset.top + 30);
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
                     var dataRecord = $("#jqxgrid-BankSetting").jqxGrid('getrowdata', editrow);
											
											var form_data = {
												//id: $("#id").val(),
												bank_id: dataRecord.bank_id,
												is_ajax: 1
											};
												
												$.ajax({
													type: "POST",
													url: "info_inc.php?action=deleteBank&id="+id,
													data: form_data,
													dataType: "json",  
													
													success: function(response) {
													
														var id = response["id"];
														var success = response["success"];
														var displayMsg = response["displayMsg"];
														
														if (success == '1') {
															window.location.href = "index.php?view=detail&sub=bank_setting&id="+id+'&displayMsg='+displayMsg;
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
				
				{ text: '<?php echo $lang['NEW_BANK_SETTING_COUNTRY_NAME']; ?>', editable: true, datafield: 'country_name', width: 150 },
				{ text: '<?php echo $lang['NEW_BANK_SETTING_BANK_NAME']; ?>',editable: true, datafield: 'bank_name', width: 200 },
				{ text: '<?php echo $lang['NEW_BANK_SETTING_BANK_SWIFT_CODE']; ?>',editable: true, datafield: 'bank_swift_code', width: 150 }
			]
		});  
		
			// create jqxWindow.
            $("#popupWindowBankAdd").jqxWindow({ resizable: false,  autoOpen: false, width: 220, height: 250,cancelButton: $("#Cancel"), });
			$("#popupWindowBankDetail").jqxWindow({ resizable: false,  autoOpen: false, width: 220, height: 250,cancelButton: $("#Cancel"), });							
	});			

</script>
													<form action="" method="post" name="theBankFormAdd" id="theBankFormAdd">
                                                    <div id="popupWindowBankAdd">
                                                   		 <div>
                                                                    <?php echo $lang['ADD_RECORD']; ?></div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                        <?php echo $lang['NEW_BANK_SETTING_COUNTRY_NAME']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                    <select name='country_id_add' id='country_id_add' class="form-control">
																	<?php
                                                                    $sql = "SELECT *
                                                                                    FROM country
                                                                                 ";
                                                                    $result=dbQuery($sql);	
                                                                    
                                                                    //echo "<option value='0'></option>";												
                                                                    
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
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        <?php echo $lang['NEW_BANK_SETTING_BANK_NAME']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='bank_name_add' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                       <?php echo $lang['NEW_BANK_SETTING_BANK_SWIFT_CODE']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='bank_swift_code_add' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                                                                                   
                                                                    <div style='margin-top:7px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonBankAdd" value="<?php echo $lang['BUTTON_ADD']; ?>" onclick="document.theBankFormAdd.action='info_inc.php?action=addBank&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="<?php echo $lang['BUTTON_CANCEL']; ?>" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>
                                        
													<form action="" method="post" name="theBankDetailFormUpdate" id="theBankDetailFormUpdate">
                                                    <div id="popupWindowBankDetail">
                                                   		 <div>
                                                                    <?php echo $lang['ADD_RECORD']; ?></div>
                                                                <div style="overflow: hidden;">
                                                                   <div>
                                                                        <?php echo $lang['NEW_BANK_SETTING_COUNTRY_NAME']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                    <select name='country_id' id='country_id' class="form-control">
																	<?php
                                                                    $sql = "SELECT *
                                                                                    FROM country
                                                                                 ";
                                                                    $result=dbQuery($sql);	
                                                                    
                                                                    //echo "<option value='0'></option>";												
                                                                    
                                                                    if(dbNumRows($result)>0)
                                                                    {														
                                                                        
                                                                        
                                                                        while($row=dbFetchAssoc($result))
                                                                        {
            
                                                                                                                                                                                                 
                                                                            echo "<option value='$row[country_id]' >$row[country_name]</option>";
                                                                        }
                                                                    }
                                                
                                                                ?>
                                                                  </select>
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        <?php echo $lang['NEW_BANK_SETTING_BANK_NAME']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='bank_name' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                       <?php echo $lang['NEW_BANK_SETTING_BANK_SWIFT_CODE']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='bank_swift_code' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                                    </div>
                                                                         
                                                                   <input id='bank_id' type="hidden" class="jqx-input" style="width: 200px; height: 23px;" />                                                          
                                                                    <div style='margin-top:7px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonBankUpdate" value="<?php echo $lang['BUTTON_UPDATE']; ?>" onclick="document.theBankDetailFormUpdate.action='info_inc.php?action=updateBank&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="<?php echo $lang['BUTTON_CANCEL']; ?>" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>	                                                                 	                                         
                                             <div id="jqxgrid-BankSetting">
        
                                            </div>                            

<script type="text/javascript">

$(document).ready(function () {


            $('#buttonBankAdd').on('click', function () {
               $('#theBankFormAdd').jqxValidator('validate');
            });
			
            // initialize validator.
            $('#theBankFormAdd').jqxValidator({
                rules: [
						 { input: '#bank_name_add', message: 'Required', action: 'keyup, blur', rule: 'required' },									   
					   ]
            });
			
			//validate success & submit				
			$('#theBankFormAdd').bind('validationSuccess', function (event) { 
					
			var action = $("#theBankFormAdd").attr('action');
							
			var form_data = {
				bank_name: $("#bank_name_add").val(),
				bank_swift_code: $("#bank_swift_code_add").val(),
				country_id: $("#country_id_add").val(),

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
						
							
							window.location.href = "index.php?view=detail&sub=bank_setting&id="+id+'&displayMsg='+displayMsg;
		
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
			
			
			$('#buttonBankUpdate').on('click', function () {
                $('#theBankDetailFormUpdate').jqxValidator('validate');
            });
			
            // initialize validator.
            $('#theBankDetailFormUpdate').jqxValidator({
                rules: [
						 { input: '#bank_name', message: 'Required', action: 'keyup, blur', rule: 'required' },
									   
					   ]
            });
			
			//validate success & submit				
			$('#theBankDetailFormUpdate').bind('validationSuccess', function (event) { 
					
			var action = $("#theBankDetailFormUpdate").attr('action');
							
			var form_data = {
				bank_id: $("#bank_id").val(),
				bank_name: $("#bank_name").val(),
				bank_swift_code: $("#bank_swift_code").val(),
				country_id: $("#country_id").val(),

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
							window.location.href = "index.php?view=detail&sub=bank_setting&id="+id+'&displayMsg='+displayMsg;
							
		
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
<?php 
} // end of function showList
?>

                                    

