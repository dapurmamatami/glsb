<?php
function addForm()
{
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
					
	var form_data = {
		request_date: $("#request_date").val(),
		user_id: $("#user_id option:selected").val(),
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
	
	}); 
	//end of validate sucess and submit
	
			
});
    </script>


              <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
              <div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                        <div class="box-header with-border">

                          <h3 class="box-title">E-Wallet Available Balance :<?php echo $available_balance; ?></h3> 	
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
                                            <label for="input" class="col-sm-2 control-label">Request Date</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="request_date" readonly="readonly" value="<?php echo date('d-m-Y'); ?>">
                                            </div>
                                            
                                            <label for="inputName" class="col-sm-1 control-label">Request By</label>
                                            <div class="col-sm-2">
                                              <select name='user_id' id='user_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM user where user_id = $_SESSION[user_id]
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[user_id]==$user_id){
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
				{ name: 'remark', type: 'string'}
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
				{ text: 'Remark',editable: false, datafield: 'remark', width: 500 }
			]
		});  
		
				
						
});

</script>
								
				<div class="box box-warning">
                  <div class="box-body">                                   
                    <div class="col-md-12">


							<form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
								<input type="submit" value="Print" id="buttonPrint" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=printReportAll&report_name=pending_monthly_payout&id=<?php echo $id; ?>'" formtarget="_blank"/>
                                
                                
							</form>
                            
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
				{ name: 'user_name', type: 'string'},
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
				{ text: 'Member', editable: false, datafield: 'user_name', width: 100 },
				{ text: 'Description', editable: false, datafield: 'trans_description', width: 550 },
				//{ text: 'Currency', editable: false, datafield: 'currency_name', width: 70 },
				{ text: 'In', editable: false, datafield: 'amount_in', width: 100, cellsalign: 'right', cellsformat: 'd2' },
				{ text: 'Out',editable: false, datafield: 'amount_out', width: 100, cellsalign: 'right', cellsformat: 'd2' }								
				//{ text: 'In', editable: false, datafield: 'amount_in', width: 100, cellsalign: 'right', cellsformat: 'd2', aggregates: ['sum'] },
				//{ text: 'Out',editable: false, datafield: 'amount_out', width: 100, cellsalign: 'right', cellsformat: 'd2', aggregates: ['sum']  }
			]
		});  
		
				
						
});

</script>
				
                <?php 
				if($_GET[wallet] == 'ewallet')
				{
					$wallet_balance = 'E-Wallet Balance : ' . walletBalance('acct_ewallet', $_SESSION['user_id']);	
					
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
                    <div class="widget-header" >
                    <?php if($_GET['wallet'] <> 'ewalletWithdraw') { ?>
                    <h4> <?php echo $wallet_balance; ?> </h4>
                    <?php } ?>
                    </div>                                                 
                    <div class="col-md-12">
							
							<div class="widget-content">
                            
                            <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
                            <div class="form-group">
                                            <label for="input" class="col-sm-3 control-label">Date From</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="date_from" name="date_from" value="<?php echo date('01-m-Y'); ?>">
                                            </div> 
                                            
                                            <label for="input" class="col-sm-1 control-label">Date To</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="date_to" name="date_to"  value="<?php echo date('d-m-Y'); ?>">
                                            </div>   
                                            </div>
                            
                             <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
                                         <input type="submit" value="Print" id="buttonPrint" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=printReportAll&wallet=<?php echo $_GET['wallet']; ?>&id=<?php echo $id; ?>'" formtarget="_blank"/>
                                        </form> 
									
									<div id="jqxgrid">

									</div>
							</div>

					</div>
				</div>
				

<?php 
} // end of function showList
?>