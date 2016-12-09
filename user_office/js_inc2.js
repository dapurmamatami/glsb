$(document).ready(function () {     

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
			
			$('#buttonResetPassword').on('click', function () {
				var answer = confirm("Are you sure to change password?");
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
						{ input: '#name', message: 'Name is required..!', action: 'keyup, blur', rule: 'required'  },
						{ input: '#user_name', message: 'Your username must be between 5 and 15 characters!', action: 'keyup, blur', rule: 'length=5,15'  },
						{ input: '#password', message: 'Your password must be between 6 and 15 characters!', action: 'keyup, blur', rule: 'length=6,50'  },			
						{input: '#user_group', message: 'User group required', action: 'select', rule: function(input){
								var val = $("#user_group option:selected").val();
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
			user_name: $("#user_name").val(),
			password: $("#password").val(),
			name: $("#name").val(),
			user_group: $("#user_group option:selected").val(),
			remark: $("#remark").val(),
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

