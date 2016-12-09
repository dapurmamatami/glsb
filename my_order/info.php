<?php
function addForm()
{
	
	$user_data = getUserDetail($_SESSION[user_id]);
	
	$setupData = getCompanySetupDetailForm(1);
	$manual_withdrawal_charge = $setupData[manual_withdrawal_charge];
	$min_balance_to_keep = $setupData[min_balance_to_keep];
	$commission_period_sw = $setupData[commission_period_sw];
	
	$available_balance = walletAvailableBalance($_SESSION[user_id]) - $manual_withdrawal_charge - $min_balance_to_keep;

	if($available_balance > 0) {
		$available_balance = $available_balance;
	}else{
		$available_balance = 0;
	}
	
	$today = date('Y-m-d');
	if (checkClosing($today, 1, 0)){
?>
   
<script>


var ajax = new Array();

function getMemberName(x)
{		

		var member_reg_no = document.getElementById('member_reg_no').value;
		//stateName = inputState.options[inputState.selectedIndex].value;
		//document.getElementById('inputArea1').options.length = 'Please select area';
		//document.getElementById('inputArea2').options.length = 'Please select area';
		//document.getElementById('inputArea3').options.length = 'Please select area';
		//document.getElementById('inputArea4').options.length = 'Please select area';
				

				
		//if(sponsor_user_name.length>0){
		if(member_reg_no != ''){
					
			var index = ajax.length;
			ajax[index] = new sack();
						
			ajax[index].requestFile = 'getMemberName.php?member_reg_no='+member_reg_no;	// Specifying which file to get
			ajax[index].onCompletion = function(){ createMemberName(index) };	// Specify function that will be executed after file has been found
			ajax[index].runAJAX();		// Execute AJAX function
						

		}
		else
		{				
			
		}
				
}
			
function createMemberName(index)
{
		//var channel_id = document.getElementById('channel_id');
		//var obj = document.getElementById('name');
		var obj = document.getElementById('so_address');
		//var obj = document.getElementById('inputArea1');
		//var obj2 = document.getElementById('inputArea2');
		//var obj3 = document.getElementById('inputArea3');
		//var obj4 = document.getElementById('inputArea4');

						
		eval(ajax[index].response);	// Executing the response from Ajax as Javascript code	
}
</script> 
          
              <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
              <div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                        <div class="box-header with-border">
                          <h3 class="box-title"></h3> 	
										<div style="float: right;">								
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        						<input type="button" value="BUY" id="buttonAdd" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=add'"/>
	                  <?php } ?>
										</div>
                         </div> 
                        <div class="tab-content">
                          <div class="active tab-pane" id="detail">
                                <div class="form-group">
                                	<label for="inputName" class="col-sm-2 control-label">Order Date</label>
                                    <div class="col-sm-2">
                                    <?php echo date('d-m-Y'); ?>  
                                    </div>                                                                        
                                 </div>

                                <div class="form-group">
                                	<label for="inputName" class="col-sm-2 control-label">Member Reg No</label>
                                    <div class="col-sm-2">
                                		
                                        <input name="member_reg_no" id="member_reg_no" type="text" onchange="getMemberName(this.value)" value="<?php if($_SESSION['user_grp'] == 10) { echo $user_data['member_reg_no']; } ?>" <?php if($_SESSION['user_grp'] == 10) { ?> readonly=readonly <?php } ?>/> 
                                    </div> 
                                                                                                           
                                 </div>
                                  
 
                                <div class="form-group">
											<label class="col-md-2 control-label">Delivery Method  </label>
											<div class="col-md-3">
                                            Courier
                                            <!--
                                            <input name="courier_sw" id="courier_sw" type="radio" value="0" checked="checked"/>
											Pickup &nbsp;&nbsp;&nbsp;&nbsp;
											<input name="courier_sw" id="courier_sw" type="radio" value="1"/>
											Courier
                                            -->
							  				</div>
                                          	</div>
                                            
										<div class="form-group">
											<label class="col-md-2 control-label">Payment Method  </label>
											<div class="col-md-5">
                                            <input name="paid_by_ewallet_sw" id="paid_by_ewallet_sw" type="radio" value="0" checked="checked"/> 

											Cash &nbsp;&nbsp;&nbsp;&nbsp;
											<input name="paid_by_ewallet_sw" id="paid_by_ewallet_sw" type="radio" value="1"  />
                                            <?php if($_SESSION['user_grp'] == 10) { ?>
											eWallet &nbsp;&nbsp; <strong>(Available Balance = RM<?php echo $available_balance; ?>)</strong>
                                            <?php } 
											else { ?>
											eWallet 
                                            <?php } ?>
                                            </div>                                                                                                                     
										</div>
                                        
                                        <?php if ($commission_period_sw == 1) { ?>
                                        <div class="form-group">     
											<label for="inputName" class="col-sm-2 control-label">Period Name</label>
                                            <div class="col-sm-2">
                                                <select name='period_id' id='period_id' class="form-control">
                                                <?php
                                                    $sql = "SELECT * FROM commission_period where active_sw = 1";
                                                    
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
										</div>
                                 		<?php } ?>
                                        
                                 <div class="form-group">
                                            <label for="inputExperience" class="col-sm-2 control-label">Payment Remarks</label>
                                            <div class="col-sm-8">
                                              <textarea name="internal_remark" rows="3" class="form-control" id="internal_remark"></textarea>
                                            </div>
                                </div>
                                
                                 <div class="form-group">

                                            <label for="inputExperience" class="col-sm-2 control-label">Delivery Address</label>
                                            <div class="col-sm-8">
                                            <?php if($_SESSION['user_grp'] == 10) { ?>
                                              <textarea rows="3" class="form-control" id="so_address"><?php echo $user_data['address1']; ?>&#13;&#10;<?php echo $user_data['postcode']; ?>&nbsp;<?php echo $user_data['city']; ?>,&#13;&#10;<?php echo $user_data['state_name']; ?>&#13;&#10;<?php echo $user_data['country_name']; ?></textarea>
                                            <?php } 
											else { ?>
											<textarea rows="3" class="form-control" id="so_address"></textarea>
                                            <?php } ?>
                                            </div>
                                              <input type="hidden" class="form-control" id="customer_id"  value="<?php echo $user_data['user_id']; ?>" />
                                              <input type="hidden" class="form-control" id="so_customer_name"  value="<?php echo $user_data['name']; ?>" />
                                </div>
                                            
 								<div class="form-group">
                               	
                                </div>

                                 <div class="form-group">
                                	 <div class="col-sm-1">  
                                     </div>
                                     <div class="col-sm-9">       
                                            
                  <table border="1" class="table table-bordered">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Product</th>
                      <th>Unit Price</th>
                      <th style="width: 40px">Quantity</th>
                    </tr>
                    
                    <?php
                             $sql = "SELECT *
                                      FROM product
                                      where active_sw = 1
                                      order by product_id
                                    ";
                              $result=dbQuery($sql);
                              if(dbNumRows($result)>0)
                              {
                                                    
                                  $x = 1;   
								  $total_product = dbNumRows($result);
								  
								   echo "<input type='hidden' name='total_product' id='total_product' class='form-control' value=".$total_product." />";
								   
                                  while($row=dbFetchAssoc($result))
                                  {
													
					?>
                    <tr>
                      <td><?php echo $x; echo "<input type='hidden' name='product_id$x' id='product_id$x' class='form-control' value=".$row[product_id]." />"; ?></td>
                      <td><?php echo $row['product_name']; ?></td>
                      <td><?php echo $row['selling_price']; ?></td>
                      <td><?php  echo "<input type='text' name='product_qty$x' id='product_qty$x' class='form-control' />"; ?></td>
                    </tr>
                    <?php 
									$x++;
                                 }
                            }
                                        
                    ?>
                  </table>

                                            	</div>
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
<?php } else { echo 'Temporary Disabled'; } ?>

