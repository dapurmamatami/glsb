<?php
function addForm()
{
	
	
	$today = date('Y-m-d');
	if (checkClosing($today, 1, 0)){
		
		
		include '../main/lang_default.php';
		
		$data = getNewUserDetail($_SESSION['u_id']);
		if ($data['bank_id'] && $data['bank_account_no'] !='')
		{
			
				$setupData = getCompanySetupDetailForm(1);
				$manual_withdrawal_charge = $setupData[manual_withdrawal_charge];
				$min_balance_to_keep = $setupData[min_balance_to_keep];
				
				$available_balance = walletAvailableBalance($_SESSION[user_id]) - $manual_withdrawal_charge - $min_balance_to_keep;
				
				if($available_balance > 0) {
					$available_balance = $available_balance;
				}else{
					$available_balance = 0;
				}
?>


<script type="text/javascript">
$(document).ready(function () {
	
	$('#request_date').datepicker({ dateFormat: 'dd-mm-yy' });
       
	//var theme = getTheme();
	//var theme = 'classic';
    // initialize validator.
	 
	// initialize validator.
	$('#theForm').jqxValidator({
		rules: [
						   
			   ]
	});

	
	
    //button click
	$('#buttonAdd').bind('click', function () {
		var validationResult = function (isValid) {
			if (isValid) {
				$("#theForm").submit();
			}
		}
				$('#theForm').jqxValidator('validate', validationResult);
     });
	 //end of button click
	 
		
	//validate success & submit				
	$('#theForm').bind('validationSuccess', function (event) { 
			
	var action = $("#theForm").attr('action');
	
	var agree=confirm("Are you sure want to withdraw?");
	if (agree)
	{

	var form_data = 
	{
		request_date: $("#request_date").val(),
		user_id: $("#user_id").val(),
		//user_id: $("#user_id option:selected").val(),
		amount: $("#amount").val(),
		remark: $("#remark").val(),
		//customer_type_id: $('input:radio[name=customer_type_id]:checked').val(),
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
				
					
					window.location.href = "index.php?view=list&wallet=ewalletWithdraw&id="+id+'&displayMsg='+displayMsg;

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
		
	}
	else
	{
		return false;
	}
	
	}); 
	//end of validate sucess and submit
		
});
</script>

              <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
              <div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                        <div class="box-header with-border">

                          <h2 class="box-title">E-Wallet Available Balance : <?php echo number_format((float)$available_balance, 2, '.', ''); ?></h2>
                          <br />
                          <h4>Attention : "Service charge of RM <?php echo $setupData['manual_withdrawal_charge']; ?> will be imposed for manual withdrawal"</h4>
                          
										<div style="float: right;">								
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        						<input type="button" value="WITHDRAW" id="buttonAdd" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=add'"/>
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
                                            <label for="input" class="col-sm-2 control-label">Request Date</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="request_date" readonly="readonly" value="<?php echo date('d-m-Y'); ?>">
                                              <input type="text" id="user_id" hidden="hidden" value="<?php echo $_SESSION['user_id']; ?>">
                                            </div>
                                            </div>
                                            
                                            <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Amount</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="amount" >
                                            </div>
                                            </div> 
                                            
                                           <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Remark</label>
                                            <div class="col-sm-8">
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
              
        <?php 
		}	
        else
        {
        echo 'You Have to Fill In the Bank Account Number and Bank Name Before You Can Request Withdraw';
        } ?>

<?php } else { echo 'Temporary Disabled'; } ?>
<?php } ?>

<?php
function showListWithdraw()
{

?>
<script type="text/javascript">

$(document).ready(function () {

		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'request_id', type: 'string'},
				{ name: 'request_date', type: 'string'},
				{ name: 'user_id', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'amount', type: 'string'},
				{ name: 'remark', type: 'string'},
			],
				
			cache: false,
			url: 'data3.php',

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
				//{ text: '', editable: false, datafield: 'request_id', width: 80 ,cellsrenderer: linkrenderer},
				{ text: 'Request Date', editable: false, datafield: 'request_date', width: 200 },
				{ text: 'Request By',editable: false, datafield: 'name', width: 300 },
				{ text: 'Amount',editable: false, datafield: 'amount', width: 100 },
				{ text: 'Remark',editable: false, datafield: 'remark', width: 500 }
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
function showListWithdrawPending()
{
	$today = date('Y-m-d');
	if (checkClosing($today, 1, 0)){
		
	updateWithdrawRequestBankAccount();
	

?>
<script type="text/javascript">

$(document).ready(function () {

		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'request_id', type: 'string'},
				{ name: 'request_date', type: 'string'},
				{ name: 'user_id', type: 'string'},
				{ name: 'type_id', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'amount', type: 'string'},
				{ name: 'remark', type: 'string'},
				{ name: 'bank_name', type: 'string'},
				{ name: 'bank_account_no', type: 'string'},
				{ name: 'reference_no', type: 'string'},
			],
				
			cache: false,
			url: 'dataWithdrawPending.php',

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
			columns: [ 
			<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
		   			{ text: '', datafield: 'Edit', columntype: 'button',pinned: true , width: 40, cellsrenderer: function () {
						 return "Edit";
					  }, buttonclick: function (row) {
						 // open the popup window when the user clicks a button.
											
						 editrow = row;
						 var offset = $("#jqxgrid").offset();
						 //$("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 60, y: parseInt(offset.top) + 60 } });
						 // get the clicked row's data and initialize the input fields.
						 var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
						 $("#request_id").val(dataRecord.request_id);
						 $("#reference_no").val(dataRecord.reference_no);
	
						 // show the popup window.
						 $("#popupWindowPendingWithdrawDetail").jqxWindow('open');
						 $("#popupWindowPendingWithdrawDetail").jqxWindow('move', offset.left + 30, offset.top + 30);
					 }
					},		
			<?php } ?>
				//{ text: '', editable: false, datafield: 'request_id', width: 80 ,cellsrenderer: linkrenderer},
				<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
 				{ text: '',width: 100, datafield: 'Delete', columntype: 'button',pinned: true , cellsrenderer: function () {
                     return "Approve";
                 }, buttonclick: function (row) {


			

                     editrow = row;                    
                     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
											
											var id = dataRecord.do_id;
											var form_data = {
												//id: $("#id").val(),
												request_id: dataRecord.request_id,
												user_id: dataRecord.user_id,
												amount: dataRecord.amount,
												type_id: dataRecord.type_id,
												remark: dataRecord.remark,
												bank_name: dataRecord.bank_name,
												bank_account_no: dataRecord.bank_account_no,
												request_date: dataRecord.request_date,
												reference_no: dataRecord.reference_no,
												//id: dataRecord.do_id,
												is_ajax: 1
											};
												
												$.ajax({
													type: "POST",
													url: "info_inc.php?action=changeRequestStatus&status_id=1&id="+id,
													data: form_data,
													dataType: "json",  
													
													success: function(response) {
													
														var id = response["id"];
														var success = response["success"];
														var displayMsg = response["displayMsg"];
														
														if (success == '1') {
															window.location.href = "index.php?view=listWithdrawPending&id="+id;
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
        },				
				<?php } ?>	
				<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
 				{ text: '',width: 80, datafield: 'Reject', columntype: 'button',pinned: true , cellsrenderer: function () {
                     return "Reject";
                 }, buttonclick: function (row) {


			

                     editrow = row;                    
                     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
											
											var id = dataRecord.do_id;
											var form_data = {
												//id: $("#id").val(),
												request_id: dataRecord.request_id,
												user_id: dataRecord.user_id,
												amount: dataRecord.amount,
												type_id: dataRecord.type_id,
												remark: dataRecord.remark,
												bank_name: dataRecord.bank_name,
												bank_account_no: dataRecord.bank_account_no,
												request_date: dataRecord.request_date,
												reference_no: dataRecord.reference_no,
												//id: dataRecord.do_id,
												is_ajax: 1
											};
												
												$.ajax({
													type: "POST",
													url: "info_inc.php?action=changeRequestStatus&status_id=9&id="+id,
													data: form_data,
													dataType: "json",  
													
													success: function(response) {
													
														var id = response["id"];
														var success = response["success"];
														var displayMsg = response["displayMsg"];
														
														if (success == '1') {
															window.location.href = "index.php?view=listWithdrawPending&id="+id+'&displayMsg='+displayMsg;
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
        },				
				<?php } ?>									
				{ text: 'Request Date', editable: false, datafield: 'request_date', width: 180 },
				{ text: 'Request By',editable: false, datafield: 'name', width: 180 },
				{ text: 'Bank Name',editable: false, datafield: 'bank_name', width: 180 },
				{ text: 'Bank Account No',editable: false, datafield: 'bank_account_no', width: 160 },
				{ text: 'Amount',editable: false, datafield: 'amount', width: 100 },
				{ text: 'Reference No',editable: false, datafield: 'reference_no', width: 150 },
				{ text: 'Remark',editable: false, datafield: 'remark', width: 500 },
			]
		});  
		
				$("#popupWindowPendingWithdrawDetail").jqxWindow({ resizable: false,  autoOpen: false, width: 220, height: 250,cancelButton: $("#Cancel"), });								
});

</script>
                            <form action="" method="post" name="thePendingWithdrawDetailUpdate" id="thePendingWithdrawDetailUpdate">
                                <div id="popupWindowPendingWithdrawDetail">
                                     <div>
                                            Add Record</div>
                                            <div style="overflow: hidden;">
                                               <div>
                                                    Reference No :</div>
                                                <div style='margin-top:5px;'>
                                                     <input id='reference_no' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                                                </div>
                                                     
                                               <input id='request_id' type="hidden" class="jqx-input" style="width: 200px; height: 23px;" />                                                          
                                                <div style='margin-top:7px;'>
                                                    <div>
                                                        <input style="margin-right: 5px;" type="button" id="buttonPendingWithdrawUpdate" value="Update" onclick="document.thePendingWithdrawDetailUpdate.action='info_inc.php?action=updatePendingWithdraw&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="Cancel" />
                                                    </div>
                                                </div>
                                      </div>
                                </div>		
                            </form>
								
				<div class="box box-warning">
                  <div class="box-body">                                   
                    <div class="col-md-12">


							<form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
								<input type="submit" value="PRINT PENDING WITHDRAWAL LIST" id="buttonPrint" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=printReport&id=<?php echo $id; ?>'" formtarget="_blank"/>
                                
                                
							</form>
                            
							<div class="widget-content">
							
									<div id="jqxgrid">

									</div>
							</div>

					</div>
				</div>
                
<script type="text/javascript">
$(document).ready(function () {

	
			$('#buttonPendingWithdrawUpdate').on('click', function () {
                $('#thePendingWithdrawDetailUpdate').jqxValidator('validate');
            });
			
            // initialize validator.
            $('#thePendingWithdrawDetailUpdate').jqxValidator({
                rules: [
						 //{ input: '#reference_no', message: 'Required', action: 'keyup, blur', rule: 'required' },   
					   ]
            });
			
			//validate success & submit				
			$('#thePendingWithdrawDetailUpdate').bind('validationSuccess', function (event) { 
					
			var action = $("#thePendingWithdrawDetailUpdate").attr('action');
							
			var form_data = {
				request_id: $("#request_id").val(),
				reference_no: $("#reference_no").val(),

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
							window.location.href = "index.php?view=listWithdrawPending&id="+id+'&displayMsg='+displayMsg;
							
		
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
<?php } else { echo 'Temporary Disabled'; } ?>
<?php } // end of function showList ?>


<?php
function showListWithdrawRequest()
{

?>
<script type="text/javascript">

$(document).ready(function () {

		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'request_id', type: 'string'},
				{ name: 'request_date', type: 'string'},
				{ name: 'user_id', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'amount', type: 'string'},
				{ name: 'remark', type: 'string'},
				{ name: 'bank_name', type: 'string'},
				{ name: 'bank_account_no', type: 'string'},
			],
				
			cache: false,
			url: 'dataWithdrawRequest.php',

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
				//{ text: '', editable: false, datafield: 'request_id', width: 80 ,cellsrenderer: linkrenderer},
								
				{ text: 'Request Date', editable: false, datafield: 'request_date', width: 180 },
				{ text: 'Request By',editable: false, datafield: 'name', width: 180 },
				{ text: 'Bank Name',editable: false, datafield: 'bank_name', width: 180 },
				{ text: 'Bank Account No',editable: false, datafield: 'bank_account_no', width: 160 },
				{ text: 'Amount',editable: false, datafield: 'amount', width: 100 },
				{ text: 'Remark',editable: false, datafield: 'remark', width: 500 }
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
function showUserWalletList()
{

?>
<script type="text/javascript">

$(document).ready(function () {
	
		$('#date_from').datepicker({ dateFormat: 'dd-mm-yy' }); 	
		$('#date_to').datepicker({ dateFormat: 'dd-mm-yy' }); 
		
		var wallet = '<?php echo $_GET['wallet']; ?>';
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'trans_date'},
				{ name: 'member_reg_no', type: 'string'},
				{ name: 'trans_description', type: 'string'},
				{ name: 'withdraw_name', type: 'string'},
				{ name: 'currency_name', type: 'string'},
				{ name: 'amount_in', type: 'string'},
				{ name: 'amount_out', type: 'string'}
			],
			
			cache: false,
			<?php if($_GET['wallet'] == 'ewalletWithdraw') { ?>
			url: 'data2.php?wallet='+wallet,
			<?php } else if($_GET['wallet'] == 'ewallet') { ?>
			url: 'data.php?wallet='+wallet,
			<?php } ?>
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
			height: 550,		
			showstatusbar: true,
			//showaggregates: true,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},		
			columns: [ 
				{ text: 'Date', editable: false, datafield: 'trans_date', width: 150 },
				{ text: 'Member', editable: false, datafield: 'member_reg_no', width: 100 },
				{ text: 'Description', editable: false, datafield: 'trans_description', width: 300 },
				//{ text: 'Currency', editable: false, datafield: 'currency_name', width: 70 },
				<?php if($_GET['wallet'] == 'ewallet') { ?>
				{ text: 'In', editable: false, datafield: 'amount_in', width: 100, cellsalign: 'right', cellsformat: 'd2' },
				<?php } ?>	
				<?php if($_GET['wallet'] == 'ewalletWithdraw') { ?>
				{ text: 'Amount',editable: false, datafield: 'amount_out', width: 100, cellsalign: 'right', cellsformat: 'd2' }
				<?php }
				else { ?>		
				{ text: 'Out',editable: false, datafield: 'amount_out', width: 100, cellsalign: 'right', cellsformat: 'd2' }	
				<?php } ?>					
				//{ text: 'In', editable: false, datafield: 'amount_in', width: 100, cellsalign: 'right', cellsformat: 'd2', aggregates: ['sum'] },
				//{ text: 'Out',editable: false, datafield: 'amount_out', width: 100, cellsalign: 'right', cellsformat: 'd2', aggregates: ['sum']  }
			]
		});  
		
				
						
});

</script>
				
                <?php 
				$setupData = getCompanySetupDetailForm(1);
				$manual_withdrawal_charge = $setupData[manual_withdrawal_charge];
				$min_balance_to_keep = $setupData[min_balance_to_keep];
				
				$available_balance = walletAvailableBalance($_SESSION[user_id]) - $manual_withdrawal_charge - $min_balance_to_keep;
				
				if($available_balance > 0) {
					$available_balance = $available_balance;
				}else{
					$available_balance = 0;
				}
				
				if($_GET[wallet] == 'ewallet')
				{
					$wallet_balance = 'E-Wallet Available Balance : ' . number_format((float)$available_balance, 2, '.', '');
					
				}
				if($_GET[wallet] == 'rwallet')
				{
	
					$wallet_balance = walletBalance('acct_rwallet', $_SESSION['user_id']);		
				}	
				if($_GET[wallet] == 'mwallet')
				{

					$wallet_balance = 'Pool Bonus';			
				}				
				
				
				?> 
                

                
				<div class="box box-warning">
					<div class="box-body">    
						<div class="widget-header"s>
							<?php if($_GET['wallet'] <> 'ewalletWithdraw') { ?>
                            <h4><?php echo $wallet_balance; ?></h4>
                            <?php } ?>
                    	</div>                                                 
                    		<div class="col-md-12">
								<div class="widget-content">
									<?php if($_GET['wallet'] == 'ewallet') { ?>
                                    <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
                                        <div class="form-group">
                                        				<label for="input" class="col-sm-1 control-label">Year</label>
                                                        <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="year_id" name="year_id" value="<?php echo date('Y'); ?>">
                                                        </div>
                                                        
                                                        <label for="input" class="col-sm-1 control-label">Month</label>
                                                        <div class="col-sm-2">
                                                        <select id="month_id" name="month_id" class="form-control">
                                                            <option value="01">January</option>
                                                            <option value="02">February</option>
                                                            <option value="03">March</option>
                                                            <option value="04">April</option>
                                                            <option value="05">May</option>
                                                            <option value="06">June</option>
                                                            <option value="07">July</option>
                                                            <option value="08">August</option>
                                                            <option value="09">September</option>
                                                            <option value="10">October</option>
                                                            <option value="11">November</option>
                                                            <option value="12">December</option>
                                                        </select>
                                                        </div> 
                                                        
                                                        <input type="submit" value="Generate Report" id="buttonPrint" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=printReportAll&wallet=<?php echo $_GET['wallet']; ?>&id=<?php echo $id; ?>'" formtarget="_blank"/> **Enter Year and Month to Print Report 
									<?php } ?>  
                                        </div>
                                    </form>
									
									<div id="jqxgrid">

									</div>
							
								</div>
							</div>
					</div>
				</div>
				

<?php 
} // end of function showList
?>

<?php
function showEWalletAdjustment()
{
include '../main/lang_default.php';
?>
<script type="text/javascript">			

$(document).ready(function () {
		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'ewallet_id', type: 'string'},
				{ name: 'member_reg_no', type: 'string'},
				{ name: 'trans_date', type: 'string'},
				{ name: 'trans_description', type: 'string'},
				{ name: 'amount_out', type: 'string'},
				{ name: 'amount_in', type: 'string'},
				{ name: 'name', type: 'string'},
			],
			
			cache: false,
			url: 'dataEWalletAdjustment.php',
			filter: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid-Setting").jqxGrid('updatebounddata', 'filter');
			},
			sort: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid-Setting").jqxGrid('updatebounddata', 'sort');
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

			
		$("#jqxgrid-Setting").jqxGrid(
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
                        var offset = $("#jqxgrid-Setting").offset();
                        $("#popupWindowAdd").jqxWindow('open');
                        $("#popupWindowAdd").jqxWindow('move', offset.left + 30, offset.top + 30);
                    });									
				},			
				<?php } ?>				
			columns: [ 
				{ text: 'Date', editable: false, datafield: 'trans_date', width: 150 },
				{ text: 'Member Reg No', editable: false, datafield: 'member_reg_no', width: 130 },
				{ text: 'Member Name', editable: false, datafield: 'name', width: 300 },
				{ text: 'Description', editable: false, datafield: 'trans_description', width: 550 },
				{ text: 'In', editable: false, datafield: 'amount_in', width: 100},
				{ text: 'Out',editable: false, datafield: 'amount_out', width: 100},
			]
		});  
		
			// create jqxWindow.
            $("#popupWindowAdd").jqxWindow({ resizable: false,  autoOpen: false, width: 250, height: 340,cancelButton: $("#Cancel"), });
			//$("#popupWindowDetail").jqxWindow({ resizable: false,  autoOpen: false, width: 220, height: 250,cancelButton: $("#Cancel"), });							
	});			

