$(document).ready(function () {
       
      		

            $('#buttonUpdate').on('click', function () {
                $('#theForm').jqxValidator('validate');
            });

            // initialize validator.
            $('#theForm').jqxValidator({
                rules: [

						 { input: '#host_password', message: 'Required', action: 'keyup, blur', rule: 'required' },
						 //{ input: '#host_port', message: 'Required', action: 'keyup, blur', rule: 'required' },							   
					   ]
            });
			
			
			
			//validate success & submit				
			$('#theForm').bind('validationSuccess', function (event) { 
					
			var action = $("#theForm").attr('action');
							
			var form_data = {
				host_name: $("#host_name").val(),
				host_user_name: $("#host_user_name").val(),
				host_password: $("#host_password").val(),
				host_port: $("#host_port").val(),
				host_mail_from: $("#host_mail_from").val(),
				host_mail_from_name: $("#host_mail_from_name").val(),
				notify_send_to: $("#notify_send_to").val(),
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
						
							
							window.location.href = "index.php?view=detail&sub=email&id="+id+'&displayMsg='+displayMsg;
		
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

