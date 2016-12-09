$(document).ready(function () {
      

            $('#buttonAdd').on('click', function () {
                $('#theForm').jqxValidator('validate');
            });
					
			
            // initialize validator.
            $('#theForm').jqxValidator({
                rules: [
						 { input: '#sponsor_user_name', message: 'Required', action: 'keyup, blur', rule: 'required' },
						 { input: '#name', message: 'Required', action: 'keyup, blur', rule: 'required' },						 
						 { input: '#upline_user_name', message: 'Required', action: 'keyup, blur', rule: 'required' },
						 {input: '#placement_side', message: 'Required', action: 'select', rule: function(input){
									var val = $("#placement_side option:selected").val();
									//alert(val);
									if(val==""){
									return false;
									}
									return true;
									}
						 },	
						 {input: '#pkg_id', message: 'Required', action: 'select', rule: function(input){
									var val = $("#pkg_id option:selected").val();
									//alert(val);
									if(val==""){
									return false;
									}
									return true;
									}
						 }			   
					   ]
            });
			
			
			
			//validate success & submit				
			$('#theForm').bind('validationSuccess', function (event) { 
					
			var action = $("#theForm").attr('action');
							
			var form_data = {
				name: $("#name").val(),
				sponsor_user_name: $("#sponsor_user_name").val(),
				upline_user_name: $("#upline_user_name").val(),
				placement_side: $("#placement_side option:selected").val(),
				pkg_id: $("#pkg_id option:selected").val(),
				name: $("#name").val(),
				id_no: $("#id_no").val(),
				email: $("#email").val(),
				address1: $("#address1").val(),
				city: $("#city").val(),
				state: $("#state").val(),
				country: $("#country").val(),
				postcode: $("#postcode").val(),
				hp: $("#hp").val(),
				bank_name: $("#bank_name").val(),
				bank_account_holder: $("#bank_account_holder").val(),
				bank_account_no: $("#bank_account_no").val(),
				//tmb_sw: $('input:radio[name=tmb_sw]:checked').val(),
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
						
							
							window.location.href = "index.php?view=list&displayMsg="+displayMsg;
		
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




            $('#buttonFreeUpgrade').on('click', function () {
                $('#theFreeUpgradeForm').jqxValidator('validate');
            });
					
			
            // initialize validator.
            $('#theFreeUpgradeForm').jqxValidator({
                rules: [
						 { input: '#user_name', message: 'Required', action: 'keyup, blur', rule: 'required' }			   
					   ]
            });
			
			


	
			
});

