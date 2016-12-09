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
         
 
           
                     
		 <?php } ?>
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Annoucement</h3>
                </div><!-- /.box-header -->
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
                </div><!-- /.box-body -->
              </div><!-- /.box -->


          <div class="row">
            <div class="col-md-6">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">My Account Summary</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <td>User Name :</td>
                      <td><?php echo $_SESSION['user_name']; ?></td>
                    </tr>
                    <tr>
                      <td>Full Name :</td>
                      <td><?php echo $_SESSION['name']; ?></td>
                    </tr>                    
                    <tr>
                      <td>E-Wallet Balance :</td>
                      <td><?php echo walletBalance('acct_ewallet', $_SESSION['user_id']); ?></td>
                    </tr> 


                    <tr>
                      <td>Today Income :</td>
                      <td></td>
                    </tr>

                    <tr>
                      <td>This Month Income :</td>
                      <td></td>
                    </tr>                                          
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
           </div>
         </div> <!-- row -->
         
                  
       </section>
       
 
       
       
</body>
        
<?php 

//monthEndClosingWallet('acct_ewallet', '2016', '05');

} ?>


