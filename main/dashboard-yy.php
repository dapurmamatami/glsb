<?php
echo showDashboard();



function showDashboard()
{
?>

         <?php  
         if(!checkBankAccountExist($_SESSION['user_id'])) {		 
		 ?>
          <div class="row">
            <div class="col-md-6">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Reminder</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <td><h4 class="box-title">Your bank account detail is missing. Please fill out all the information !</h4></td>
                    </tr>
                                         
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
           </div>
         </div> <!-- row -->
         
         
         <?php } ?> 
                 
        <?php if($_SESSION['user_grp'] <> 10) { ?>
        <!-- Main content -->
        <section class="content">         
          <!-- Small boxes (Stat box) -->
          <div class="row">
          <?php 
           $total_pending_sorder = getPendingSaleOrderTotal(); 
		   if($total_pending_sorder > 0) {  
		  ?> 
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $total_pending_sorder; ?></h3>
                  <p>Pending Order</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                 <a href="../my_order/index.php?view=list&sub=pending" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          <?php } ?>


          <?php 
           $total_pending_member = getPendingMemberTotal(); 
		   if($total_pending_member > 0) {  
		  ?> 
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $total_pending_member; ?></h3>
                  <p>Pending Members</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="../user/index.php?view=listMember&status_id=0" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          <?php } ?>  


          <?php 
           $total_pending = getPendingWithdrawRequestTotal(); 
		   if($total_pending > 0) {  
		  ?> 
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $total_pending; ?></h3>
                  <p>Pending Withdraw Request</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="../wallet/index.php?view=listWithdrawPending" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          <?php } ?>        
		  </div>
         
        
         <div class="row">
		   <div class="col-md-6">
		     <div class="box">
		       <div class="box-header with-border">
		         <h3 class="box-title">MEMBER</h3>
	           </div>
		       <!-- /.box-header -->
		       <div class="box-body">
		         <table class="table table-bordered">
		           <tr>
		             <td width="163">&nbsp;</td>
		             <td width="178">TOTAL</td>
		             <td width="178">ACTIVE</td>
		             <td width="178">PENDING</td>
		             <td width="178">SUSPEND</td>
	               </tr>
		           <tr>
		             <td>MEMBER</td>
		             <td><?php echo getTotalMemberDashboard(1) + getTotalMemberDashboard(0) + getTotalMemberDashboard(9);?></td>
		             <td><?php echo getTotalMemberDashboard(1); ?></td>
		             <td><?php echo getTotalMemberDashboard(0); ?></td>
		             <td><?php echo getTotalMemberDashboard(9); ?></td>
	               </tr>
		         </table>
		       </div>
		       <!-- /.box-body -->
	         </div>
		     <!-- /.box -->
	       </div>
	      </div>
          
          



                     
		 <?php } //end of admin 
		 else { 
		 
		$data_user = getUserDetail($_SESSION['user_id']);
		$full_name = $data_user['name'];
		$business_name = $data_user['business_name'];
		$approve_date = $data_user['approve_date'];
		$member_approve_date = strtotime($approve_date);
		$new_date = date('d-F-Y', $member_approve_date);   
		 ?>
        
        <div class="row">
		   <div class="col-md-6">
		     <div class="box">
		       <div class="box-header with-border">
		         <h3 class="box-title">Annoucement Board</h3>
	           </div>
		       <!-- /.box-header -->
		       <div class="box-body">
		         <table class="table table-bordered">
					
                                                  <?php
                                                  $sql = "SELECT *
                                                          FROM announcement
														  where active_sw = 1
                                                          order by anno_date desc
                                                         ";
                                                  $result=dbQuery($sql);
                                                  if(dbNumRows($result)>0)
                                                  {
                                                    
													$i = 1;
													         
                                                    while($row=dbFetchAssoc($result))
                                                    {
                                                      echo "<tr><td>$i</td>";
													  echo "<td>";
													  echo $row[anno_date]; 
													  echo "   -   ";
													  echo $row[anno_title];
													  echo "</br>";
													  echo $row[anno_description];
													  echo "</td>";
													  echo "</tr>";
													  $i++;
                                                    }
													
                                                  }
                                        
                                                  ?>
                                                  
                                                  

                    <tr>

                  </table>
	           </div>
		       <!-- /.box-body -->
	         </div>
		     <!-- /.box -->
	       </div>
	      </div>
          
		 <div class="row">
		   <div class="col-md-6">
		     <div class="box">
		       <div class="box-header with-border">
		         <h3 class="box-title">My Account Summary</h3>
	           </div>
		       <!-- /.box-header -->
		       <div class="box-body">
		         <table class="table table-bordered">
		           <tr>
		             <td width="163">User ID </td>
		             <td width="178"><?php echo $_SESSION['user_name']; ?></td>
	               </tr>
		           <tr>
		             <td>Full Name </td>
		             <td><?php echo $full_name; ?></td>
	               </tr>
                   <tr>
		             <td>Business Name </td>
		             <td><?php echo $business_name; ?></td>
	               </tr>
                   <tr>
		             <td>Membership Since </td>
		             <td><?php echo $new_date; ?></td>
	               </tr>
		           <tr>
	             </table>
	           </div>
		       <!-- /.box-body -->
	         </div>
		     <!-- /.box -->
	       </div>
	      </div>
          
          <div class="row">
		   <div class="col-md-6">
		     <div class="box">
		       <div class="box-header with-border">
		         <h3 class="box-title">My Income Summary</h3>
	           </div>
		       <!-- /.box-header -->
		       <div class="box-body">
		         <table class="table table-bordered">
                 <tr>
		             <td width="163">E-Wallet Balance </td>
		             <td width="178"><?php echo walletBalance('acct_ewallet', $_SESSION['user_id']); ?></td>
	               </tr>
                   <tr>
		             <td>Income - Today </td>
		             <td><?php echo TotalToday($_SESSION['user_id']); ?></td>
	               </tr>
		           <tr>
		             <td>Income - Month To-Date </td>
		             <td><?php echo TotalThisMonth($_SESSION['user_id']); ?></td>
	               </tr>
		           <tr>
		             <td>Income - Total Since Day 1:</td>
		             <td><?php echo TotalSinceMember($_SESSION['user_id']); ?></td>
	               </tr>
		           
	             </table>
	           </div>
		       <!-- /.box-body -->
	         </div>
		     <!-- /.box -->
	       </div>
	      </div>


 

       </section>  
</body>
<?php } ?>   
<?php 
} 
?>



