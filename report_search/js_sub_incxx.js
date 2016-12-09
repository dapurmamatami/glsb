$(document).ready(function () {
	  var theme = getTheme();     
		
		var id = $("#id").val();
		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'product_id'},
				{ name: 'product_name'},
				{ name: 'unit_price'},
				{ name: 'remark'}
			],
			url: 'data_sub.php?id=' + id,
			cache: false
		};
		
		var dataAdapter = new $.jqx.dataAdapter(source);
		
		
	 	var linkrenderer = function (row, column, value) {
			if (value.indexOf('#') != -1) {
				value = value.substring(0, value.indexOf('#'));
			}
			var format = { target: '"_blank"' };
			var html = $.jqx.dataFormat.formatlink(value, format);
	
					//return "<a href='" + value + "' target='_blank'>Link Text</a>";
			return "<a href=index.php?view=detail&id=" + value + " >View</a>";
		}			
		
			
		$("#jqxgrid").jqxGrid(
		{	
			source: source,
			theme: theme,
			pageable: true,
			width: '100%',	
			height: '190px',
			filterable: true,
			columns: [
				{ text: '',editable: true, datafield: '', width: 100,columntype: 'checkbox' },		 
				{ text: '', editable: false, datafield: 'product_id', width: 80 ,cellsrenderer: linkrenderer},
 				{ text: 'Edit',width: 50, datafield: 'Edit', columntype: 'button', cellsrenderer: function () {
                     return "Edit";
                 }, buttonclick: function (row) {
                     // open the popup window when the user clicks a button.
                     editrow = row;
                     var offset = $("#jqxgrid").offset();
                     $("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 60, y: parseInt(offset.top) + 60} });

                     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
                     $("#porder_date").val(dataRecord.porder_date);
                     $("#ref1").val(dataRecord.ref1);
										                 
                     // show the popup window.
                     $("#popupWindow").jqxWindow('show');
                 }
                 },				
				{ text: 'product_id',editable: false, datafield: 'product_id', width: 100 },
				{ text: 'product_name', editable: false, datafield: 'product_name', width: 150 },
				{ text: 'unit_price',editable: false, datafield: 'unit_price', width: 150 },
				{ text: 'remark',editable: false, datafield: 'remark', width: 450 } 
			]
		});        
		
 // initialize the popup window and buttons.
            $("#popupWindow").jqxWindow({ width: 250, resizable: false, theme: theme, isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.01 });
            $("#Cancel").jqxButton({ theme: theme });
            $("#Save").jqxButton({ theme: theme });
            // update the edited row when the user clicks the 'Save' button.
            $("#Save").click(function () {
                if (editrow >= 0) {
                    var row = { porder_id: $("#porder_id").val(), porder_date: $("#porder_date").val(), ref1: $("#ref1").val(),
                        quantity: parseInt($("#quantity").jqxNumberInput('decimal')), price: parseFloat($("#price").jqxNumberInput('decimal'))
                    };
                    $('#jqxgrid').jqxGrid('updaterow', editrow, row);
                    $("#popupWindow").jqxWindow('hide');
                }
            });
						
	});
