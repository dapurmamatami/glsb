$(document).ready(function () {
       
	//var theme = getTheme();
	var theme = 'classic';
    // initialize validator.
	 
    $('#theForm').jqxValidator({
     rules: [
				{ input: '#customer_name', message: 'Customer Name is required!', action: 'keyup, blur', rule: 'required'  },
				/**{ input: '#customer_code', message: 'Customer No is required!', action: 'keyup, blur', rule: 'required'  },**/
				{ input: '#customer_code', message: 'Numeric field only!', action: 'keyup, blur', rule: function (input) {
					if (isNaN(input.val())) {
					return false;
					}
					return true;
					}
				} 
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
		customer_name3: $("#customer_name3").val(),
		customer_code: $("#customer_code").val(),
		customer_parent_code: $("#customer_parent_code").val(),
		register_no: $("#register_no").val(),
		address1: $("#address1").val(),
		address2: $("#address2").val(),
		address3: $("#address3").val(),
		address4: $("#address4").val(),
		address5: $("#address5").val(),
		city: $("#city").val(),
		postcode: $("#postcode").val(),
		state: $("#state").val(),
		country: $("#country").val(),
		tel: $("#tel").val(),
		fax: $("#fax").val(),
		duty_check: $("#duty_check").val(),
		//email: $("#email").val(),
		//contact_person: $("#contact_person").val(),
		remark: $("#remark").val(),
		customer_type_id: $('input:radio[name=customer_type_id]:checked').val(),
		//sales_id: $("#sales_id option:selected").val(),
		tmb_name: $("#tmb_name").val(),
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

