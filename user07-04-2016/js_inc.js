$(document).ready(function () {
       
	//var theme = getTheme();
	var theme = 'classic';
    // initialize validator.
    $('#theForm').jqxValidator({
     rules: [
				{ input: '#name', message: 'Name is Required!', action: 'keyup, blur', rule: 'required'  },
				{ input: '#user_name', message: 'Your User ID must be between 5 and 15 characters!', action: 'keyup, blur', rule: 'length=5,15'  },
				{ input: '#password', message: 'Your password must be between 6 and 15 characters!', action: 'keyup, blur', rule: 'length=6,50'  },			
				{input: '#user_group', message: 'User Group Required', action: 'select', rule: function(input){
						var val = $("#user_group option:selected").val();
						//alert(val);
						if(val==""){
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
	$('#buttonResetPassword').bind('click', function () {
		var validationResult = function (isValid) {
			if (isValid) {
				$("#theForm").submit();
			}
		}
				$('#theForm').jqxValidator('validate', validationResult);
     });
	 //end of button click	 
	 
  $('#buttonDelete').click(function (){
		var answer = confirm("Are you sure you want to delete this record?");
		if (answer) {
			return true;
		}else{
			return false;
		}
  });
		
	//validate success & submit				
	//$('#theForm').bind('validationSuccess', function (event) { 
	$('#theForm').bind('validationSuccess', function (event) { 
			
	var action = $("#theForm").attr('action');
					
	var form_data = {
		name: $("#name").val(),
		ic_no: $("#ic_no").val(),
		nationality_id: $("#nationality_id option:selected").val(),
		nationality_name: $("#nationality_id option:selected").text(),
		address1: $("#address1").val(),
		postcode: $("#postcode").val(),
		city: $("#city").val(),		
		state_id: $("#state_id option:selected").val(),
		state_prefix: $("#state_id option:selected").text(),
		country_id: $("#country_id option:selected").val(),
		country_name: $("#country_id option:selected").text(),
		prefix_name: $("#country_id option:selected").text(),
		tel: $("#tel").val(),
		email: $("#email").val(),
		bank_id: $("#bank_id option:selected").val(),
		bank_name: $("#bank_id option:selected").text(),
		bank_switf_code: $("#bank_id option:selected").text(),
		bank_account_no: $("#bank_account_no").val(),
		user_name: $("#user_name").val(),
		password: $("#password").val(),
		user_group: $("#user_group option:selected").val(),
		remark: $("#remark").val(),
		is_ajax: 1
		
	};
	
	
		
		$.ajax({
			type: "POST",
			//url: action,
			url: action,
			data: form_data,
			dataType: "json",
			
			
			
			success: function(response) {
			
				var id = response["id"];
				var success = response["success"];
				var displayMsg = response["displayMsg"];
				
				//alert("yesssss");

				
				if (success == 1) {
				
					
					window.location.href = "index.php?view=detail&id="+id+'&displayMsg='+displayMsg;

				} else {

					
					document.getElementById("errMsg").innerHTML=displayMsg;
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

