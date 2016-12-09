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
				{ name: 'message_id', type: 'string'},
				{ name: 'message_subject', type: 'string'},
				{ name: 'message_content', type: 'string'},
				{ name: 'message_footer', type: 'string'},
				{ name: 'message_type_display', type: 'string'},
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
                        $("#popupWindowMessageAdd").jqxWindow('move', offset.left + 30, offset.top + 10);
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
						 $("#message_id").val(dataRecord.message_id);
						 $("#message_subject").val(dataRecord.message_subject);
						 $("#message_content").val(dataRecord.message_content);
						 $("#message_footer").val(dataRecord.message_footer);
	
						 // show the popup window.
						 $("#popupWindowMessageDetail").jqxWindow('open');
						 $("#popupWindowMessageDetail").jqxWindow('move', offset.left + 30, offset.top + 10);
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
												message_id: dataRecord.message_id,
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
				{ text: 'Message Type Display',editable: true, datafield: 'message_type_display', width: 200 },
				{ text: '<?php echo $lang['NEW_DEFAULT_MESSAGE_MESSAGE_SUBJECT']; ?>', editable: true, datafield: 'message_subject', width: 150 },
				{ text: '<?php echo $lang['NEW_DEFAULT_MESSAGE_MESSAGE_CONTENT']; ?>',editable: true, datafield: 'message_content', width: 350 },
				{ text: '<?php echo $lang['NEW_DEFAULT_MESSAGE_MESSAGE_FOOTER']; ?>',editable: true, datafield: 'message_footer', width: 350 },
			]
		});  
		
			// create jqxWindow.
            $("#popupWindowMessageAdd").jqxWindow({ resizable: false,  autoOpen: false, width: 750, height: 500,cancelButton: $("#Cancel"), });
			$("#popupWindowMessageDetail").jqxWindow({ resizable: false,  autoOpen: false, width: 750, height: 500,cancelButton: $("#Cancel"), });							
	});			

</script>
													<form action="" method="post" name="theMessageFormAdd" id="theMessageFormAdd">
                                                    <div id="popupWindowMessageAdd">
                                                   		 <div>
                                                                    <?php echo $lang['ADD_RECORD']; ?></div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                        <?php echo $lang['NEW_DEFAULT_MESSAGE_MESSAGE_SUBJECT']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                        <textarea class="form-control" id="message_subject_add" name="message_subject_add" rows="2"></textarea>
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        <?php echo $lang['NEW_DEFAULT_MESSAGE_MESSAGE_CONTENT']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                        <textarea class="form-control" id="message_content_add" rows="8"></textarea>
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        <?php echo $lang['NEW_DEFAULT_MESSAGE_MESSAGE_FOOTER']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                        <textarea class="form-control" id="message_footer_add" rows="3"></textarea>
                                                                    </div>
                                                                                                                                   
                                                                    <div style='margin-top:7px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonMessageAdd" value="<?php echo $lang['BUTTON_ADD']; ?>" onclick="document.theMessageFormAdd.action='info_inc.php?action=addMessage&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="<?php echo $lang['BUTTON_CANCEL']; ?>" />
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
                                                                        <?php echo $lang['NEW_DEFAULT_MESSAGE_MESSAGE_SUBJECT']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                        <textarea class="form-control" id="message_subject" rows="2"></textarea>
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        <?php echo $lang['NEW_DEFAULT_MESSAGE_MESSAGE_CONTENT']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                        <textarea class="form-control" id="message_content" rows="8"></textarea>
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        <?php echo $lang['NEW_DEFAULT_MESSAGE_MESSAGE_FOOTER']; ?></div>
                                                                    <div style='margin-top:5px;'>
                                                                        <textarea class="form-control" id="message_footer" rows="3"></textarea>
                                                                    </div>
                                                                         
                                                                   <input id='message_id' type="hidden" class="jqx-input" style="width: 200px; height: 23px;" />                                                          
                                                                    <div style='margin-top:7px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonMessageUpdate" value="<?php echo $lang['BUTTON_UPDATE']; ?>" onclick="document.theMessageDetailFormUpdate.action='info_inc.php?action=updateMessage&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="<?php echo $lang['BUTTON_CANCEL']; ?>" />
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
						 { input: '#message_subject_add', message: 'Required', action: 'keyup, blur', rule: 'required' },
									   
					   ]
            });
			
			//validate success & submit				
			$('#theMessageFormAdd').bind('validationSuccess', function (event) { 
					
			var action = $("#theMessageFormAdd").attr('action');
							
			var form_data = {
				message_subject: $("#message_subject_add").val(),
				message_content: $("#message_content_add").val(),
				message_footer: $("#message_footer_add").val(),

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
						 { input: '#message_subject', message: 'Required', action: 'keyup, blur', rule: 'required' },
									   
					   ]
            });
			
			//validate success & submit				
			$('#theMessageDetailFormUpdate').bind('validationSuccess', function (event) { 
					
			var action = $("#theMessageDetailFormUpdate").attr('action');
							
			var form_data = {
				message_id: $("#message_id").val(),
				message_subject: $("#message_subject").val(),
				message_content: $("#message_content").val(),
				message_footer: $("#message_footer").val(),

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

                                    