</script>
													<form action="" method="post" name="theFormAdd" id="theFormAdd">
                                                    <div id="popupWindowAdd">
                                                   		 <div>
                                                                    <?php echo $lang['ADD_RECORD']; ?></div>
                                                                <div style="overflow: hidden;">
                                                                    <div>
                                                                        Member Reg No</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='member_reg_no_add' type="text" class="jqx-input" style="width: 240px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                        Trans Description</div>
                                                                    <div style='margin-top:5px;'>
                                                                        <textarea class="form-control" id="trans_description_add" rows="3"></textarea>
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                       Amount</div>
                                                                    <div style='margin-top:5px;'>
                                                                         <input id='amount_add' type="text" class="jqx-input" style="width: 240px; height: 23px;" />
                                                                    </div>
                                                                    <div style="margin-top: 7px; clear: both;">
                                                                       Notes : <br />
                                                                       Positive Amount = Reimbursement <br />
                                                                       Negative Amount = Charges
                                                                    </div>
                                                                                                                                   
                                                                    <div style='margin-top:7px;'>
                                                                        <div>
                                                                            <input style="margin-right: 5px;" type="button" id="buttonAdd" value="<?php echo $lang['BUTTON_ADD']; ?>" onclick="document.theFormAdd.action='info_inc.php?action=addEWalletAdjustment&id=<?php echo $_GET[id]; ?>'"/><input id="Cancel" type="button" value="<?php echo $lang['BUTTON_CANCEL']; ?>" />
                                                                        </div>
                                                                    </div>
                                                          </div>
                                                    </div>		
                                        </form>
                                        
													                                              	                                         
                                             <div id="jqxgrid-Setting">
        
                                            </div>                            

<script type="text/javascript">

$(document).ready(function () {


            $('#buttonAdd').on('click', function () {
               $('#theFormAdd').jqxValidator('validate');
            });
			
            // initialize validator.
            $('#theFormAdd').jqxValidator({
                rules: [
						 { input: '#member_reg_no_add', message: 'Required', action: 'keyup, blur', rule: 'required' },	
						 { input: '#trans_description_add', message: 'Required', action: 'keyup, blur', rule: 'required' },	
						 { input: '#amount_add', message: 'Required', action: 'keyup, blur', rule: 'required' },									   
					   ]
            });
			
			//validate success & submit				
			$('#theFormAdd').bind('validationSuccess', function (event) { 
					
			var action = $("#theFormAdd").attr('action');
							
			var form_data = {
				member_reg_no: $("#member_reg_no_add").val(),
				trans_description: $("#trans_description_add").val(),
				amount: $("#amount_add").val(),

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
						
							
							window.location.href = "index.php?view=listEWalletAdjustment&id="+id+'&displayMsg='+displayMsg;
		
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