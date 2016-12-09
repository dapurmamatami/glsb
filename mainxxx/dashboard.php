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
                      <td width="163">User Name :</td>
                      <td width="178"><?php echo $_SESSION['user_name']; ?></td>
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
                      <td>Income : </td>
                      <td><p>&nbsp;</p></td>
                    </tr>
                    
                    <tr>
                      <td>Total Since Membership:</td>
                      <td><?php echo TotalSinceMember($_SESSION['user_id']); ?></td>
                    </tr>

                    <tr>
                      <td>Month to Date :</td>
                      <td><?php echo TotalThisMonth($_SESSION['user_id']); ?></td>
                    </tr>
                    <tr>
                      <td>Today :</td>
                      <td><?php echo TotalToday($_SESSION['user_id']); ?></td>
                    </tr>                                          
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
           </div>
           

            <div class="col-md-6">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">PV Summary</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <td width="163">&nbsp;</td>
                      <td width="178">PV Status</td>
                      <td width="178">Balance PV For Bonus</td>
                    </tr>
                    
					<?php 
					$companyData = getCompanySetupDetailForm(1);
					$bonus_member_pv = $companyData['bonus_member_pv'];
					$bonus_downline_pv = $companyData['bonus_downline_pv'];
					?>
                    
                    <tr>
						<td>You</td>
						<td><?php 
					  		$personal_pv = TotalPVUser($_SESSION['user_id']); 
					  		echo $personal_pv; 
							?>
						</td> 
						<td><?php
							if($personal_pv >= $bonus_member_pv)
							{
								$balance_pv = '0';
								echo $balance_pv;
							}
							else
							{
								$balance_pv = $bonus_member_pv - $personal_pv;
								echo $balance_pv;		
							}
							?>
                        </td>
                    </tr>
                                        
                    <tr>
                        <td>Downline</td>
                        <td><?php 
							$downline_pv = TotalPVDownline($_SESSION['user_id']);
							echo $downline_pv;
							?>
						</td>
                        <td><?php
							if($downline_pv >= $bonus_downline_pv)
							{
								$balance_downline = '0';
								echo $balance_downline;
							}
							else
							{
								$balance_downline = $bonus_downline_pv - $downline_pv;
								echo $balance_downline;		
							}
							?>
						</td>
                    </tr> 


                    <tr>
                      <td>Total</td>
                      <td><?php echo $personal_pv + $downline_pv; ?></td>
                      <td><?php echo $balance_pv + $balance_downline; ?></td>
                    </tr>                                          
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
           </div>           
         </div> <!-- row -->
 
		<form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm" target="blank">
          <div class="row">
            <div class="col-md-6">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Year <?php echo date("Y"); ?>  Income</h3>
                  <input type="submit" value="Print" id="buttonPrint" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=printReportAll&id=<?php echo $id; ?>'"/>     
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <td>&nbsp;</td>
                      <td>Commission</td>
                      <td>Bonus</td>
                      <td>Total</td>
                    </tr>
                    <?php 
					$data_commission = getMonthIncomeCommission($_SESSION['user_id']);

					$month_1 = $data_commission['total_month1'];
					$month_2 = $data_commission['total_month2'];
					$month_3 = $data_commission['total_month3'];
					$month_4 = $data_commission['total_month4'];
					$month_5 = $data_commission['total_month5'];
					$month_6 = $data_commission['total_month6'];
					$month_7 = $data_commission['total_month7'];
					$month_8 = $data_commission['total_month8'];
					$month_9 = $data_commission['total_month9'];
					$month_10 = $data_commission['total_month10'];
					$month_11 = $data_commission['total_month11']; 
					$month_12 = $data_commission['total_month12'];
					?>
                    
                    <?php 
					$data_bonus_pool = getIncomeMonthBonusPool($_SESSION['user_id']);
					
					$bonus_month_1 = $data_bonus_pool['total_month1'];
					$bonus_month_2 = $data_bonus_pool['total_month2'];
					$bonus_month_3 = $data_bonus_pool['total_month3'];
					$bonus_month_4 = $data_bonus_pool['total_month4'];
					$bonus_month_5 = $data_bonus_pool['total_month5'];
					$bonus_month_6 = $data_bonus_pool['total_month6'];
					$bonus_month_7 = $data_bonus_pool['total_month7'];
					$bonus_month_8 = $data_bonus_pool['total_month8'];
					$bonus_month_9 = $data_bonus_pool['total_month9'];
					$bonus_month_10 = $data_bonus_pool['total_month10'];
					$bonus_month_11 = $data_bonus_pool['total_month11']; 
					$bonus_month_12 = $data_bonus_pool['total_month12'];
					?>
                    <tr>
                      <td width="163">Jan</td>
                      <td width="178"><?php echo $month_1; ?></td>
                      <td width="178"><?php echo $bonus_month_1; ?></td>
                      <td width="178"><?php echo $month_1 + $bonus_month_1; ?></td>
                    </tr>
                    
                    <tr>
                      <td width="163">Feb</td>
                      <td width="178"><?php echo $month_2; ?></td>
                      <td width="178"><?php echo $bonus_month_2; ?></td>
                      <td width="178"><?php echo $month_2 + $bonus_month_2; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">Mac</td>
                      <td width="178"><?php echo $month_3; ?></td>
                      <td width="178"><?php echo $bonus_month_3; ?></td>
                      <td width="178"><?php echo $month_3 + $bonus_month_3; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">Apr</td>
                      <td width="178"><?php echo $month_4; ?></td>
                      <td width="178"><?php echo $bonus_month_4; ?></td>
                      <td width="178"><?php echo $month_4 + $bonus_month_4; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">Mei</td>
                      <td width="178"><?php echo $month_5; ?></td>
                      <td width="178"><?php echo $bonus_month_5; ?></td>
                      <td width="178"><?php echo $month_5 + $bonus_month_5; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">Jun</td>
                      <td width="178"><?php echo $month_6; ?></td>
                      <td width="178"><?php echo $bonus_month_6; ?></td>
                      <td width="178"><?php echo $month_6 + $bonus_month_6; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">Jul</td>
                      <td width="178"><?php echo $month_7; ?></td>
                      <td width="178"><?php echo $bonus_month_7; ?></td>
                      <td width="178"><?php echo $month_7 + $bonus_month_7; ?></td>
                    </tr>
                    
                    <tr>
                      <td width="163">Ogs</td>
                      <td width="178"><?php echo $month_8; ?></td>
                      <td width="178"><?php echo $bonus_month_8; ?></td>
                      <td width="178"><?php echo $month_8 + $bonus_month_8; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">Sep</td>
                      <td width="178"><?php echo $month_9; ?></td>
                      <td width="178"><?php echo $bonus_month_9; ?></td>
                      <td width="178"><?php echo $month_9 + $bonus_month_9; ?></td>
                    </tr>  
                    
                    <tr>
                      <td width="163">Okt</td>
                      <td width="178"><?php echo $month_10; ?></td>
                      <td width="178"><?php echo $bonus_month_10; ?></td>
                      <td width="178"><?php echo $month_10 + $bonus_month_10; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">Nov</td>
                      <td width="178"><?php echo $month_11; ?></td>
                      <td width="178"><?php echo $bonus_month_11; ?></td>
                      <td width="178"><?php echo $month_11 + $bonus_month_11; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">Dis</td>
                      <td width="178"><?php echo $month_12; ?></td>
                      <td width="178"><?php echo $bonus_month_12; ?></td>
                      <td width="178"><?php echo $month_12 + $bonus_month_12; ?></td>
                    </tr>                                          
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
           </div>
           
         
         </div> <!-- row -->     
		</form>                  
       </section>
       
 
       
       
</body>
        
<?php 

//monthEndClosingWallet('acct_ewallet', '2016', '05');

} ?>


