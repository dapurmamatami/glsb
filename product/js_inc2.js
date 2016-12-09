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


            // initialize validator.
            $('#theForm').jqxValidator({
                rules: [

						 { input: '#product_name', message: 'Required', action: 'keyup, blur', rule: 'required' }							   
					   ]
            });
			
			
			
			//validate success & submit				
			$('#theForm').bind('validationSuccess', function (event) { 
					
			var action = $("#theForm").attr('action');
							
			var form_data = {
				product_code: $("#product_code").val(),
				product_category: $("#product_category").val(),
				product_name: $("#product_name").val(),
				product_short_name: $("#product_short_name").val(),
				selling_price: $("#selling_price").val(),
				cost_of_good_sold: $("#cost_of_good_sold").val(),
				profit: $("#profit").val(),
				bonus_pool: $("#bonus_pool").val(),
				comm_level1: $("#comm_level1").val(),
				comm_level2: $("#comm_level2").val(),
				comm_level3: $("#comm_level3").val(),
				point_value: $("#point_value").val(),
				gst_rate_type: $("#gst_rate_type").val(),
				gst_rate: $("#gst_rate").val(),
				weight_in_gram: $("#weight_in_gram").val(),
				personal_comm: $("#personal_comm").val(),
				product_description: $("#product_description").val(),
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

