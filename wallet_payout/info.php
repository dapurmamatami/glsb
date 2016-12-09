<?php
function showPayoutList()
{

?>
<script type="text/javascript">

$(document).ready(function () {

		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'withdraw_id', type: 'string'},
				{ name: 'request_date', type: 'string'},
				{ name: 'user_id', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'amount', type: 'string'},
				{ name: 'remark', type: 'string'}
			],
				
			cache: false,
			url: 'data.php',

			filter: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
			},
			sort: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
			},
			root: 'Rows',
			pagesize: 50,
			beforeprocessing: function(data)
			{		
				if (data != null)
				{
					source.totalrecords = data[0].TotalRows;					
				}
			}
			};		
			var dataadapter = new $.jqx.dataAdapter(source, {
				loadError: function(xhr, status, error)
				{
					alert(error);
				}
			}
		);
		
	 	var linkrenderer = function (row, column, value) {
			if (value.indexOf('#') != -1) {
				value = value.substring(0, value.indexOf('#'));
			}
			var format = { target: '"_blank"' };
			var html = $.jqx.dataFormat.formatlink(value, format);
	
					//return "<a href='" + value + "' target='_blank'>Link Text</a>";
			return "<a href=index.php?view=detail&id=" + value + " >View</a>";
		}						

	 	var linkrenderer3 = function (row, column, value) {
			if (value.indexOf('#') != -1) {
				value = value.substring(0, value.indexOf('#'));
			}
			var format = { target: '"_blank"' };
			var html = $.jqx.dataFormat.formatlink(value, format);
	

			editrow = row;
     		var offset = $("#jqxgrid").offset();

      		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
										 			
			return "<a href=../report_search/excel_detail.php?report_name=monthly_payout" + "&main_id=" + value + " target='_blank'>Excel</a>";
			
		}
			
		$("#jqxgrid").jqxGrid(
		{	
			source: dataadapter,
			
			filterable: true,
			sortable: true,
			//autoheight: true,
			pageable: true,
			virtualmode: true,
			width: '98%',		
			rendergridrows: function(obj)
			{
				return obj.data;    
			},		
			columns: [ 
				//{ text: '', editable: false, datafield: 'request_id', width: 80 ,cellsrenderer: linkrenderer},
				{ text: '', editable: false, datafield: 'claim_id', width: 50 ,cellsrenderer: linkrenderer3},									
				{ text: 'Payout Date', editable: false, datafield: 'withdraw_date', width: 200 },

			]
		});  
		
				
						
});

</script>
								
				<div class="box box-warning">
                  <div class="box-body">                                   
                    <div class="col-md-12">

							<div class="widget-content">
							
									<div id="jqxgrid">

									</div>
							</div>

					</div>
				</div>
<?php 
} // end of function showList
?>


<?php
function showPayoutPendingList()
{

?>
<script type="text/javascript">

$(document).ready(function () {

		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'id', type: 'string'},
				{ name: 'total_id', type: 'string'},
				{ name: 'user_id', type: 'string'},
				{ name: 'name', type: 'string'},
				{ name: 'pool_bonus', type: 'string'},
				{ name: 'bank_name', type: 'string'},
				{ name: 'bank_account_no', type: 'string'},
				{ name: 'credited_datetime', type: 'string'},

			],
				
			cache: false,
			url: 'dataPending.php',

			filter: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
			},
			sort: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
			},
			root: 'Rows',
			pagesize: 50,
			beforeprocessing: function(data)
			{		
				if (data != null)
				{
					source.totalrecords = data[0].TotalRows;					
				}
			}
			};		
			var dataadapter = new $.jqx.dataAdapter(source, {
				loadError: function(xhr, status, error)
				{
					alert(error);
				}
			}
		);
		
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
			source: dataadapter,
			
			filterable: true,
			sortable: true,
			//autoheight: true,
			pageable: true,
			virtualmode: true,
			width: '98%',		
			rendergridrows: function(obj)
			{
				return obj.data;    
			},		
			columns: [ 
				//{ text: '', editable: false, datafield: 'request_id', width: 80 ,cellsrenderer: linkrenderer},									
				{ text: 'Name', editable: false, datafield: 'name', width: 200 },
				{ text: 'Bank name', editable: false, datafield: 'bank_name', width: 200 },
				{ text: 'Account No', editable: false, datafield: 'bank_account_no', width: 200 },
				{ text: 'Amount', editable: false, datafield: 'pool_bonus', width: 200 },
				{ text: 'Credit Date', editable: false, datafield: 'credited_datetime', width: 150 },
			]
		});  
		
				
						
});

</script>
								
				<div class="box box-warning">
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    <h4><a href="../report_search/exportCSV.php" target="_blank">Export To Excel</a></h4>

							<div class="widget-content">
                            
							<form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
								<input type="submit" value="Print" id="buttonPrint" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=printReportAll&report_name=pending_monthly_payout&id=<?php echo $id; ?>'" formtarget="_blank"/>
                                
                                <input type="submit" value="Bank Transfer Successfully" id="buttonUpdate" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=bankTransferSuccess'"/>
							</form>
									<div id="jqxgrid">

									</div>
							</div>

					</div>
				</div>
<?php 
} // end of function showList
?>