<?php 
function showProductInventory()
{
?>
<script type="text/javascript">			

$(document).ready(function () {
		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'stock_id', type: 'string'},
				{ name: 'stock_date', type: 'string'},
				{ name: 'stock_description', type: 'string'},
				{ name: 'product_id', type: 'string'},
				{ name: 'qty_in', type: 'string'},
				{ name: 'qty_out', type: 'string'},
				{ name: 'product_name', type: 'string'},
				{ name: 'total_qty_in', type: 'string'},
				{ name: 'total_qty_out', type: 'string'},
				{ name: 'balance', type: 'string'},
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

			
		$("#jqxgrid").jqxGrid(
		{	
			source: dataadapter,
			
			//filterable: true,
			//sortable: true,
			//editable: true,
			//autoheight: true,
			//pageable: true,
			virtualmode: true,
			width: '100%',		
			height: '130px',
			rendergridrows: function(obj)
			{
				return obj.data;    
			},								
			columns: [ 																		
				{ text: 'Product Name',editable: false, datafield: 'product_name', width: 300 },
				{ text: 'Balance',editable: false, datafield: 'balance', width: 120 }
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
function showSoldThisMonth()
{
?>
<script type="text/javascript">

$(document).ready(function () {
		
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'so_id', type: 'string'},
				{ name: 'product_id', type: 'string'},
				{ name: 'product_name', type: 'string'},
				{ name: 'total_sales', type: 'string'},
			],
			
			cache: false,
			url: 'dataSold.php',
			filter: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid-Sold").jqxGrid('updatebounddata', 'filter');
			},
			sort: function()
			{
				// update the grid and send a request to the server.
				$("#jqxgrid-Sold").jqxGrid('updatebounddata', 'sort');
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

			
		$("#jqxgrid-Sold").jqxGrid(
		{	
			source: dataadapter,
			
			//filterable: true,
			//sortable: true,
			//autoheight: true,
			//pageable: true,
			virtualmode: true,
			width: '98%',		
			height: '130px',
			rendergridrows: function(obj)
			{
				return obj.data;    
			},		
			columns: [ 
				{ text: 'Product Name', editable: false, datafield: 'product_name', width: 300 },
				{ text: 'Sold This Month',editable: false, datafield: 'total_sales', width: 150 },
			]
		});  
		
				
						
});

</script>

				<div class="box box-warning">
                  <div class="box-body">                                   
                    <div class="col-md-12">

							<div class="widget-content">
							
									<div id="jqxgrid-Sold">

									</div>
							</div>

					</div>
				</div>

<?php 
} // end of function showList

?>