<?php } //end of fuction add ?>



<?php
function getDetailForm($id,$displayMsg)
{
	
  $data = getSaleOrderDetail($id);
	
	 
		if ($data != ""){
	
?>

<script>
$(document).ready(function () {  
		
		$('input:radio[name=courier_sw]:nth(<?php echo $data['courier_sw']; ?>)').attr('checked',true); 
		$('input:radio[name=paid_by_ewallet_sw]:nth(<?php echo $data['paid_by_ewallet_sw']; ?>)').attr('checked',true);
		
		$('#delivery_date').datepicker({ dateFormat: 'yy-mm-dd' });

});
</script> 

 <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm" target="blank">
              <div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                        <div class="box-header with-border">
                          <h3 class="box-title"></h3> 	
										<div style="float: right;">								

										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'delete_sw')){ ?>
                                <?php if($data[status_id] == 1) { ?>       
        						<input type="button" value="Cancel Order" id="buttonDelete" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=delete&id=<?php echo $id; ?>'"/>
                                <?php } ?>
	                  <?php } ?>   
                      
                      <?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>						  <?php if($data[status_id] == 1) { ?>
        						<input type="button" value="APPROVE" id="buttonApprove" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=changestatus&id=<?php echo $id; ?>&status_id=5'"/>
                                <?php } ?>
                                
       
                                 <?php if($data[status_id] == 5 and $data[delivery_sw] == 0) { ?>
        						<input type="button" value="Deliver" id="buttonDeliver" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=changeDeliveryStatus&id=<?php echo $id; ?>&status_id=1'"/>
                                <?php } ?>
                                
                                 <?php if($data[status_id] != '-1') { ?>
                                <input type="button" value="Update" id="buttonUpdate" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=update&id=<?php echo $id; ?>&status_id=1'"/>
                                <?php } ?>   
                                
	                  <?php } ?>   
                      <input type="submit" value="Print" id="buttonPrint" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=printReport&id=<?php if($data[status_id]==5) { echo 'App'.$data[file_name]; } else { echo $data[file_name]; } ?>'"/>                
										</div>
                         </div>                       
                                  <div class="tab-content">
                                    
                                      <div class="active tab-pane" id="detail">
                                      
                                          <div class="form-group">
                                          
                                          <div class="form-group">                                           
                                            <label for="inputName" class="col-sm-2 control-label">Order Date</label>
                                            <div class="col-sm-2">
                                              <?php echo $data['so_date']; ?>  
                                            </div>  
                                            
                                             <label for="inputName" class="col-sm-2 control-label">Status</label>
                                            <div class="col-sm-2">
                                              <?php echo $data['status_name']; ?>   - <?php echo $data['delivery_name']; ?>
                                            </div>  
                                            </div>
                                                                           
                               <div class="form-group">
                                	<label for="inputName" class="col-sm-2 control-label">Member Reg No</label>
                                    <div class="col-sm-2">
                                		<?php echo $data['member_reg_no']; ?>
                                    </div> 
                                	<label for="inputName" class="col-sm-2 control-label">Member Name</label>
                                    <div class="col-sm-2">
                                		<?php echo $data['name']; ?>
                                    </div>                                                                                                           
                                 </div>
                                  
 
                                <div class="form-group">
											<label class="col-md-2 control-label">Delivery Method  </label>
											<div class="col-md-2">
											Courier
                                            <!--
                                            <input name="courier_sw" id="courier_sw" type="radio" value="0" checked="checked"/>
											Pickup &nbsp;&nbsp;&nbsp;&nbsp;
											<input name="courier_sw" id="courier_sw" type="radio" value="1"/>
											Courier
                                            -->
							  				</div>
                                            </div>
										<div class="form-group">                                             
											<label class="col-md-2 control-label">Payment Method  </label>
											<div class="col-md-3">
                                            <input name="paid_by_ewallet_sw" id="paid_by_ewallet_sw" type="radio" /> 

											Cash &nbsp;&nbsp;&nbsp;&nbsp;
											<input name="paid_by_ewallet_sw" id="paid_by_ewallet_sw" type="radio" value="1"  />
											eWallet
							  				 </div>                                                                                                                    
										</div>
                                        
                                        <?php if ($commission_period_sw == 1) { ?>
                                        <div class="form-group">     
											<label for="inputName" class="col-sm-2 control-label">Period Name</label>
                                            <div class="col-sm-2">
                                                <select name='period_id' id='period_id' class="form-control">
                                                <?php
                                                    $sql = "SELECT * FROM commission_period where active_sw = 1";
                                                    
                                                    $result=dbQuery($sql);												
                                                            
                                                    if(dbNumRows($result)>0)
                                                    {
                                                        while($row=dbFetchAssoc($result))
                                                        {
                                                            if($row[period_id]==$data['period_id'])
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
										</div>
                                 		<?php } ?>
                                        
                                 <div class="form-group">

                                            <label for="inputExperience" class="col-sm-2 control-label">Payment Remarks</label>
                                            <div class="col-sm-8">
                                              <textarea rows="3" class="form-control" id="internal_remark"><?php echo $data['internal_remark']; ?></textarea>
                                            </div>
                                </div>
                                
                                 <div class="form-group">

                                            <label for="inputExperience" class="col-sm-2 control-label">Delivery Address</label>
                                            <div class="col-sm-8">
                                              <textarea class="form-control" id="so_address"><?php echo $data[so_address]; ?></textarea>
                                            </div>
                                              <input type="hidden" class="form-control" id="customer_id"  value="<?php echo $user_data['user_id']; ?>" />
                                              <input type="hidden" class="form-control" id="so_customer_name"  value="<?php echo $user_data['name']; ?>" />
                                </div>
                                            
 								<div class="form-group">
									<label for="inputExperience" class="col-sm-2 control-label">Delivery Date</label>			                                    <div class="col-sm-2">
                                    <input type="text" class="form-control" id="delivery_date"  value="<?php echo $data['delivery_date']; ?>" />   
                                     </div>  
                                </div>
                                <div class="form-group">     
									<label for="inputExperience" class="col-sm-2 control-label">Courier Company</label>			                                    <div class="col-sm-2">
                                    <input type="text" class="form-control" id="delivery_courier_company"  value="<?php echo $data['delivery_courier_company']; ?>" />   
                                     </div>    
                                     
									<label for="inputExperience" class="col-sm-2 control-label">Courier Ref No</label>			                                    <div class="col-sm-2">
                                    <input type="text" class="form-control" id="delivery_courier_ref_no"  value="<?php echo $data['delivery_courier_ref_no']; ?>" />   
                                     </div>                                                                                                    	
                                </div>
                                <div class="form-group"> 
									 <label for="inputExperience" class="col-sm-2 control-label">Total Weight (gram)</label>
                                     <div class="col-sm-2">
                                     <?php echo $data['total_weight_in_gram']; ?>
                                     </div>			

									 <label for="inputExperience" class="col-sm-2 control-label">Courier Amount</label>
                                     <div class="col-sm-2">
                                     <?php echo $data['courier_amount']; ?>
                                     </div> 
                                     <label for="inputExperience" class="col-sm-2 control-label">Total Amount</label>
                                     <div class="col-sm-2">
                                     <?php echo $data['amount']; ?>
                                     </div>                                                                                                      
                                </div>  
                                <div class="form-group"> 
                                </div>          
 
                                         <div class="form-group">
                                         	<div class="col-sm-1">
                                            </div>
                                         	<div class="col-sm-9">
                                         
<table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Product</th>
                      <th>Unit Price</th>
                      <th style="width: 40px">Quantity</th>
                    </tr>
                    
                    <?php
                             $sql = "SELECT sorder_detail.*
                                      FROM sorder_detail left join product 
									  on sorder_detail.product_id = product.product_id
                                      where sorder_detail.so_id = $id
                                      order by sod_id
                                    ";
                              $result=dbQuery($sql);
                              if(dbNumRows($result)>0)
                              {
                                                    
                                  $x = 1;   
								  $total_product = dbNumRows($result);
								  
								   echo "<input type='hidden' name='total_product' id='total_product' class='form-control' value=".$total_product." />";
								   
                                  while($row=dbFetchAssoc($result))
                                  {
													
					?>
                    <tr>
                      <td><?php echo $x; echo "<input type='hidden' name='product_id$x' id='product_id$x' class='form-control' value=".$row[product_id]." />"; ?></td>
                      <td><?php echo $row['product_name']; ?></td>
                      <td><?php echo $row['unit_price']; ?></td>
                      <td><?php  echo $row['quantity']; ?></td>
                    </tr>
                    <?php 
									$x++;
                                 }
                            }
                                        
                    ?>
                  </table>                   </div>
                 						   </div>                      
										<form>

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
	
		$('#date_from').datepicker({ dateFormat: 'dd-mm-yy' }); 	
		$('#date_to').datepicker({ dateFormat: 'dd-mm-yy' }); 
		
		var subname = '<?php echo $_GET[sub]; ?>';
		var status_id = '<?php echo $_GET[status_id]; ?>';
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'so_id', type: 'string'},
				{ name: 'so_no', type: 'string'},
				{ name: 'status_id', type: 'string'},
				{ name: 'status_name', type: 'string'},
				{ name: 'so_date', type: 'string'},
				{ name: 'approve_date_sorder', type: 'string'},
				{ name: 'so_address', type: 'string'},
				{ name: 'so_postcode', type: 'string'},
				{ name: 'so_city', type: 'string'},
				{ name: 'so_state', type: 'string'},
				{ name: 'so_country', type: 'string'},
				{ name: 'total_weight_in_gram', type: 'string'},
				{ name: 'courier_amount', type: 'string'},
				{ name: 'total_pv', type: 'string'},
				{ name: 'amount', type: 'string'},
				{ name: 'member_reg_no', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'file_name', type: 'string'},
			],
				
			cache: false,
			url: 'data.php?status_id='+status_id+'&subname='+subname,
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
		
		var linkrenderer2 = function (row, column, value) {
			if (value.indexOf('#') != -1) {
				value = value.substring(0, value.indexOf('#'));
			}
			var format = { target: '"_blank"' };
			var html = $.jqx.dataFormat.formatlink(value, format);
			
			var file_name = value + '.pdf';

			editrow = row;
      		var offset = $("#jqxgrid").offset();

      		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
			status_id = dataRecord.status_id;
			
			if(status_id == 5)
			{
				file_name = 'App' + file_name;
				
			}
			else
			{
				file_name = file_name;
			}
				
					//return "<a href='" + value + "' target='_blank'>Link Text</a>";
			return "<a href=../upload_glsb/" + file_name +  " target='_blank'>Print</a>";
		}	
							
			
		$("#jqxgrid").jqxGrid(
		{	
			source: dataadapter,
			
			filterable: true,
			sortable: true,
			columnsresize: true,
			editable: true,
			//autoheight: true,
			pageable: true,
			virtualmode: true,
			width: '98%',	
			selectionmode: 'none',
            altrows: true,	
			rendergridrows: function(obj)
			{
				return obj.data;    
			},		
			columns: [ 
				{ text: '', editable: false, datafield: 'file_name', width: 50 ,cellsrenderer: linkrenderer2},
				<?php if ($_SESSION['user_grp'] == 1 ) { ?>
				{ text: '', editable: false, datafield: 'so_id', width: 50 ,cellsrenderer: linkrenderer},
				<?php } ?>
			
				{ text: 'Status', editable: false, datafield: 'status_name', width: 100 },
				{ text: 'Order ID',editable: false, datafield: 'so_no', width: 80 },
				//{ text: 'Member No',editable: false, datafield: 'member_reg_no', width: 100 },
				//{ text: 'Member Name',editable: false, datafield: 'name', width: 200 },
				{ text: 'Order Date',editable: false, datafield: 'so_date', width: 160 },
				{ text: 'Approved Date',editable: false, datafield: 'approve_date_sorder', width: 160 },
				{ text: 'Total PV', editable: false, datafield: 'total_pv', width: 70 },
				{ text: 'Order Amount', editable: false, datafield: 'amount', width: 120 },
			]
		});  
			

								
});

