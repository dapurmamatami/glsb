$(document).ready(function () {
       
	//var theme = getTheme();
	var theme = 'classic';
    // initialize validator.
	 
    $('#theForm').jqxValidator({
     rules: [
					{input: '#customer_id', message: 'customer required', action: 'select', rule: function(input){
						var val = $("#customer_id option:selected").val();
						//alert(val);
						if(val==""){
						return false;
						}
						return true;
						}
					}					
				//{ input: '#ref1', message: 'ref1 is required!', action: 'keyup, blur', rule: 'required'  }
			], theme: theme
     });
		

    $('#theSubFormAdd').jqxValidator({
     rules: [
				{ input: '#weight_add', message: 'weight is required!', action: 'keyup, blur', rule: 'required'  },
				{ input: '#amount_add', message: 'amount is required!', action: 'keyup, blur', rule: 'required'  }
			], theme: theme
     });
	// end of validator
	

    $('#theSubFormUpdate').jqxValidator({
     rules: [
				{ input: '#weight', message: 'weight is required!', action: 'keyup, blur', rule: 'required'  },
				{ input: '#amount', message: 'amount is required!', action: 'keyup, blur', rule: 'required'  }
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
	$('#buttonUpdate').bind('click', function () {
		var validationResult = function (isValid) {
			if (isValid) {
				$("#theForm").submit();
			}
		}
				$('#theForm').jqxValidator('validate', validationResult);
     });
	 //end of button click	 

    //button click
	$('#buttonBill').bind('click', function () {
																					// alert("system bill now");
		var validationResult = function (isValid) {
			if (isValid) {
				$("#theForm").submit();
			}
		}
				$('#theForm').jqxValidator('validate', validationResult);
     });
	 //end of button click
	 
    //button click
	$('#buttonUnBill').bind('click', function () {
		var validationResult = function (isValid) {
			if (isValid) {
				$("#theForm").submit();
			}
		}
				$('#theForm').jqxValidator('validate', validationResult);
     });
	 //end of button click	 

    //button click
	$('#buttonApprove').bind('click', function () {
		var validationResult = function (isValid) {
			if (isValid) {
				$("#theForm").submit();
			}
		}
				$('#theForm').jqxValidator('validate', validationResult);
     });
	 //end of button click	 
	 

    //button click
	$('#buttonUnApprove').bind('click', function () {
		var validationResult = function (isValid) {
			if (isValid) {
				$("#theForm").submit();
			}
		}
				$('#theForm').jqxValidator('validate', validationResult);
     });
	 //end of button click	
	 
    //button click
	$('#buttonRenew').bind('click', function () {
		var validationResult = function (isValid) {
			if (isValid) {
				$("#theForm").submit();
			}
		}
				$('#theForm').jqxValidator('validate', validationResult);
     });
	 //end of button click		
	 
    //button click
	$('#buttonUndoRenew').bind('click', function () {
		var validationResult = function (isValid) {
			if (isValid) {
				$("#theForm").submit();
			}
		}
				$('#theForm').jqxValidator('validate', validationResult);
     });
	 //end of button click			 
	 
    //button click
	$('#buttonBuyBack').bind('click', function () {
		var validationResult = function (isValid) {
			if (isValid) {
				$("#theForm").submit();
			}
		}
				$('#theForm').jqxValidator('validate', validationResult);
     });
	 //end of button click		 

    //button click
	$('#buttonBreakContract').bind('click', function () {
		var validationResult = function (isValid) {
			if (isValid) {
				$("#theForm").submit();
			}
		}
				$('#theForm').jqxValidator('validate', validationResult);
     });
	 //end of button click	
	 
    //button click
	$('#buttonUndoBreakContract').bind('click', function () {
		var validationResult = function (isValid) {
			if (isValid) {
				$("#theForm").submit();
			}
		}
				$('#theForm').jqxValidator('validate', validationResult);
     });
	 //end of button click		 
	 
    //button click
	$('#buttonSubUpdate').bind('click', function () {
		var validationResult = function (isValid) {
			if (isValid) {
				$("#theSubFormUpdate").submit();
			}
		}
				$('#theSubFormUpdate').jqxValidator('validate', validationResult);
     });
	 //end of button click	
	 
    //button click
	$('#buttonModalAddSave').bind('click', function () {
		var validationResult = function (isValid) {
			if (isValid) {
				$("#theSubFormAdd").submit();
			}
		}
				$('#theSubFormAdd').jqxValidator('validate', validationResult);

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
	

    //button click
	$('#buttonAddNewLineItem').click(function (){


     $("#popupWindowSubAdd").jqxWindow('show');
	
	});
	 //end of button click	
	 
    //button click
	$('#buttonReport').click(function (){

     $("#popupWindowReport").jqxWindow('show');
	
	});	 
		
	//validate success & submit				
	$('#theForm').bind('validationSuccess', function (event) { 
			
	var action = $("#theForm").attr('action');
	
	//var date = $('#so_date').jqxDateTimeInput('getDate');
	//var so_date = $.jqx.dataFormat.formatdate(date, 'yyyy-MM-dd');	
	
	var date = $('#invoice_date').jqxDateTimeInput('getDate');
	var invoice_date = $.jqx.dataFormat.formatdate(date, 'yyyy-MM-dd');	
	
	var date = $('#cpo_date').jqxDateTimeInput('getDate');
	var cpo_date = $.jqx.dataFormat.formatdate(date, 'yyyy-MM-dd');		
	
	//var date = $('#renew_buy_back_date').jqxDateTimeInput('getDate');
	//var renew_buy_back_date = $.jqx.dataFormat.formatdate(date, 'yyyy-MM-dd');		

	if ($('#renew_buy_back_date').jqxDateTimeInput('getDate') == null)
	{
		renew_buy_back_date = null;			
	}
	else
	{
		var date = $('#renew_buy_back_date').jqxDateTimeInput('getDate');
		var renew_buy_back_date = $.jqx.dataFormat.formatdate(date, 'yyyy-MM-dd');		
	}

	
	var form_data = {
		//porder_no: $("#porder_no").val(),
		customer_id: $("#customer_id option:selected").val(),
		type_id: $("#type_id option:selected").val(),
		total_month: $("#total_month option:selected").val(),
		so_date: cpo_date,
		invoice_date: invoice_date,
		cpo_date: cpo_date,
		cpo_no: $("#cpo_no").val(),
		renew_buy_back_date: renew_buy_back_date,
		special_rate_sw: $('input:radio[name=special_rate_sw]:checked').val(),
		rate_01: $("#rate_01").val(),
		rate_02: $("#rate_02").val(),
		rate_03: $("#rate_03").val(),
		rate_04: $("#rate_04").val(),
		rate_05: $("#rate_05").val(),
		rate_06: $("#rate_06").val(),
		rate_07: $("#rate_07").val(),
		rate_08: $("#rate_08").val(),
		rate_09: $("#rate_09").val(),
		rate_10: $("#rate_10").val(),
		rate_11: $("#rate_11").val(),
		rate_12: $("#rate_12").val(),
		ref1: $("#ref1").val(),
		ref2: $("#ref2").val(),
		remark: $("#remark").val(),
		internal_remark: $("#internal_remark").val(),
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

	
				if (success == '1') {
				
					
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
	

	//validate success & submit				
	$('#theSubFormUpdate').bind('validationSuccess', function (event) { 
			
	var action = $("#theSubFormUpdate").attr('action');
					
	var form_data = {
		//porder_id: $("#id").val(),
		sod_id: $("#sod_id").val(),
		weight: $("#weight").val(),
		cert_no: $("#cert_no").val(),
		amount: $("#amount").val(),
		//remark: $("#sod_remark").val(),
		//remark: $("#remark").val(),
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
				
					window.location.href = "index.php?view=detail&id="+id;
					//$("#jqxgrid").jqxGrid({ source: source });

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
	
	
	//validate success & submit				
	$('#theSubFormAdd').bind('validationSuccess', function (event) { 
			
	var action = $("#theSubFormAdd").attr('action');
					
	var form_data = {

		//unit_price: $("#unit_price_add").val(),
		//quantity: $("#quantity_add").val(),
		//product_id: $("#product_id_add option:selected").val(),
		weight: $("#weight_add").val(),
		cert_no: $("#cert_no_add").val(),
		amount: $("#amount_add").val(),
		remark: $("#remark_add").val(),
		//porder_detail_id: $("#porder_detail_id").val(),
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
				
					window.location.href = "index.php?view=detail&id="+id;
					//$("#jqxgrid").jqxGrid({ source: source });

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

