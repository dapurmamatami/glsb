$(document).ready(function () {



            $('#buttonUpdate').on('click', function () {
                $('#theUpdateForm').jqxValidator('validate');
            });

            // initialize validator.
            $('#theUpdateForm').jqxValidator({
                rules: [
						{ input: '#current_password', message: 'Current Password is required!', action: 'keyup, blur', rule: 'required'  },
						{ input: '#new_password', message: 'Your new_password must be between 6 and 15 characters!', action: 'keyup, blur', rule: 'length=6,15' },
						{ input: '#new_password_confirm', message: 'Your Confirm Password  must be between 6 and 15 characters!', action: 'keyup, blur', rule: 'length=6,15' }		   
					   ]
            });
			
			
			
			//validate success & submit				
			$('#theUpdateForm').bind('validationSuccess', function (event) { 
					
			var action = $("#theUpdateForm").attr('action');
							
			var form_data = {
				current_password: $("#current_password").val(),
				new_password: $("#new_password").val(),
				new_password_confirm: $("#new_password_confirm").val(),
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
						
							
							window.location.href = "../main/index.php";
		
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