</script>

				<div class="box box-warning">
                  <div class="box-body">                                   
                    <div class="col-md-12">

							<div class="widget-content">
							
                             <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
                            			<div class="form-group">
                                            <label for="input" class="col-sm-1 control-label">Date From</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="date_from" name="date_from" value="<?php echo date('01-m-Y'); ?>" />
                                            </div> 
                                            
                                            <label for="input" class="col-sm-1 control-label">Date To</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="date_to" name="date_to" value="<?php echo date('d-m-Y'); ?>">
                                            </div> 
                                            
                                            <?php if ($_SESSION['user_grp'] <> 10) { ?>
                                            <label for="input" class="col-sm-1 control-label">Status</label>
                                            <div class="col-sm-2">
                                            	<select name="status_id" id="status_id" class="form-control">
                                                <?php
                                                    $sql = "SELECT * FROM sorder_status where status_id <> 1 order by status_name asc";
                                                    
                                                    $result=dbQuery($sql);												
                                                            
                                                    if(dbNumRows($result)>0)
                                                    {
                                                        while($row=dbFetchAssoc($result))
                                                        {
                                                            if($row[status_id]==$status_id)
                                                            {
                                                                $cSelect="SELECTED";
                                                            }
                                                            else
                                                            {
                                                                $cSelect="";
                                                            }
                                                                echo "<option value='$row[status_id]' $cSelect>$row[status_name]</option>";
                                                        }
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                            <?php } ?>  
                                            			
                                                         <input type="submit" value="Print Report" id="buttonPrint" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=printReportAll2&sub=<?php echo $_GET['sub']; ?>'" formtarget="_blank"/>
                                                         </div>
                                                        </form> 
									<div id="jqxgrid">

									</div>
							</div>

					</div>
				</div>

<?php 
} // end of function showList

