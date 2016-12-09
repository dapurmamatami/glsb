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
				{ name: 'percentage_id', type: 'string'},
				{ name: 'app_id', type: 'string'},
				{ name: 'total_sales_from', type: 'string'},
				{ name: 'total_sales_to', type: 'string'},
				{ name: 'total_percentage', type: 'string'},
				{ name: 'total_percentage2', type: 'string'},
			],
			
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
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>ADD</span></div>");
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
						 return "EDIT";
					  }, buttonclick: function (row) {
						 // open the popup window when the user clicks a button.
											
						 editrow = row;
						 var offset = $("#jqxgrid").offset();
						 //$("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 60, y: parseInt(offset.top) + 60 } });
						 // get the clicked row's data and initialize the input fields.
						 var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
						 $("#percentage_id").val(dataRecord.percentage_id);
						 $("#app_id").val(dataRecord.app_id);
						 $("#total_sales_from").val(dataRecord.total_sales_from);
						 $("#total_sales_to").val(dataRecord.total_sales_to);
						 $("#total_percentage").val(dataRecord.total_percentage);
						 $("#total_percentage2").val(dataRecord.total_percentage2);
						 
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
												percentage_id: dataRecord.percentage_id,
												is_ajax: 1
											};
												
												$.ajax({
													type: "POST",
													url: "info_inc.php?action=deletePercentage&id="+id,
													data: form_data,
													dataType: "json",  
													
													success: function(response) {
													
														var id = response["id"];
														var success = response["success"];
														var displayMsg = response["displayMsg"];
														
														if (success == '1') {
															window.location.href = "index.php?view=list&id="+id;
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
				
				{ text: 'Total Sales From(RM)', editable: true, datafield: 'total_sales_from', width: 200 },
				{ text: 'Total Sales To (RM)',editable: true, datafield: 'total_sales_to', width: 200 },
				{ text: 'Total Percentage 1 (%)',editable: true, datafield: 'total_percentage', width: 180 },
				{ text: 'Total Percentage 2 (%)',editable: true, datafield: 'total_percentage2', width: 180 },
			]
		});  
		
			// create jqxWindow.
            $("#popupWindowMessageAdd").jqxWindow({ resizable: false,  autoOpen: false, width: 500, height: 300,cancelButton: $("#Cancel"), });
			$("#popupWindowMessageDetail").jqxWindow({ resizable: false,  autoOpen: false, width: 500, height: 300,cancelButton: $("#Cancel"), });							
	});			

</script>
													<form action="" method="post" name="theMessageFormAdd" id="theMessageFormAdd">
                                                    <div id="popupWindowMessageAdd">
                                                   		 <div>
                                                                     Add Record</div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                        Total Sales From (RM)</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='total_sales_from_add' type="text" class="jqx-input" style="width: 490px; height: 23px;" />
                                                                    </div>
                                                                    
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Total Sales To (RM)</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='total_sales_to_add' type="text" class="jqx-input" style="width: 490px; height: 23px;" />
                                                                    </div>
                                                                    
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Total Percentage 1 (%)</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='total_percentage_add' type="text" class="jqx-input" style="width: 490px; height: 23px;" />
                                                                    </div>
                                                                    
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Total Percentage 2 (%)</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='total_percentage2_add' type="text" class="jqx-input" style="width: 490px; height: 23px;" />
                                                                    </div>
                                                                                                                                   
                                                                    <div style='margin-top:7px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonMessageAdd" value="ADD" onclick="document.theMessageFormAdd.action='info_inc.php?action=addPercentage&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="CANCEL" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>
                                        
													<form action="" method="post" name="theMessageDetailFormUpdate" id="theMessageDetailFormUpdate">
                                                    <div id="popupWindowMessageDetail">
                                                   		 <div>
                                                                    Add Record</div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                        Total Sales From (RM)</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='total_sales_from' type="text" class="jqx-input" style="width: 490px; height: 23px;" />
                                                                    </div>
                                                                    
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Total Sales To (RM)</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='total_sales_to' type="text" class="jqx-input" style="width: 490px; height: 23px;" />
                                                                    </div>
                                                                    
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Total Percentage 1 (%)</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='total_percentage' type="text" class="jqx-input" style="width: 490px; height: 23px;" />
                                                                    </div>
                                                                    
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Total Percentage 2 (%)</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='total_percentage2' type="text" class="jqx-input" style="width: 490px; height: 23px;" />
                                                                    </div>
                                                                         
                                                                   <input id='percentage_id' type="hidden" class="jqx-input" style="width: 200px; height: 23px;" />                                                          
                                                                    <div style='margin-top:7px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonMessageUpdate" value="UPDATE" onclick="document.theMessageDetailFormUpdate.action='info_inc.php?action=updatePercentage&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="CANCEL" />
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
						 { input: '#total_sales_from_add', message: 'Required', action: 'keyup, blur', rule: 'required' },
									   
					   ]
            });
			
			//validate success & submit				
			$('#theMessageFormAdd').bind('validationSuccess', function (event) { 
					
			var action = $("#theMessageFormAdd").attr('action');
							
			var form_data = {
				app_id: $("#app_id_add").val(),
				total_sales_from: $("#total_sales_from_add").val(),
				total_sales_to: $("#total_sales_to_add").val(),
				total_percentage: $("#total_percentage_add").val(),
				total_percentage2: $("#total_percentage2_add").val(),

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
						
							
							window.location.href = "index.php?view=list&id="+id+'&displayMsg='+displayMsg;
		
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
						 { input: '#total_sales_from', message: 'Required', action: 'keyup, blur', rule: 'required' },
									   
					   ]
            });
			
			//validate success & submit				
			$('#theMessageDetailFormUpdate').bind('validationSuccess', function (event) { 
					
			var action = $("#theMessageDetailFormUpdate").attr('action');
							
			var form_data = {
				percentage_id: $("#percentage_id").val(),
				app_id: $("#app_id").val(),
				total_sales_from: $("#total_sales_from").val(),
				total_sales_to: $("#total_sales_to").val(),
				total_percentage: $("#total_percentage").val(),
				total_percentage2: $("#total_percentage2").val(),

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
							window.location.href = "index.php?view=list&id="+id;
							
		
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

                                    
