<?php
function addCustomerForm()
{
?>

				<!--=== Page Content ===-->
				<!--=== Full Size Inputs ===-->
				<form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
				<div class="row">
					<div class="col-md-12">				
							<div class="widget box">
								<div class="widget-header" >	
								<h4><i class="icon-reorder"></i> Add New Customer/Vendor</h4>	
										<div style="float: right;">								
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        						<input type="button" value="Add" id="buttonAdd" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=add&id=<?php echo $id; ?>'"/>		
	                  <?php } ?>
        						<input name="SubmitCancel" type="submit" class="btn btn-primary" id="SubmitCancel" value="Cancel" onClick="document.theForm.action='info_inc.php?action=cancel&id=<?php echo $id; ?>'" />
										</div>
								</div>
								
								<div class="widget-content">
									
										
										<div class="form-group">

											<label class="col-md-2 control-label"> Type:</label>
											<div class="col-md-4">
											  <input name="customer_type_id" type="radio" value="1" checked="checked" />
											Customer 
											<input name="customer_type_id" type="radio" value="2" />
											Vendor</div>
											
											
														
										</div>
										
										<div class="form-group">										
											<label class="col-md-2 control-label"> Name :</label>
											<div class="col-md-9">
												<input name="customer_name" type="text" class="form-control" id="customer_name" value="<?php echo $customer_name; ?>" />
											</div>

											<label class="col-md-2 control-label">Trading As :</label>
											<div class="col-md-9">
												<input name="customer_name3" type="text" class="form-control" id="customer_name3" value="<?php echo $customer_name3; ?>" />
											</div>
																																
											<label class="col-md-2 control-label">Customer/Vendor No:</label>
											<div class="col-md-2">
												<input type="text" name="customer_code" id="customer_code" value="<?php echo $customer_code; ?>" class="form-control" />
											</div>
											<label class="col-md-5 control-label">Link to parent :</label>
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
				{ name: 'customer_id'},
				{ name: 'customer_type_name'},
				{ name: 'customer_code', type: 'string'},
				{ name: 'tel', type: 'string'},
				{ name: 'fax', type: 'string'},
				{ name: 'reg_no', type: 'string'},
				{ name: 'email', type: 'string'},
				{ name: 'customer_name', type: 'string'},
				{ name: 'customer_name3', type: 'string'},
				{ name: 'address1'},
				{ name: 'address2'},
				{ name: 'address3'},
				{ name: 'address4'},
				{ name: 'address5'},
				{ name: 'contact_person_1'},
				{ name: 'contact_person_2'},
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
			columns: [ 
				{ text: '', editable: false, datafield: 'customer_id', width: 60 ,cellsrenderer: linkrenderer},
				{ text: 'Name', editable: false, datafield: 'customer_name', width: 250 },
				{ text: 'Trading Name', editable: false, datafield: 'customer_name3', width: 250 },
				{ text: 'Type', editable: false, datafield: 'customer_type_name', width: 100 },
				{ text: 'Customer/Vendor No', editable: false, datafield: 'customer_code', width: 150 },
				{ text: 'Street1',editable: false, datafield: 'address1', width: 200 },
				{ text: 'Street2',editable: false, datafield: 'address2', width: 150 },
				{ text: 'Street3',editable: false, datafield: 'address3', width: 150 },
				{ text: 'Street4',editable: false, datafield: 'address4', width: 150 },
				{ text: 'Street5',editable: false, datafield: 'address5', width: 150 },	
				{ text: 'Tel',editable: false, datafield: 'tel', width: 100 },			
				{ text: 'Fax',editable: false, datafield: 'fax', width: 100 }
			]
		});  
		
				
						
});

</script>

				<div class="row">
					<div class="col-md-12">
						<div class="widget box">
							<div class="widget-header">
								<h4><i class="icon-reorder"></i> Customer/Vendor Listing</h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content">
							
									<div id="jqxgrid">

									</div>
							</div>
						</div>
					</div>
				</div>
				

<?php 
} // end of function showList

?>