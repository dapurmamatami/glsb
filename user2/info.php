<?php
header("Access-Control-Allow-Origin: *");	

function addForm()
{


	 
                             $sql = "SELECT *
                                      FROM product
                                      where active_sw = 1
                                      order by product_id
                                    ";
                              $resultMain=dbQuery($sql);
                              

?>

<script>


function calcTotal(i){

	if(isNaN(document.getElementById("product_qty" + i).value) || document.getElementById("product_qty" + i).value=='')
	{
		document.getElementById("product_total" + i).value = 0;
		document.getElementById("product_total_pv" + i).value = 0;
		document.getElementById("product_weight_in_gram" + i).value = 0;
	}else
	{
		unit_price = document.getElementById("unit_price" + i).value;
		product_qty = document.getElementById("product_qty" + i).value;
		product_pv = document.getElementById("product_pv" + i).value;
		product_weight_in_gram = document.getElementById("product_weight_in_gram" + i).value;

		product_total_pv = parseFloat(product_pv) * parseFloat(product_qty);	
		amount = parseFloat(unit_price) * parseFloat(product_qty);
		total_product_weight = parseFloat(product_weight_in_gram) * parseFloat(product_qty);
				
		document.getElementById("product_total" + i).value = amount.toFixed(2);	
		document.getElementById("product_total_pv" + i).value = product_total_pv.toFixed(0);
		document.getElementById("total_product_weight" + i).value = total_product_weight.toFixed(0);
	}
	
			//x = 4;
			numRecord = '<?php echo dbNumRows($resultMain); ?>';
			total_amount = 0;
			total_weight = 0;
			total_pv = 0;
			
			for (x=1; x<= numRecord; x++)
			{

					
				total_amount2 = document.getElementById("product_total" + x).value;	
				total_weight2 = document.getElementById("total_product_weight" + x).value;
				total_pv2 = document.getElementById("product_total_pv" + x).value;
				//alert(total_amount);
				total_amount = parseFloat(total_amount) + parseFloat(total_amount2);
				total_weight = parseFloat(total_weight) + parseFloat(total_weight2);
			
				document.getElementById("so_total_amount").value = total_amount.toFixed(2);
				document.getElementById("total_weight").value = total_weight;
				
				total_pv = parseFloat(total_pv) + parseFloat(total_pv2);
				document.getElementById("total_pv").value = total_pv;
				
			}
			
			
			//alert(total_weight);
			getCourierAmount(total_weight);
			grand_total = parseFloat(document.getElementById("so_total_amount").value) + parseFloat(document.getElementById("courier_amount").value);
			
			document.getElementById("grand_total").value = grand_total.toFixed(2);

			
		
}



$(document).ready(function () {

			numRecord = '<?php echo dbNumRows($resultMain); ?>';
			
			for (x=1; x<= numRecord; x++)
			{
				
				$('#product_qty'+x).bind('change', {button: x}, function(event) {
	
							amount = calcTotal(event.data.button);
						
				});	

			
				
			}



						
		
			
      		
			$('#buttonAdd').on('click', function () {
                $('#theForm').jqxValidator('validate');
            });

            $('#buttonUpdate').on('click', function () {
                $('#theForm').jqxValidator('validate');
            });
			
 			  $('#buttonDelete').on('click', function () {
				var answer = confirm("Are you sure you want to delete this?");
				if (answer) {
					var validationResult = function (isValid) {
						if (isValid) {
							$("#theForm").submit();
						}
					}
							$('#theForm').jqxValidator('validate', validationResult);
				}else{
					return false;
				
				}
            });	


            // initialize validator.
            $('#theForm').jqxValidator({
                rules: [

						 //{ input: '#name', message: 'Required', action: 'keyup, blur', rule: 'required' },
						// { input: '#tel', message: 'Required', action: 'keyup, blur', rule: 'required' },
						 { input: '#name', message: 'req', action: 'keyup, blur', rule: 'required' },
						 //{ input: '#user_name', message: 'req', action: 'keyup, blur', rule: 'required' },
						 { input: '#email', message: 'req', action: 'keyup, blur', rule: 'required' },
						 { input: '#email', message: 'req', action: 'keyup, blur', rule: 'email' },
						 { input: '#tel', message: 'req', action: 'keyup, blur', rule: 'required' },
						 { input: '#address1', message: 'req', action: 'keyup, blur', rule: 'required' },
						 { input: '#postcode', message: 'req', action: 'keyup, blur', rule: 'required' },
						 { input: '#city', message: 'req', action: 'keyup, blur', rule: 'required' }

						// { input: '#password', message: 'Required', action: 'keyup, blur', rule: 'required' },					   
					   ]
            });
			
			
			
			//validate success & submit				
			$('#theForm').bind('validationSuccess', function (event) { 
			var action = $("#theForm").attr('action');
			$("#buttonAdd").jqxButton({ disabled: true, theme: 'shinyblack' });
							
			var numRecord = $("#total_product").val();
			
			var selectedRecords = new Array();
			for (var m = 1; m <= numRecord; m++) {
				
					//var output_tax_name = 'output_tax' + m;
					
					selectedRecords[m] = 												
					{
							//mode: $("#mode"+[m]).val(),
							//deleteSW: $("#deleteSW"+[m]).prop("checked")?1:0,
							//claim_form_detail_id: $("#claim_form_detail_id"+[m]).val(),
							
							//output_tax: $("#output_tax"+[m]).prop("checked").val(),
							product_id: $("#product_id"+[m]).val(),
							product_qty: $("#product_qty"+[m]).val(),
							//product_id: $("#product_id"+[m]).val(),
							type_id: '6'
					};											
																		
			}										
			var jsontosend = JSON.stringify(selectedRecords);

			
			var numRecordB = 1;
			
			var selectedRecordsB = new Array();
			for (var m = 1; m <= numRecordB; m++) {
					
					selectedRecordsB[m] = 												
					{
						
						name: $("#name").val(),
						ic_no: $("#ic_no").val(),
						nationality_id: $("#nationality_id option:selected").val(),
						nationality_name: $("#nationality_id option:selected").text(),
						address1: $("#address1").val(),
						postcode: $("#postcode").val(),
						city: $("#city").val(),		
						state_id: $("#state_id option:selected").val(),
						state_prefix: $("#state_id option:selected").text(),
						country_id: $("#country_id option:selected").val(),
						//country_name: $("#country_id option:selected").text(),
						prefix_name: $("#country_id option:selected").text(),
						tel: $("#tel").val(),
						email: $("#email").val(),
						//bank_id: $("#bank_id option:selected").val(),
						//bank_name: $("#bank_id option:selected").text(),
						//bank_swift_code: $("#bank_id option:selected").text(),
						//bank_account_no: $("#bank_account_no").val(),
						user_name: $("#user_name").val(),
						password: $("#password").val(),
						user_group: $("#user_group").val(),
						//remark: $("#remark").val(),
						member_reg_no: $("#member_reg_no").val(),
						sponsor_member_reg_no: $("#sponsor_member_reg_no").val(),
						
										
					};											
																		
			}										
			var jsontosendB = JSON.stringify(selectedRecordsB);

			if(this.id == 'buttonAdd') {							
				var actionName ='add2';
				
			}
			
			
				$.ajax({
					type: "POST",
					url: action,
					//data: form_data,
					data: {mydata: jsontosend, mydataB: jsontosendB, action:actionName,},
					dataType: "json",
					
					success: function(response) {
					
						var id = response["id"];
						var success = response["success"];
						var displayMsg = response["displayMsg"];
		
			
						if (success == 1) {
						
							
							//window.location.href = "index.php?view=detail&id="+id+'&displayMsg='+displayMsg;
							//window.top.location.href = "index.php?view=detail&id="+id+'&displayMsg='+displayMsg;
							window.top.location.href = "../../thanks.php?id="+id;
							//window.parent.location = "http://www.example.com/index.php";
							//alert("You will now be redirected.");
							//window.location = "http://www.aspsnippets.com/";							
							
		
						} else {
		
							$("#buttonAdd").jqxButton({ disabled: false});
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


var ajax = new Array();

function getCourierAmount()
{
				
				//var brandname = 'brand_id1';
				var total_weight = document.getElementById('total_weight').value;
				var x = 1;
				
				//alert(brand_id);
				
				if(total_weight > 0){
				
					//alert("Yesssss");
					var index = ajax.length;
						ajax[index] = new sack();
						
						ajax[index].requestFile = 'getCourierAmount.php?total_weight='+total_weight;	// Specifying which file to get
						ajax[index].onCompletion = function(){ createCourierAmount(index, x) };	// Specify function that will be executed after file has been found
						ajax[index].runAJAX();		// Execute AJAX function
						

				}
				else
				{				
					//alert("No");
				}
				
}
			
function createCourierAmount(index, x)
{
				//var brand_id = document.getElementById('courier_amount' + x);
				//var obj = document.getElementById('project_idC' + x);
				var obj = document.getElementById('courier_amount');
						
				eval(ajax[index].response);	// Executing the response from Ajax as Javascript code	

			grand_total = parseFloat(document.getElementById("so_total_amount").value) + parseFloat(document.getElementById("courier_amount").value);
			
			document.getElementById("grand_total").value = grand_total.toFixed(2);
}	
			
</script> 
              
              <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm" target="hidden_iframe" 
onsubmit="submitted=true;">
      
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                        <p class="font_7">&nbsp;</p> 	

                    </div>                       
                                  
                                    <!--
                                    <ul class="nav nav-tabs">
                                      <li class="active"><a href="#detail" data-toggle="tab">Worker Details</a></li>	
                                    </ul>
                                    -->

<table border="0" class="table table-bordered" width="100%">
                    <tr>
                      <th width="450">&nbsp;</th>
                      <th width="180">Harga<br /> 
                        Seunit <br />
                      (RM)</th>
                      <th width="180" >PV Seunit</th>
                      <th width="90" >Kuantity</th>
                      <th width="150" >Jumlah Harga (RM)</th>
                      <th width="91" >Jumlah PV</th>
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
                      <td><?php echo "<input type='text' name='product_name$x' id='product_name$x'  size='10' class='form-control' value=".$row[product_name]."  disabled=disabled/>"; ?><?php echo "<input type='hidden' name='product_id$x' id='product_id$x' class='form-control'  value=".$row[product_id]." />";  echo "<input type='hidden' name='product_weight_in_gram$x' id='product_weight_in_gram$x' class='form-control'  value=".$row[weight_in_gram]." />" ?></td>
                      <td align="right"><?php  echo "<input type='text' name='unit_price$x' id='unit_price$x'  size='3' class='form-control' value=".$row[selling_price]."  disabled=disabled/>"; ?></td>
                      <td><?php echo "<input type='text' name='product_pv$x' id='product_pv$x' size='5'  class='form-control'  value=".$row[point_value]." disabled=disabled/>"; ?></td>
                      <td><?php  echo "<input type='text' name='product_qty$x' id='product_qty$x'  size='5' class='form-control' />"; ?></td>
                      <td><?php  echo "<input type='text' name='product_total$x' id='product_total$x'  size='15' class='form-control'  value='0' disabled=disabled/>"; ?></td>
                      <td><?php  echo "<input type='text' name='product_total_pv$x' id='product_total_pv$x'  size='5' class='form-control'  disabled=disabled value='0'/>"; ?>
                      <?php  echo "<input type='hidden' name='total_product_weight$x' id='total_product_weight$x'  size='5' class='form-control' value='0'/>"; ?></td>
                    </tr>
                    <?php 
									$x++;
                                 }
                            }
                                        
                    ?>
                    
                    <tr>
                      <th>&nbsp;</th>
                      <th colspan="3" align="right">Jumlah - RM / PV</th>
                   
                      <th style="width: 40px"><input name="so_total_amount" type="text" disabled=disabled id="so_total_amount" value="0" size="8" class='form-control'/></th>
                      <th style="width: 40px"><input name="total_pv" type="text" disabled="disabled" id="total_pv" value="0" size="8" class='form-control'/></th>
                    </tr>
                    <tr>
                      <th>&nbsp;</th>
                      <th colspan="3" align="right">Caj Penghantaran - RM</th>

                      <th style="width: 40px"><input name="courier_amount" type="text"  id="courier_amount" value="0" size="8" disabled=disabled class='form-control'/></th>
                      <th style="width: 40px"></th>
                    </tr>
                    <tr>
                      <th>&nbsp;</th>
                      <th colspan="3" align="right">Jumlah Perlu Bayar - RM</th>
                      <th style="width: 40px"><input name="grand_total" type="text" disabled="disabled" id="grand_total" value="0" size="8" class='form-control'/></th>
                      <th style="width: 40px"><input type="hidden" name="total_weight" id="total_weight" /></th>
                    </tr>                    
                  </table>
                  </br>
                  </br>                                    
                                    <div class="tab-content">
                                    
                                      <div class="active tab-pane" id="detail">

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Nombor Ahli Penaja  (Biarkan kosong jika anda tidak tahu nombor ahli penaja anda)</label>
                                            <div class="col-md-2">
                                              <input name="sponsor_member_reg_no" type="text" class="form-control" id="sponsor_member_reg_no" value="<?php echo $_GET['id'] ; ?>" />
                                                                               
                                          </div>		
                                           
                                        </div>
                                      </div>
                                                                      
                                        <div class="form-group">
                                           	<label class="col-md-2 control-label">Nama</label>
											<div class="col-md-6">
												<input name="name" type="text" class="form-control" id="name" />
											</div>
										</div>
                                        
                                     <div class="form-group">
                                             <label class="col-md-2 control-label">Email</label>
											<div class="col-md-3">
												<input name="name" type="text" class="form-control" id="email" />
											</div>                                    
                                    </div>  
                                     <div class="form-group">
                                           	<label class="col-md-2 control-label">Telefon Bimbit</label>
											<div class="col-md-3">
												<input name="tel" type="text" class="form-control" id="tel" />
											</div>
                                            

									</div> 
                                    
                                                                            
 									<div class="form-group">
                                            <label for="inputExperience" class="col-sm-2 control-label">Alamat</label>
                                            <div class="col-sm-5">
                                              <textarea class="form-control" id="address1"></textarea>
                                            </div>
                                    </div>
                                       <div class="form-group">     
                                            <label for="inputName" class="col-sm-1 control-label">Poskod</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="postcode" >
                                      </div>
                                      </div>
                                                                                                                                                               
                                                                                                                                                                                                     
                                          <div class="form-group">
                                          <label for="inputName" class="col-sm-1 control-label">Bandar</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="city" >
                                            </div>     
                                          </div>
                                          <div class="form-group">
                                           <label for="inputName" class="col-sm-1 control-label">Negeri</label>
                                            <div class="col-sm-2">
                                              <select name='state_id' id='state_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM state
																	 ";
														$result=dbQuery($sql);												
														
														if(dbNumRows($result)>0)
														{														
															
															
															while($row=dbFetchAssoc($result))
															{

																if($row[state_id]==$state_id){
																	$cSelect="SELECTED";
																}else{
																	$cSelect="";
																}
																														
																echo "<option value='$row[state_id]' $cSelect>$row[state_name]</option>";
															}
														}
									
													?>
                    </select>
                                            </div>
                                            </div>
                                            <div class="form-group">
                                            
                                             <label for="inputName" class="col-sm-1 control-label">Negara</label>
                                            <div class="col-sm-2">
                                              <select name='country_id' id='country_id' class="form-control">
            <?php
														$sql = "SELECT *
																		FROM country where country_id = 1
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
                                      </div> 
                                            

       
                                                                                    

          
                                   
                    </div><!-- /.tab-pane -->
                                                                          
 
                </div><!-- /.tab-content -->
                                 
                </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <table width="100%" border="0">
					  <tr>
								    <td width="37%">&nbsp;</td>
								    <td width="52%"><h5>Klik BELI SEKARANG dan buat pendaftaran untuk membuka akaun menjadi ahli Go Lestary</h5></td>
								    <td width="11%"><input type="button" id="buttonAdd" style="background: url(../images/buybutton.png); height: 35px; width: 130px" onClick="document.theForm.action='info_inc.php?action=add2'"/></td>
							      </tr>
				    </table>
								<div style="float: right;">								


        						
           			</div>	
                </div><!-- /.box-footer -->
               	
            
		      </form>


<?php } //end of fuction add ?>


<?php
function getDetailForm($id)
{
	header('Location: http://www.ccm.net/forum/');  
?>
<table width="600" border="0">
	  <tr>
	    <td><p>TERIMA KASIH di atas pembelian anda.</p>
	      <p><br />
        </p></td>
	    <td width="126" rowspan="13">&nbsp;</td>
      </tr>
	  <tr>
	    <td width="464">NOMBOR PESANAN PEMBELIAN ANDA : <?php echo $_GET['id']; ?></td>
      </tr>
	  <tr>
	    <td>&nbsp;</td>
      </tr>
	  <tr>
	    <td>Sila buat pembayaran dengan mendepositkan bayaran anda ke dalam akaun Maybank. Anda diberi tempoh 7 hari untuk menjelaskan pembayaran</td>
      </tr>
	  <tr>
	    <td>&nbsp;</td>
      </tr>
	  <tr>
	    <td>BAYAR KEPADA:</td>
      </tr>
	  <tr>
	    <td><p>Go Lestary Sdn Bhd</p>
	      <p>    Maybank - Nombor Akaun  5620-8560-5702</p>
        <p>    Email: golestary.glsb@gmail.com</p></td>
      </tr>
	  <tr>
	    <td>&nbsp;</td>
      </tr>
	  <tr>
	    <td>SELEPAS PEMBAYARAN TELAH DIBUAT, SILA WHATSAPP atau TELEGRAM atau MMS</td>
      </tr>
	  <tr>
	    <td>&nbsp;</td>
      </tr>
	  <tr>
	    <td><ol>
	      <li>
	        <p>Slip Pembayaran (bukti pembayaran telah dibuat)</p>
          </li>
	      <li>
	        <p>Nombor pesanan pembelian seperti di atas</p>
          </li>
        </ol></td>
      </tr>
	  <tr>
	    <td>&nbsp;</td>
      </tr>
	  <tr>
	    <td><p>KEPADA:</p>
        <p>    012-333-7646  |   019-282-9427</p></td>
      </tr>
</table>
<?php 	
}
	
?>

<?php

function showList()
{

?>
<script type="text/javascript">

$(document).ready(function () {

		
		var user_sub = '<?php echo  $_GET['sub']; ?>';
				
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'user_id', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'ic_no', type: 'string'},
				{ name: 'address1', type: 'string'},
				{ name: 'tel', type: 'string'},
				{ name: 'email', type: 'string'},
				{ name: 'bank_name', type: 'string'},
				{ name: 'bank_swift_code', type: 'string'},
				{ name: 'bank_account_no', type: 'string'},
				{ name: 'user_name', type: 'string'},
				{ name: 'member_reg_no', type: 'string'},
				{ name: 'status_name', type: 'string'},
			],
				
			cache: false,
			url: 'data.php?sub='+user_sub,
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
			
			//filterable: true,
			//sortable: true,
			columnsresize: true,
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
				//{ text: '', editable: false, datafield: 'user_id', width: 80 ,cellsrenderer: linkrenderer},
				
				{ text: 'Member Registration Number',editable: true, datafield: 'member_reg_no', width: 230 },
				{ text: 'Status',editable: true, datafield: 'status_name', width: 120 },
				{ text: 'Name', editable: true, datafield: 'name', width: 300 },
				//{ text: 'Address',editable: false, datafield: 'address1', width: 300 },
				{ text: 'Mobile Phone', editable: true, datafield: 'tel', width: 130 },
				{ text: 'Email',editable: true, datafield: 'email', width: 300 },
				//{ text: 'Bank',editable: false, datafield: 'bank_name', width: 150 },
				//{ text: 'Bank Swift Code',editable: false, datafield: 'bank_swift_code', width: 150 },
				//{ text: 'Bank Account',editable: false, datafield: 'bank_account_no', width: 150 },
				//{ text: 'User ID',editable: false, datafield: 'user_name', width: 150 },
				
				
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

function showListMember($status_id)
{

?>
<script type="text/javascript">

$(document).ready(function () {

		
		var status_id = '<?php echo  $_GET['status_id']; ?>';
				
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'user_id', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'ic_no', type: 'string'},
				{ name: 'address1', type: 'string'},
				{ name: 'tel', type: 'string'},
				{ name: 'email', type: 'string'},
				{ name: 'bank_name', type: 'string'},
				{ name: 'bank_swift_code', type: 'string'},
				{ name: 'bank_account_no', type: 'string'},
				{ name: 'user_name', type: 'string'},
				{ name: 'u_id', type: 'string'},
			],
				
			cache: false,
			url: 'dataMember.php?status_id='+status_id,
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
				{ text: '', editable: false, datafield: 'u_id', width: 80 ,cellsrenderer: linkrenderer},
				{ text: 'Name', editable: false, datafield: 'name', width: 200 },
				{ text: 'IC Number',editable: false, datafield: 'ic_no', width: 150 },
				{ text: 'Address',editable: false, datafield: 'address1', width: 300 },
				{ text: 'Mobile Phone', editable: false, datafield: 'tel', width: 100 },
				{ text: 'Email',editable: false, datafield: 'email', width: 200 },
				{ text: 'Bank',editable: false, datafield: 'bank_name', width: 150 },
				{ text: 'Bank Swift Code',editable: false, datafield: 'bank_swift_code', width: 150 },
				{ text: 'Bank Account',editable: false, datafield: 'bank_account_no', width: 150 },
				{ text: 'User ID',editable: false, datafield: 'user_name', width: 150 },
				
				
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