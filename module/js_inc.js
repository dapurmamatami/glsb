$(document).ready(function () {
       
	//var theme = getTheme();
	var theme = 'classic';
    // initialize validator.
	 
    $('#theForm').jqxValidator({
     rules: [
				{ input: '#product_name', message: 'Product Name is required!', action: 'keyup, blur', rule: 'required'  },
				{ input: '#type_id', message: 'Type is required!', action: 'select', rule: function(input){
						var val = $("#type_id option:selected").val();
						//alert(val);
						if(val==""){
						return false;
						}
						return true;
						}
				},
				{ input: '#unit_price', message: 'numeric field only!', action: 'keyup, blur', rule: function (input) {
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
	 
  $('#buttonDelete').click(function (){
		var answer = confirm("Are you sure you want to delete this record?");
		if (answer) {
			return true;
		}else{
			return false;
		}
  });
		
	//validate success & submit				
	$('#theForm').bind('validationSuccess', function (event) { 
			
	var action = $("#theForm").attr('action');
					
	var form_data = {
		product_name: $("#product_name").val(),
		type_id: $("#type_id option:selected").val(),
		unit_price: $("#unit_price").val(),
		comm_sw: $("#comm_sw option:selected").val(),
		comm_level_1: $("#comm_level_1").val(),
		comm_level_2: $("#comm_level_2").val(),
		comm_level_3: $("#comm_level_3").val(),
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

