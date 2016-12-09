$(document).ready(function () {
       
      		

            $('#buttonUpdate').on('click', function () {
                $('#theForm').jqxValidator('validate');
            });

 			$('#buttonUpdate2').on('click', function () {
                $('#theForm').jqxValidator('validate');
            });
            // initialize validator.
            $('#theForm').jqxValidator({
                rules: [

						 { input: '#company_name', message: 'Required', action: 'keyup, blur', rule: 'required' },	
						 { input: '#gst_rate', message: 'Required', action: 'keyup, blur', rule: 'required' },						   
					   ]
            });
			
			
			
			//validate success & submit				
			$('#theForm').bind('validationSuccess', function (event) { 
					
			var action = $("#theForm").attr('action');
							
			var form_data = {
				company_name: $("#company_name").val(),
				code: $("#code").val(),
				register_no: $("#register_no").val(),
				gst_no: $("#gst_no").val(),
				address1: $("#address1").val(),
				postcode: $("#postcode").val(),
				city: $("#city").val(),
				state: $("#state").val(),
				country: $("#country").val(),
				tel: $("#tel").val(),
				fax: $("#fax").val(),
				email: $("#email").val(),
				remark: $("#remark").val(),
				invoice_message: $("#invoice_message").val(),
				statement_message: $("#statement_message").val(),
				cheque_payable: $("#cheque_payable").val(),
				remit_to: $("#remit_to").val(),
				bank_name: $("#bank_name").val(),
				acct_type: $("#acct_type").val(),
				acct_no: $("#acct_no").val(),
				swiftcode: $("#swiftcode").val(),
				send_to: $("#send_to").val(),
				
				//update company setup
				setup_id: $("#setup_id").val(),
				gst_sw: $('input:radio[name=gst_sw]:checked').val(),
				gst_rate: $("#gst_rate").val(),
				pending_member_day: $("#pending_member_day").val(),
				pending_sale_order_day: $("#pending_sale_order_day").val(),
				monthly_payout_day: $("#monthly_payout_day").val(),
				monthly_bonus_limit: $("#monthly_bonus_limit").val(),
				bonus_member_pv: $("#bonus_member_pv").val(),
				bonus_downline_pv: $("#bonus_downline_pv").val(),
				min_account_value: $("#min_account_value").val(),
				request_payout_charge: $("#request_payout_charge").val(),
				activate_account_charge: $("#activate_account_charge").val(),
				manual_withdrawal_charge: $("#manual_withdrawal_charge").val(),
				admin_charge: $("#admin_charge").val(),
				min_balance_to_keep: $("#min_balance_to_keep").val(),
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
						
							
							window.location.href = "index.php?view=detail&id="+id+'&displayMsg='+displayMsg;
		
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

