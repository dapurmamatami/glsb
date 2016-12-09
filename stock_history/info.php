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
				{ name: 'stock_id', type: 'string'},
				{ name: 'stock_date', type: 'string'},
				{ name: 'stock_description', type: 'string'},
				{ name: 'product_id', type: 'string'},
				{ name: 'qty_in', type: 'string'},
				{ name: 'qty_out', type: 'string'},
				{ name: 'product_name', type: 'string'},
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
					<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw') and $realwork == 1){ ?>
		   			{ text: '', datafield: 'Edit', columntype: 'button',pinned: true , width: 40, cellsrenderer: function () {
						 return "<?php echo $lang['EDIT']; ?>";
					  }, buttonclick: function (row) {
						 // open the popup window when the user clicks a button.
											
						 editrow = row;
						 var offset = $("#jqxgrid").offset();
						 //$("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 60, y: parseInt(offset.top) + 60 } });
						 // get the clicked row's data and initialize the input fields.
						 var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
						 $("#stock_id").val(dataRecord.stock_id);
						 $("#stock_date").val(dataRecord.stock_date);
						 $("#stock_description").val(dataRecord.stock_description);
						 $("#product_id").val(dataRecord.product_id);
						 $("#qty_in").val(dataRecord.qty_in);
						 $("#qty_out").val(dataRecord.qty_out);
	
						 // show the popup window.
						 $("#popupWindowMessageDetail").jqxWindow('open');
						 $("#popupWindowMessageDetail").jqxWindow('move', offset.left + 30, offset.top + 30);
					 }
					},		
					<?php } ?>
					
				<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'delete_sw') and $realwork == 1){ ?>
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
												stock_id: dataRecord.stock_id,
												is_ajax: 1
											};
												
												$.ajax({
													type: "POST",
													url: "info_inc.php?action=deleteMessage&id="+id,
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
				
				{ text: 'Stock Date', editable: true, datafield: 'stock_date', width: 130 },
				{ text: 'Product Name',editable: true, datafield: 'product_name', width: 300 },
				{ text: 'Quantity In',editable: true, datafield: 'qty_in', width: 120 },
				{ text: 'Quantity Out',editable: true, datafield: 'qty_out', width: 120 },
				{ text: 'Stock Description',editable: true, datafield: 'stock_description', width: 300 }
			]
		});  
		
		
			// create jqxWindow.
            $("#popupWindowMessageAdd").jqxWindow({ resizable: false,  autoOpen: false, width: 300, height: 430,cancelButton: $("#Cancel"), });
			$("#popupWindowMessageDetail").jqxWindow({ resizable: false,  autoOpen: false, width: 500, height: 500,cancelButton: $("#Cancel"), });							
	});			