?>


<?php

function showPendingList()
{

?>
<script type="text/javascript">

$(document).ready(function () {
	
		//process button clicked
		
        $('#buttonApproveBySelection').on('click', function () {

			 $('#theApproveForm').jqxValidator('validate');
        });

           // initialize validator.
            $('#theApproveForm').jqxValidator({
                rules: [
						 //{ input: '#jqxInput', message: 'Required', action: 'keyup, blur', rule: 'required' },
									   
					   ]
            });
			
			//validate success & submit				
			$('#theApproveForm').bind('validationSuccess', function (event) { 


			var rows = $("#jqxgrid").jqxGrid('selectedrowindexes');
			var selectedRecords = new Array();
			var selectedRecords2 = new Array();
			//var selectedRecords = new Array();
			for (var m = 0; m < rows.length; m++) {
				var row = $("#jqxgrid").jqxGrid('getrowdata', rows[m]);
				selectedRecords[selectedRecords.length] = row;
												
				selectedRecords[m] = 
				{
					chkBox : row['chkBox'],
					//chkBoxRemove : row['chkBoxRemove'],
					so_id : row['so_id'],
					//qty : row['qty'],
					//qty_receive : row['qty_receive'],
	
				};								
																
			}						
			var jsontosend = JSON.stringify(selectedRecords);
															
		
			//var action = $("#theRequestItemForm").attr('action');
			var actionName = 'approveBySelection';
		    //var removeChk = $("#removeChk").prop("checked")?1:0;	
			//var customer_id = $("#customer_id option:selected").val();						
			/**
			var form_data = {
				request_date: $("#request_date").val(),
				project_id: $("#project_id option:selected").val(),
				status_id: $("#status_id option:selected").val(),
				remark: $("#remark").val(),
				is_ajax: 1
			};
			**/
				
				$.ajax({
					type: "POST",
					//url: action,
					//data: form_data,
					url: "info_inc.php?action="+actionName,			
					data: {mydata: jsontosend},					
					dataType: "json",
					
					success: function(response) {
					
						var id = response["id"];
						var success = response["success"];
						var displayMsg = response["displayMsg"];
		
			
						if (success == 1) {
						
							
							window.location.href = "index.php?view=list&sub=pending&id="+id+'&displayMsg='+displayMsg;
		
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
		//end of process button clicked			
						
		
		var status_id = '<?php echo $_GET[sub]; ?>';
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'so_id', type: 'string'},
				{ name: 'so_no', type: 'string'},
				{ name: 'status_name', type: 'string'},
				{ name: 'so_date', type: 'string'},
				{ name: 'approve_date_pending', type: 'string'},
				{ name: 'so_address', type: 'string'},
				{ name: 'so_postcode', type: 'string'},
				{ name: 'so_city', type: 'string'},
				{ name: 'so_state', type: 'string'},
				{ name: 'so_country', type: 'string'},
				{ name: 'total_weight_in_gram', type: 'string'},
				{ name: 'courier_amount', type: 'string'},
				{ name: 'total_pv', type: 'string'},
				{ name: 'amount', type: 'string'},
				{ name: 'member_reg_no', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'file_name', type: 'string'},
			],
				
			cache: false,
			url: 'dataPending.php?status_id='+status_id,
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
		
		var linkrenderer2 = function (row, column, value) 
		{
			if (value.indexOf('#') != -1) 
			{
				value = value.substring(0, value.indexOf('#'));
			}
			var format = { target: '"_blank"' };
			var html = $.jqx.dataFormat.formatlink(value, format);
			
			var file_name = value + '.pdf';

			return "<a href=../upload_glsb/" + file_name +  " target='_blank'>Print</a>";
		}	
							
        var columnCheckBox = null;
        var updatingCheckState = false;
			
		$("#jqxgrid").jqxGrid(
		{	
			source: dataadapter,
			
			filterable: true,
			sortable: true,
			columnsresize: true,
			editable: true,
			//autoheight: true,
			pageable: true,
			virtualmode: true,
			width: '98%',	
			selectionmode: 'none',
            altrows: true,	
			rendergridrows: function(obj)
			{
				return obj.data;    
			},		
			columns: [ 
				//{ text: '', editable: false, datafield: 'file_name', width: 50 ,cellsrenderer: linkrenderer2},
				<?php if ($_SESSION['user_grp'] == 1 ) { ?>
				{ text: '', editable: false, datafield: 'so_id', width: 50 ,cellsrenderer: linkrenderer},
				<?php } ?>
				
                  {
                      text: '', menu: false, sortable: false,
                      datafield: 'chkBox', columntype: 'checkbox', width: 40,
                      renderer: function () {
                          return '<div style="margin-left: 10px; margin-top: 5px;"></div>';
                      },
                      rendered: function (element) {
                          $(element).jqxCheckBox({ width: 16, height: 16, animationShowDelay: 0, animationHideDelay: 0 });
                          columnCheckBox = $(element);
                          $(element).on('change', function (event) {
                              var checked = event.args.checked;
                              var pageinfo = $("#jqxgrid").jqxGrid('getpaginginformation');
                              var pagenum = pageinfo.pagenum;
                              var pagesize = pageinfo.pagesize;
                              if (checked == null || updatingCheckState) return;
                              $("#jqxgrid").jqxGrid('beginupdate');

                              // select all rows when the column's checkbox is checked.
                              if (checked) {
                                  $("#jqxgrid").jqxGrid('selectallrows');	
								  
                              }
                              // unselect all rows when the column's checkbox is checked.
                              else if (checked == false) {
                                  $("#jqxgrid").jqxGrid('clearselection');
                              }

                              // update cells values.
                              var startrow = pagenum * pagesize;
                              for (var i = startrow; i < startrow + pagesize; i++) {
                                  // The bound index represents the row's unique index. 
                                  // Ex: If you have rows A, B and C with bound indexes 0, 1 and 2, afer sorting, the Grid will display C, B, A i.e the C's bound index will be 2, but its visible index will be 0.
                                  // The code below gets the bound index of the displayed row and updates the value of the row's available column.

						  
                                  var boundindex = $("#jqxgrid").jqxGrid('getrowboundindex', i);
                                  $("#jqxgrid").jqxGrid('setcellvalue', boundindex, 'chkBox', event.args.checked);
									

									if (checked == false) {
										$("#jqxgrid").jqxGrid('unselectrow', event.args.rowindex);
									}
									else
									{
										$("#jqxgrid").jqxGrid('setcellvalue', boundindex, 'chkBox', event.args.checked);
									}
	
																
									//$("#jqxgrid").jqxGrid('setcellvalue',boundindex, 'qty', quantity);	
									
									//var qty = $("#jqxgrid").jqxGrid('getcellvalue', event.args.rowindex, 'qty');
									//if(qty > 0) {
										// $("#jqxgrid").jqxGrid('setcellvalue', boundindex, 'chkBox', event.args.checked);
										//columnCheckBox.jqxCheckBox({ checked: true });
									//}
		
                              		
							  }
							  						  

                              $("#jqxgrid").jqxGrid('endupdate');
                          });
                          return true;
                      } 
                  },				
				{ text: 'Status', editable: false, datafield: 'status_name', width: 70 },
				{ text: 'Order ID',editable: false, datafield: 'so_no', width: 80 },
				{ text: 'Member No',editable: false, datafield: 'member_reg_no', width: 100 },
				{ text: 'Member Name',editable: false, datafield: 'name', width: 200 },
				{ text: 'Order Date',editable: false, datafield: 'so_date', width: 160 },
				//{ text: 'Approved Date',editable: false, datafield: 'approve_date_pending', width: 160 },
				{ text: 'Total PV', editable: false, datafield: 'total_pv', width: 70 },
				{ text: 'Order Amount', editable: false, datafield: 'amount', width: 120 },
			]
		});  
			


          var updatePageState = function (pagenum) {
                var datainfo = $("#jqxgrid").jqxGrid('getdatainformation');
                var pagenum = datainfo.paginginformation.pagenum;
                var pagesize = datainfo.paginginformation.pagesize;
                var startrow = pagenum * pagesize;
                // select the rows on the page.
                $("#jqxgrid").jqxGrid('beginupdate');
                var checkedItemsCount = 0;
                for (var i = startrow; i < startrow + pagesize; i++) {
                    var boundindex = $("#jqxgrid").jqxGrid('getrowboundindex', i);
                    var value = $("#jqxgrid").jqxGrid('getcellvalue', boundindex, 'chkBox');
                    if (value) checkedItemsCount++;
                    if (value) {
                        $("#jqxgrid").jqxGrid('selectrow', boundindex);
						
                    }
                    else {
                        $("#jqxgrid").jqxGrid('unselectrow', boundindex);
                    }
                }

                $("#jqxgrid").jqxGrid('endupdate');
                if (checkedItemsCount == pagesize) {
                    columnCheckBox.jqxCheckBox({ checked: true });
					
                }
                else if (checkedItemsCount == 0) {
                    columnCheckBox.jqxCheckBox({ checked: false });
                }
                else {
                    columnCheckBox.jqxCheckBox({ checked: null });
                }
            }

            // update the selection after sort.
            $("#jqxgrid").on('sort', function (event) {
                updatePageState();
            });

            // update the selection after page change.
            $("#jqxgrid").on('pagechanged', function (event) {
                updatePageState();
            });

            // select or unselect rows when a checkbox is checked or unchecked. 
            //$("#jqxgrid").on('cellvaluechanged', function (event) {
			$("#jqxgrid").bind('cellendedit', function (event) {	
                if (event.args.value) {
                    $("#jqxgrid").jqxGrid('selectrow', event.args.rowindex);


					var chkBox = $("#jqxgrid").jqxGrid('getcellvalue', event.args.rowindex, 'chkBox');
					if(chkBox == true) {
											

					}
							

                }
                else {
					
					var chkBox = $("#jqxgrid").jqxGrid('getcellvalue', event.args.rowindex, 'chkBox');
					if(chkBox == true) {
							
					}
					else {
						//var quantity = 0;	
						//$("#jqxgrid").jqxGrid('setcellvalue', event.args.rowindex, 'qty', quantity);						
						$("#jqxgrid").jqxGrid('unselectrow', event.args.rowindex);
					}
					
					
                }

                // update the state of the column's checkbox. When all checkboxes on the displayed page are checked, we need to check column's checkbox. We uncheck it,
                // when there are no checked checkboxes on the page and set it to intederminate state when there is at least one checkbox checked on the page.  
                if (columnCheckBox) {
                    var datainfo = $("#jqxgrid").jqxGrid('getdatainformation');
                    var pagesize = datainfo.paginginformation.pagesize;
                    var pagenum = datainfo.paginginformation.pagenum;
                    var selectedRows = $("#jqxgrid").jqxGrid('getselectedrowindexes');
                    var state = false;
                    var count = 0;
                    $.each(selectedRows, function () {
                        if (pagenum * pagesize <= this && this < pagenum * pagesize + pagesize) {
                            count++;
							
                        }
                    });

                    if (count != 0) state = null;
                    if (count == pagesize) state = true;
                    if (count == 0) state = false;

                    updatingCheckState = true;
                    $(columnCheckBox).jqxCheckBox({ checked: state });

                    updatingCheckState = false;

					
                }
            });									
});

</script>

				<div class="box box-warning">
                  <div class="box-body">                                   
                    <div class="col-md-12">

 							<form class="form-horizontal" name='theApproveForm' id='theApproveForm'>
 								<input style="margin-right: 5px;" type="button" id="buttonApproveBySelection" value="Approve Selected Item" onclick="document.theApproveForm.action='info_inc.php?action=approveBySelection&amp;id=<?php echo $_GET[id]; ?>'"/>                            
                            </form>
							<div class="widget-content">

                            <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
                                                         <input type="submit" value="PRINT PENDING ORDERS" id="buttonPrint" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=printReportAll&report_name=pending_orders&id=<?php echo $id; ?>'" formtarget="_blank"/>
                                                        </form>
                                        							
									<div id="jqxgrid">

									</div>
							</div>

					</div>
				</div>

<?php 
} // end of function showList

?>
<?php

function showDownlineList()
{

?>
<script type="text/javascript">

$(document).ready(function () {
		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'so_id', type: 'string'},
				{ name: 'so_no', type: 'string'},
				{ name: 'status_name', type: 'string'},
				{ name: 'so_date', type: 'string'},
				{ name: 'approve_date', type: 'string'},
				{ name: 'so_address', type: 'string'},
				{ name: 'so_postcode', type: 'string'},
				{ name: 'so_city', type: 'string'},
				{ name: 'so_state', type: 'string'},
				{ name: 'so_country', type: 'string'},
				{ name: 'total_weight_in_gram', type: 'string'},
				{ name: 'courier_amount', type: 'string'},
				{ name: 'total_pv', type: 'string'},
				{ name: 'amount', type: 'string'},
				{ name: 'member_reg_no', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'file_name', type: 'string'},
				{ name: 'level_name', type: 'string'},
				
			],
				
			cache: false,
			url: 'dataDownline.php',
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

	 	var linkrenderer2 = function (row, column, value) {
			if (value.indexOf('#') != -1) {
				value = value.substring(0, value.indexOf('#'));
			}
			var format = { target: '"_blank"' };
			var html = $.jqx.dataFormat.formatlink(value, format);
			
			var file_name = value + '.pdf';
	
					//return "<a href='" + value + "' target='_blank'>Link Text</a>";
			return "<a href=../upload_glsb/" + file_name +  " target='_blank'>Print</a>";
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
				//{ text: '', editable: false, datafield: 'file_name', width: 50 ,cellsrenderer: linkrenderer2},
				<?php if ($_SESSION['user_grp'] != 10) { ?> 
				{ text: '', editable: false, datafield: 'so_id', width: 50 ,cellsrenderer: linkrenderer},
				<?php } ?>
				{ text: 'Status', editable: false, datafield: 'status_name', width: 100 },
				{ text: 'Order ID',editable: false, datafield: 'so_no', width: 80 },
				{ text: 'Order Date',editable: false, datafield: 'so_date', width: 160 },
				{ text: 'Approved Date',editable: false, datafield: 'approve_date', width: 160 },
				{ text: 'Member Name',editable: false, datafield: 'name', width: 200 },
				{ text: 'Member No',editable: false, datafield: 'member_reg_no', width: 100 },
				{ text: 'Total PV', editable: false, datafield: 'total_pv', width: 70 },
				{ text: 'Order Amount', editable: false, datafield: 'amount', width: 110 },
				{ text: 'Level', editable: false, datafield: 'level_name', width: 70 },
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
function showPendingDelivery()
{

?>
<script type="text/javascript">

$(document).ready(function () {
		
		var delivery_sw = '<?php echo $_GET[delivery_sw]; ?>';
		var status_id = '<?php echo $_GET[status_id]; ?>';
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'so_id', type: 'string'},
				{ name: 'so_no', type: 'string'},
				{ name: 'status_name', type: 'string'},
				{ name: 'so_date', type: 'string'},
				{ name: 'approve_date', type: 'string'},
				{ name: 'so_address', type: 'string'},
				{ name: 'so_postcode', type: 'string'},
				{ name: 'so_city', type: 'string'},
				{ name: 'so_state', type: 'string'},
				{ name: 'so_country', type: 'string'},
				{ name: 'total_weight_in_gram', type: 'string'},
				{ name: 'courier_amount', type: 'string'},
				{ name: 'total_pv', type: 'string'},
				{ name: 'amount', type: 'string'},
				{ name: 'member_reg_no', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'file_name', type: 'string'},
				{ name: 'delivery_sw', type: 'string'},
			],
				
			cache: false,
			url: 'dataPendingDelivery.php?status_id='+status_id + '?delivery_sw='+delivery_sw,
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
		
		var linkrenderer2 = function (row, column, value) {
			if (value.indexOf('#') != -1) {
				value = value.substring(0, value.indexOf('#'));
			}
			var format = { target: '"_blank"' };
			var html = $.jqx.dataFormat.formatlink(value, format);
			
			var file_name = value + '.pdf';
	
					//return "<a href='" + value + "' target='_blank'>Link Text</a>";
			return "<a href=../upload_glsb/" + file_name +  " target='_blank'>Print</a>";
		}	
							
			
		$("#jqxgrid").jqxGrid(
		{	
			source: dataadapter,
			
			filterable: true,
			sortable: true,
			columnsresize: true,
			editable: true,
			//autoheight: true,
			pageable: true,
			virtualmode: true,
			width: '98%',	
			selectionmode: 'none',
            altrows: true,	
			rendergridrows: function(obj)
			{
				return obj.data;    
			},		
			columns: [ 
				{ text: '', editable: false, datafield: 'file_name', width: 60 ,cellsrenderer: linkrenderer2},
				<?php if ($_SESSION['user_grp'] == 1 ) { ?>
				{ text: '', editable: false, datafield: 'so_id', width: 80 ,cellsrenderer: linkrenderer},
				<?php } ?>
			
				{ text: 'Status', editable: false, datafield: 'status_name', width: 100 },
				{ text: 'Delivery Status', editable: false, datafield: 'delivery_sw', width: 100 },
				{ text: 'Order ID',editable: false, datafield: 'so_no', width: 80 },
				{ text: 'Member No',editable: false, datafield: 'member_reg_no', width: 100 },
				{ text: 'Member Name',editable: false, datafield: 'name', width: 350 },
				{ text: 'Order Date',editable: false, datafield: 'so_date', width: 160 },
				{ text: 'Approved Date',editable: false, datafield: 'approve_date', width: 160 },
				{ text: 'Total PV', editable: false, datafield: 'total_pv', width: 70 },
				{ text: 'Order Amount', editable: false, datafield: 'amount', width: 110 },
			]
		});   
			
						
});

</script>

				<div class="box box-warning">
                  <div class="box-body">                                   
                    <div class="col-md-12">

							<div class="widget-content">
                            
                            <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
                             <input type="submit" value="Print" id="buttonPrint" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=printReportAll&report_name=pending_delivery&id=<?php echo $id; ?>'" formtarget="_blank"/>
                            </form>
							
							
									<div id="jqxgrid">

									</div>
							</div>

					</div>
				</div>

<?php 
} // end of function showList

?>

<?php

function showPendingDeliveryList()
{

?>

<script type="text/javascript">

$(document).ready(function () {

		//process button clicked
		/**
        $('#buttonApproveBySelection').on('click', function () {

			 $('#theApproveForm').jqxValidator('validate');
        });

           // initialize validator.
            $('#theApproveForm').jqxValidator({
                rules: [
						 //{ input: '#jqxInput', message: 'Required', action: 'keyup, blur', rule: 'required' },
									   
					   ]
            });
			
			//validate success & submit				
			$('#theApproveForm').bind('validationSuccess', function (event) { 


			var rows = $("#jqxgrid").jqxGrid('selectedrowindexes');
			var selectedRecords = new Array();
			var selectedRecords2 = new Array();
			//var selectedRecords = new Array();
			for (var m = 0; m < rows.length; m++) {
				var row = $("#jqxgrid").jqxGrid('getrowdata', rows[m]);
				selectedRecords[selectedRecords.length] = row;
												
				selectedRecords[m] = 
				{
					chkBox : row['chkBox'],
					//chkBoxRemove : row['chkBoxRemove'],
					so_id : row['so_id'],
					//qty : row['qty'],
					//qty_receive : row['qty_receive'],
	
				};								
																
			}						
			var jsontosend = JSON.stringify(selectedRecords);
															
		
			//var action = $("#theRequestItemForm").attr('action');
			var actionName = 'deliveryBySelection';
			var delivery_courier_company = $("#delivery_courier_company").val();
			var delivery_courier_ref_no = $("#delivery_courier_ref_no").val();
		    //var removeChk = $("#removeChk").prop("checked")?1:0;	
			//var customer_id = $("#customer_id option:selected").val();						
			/**
			var form_data = {
				request_date: $("#request_date").val(),
				project_id: $("#project_id option:selected").val(),
				status_id: $("#status_id option:selected").val(),
				remark: $("#remark").val(),
				is_ajax: 1
			};
			**/
				/**	
				$.ajax({
					type: "POST",
					//url: action,
					//data: form_data,
					url: "info_inc.php?action="+actionName+'&delivery_courier_company='+delivery_courier_company+'&delivery_courier_ref_no='+delivery_courier_ref_no,			
					data: {mydata: jsontosend},					
					dataType: "json",
					
					success: function(response) {
					
						var id = response["id"];
						var success = response["success"];
						var displayMsg = response["displayMsg"];
		
			
						if (success == 1) {
						
							
							window.location.href = "index.php?view=list&sub=pendingdelivery&id="+id+'&displayMsg='+displayMsg;
		
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
		//end of process button clicked			
		**/				
		
		var status_id = '<?php echo $_GET[status_id]; ?>';
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'so_id', type: 'string'},
				{ name: 'so_no', type: 'string'},
				{ name: 'status_name', type: 'string'},
				{ name: 'so_date', type: 'string'},
				{ name: 'approve_date', type: 'string'},
				{ name: 'so_address', type: 'string'},
				{ name: 'so_postcode', type: 'string'},
				{ name: 'so_city', type: 'string'},
				{ name: 'so_state', type: 'string'},
				{ name: 'so_country', type: 'string'},
				{ name: 'total_weight_in_gram', type: 'string'},
				{ name: 'courier_amount', type: 'string'},
				{ name: 'total_pv', type: 'string'},
				{ name: 'amount', type: 'string'},
				{ name: 'member_reg_no', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'file_name', type: 'string'},
			],
				
			cache: false,
			url: 'dataPendingDelivery.php?status_id='+status_id,
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
		
		var linkrenderer2 = function (row, column, value) {
			if (value.indexOf('#') != -1) {
				value = value.substring(0, value.indexOf('#'));
			}
			var format = { target: '"_blank"' };
			var html = $.jqx.dataFormat.formatlink(value, format);
			
			var file_name = value + '.pdf';
	
					//return "<a href='" + value + "' target='_blank'>Link Text</a>";
			return "<a href=../upload_glsb/" + file_name +  " target='_blank'>Print</a>";
		}	
							
        var columnCheckBox = null;
        var updatingCheckState = false;
			
		$("#jqxgrid").jqxGrid(
		{	
			source: dataadapter,
			
			filterable: true,
			sortable: true,
			columnsresize: true,
			editable: true,
			//autoheight: true,
			pageable: true,
			virtualmode: true,
			width: '98%',	
			selectionmode: 'none',
            altrows: true,	
			rendergridrows: function(obj)
			{
				return obj.data;    
			},		
			columns: [ 
				<?php if ($_SESSION['user_grp'] == 1 ) { ?>
				{ text: '', editable: false, datafield: 'so_id', width: 50 ,cellsrenderer: linkrenderer},
				<?php } ?>
						/*
                  		{
                      text: '', menu: false, sortable: false,
                      datafield: 'chkBox', columntype: 'checkbox', width: 40,
                      renderer: function () {
                          return '<div style="margin-left: 10px; margin-top: 5px;"></div>';
                      },
                      rendered: function (element) {
                          $(element).jqxCheckBox({ width: 16, height: 16, animationShowDelay: 0, animationHideDelay: 0 });
                          columnCheckBox = $(element);
                          $(element).on('change', function (event) {
                              var checked = event.args.checked;
                              var pageinfo = $("#jqxgrid").jqxGrid('getpaginginformation');
                              var pagenum = pageinfo.pagenum;
                              var pagesize = pageinfo.pagesize;
                              if (checked == null || updatingCheckState) return;
                              $("#jqxgrid").jqxGrid('beginupdate');

                              // select all rows when the column's checkbox is checked.
                              if (checked) {
                                  $("#jqxgrid").jqxGrid('selectallrows');	
								  
                              }
                              // unselect all rows when the column's checkbox is checked.
                              else if (checked == false) {
                                  $("#jqxgrid").jqxGrid('clearselection');
                              }

                              // update cells values.
                              var startrow = pagenum * pagesize;
                              for (var i = startrow; i < startrow + pagesize; i++) {
                                  // The bound index represents the row's unique index. 
                                  // Ex: If you have rows A, B and C with bound indexes 0, 1 and 2, afer sorting, the Grid will display C, B, A i.e the C's bound index will be 2, but its visible index will be 0.
                                  // The code below gets the bound index of the displayed row and updates the value of the row's available column.

						  
                                  var boundindex = $("#jqxgrid").jqxGrid('getrowboundindex', i);
                                  $("#jqxgrid").jqxGrid('setcellvalue', boundindex, 'chkBox', event.args.checked);
									

									if (checked == false) {
										$("#jqxgrid").jqxGrid('unselectrow', event.args.rowindex);
									}
									else
									{
										$("#jqxgrid").jqxGrid('setcellvalue', boundindex, 'chkBox', event.args.checked);
									}
	
																
									//$("#jqxgrid").jqxGrid('setcellvalue',boundindex, 'qty', quantity);	
									
									//var qty = $("#jqxgrid").jqxGrid('getcellvalue', event.args.rowindex, 'qty');
									//if(qty > 0) {
										// $("#jqxgrid").jqxGrid('setcellvalue', boundindex, 'chkBox', event.args.checked);
										//columnCheckBox.jqxCheckBox({ checked: true });
									//}
		
                              		
							  }
							  						  

                              $("#jqxgrid").jqxGrid('endupdate');
                          });
                          return true;
                      } 
                  },
				 */ 				
				{ text: 'Status', editable: false, datafield: 'status_name', width: 100 },
				{ text: 'Order ID',editable: false, datafield: 'so_no', width: 80 },
				{ text: 'Member No',editable: false, datafield: 'member_reg_no', width: 100 },
				{ text: 'Member Name',editable: false, datafield: 'name', width: 200 },
				{ text: 'Order Date',editable: false, datafield: 'so_date', width: 160 },
				{ text: 'Order Amount', editable: false, datafield: 'amount', width: 110 },
			]
		});  
			
			/*
			//coding for checkbox
			var updatePageState = function (pagenum) {
                var datainfo = $("#jqxgrid").jqxGrid('getdatainformation');
                var pagenum = datainfo.paginginformation.pagenum;
                var pagesize = datainfo.paginginformation.pagesize;
                var startrow = pagenum * pagesize;
                // select the rows on the page.
                $("#jqxgrid").jqxGrid('beginupdate');
                var checkedItemsCount = 0;
                for (var i = startrow; i < startrow + pagesize; i++) {
                    var boundindex = $("#jqxgrid").jqxGrid('getrowboundindex', i);
                    var value = $("#jqxgrid").jqxGrid('getcellvalue', boundindex, 'chkBox');
                    if (value) checkedItemsCount++;
                    if (value) {
                        $("#jqxgrid").jqxGrid('selectrow', boundindex);
						
                    }
                    else {
                        $("#jqxgrid").jqxGrid('unselectrow', boundindex);
                    }
                }

                $("#jqxgrid").jqxGrid('endupdate');
                if (checkedItemsCount == pagesize) {
                    columnCheckBox.jqxCheckBox({ checked: true });
					
                }
                else if (checkedItemsCount == 0) {
                    columnCheckBox.jqxCheckBox({ checked: false });
                }
                else {
                    columnCheckBox.jqxCheckBox({ checked: null });
                }
            }

            // update the selection after sort.
            $("#jqxgrid").on('sort', function (event) {
                updatePageState();
            });

            // update the selection after page change.
            $("#jqxgrid").on('pagechanged', function (event) {
                updatePageState();
            });

            // select or unselect rows when a checkbox is checked or unchecked. 
            //$("#jqxgrid").on('cellvaluechanged', function (event) {
			$("#jqxgrid").bind('cellendedit', function (event) {	
                if (event.args.value) {
                    $("#jqxgrid").jqxGrid('selectrow', event.args.rowindex);


					var chkBox = $("#jqxgrid").jqxGrid('getcellvalue', event.args.rowindex, 'chkBox');
					if(chkBox == true) {
											

					}
							

                }
                else {
					
					var chkBox = $("#jqxgrid").jqxGrid('getcellvalue', event.args.rowindex, 'chkBox');
					if(chkBox == true) {
							
					}
					else {
						//var quantity = 0;	
						//$("#jqxgrid").jqxGrid('setcellvalue', event.args.rowindex, 'qty', quantity);						
						$("#jqxgrid").jqxGrid('unselectrow', event.args.rowindex);
					}
					
					
                }

                // update the state of the column's checkbox. When all checkboxes on the displayed page are checked, we need to check column's checkbox. We uncheck it,
                // when there are no checked checkboxes on the page and set it to intederminate state when there is at least one checkbox checked on the page.  
                if (columnCheckBox) {
                    var datainfo = $("#jqxgrid").jqxGrid('getdatainformation');
                    var pagesize = datainfo.paginginformation.pagesize;
                    var pagenum = datainfo.paginginformation.pagenum;
                    var selectedRows = $("#jqxgrid").jqxGrid('getselectedrowindexes');
                    var state = false;
                    var count = 0;
                    $.each(selectedRows, function () {
                        if (pagenum * pagesize <= this && this < pagenum * pagesize + pagesize) {
                            count++;
							
                        }
                    });

                    if (count != 0) state = null;
                    if (count == pagesize) state = true;
                    if (count == 0) state = false;

                    updatingCheckState = true;
                    $(columnCheckBox).jqxCheckBox({ checked: state });

                    updatingCheckState = false;

					
                }
            });
			*/									
});

</script>

				<div class="box box-warning">
					<div class="box-body">
						<div class="col-md-12">
                        							
							<!---
 							<form class="form-horizontal" name='theApproveForm' id='theApproveForm'>
                            
                                <label for="input" class="col-sm-2 control-label">Courier</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" id="delivery_courier_company">
								</div>
                                                
                                <label for="input" class="col-sm-2 control-label">Courier Reference Num</label>
                                <div class="col-sm-2">
                                	<input type="text" class="form-control" id="delivery_courier_ref_no">
                                </div>   
                            
                              
 								<input style="margin-right: 5px;" type="button" id="buttonApproveBySelection" value="Delivery Done" onclick="document.theApproveForm.action='info_inc.php?action=deliveryBySelection&amp;id=<?php echo $_GET[id]; ?>'"/>
                            
                            </form>
 							--->
                            
							<div class="widget-content">
                            
                            <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
							<input type="submit" value="PRINT PENDING DELIVERY LIST" id="buttonPrint" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=printReportAll&report_name=pending_delivery&id=<?php echo $id; ?>'" formtarget="_blank"/>
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