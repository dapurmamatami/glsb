$(document).ready(function () {
       
	//var theme = getTheme();
	var theme = 'classic';
    // initialize validator.
	 
    $('#theForm').jqxValidator({
     rules: [
				{ input: '#customer_name', message: 'Customer Name is required!', action: 'keyup, blur', rule: 'required'  }
			], theme: theme
     });
	// end of validator


    //button click
	$('#buttonAdd').bind('click', function () {
		var validationResult = function (isValid) {
			if (isValid) {
				$("#theForm").submit();
			}
		}
				$('#theForm').jqxValidator('validate', validationResult);
     });
	 //end of button click


    //button click
	$('#buttonDelete').bind('click', function () {
								var agree=confirm("Are you sure you want to delete this record?");

								if (agree)
								{
										$("#theForm").submit();
								}
     });
	 //end of button click
		
	//validate success & submit				
	$('#theForm').bind('validationSuccess', function (event) { 
			
	var action = $("#theForm").attr('action');
					
	var form_data = {
		customer_name: $("#customer_name").val(),
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

