$(document).ready(function () {
      		
			$('#start_calc_date').datepicker({ dateFormat: 'yy-mm-dd' });  
			
            $('#buttonUpdate').on('click', function () {
                $('#theForm').jqxValidator('validate');
            });			

            $('#buttonApprove').on('click', function () {
                $('#theForm').jqxValidator('validate');
            });	

            $('#buttonDeliver').on('click', function () {
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
						 { input: '#period_id', message: 'Required', action: 'select', rule: function(input){
							var val = $("#period_id option:selected").val();
							//alert(val);
							if(val==0){
								return false;
							}
								return true;
							}
						},					   
					   ]
            });
			
			
			
			//validate success & submit				
			$('#theForm').bind('validationSuccess', function (event) { 
					
			var action = $("#theForm").attr('action');
	

			//var numRecordEdit = $("#numRecordEdit").val();
			//var numRecord = $("#numRecord").val();	
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
						customer_id: $("#customer_id").val(),
						member_reg_no: $("#member_reg_no").val(),
						so_customer_name: $("#so_customer_name").val(),
						so_address: $("#so_address").val(),
						internal_remark: $("#internal_remark").val(),
						period_id: $("#period_id option:selected").val(),
						start_calc_date: $("#start_calc_date").val(),
						//so_country: $("#so_country").val(),		
						//so_country: $("#so_country").val(),	
						total_product: $("#total_product").val(),
						//courier_sw: $('input:radio[name=courier_sw]:checked').val(),	
						paid_by_ewallet_sw: $('input:radio[name=paid_by_ewallet_sw]:checked').val(),
						delivery_date: $("#delivery_date").val(),
						delivery_courier_company: $("#delivery_courier_company").val(),
						delivery_courier_ref_no: $("#delivery_courier_ref_no").val(),
						is_ajax: 1
					};											
																		
			}										
			var jsontosendB = JSON.stringify(selectedRecordsB);


			if(this.id == 'buttonUpdate') {							
				var actionName ='update';
			}
			if(this.id == 'buttonDeliver') {							
				var actionName ='changeDeliveryStatus';
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
						var customerSW = response["customerSW"];
						var displayMsg = response["displayMsg"];
		
			
						if (success == 1) {
							
							if (displayMsg == "updated")
							{
								window.location.href = "index.php?view=detail&id="+id+'&displayMsg='+displayMsg;
							}
							else
							{
								if(customerSW == 1) {
									
									window.location.href = "index.php?view=list&sub=myorder"+'&displayMsg='+displayMsg;
								}else{
									window.location.href = "index.php?view=detail&id="+id+'&displayMsg='+displayMsg;
								}
								
							}
							
						} else {
		
							//if(this.id == 'buttonAdd') {
								//$("#buttonAdd").jqxButton({ disabled: false});
							//}
							
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