</script>
													<form action="" method="post" name="theMessageFormAdd" id="theMessageFormAdd">
                                                    <div id="popupWindowMessageAdd">
                                                   		 <div>
                                                                    <?php echo $lang['ADD_RECORD']; ?></div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                        Stock Date</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='stock_date_add' type="text" class="jqx-input" style="width: 290px; height: 23px;" value = "<?php echo date("Y-m-d"); ?>" readonly=readonly/>
                                                                    </div>
                                                                    <div>
                                                                        Product Name</div>
                                                                    <div style='margin-top:5px;'>
                                                                    <select name='product_id_add' id='product_id_add' class="form-control">
																	<?php
                                                                    $sql = "SELECT *
                                                                                    FROM product where active_sw = 1
                                                                                 ";
                                                                    $result=dbQuery($sql);	
                                                                    
                                                                    //echo "<option value='0'></option>";												
                                                                    
                                                                    if(dbNumRows($result)>0)
                                                                    {														
                                                                        
                                                                        
                                                                        while($row=dbFetchAssoc($result))
                                                                        {
            
                                                                            if($row[product_id]==$product_id){
                                                                                $cSelect="SELECTED";
                                                                            }else{
                                                                                $cSelect="";
                                                                            }
                                                                                                                                    
                                                                            echo "<option value='$row[product_id]' $cSelect>$row[product_name]</option>";
                                                                        }
                                                                    }
                                                
                                                                ?>
                                                                  </select>
                                                                    </div>
                                                                    <div>
                                                                        Quantity In</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='qty_in_add' type="text" class="jqx-input" style="width: 290px; height: 23px;" />
                                                                    </div>
                                                                    <div>
                                                                        Quantity Out</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='qty_out_add' type="text" class="jqx-input" style="width: 290px; height: 23px;" />
                                                                    </div>
                                                                    <div>
                                                                        Stock Description</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <textarea class="form-control" id="stock_description_add" rows="5"></textarea>
                                                                    </div>
                                                                                                                                   
                                                                    <div style='margin-top:7px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonMessageAdd" value="<?php echo $lang['BUTTON_ADD']; ?>" onclick="document.theMessageFormAdd.action='info_inc.php?action=addStock&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="<?php echo $lang['BUTTON_CANCEL']; ?>" />
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
                                                                        Stock Date</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='stock_date' type="text" class="jqx-input" style="width: 290px; height: 23px;" />
                                                                    </div>
                                                                    <div>
                                                                        Product Name</div>
                                                                    <div style='margin-top:5px;'>
                                                                    <select name='product_id' id='product_id' class="form-control">
																	<?php
                                                                    $sql = "SELECT *
                                                                                    FROM product where active_sw = 1
                                                                                 ";
                                                                    $result=dbQuery($sql);	
                                                                    
                                                                    //echo "<option value='0'></option>";												
                                                                    
                                                                    if(dbNumRows($result)>0)
                                                                    {														
                                                                        
                                                                        
                                                                        while($row=dbFetchAssoc($result))
                                                                        {
            
                                                                            if($row[product_id]==$product_id){
                                                                                $cSelect="SELECTED";
                                                                            }else{
                                                                                $cSelect="";
                                                                            }
                                                                                                                                    
                                                                            echo "<option value='$row[product_id]' $cSelect>$row[product_name]</option>";
                                                                        }
                                                                    }
                                                
                                                                ?>
                                                                  </select>
                                                                    </div>
                                                                    <div>
                                                                        Quantity In</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='qty_in' type="text" class="jqx-input" style="width: 290px; height: 23px;" />
                                                                    </div>
                                                                    <div>
                                                                        Quantity Out</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <input id='qty_out' type="text" class="jqx-input" style="width: 290px; height: 23px;" />
                                                                    </div>
                                                                    <div>
                                                                        Stock Description</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <textarea class="form-control" id="stock_description" rows="5"></textarea>
                                                                    </div>
                                                                         
                                                                   <input id='stock_id' type="hidden" class="jqx-input" style="width: 200px; height: 23px;" />                                                          
                                                                    <div style='margin-top:7px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonMessageUpdate" value="<?php echo $lang['BUTTON_UPDATE']; ?>" onclick="document.theMessageDetailFormUpdate.action='info_inc.php?action=updateStock&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="<?php echo $lang['BUTTON_CANCEL']; ?>" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>	   
                                        
                                        <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
                                         <input type="submit" value="Print Inventory Balance" id="buttonPrint" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=printReportAll&report_name=stock_inventory&id=<?php echo $id; ?>'" formtarget="_blank"/>
                                        </form>                                                              	                                         
                                             <div id="jqxgrid">
        
                                            </div>                            

<script type="text/javascript">

$(document).ready(function () {

			//$('#stock_date_add').datepicker({ dateFormat: 'dd-mm-yy' });    
			
            $('#buttonMessageAdd').on('click', function () {
               $('#theMessageFormAdd').jqxValidator('validate');
            });
			
            // initialize validator.
            $('#theMessageFormAdd').jqxValidator({
                rules: [
						 { input: '#stock_date_add', message: 'Required', action: 'keyup, blur', rule: 'required' },
									   
					   ]
            });
			
			//validate success & submit				
			$('#theMessageFormAdd').bind('validationSuccess', function (event) { 
					
			var action = $("#theMessageFormAdd").attr('action');
							
			var form_data = {
				stock_date: $("#stock_date_add").val(),
				stock_description: $("#stock_description_add").val(),
				product_id: $("#product_id_add").val(),
				qty_in: $("#qty_in_add").val(),
				qty_out: $("#qty_out_add").val(),
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

			$('#stock_date').datepicker({ dateFormat: 'dd-mm-yy' });    			
			
			$('#buttonMessageUpdate').on('click', function () {
                $('#theMessageDetailFormUpdate').jqxValidator('validate');
            });
			
            // initialize validator.
            $('#theMessageDetailFormUpdate').jqxValidator({
                rules: [
						 { input: '#stock_date', message: 'Required', action: 'keyup, blur', rule: 'required' },
									   
					   ]
            });
			
			//validate success & submit				
			$('#theMessageDetailFormUpdate').bind('validationSuccess', function (event) { 
					
			var action = $("#theMessageDetailFormUpdate").attr('action');
							
			var form_data = {
				stock_id: $("#stock_id").val(),
				stock_date: $("#stock_date").val(),
				stock_description: $("#stock_description").val(),
				product_id: $("#product_id").val(),
				qty_in: $("#qty_in").val(),
				qty_out: $("#qty_out").val(),

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

                                    
