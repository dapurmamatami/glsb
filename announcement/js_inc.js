$(document).ready(function () {

			$('#anno_date').datepicker({ dateFormat: 'dd-mm-yy' });      

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
						 { input: '#anno_title', message: 'Required', action: 'keyup, blur', rule: 'required' },
									   
					   ]
            });


          
			//validate success & submit				
			$('#theForm').bind('validationSuccess', function (event) { 
					
			var action = $("#theForm").attr('action');
							
			var form_data = {
				anno_title: $("#anno_title").val(),
				anno_description: $("#anno_description").val(),
				anno_date: $("#anno_date").val(),
				active_sw: $('input:radio[name=active_sw]:checked').val(),
				sorting_number: $("#sorting_number").val(),
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

