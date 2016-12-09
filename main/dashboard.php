<?php
echo showDashboard();

function showDashboard()
{
?>
		<?php 
		$dataCompanySetup = getCompanySetupDetailForm(1);
		$dashboard_member_status_sw = $dataCompanySetup['dashboard_member_status_sw'];
		$dashboard_collection_sw = $dataCompanySetup['dashboard_collection_sw'];
		$dashboard_inventory_sw = $dataCompanySetup['dashboard_inventory_sw'];
		$dashboard_year_info_sw = $dataCompanySetup['dashboard_year_info_sw'];
		$dashboard_pv_sw = $dataCompanySetup['dashboard_pv_sw'];
		$dashboard_yearly_income_sw = $dataCompanySetup['dashboard_yearly_income_sw'];		
		?>	
        
        
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
         
		<?php if ($dashboard_member_status_sw == 1) { ?>		
         <div class="row">
		   <div class="col-md-6">
		     <div class="box">
		       <div class="box-header with-border">
		         <h3 class="box-title">MEMBERS</h3>
	           </div>
		       <!-- /.box-header -->
		       <div class="box-body">
		         <table class="table table-bordered">
		           <tr>
		             <td width="178">TOTAL</td>
		             <td width="178">ACTIVE</td>
		             <td width="178">PENDING</td>
		             <td width="178">SUSPEND</td>
	               </tr>
		           <tr>
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
		<?php } ?>
          
		<?php if ($dashboard_collection_sw == 1) { ?>
          <div class="row">
		   <div class="col-md-6">
		     <div class="box">
		       <div class="box-header with-border">
                <h4 align="left">COLLECTIONS	</h4>
                <table class="table table-bordered">
		           <tr>
		             <td width="200">Accumulated Bonus</td>
		             <td><?php echo BonusStatusThisMonthDashboard(); ?></td>
	               </tr>
		           <tr>
		             <td>Qualified Members</td>
		             <td><?php echo TotalQualifyMembersDashboard(); ?></td>
	               </tr>
		         </table> 
	           </div>
               
		       <!-- /.box-header -->
		       <div class="box-body">
               	 <table class="table table-bordered">
		           <tr>
		             <td width="163">&nbsp;</td>
		             <td width="178">TODAY</td>
		             <td width="178">MTD</td>
		             <td width="178">YTD</td>
	               </tr>
		           <tr>
		             <td>SALES</td>
		             <td><?php echo TotalTodaySalesDashboard(); ?></td>
		             <td><?php echo TotalThisMonthSalesDashboard(); ?></td>
		             <td><?php echo TotalYearSalesDashboard(); ?></td>
	               </tr>
		           <tr>
		             <td>NON-SALES</td>
		             <td><?php echo TotalNonSalesChargesToday(); ?></td>
		             <td><?php echo TotalNonSalesChargesThisMonth(); ?></td>
		             <td><?php echo TotalNonSalesChargesThisYear(); ?></td>
	               </tr>
                   
		           <tr>
		             <td>TOTAL</td>
		             <td>
					 <?php 
					 $total_sales_today = TotalTodaySalesDashboard() + TotalNonSalesChargesToday(); 
					 echo number_format((float)$total_sales_today, 2, '.', '');
					 ?>
                     </td>
		             <td>
					 <?php 
					 $total_sales_this_month = TotalThisMonthSalesDashboard() + TotalNonSalesChargesThisMonth();
					 echo number_format((float)$total_sales_this_month, 2, '.', ''); 
					 ?>
                     </td>
		             <td>
					 <?php 
					 $total_sales_this_year = TotalYearSalesDashboard() + TotalNonSalesChargesThisYear(); 
					 echo number_format((float)$total_sales_this_year, 2, '.', '');
					 ?>
                     </td>
	               </tr>
		         </table>
	           </div>
		       <!-- /.box-body -->
	         </div>
		     <!-- /.box -->
	       </div>
	      </div>
		<?php } ?>
        
		<?php if ($dashboard_inventory_sw == 1) { ?>                
          <div class="row">
		   <div class="col-md-6">
		     <div class="box">
		       <div class="box-header with-border">
		         <h3 class="box-title">PRODUCT INVENTORY STATUS</h3>
	           </div>
		       <!-- /.box-header -->
		       <div class="box-body">
		         <table class="table table-bordered">
		           <tr>
		             <td><?php echo showProductInventory(); ?></td>
	               </tr>
		         </table>
		       </div>
		       <!-- /.box-body -->
	         </div>
		     <!-- /.box -->
	       </div>
	      </div> 
		<?php } ?>        
       
      

		<?php if ($dashboard_year_info_sw == 1) { ?>                  
          <div class="row">
            <div class="col-md-6">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">YTD SALES & PAYOUT</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <td><span class="box-title"><?php echo date("Y"); ?></span></td>
                      <td>MEMBER</td>
                      <td>SALES</td>
                      <td>BONUS</td>
                      <td>PAYOUT</td>
                    </tr>
                    
                    <?php 
					$data_sales = getSalesMonthDetailDashboard();

					$sales_month_1 = $data_sales['total_month1'];
					$sales_month_2 = $data_sales['total_month2'];
					$sales_month_3 = $data_sales['total_month3'];
					$sales_month_4 = $data_sales['total_month4'];
					$sales_month_5 = $data_sales['total_month5'];
					$sales_month_6 = $data_sales['total_month6'];
					$sales_month_7 = $data_sales['total_month7'];
					$sales_month_8 = $data_sales['total_month8'];
					$sales_month_9 = $data_sales['total_month9'];
					$sales_month_10 = $data_sales['total_month10'];
					$sales_month_11 = $data_sales['total_month11']; 
					$sales_month_12 = $data_sales['total_month12'];
					
					
					$bonus_dashboard = getBonusDashoard();
					
					$bonus_month1 = $bonus_dashboard['total_month1'];
					$bonus_month2 = $bonus_dashboard['total_month2'];
					$bonus_month3 = $bonus_dashboard['total_month3'];
					$bonus_month4 = $bonus_dashboard['total_month4'];
					$bonus_month5 = $bonus_dashboard['total_month5'];
					$bonus_month6 = $bonus_dashboard['total_month6'];
					$bonus_month7 = $bonus_dashboard['total_month7'];
					$bonus_month8 = $bonus_dashboard['total_month8'];
					$bonus_month9 = $bonus_dashboard['total_month9'];
					$bonus_month10 = $bonus_dashboard['total_month10'];
					$bonus_month11 = $bonus_dashboard['total_month11']; 
					$bonus_month12 = $bonus_dashboard['total_month12'];
					
					$payout = getPayoutDetailDashboard();
					
					$payout_month_1 = $payout['total_month1'];
					$payout_month_2 = $payout['total_month2'];
					$payout_month_3 = $payout['total_month3'];
					$payout_month_4 = $payout['total_month4'];
					$payout_month_5 = $payout['total_month5'];
					$payout_month_6 = $payout['total_month6'];
					$payout_month_7 = $payout['total_month7'];
					$payout_month_8 = $payout['total_month8'];
					$payout_month_9 = $payout['total_month9'];
					$payout_month_10 = $payout['total_month10'];
					$payout_month_11 = $payout['total_month11']; 
					$payout_month_12 = $payout['total_month12'];
					
					//total sales for dashboard admin
					$total_sales = $sales_month_1 + $sales_month_2 + $sales_month_3 + $sales_month_4 + $sales_month_5 + $sales_month_6 + $sales_month_7 + $sales_month_8 + $sales_month_9 + $sales_month_10 + $sales_month_11 + $sales_month_12;
					
					//total bonus for dashboard admin
					$total_bonus_admin_view = $bonus_month1 + $bonus_month2 + $bonus_month3 + $bonus_month4 + $bonus_month5 + $bonus_month6 + $bonus_month7 + $bonus_month8 + $bonus_month9 + $bonus_month10 + $bonus_month11 + $bonus_month12;
					
					//total payout for dashboard admin
					$total_payout =  $payout_month_1 + $payout_month_2 + $payout_month_3 + $payout_month_4 + $payout_month_5 + $payout_month_6 + $payout_month_7 + $payout_month_8 + $payout_month_9 + $payout_month_10 + $payout_month_11 + $payout_month_12;					
					
					?>
                    <tr>
                      <td width="163">JANUARY</td>
                      <td width="178"><?php echo getMemberMonthDetailDashboard('01','2016'); ?></td>
                      <td width="178"><?php echo $sales_month_1; ?></td>
                      <td width="178"><?php echo $bonus_month1; ?></td>
                      <td width="178"><?php echo $payout_month_1; ?></td>
                    </tr>
                    
                    <tr>
                      <td width="163">FEBRUARY</td>
                      <td width="178"><?php echo getMemberMonthDetailDashboard('02','2016'); ?></td>
                      <td width="178"><?php echo $sales_month_2; ?></td>
                      <td width="178"><?php echo $bonus_month2; ?></td>
                      <td width="178"><?php echo $payout_month_2; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">MARCH</td>
                      <td width="178"><?php echo getMemberMonthDetailDashboard('03','2016'); ?></td>
                      <td width="178"><?php echo $sales_month_3; ?></td>
                      <td width="178"><?php echo $bonus_month3; ?></td>
                      <td width="178"><?php echo $payout_month_3; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">APRIL</td>
                      <td width="178"><?php echo getMemberMonthDetailDashboard('04','2016'); ?></td>
                      <td width="178"><?php echo $sales_month_4; ?></td>
                      <td width="178"><?php echo $bonus_month4; ?></td>
                      <td width="178"><?php echo $payout_month_4; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">MAY</td>
                      <td width="178"><?php echo getMemberMonthDetailDashboard('05','2016'); ?></td>
                      <td width="178"><?php echo $sales_month_5; ?></td>
                      <td width="178"><?php echo $bonus_month5; ?></td>
                      <td width="178"><?php echo $payout_month_5; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">JUNE</td>
                      <td width="178"><?php echo getMemberMonthDetailDashboard('06','2016'); ?></td>
                      <td width="178"><?php echo $sales_month_6; ?></td>
                      <td width="178"><?php echo $bonus_month6; ?></td>
                      <td width="178"><?php echo $payout_month_6; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">JULY</td>
                      <td width="178"><?php echo getMemberMonthDetailDashboard('07','2016'); ?></td>
                      <td width="178"><?php echo $sales_month_7; ?></td>
                      <td width="178"><?php echo $bonus_month7; ?></td>
                      <td width="178"><?php echo $payout_month_7; ?></td>
                    </tr>
                    
                    <tr>
                      <td width="163">AUGUST</td>
                      <td width="178"><?php echo getMemberMonthDetailDashboard('08','2016'); ?></td>
                      <td width="178"><?php echo $sales_month_8; ?></td>
                      <td width="178"><?php echo $bonus_month8; ?></td>
                      <td width="178"><?php echo $payout_month_8; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">SEPTEMBER</td>
                      <td width="178"><?php echo getMemberMonthDetailDashboard('09','2016'); ?></td>
                      <td width="178"><?php echo $sales_month_9; ?></td>
                      <td width="178"><?php echo $bonus_month9; ?></td>
                      <td width="178"><?php echo $payout_month_9; ?></td>
                    </tr>  
                    
                    <tr>
                      <td width="163">OCTOBER</td>
                      <td width="178"><?php echo getMemberMonthDetailDashboard('10','2016'); ?></td>
                      <td width="178"><?php echo $sales_month_10; ?></td>
                      <td width="178"><?php echo $bonus_month10; ?></td>
                      <td width="178"><?php echo $payout_month_10; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">NOVEMBER</td>
                      <td width="178"><?php echo getMemberMonthDetailDashboard('11','2016'); ?></td>
                      <td width="178"><?php echo $sales_month_11; ?></td>
                      <td width="178"><?php echo $bonus_month11; ?></td>
                      <td width="178"><?php echo $payout_month_11; ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">DECEMBER</td>
                      <td width="178"><?php echo getMemberMonthDetailDashboard('12','2016'); ?></td>
                      <td width="178"><?php echo $sales_month_12; ?></td>
                      <td width="178"><?php echo $bonus_month12; ?></td>
                      <td width="178"><?php echo $payout_month_12; ?></td>
                    </tr>
                    
                    <tr>
                      <td width="163"><strong>TOTAL</strong></td>
                      <td width="178"><?php echo getMemberMonthDetailDashboard('01','2016') + getMemberMonthDetailDashboard('02','2016') + getMemberMonthDetailDashboard('03','2016') + getMemberMonthDetailDashboard('04','2016') + getMemberMonthDetailDashboard('05','2016') + getMemberMonthDetailDashboard('06','2016') + getMemberMonthDetailDashboard('07','2016') + getMemberMonthDetailDashboard('08','2016') + getMemberMonthDetailDashboard('09','2016') + getMemberMonthDetailDashboard('10','2016') + getMemberMonthDetailDashboard('11','2016') + getMemberMonthDetailDashboard('12','2016'); ?></td>
                      <td width="178"><?php echo number_format((float)$total_sales, 2, '.', ''); ?></td>
                      <td width="178"><?php echo number_format((float)$total_bonus_admin_view, 2, '.', ''); ?></td>
                      <td width="178"><?php echo number_format((float)$total_payouts, 2, '.', ''); ?></td>
                    </tr>                                          
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
           </div>
         </div> <!-- row -->     
		<?php } ?>		

                     
		 <?php } //end of admin 
		 else { 
		 
		$data_user = getUserDetail($_SESSION['user_id']);
		$full_name = $data_user['name'];
		$business_name = $data_user['business_name'];
		$approve_date = $data_user['approve_date'];
		$member_reg_no = $data_user['member_reg_no'];
		$member_approve_date = strtotime($approve_date);
		$new_date = date('d-F-Y', $member_approve_date);   
		
		//echo 'Business Website: http://www.golestary.com.my';
		//echo 'Your Promotional Link: http://www.golestary.com.my/?id=<mrn>';
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
                                                          order by sorting_number asc
                                                         ";
                                                  $result=dbQuery($sql);
                                                  if(dbNumRows($result)>0)
                                                  {
                                                    
													$i = 1;
													         
                                                    while($row=dbFetchAssoc($result))
                                                    {
                                                     
													 $anno_description = str_replace("\n","<br />", $row[anno_description]);
													  echo "<tr><td>$i</td>";
													  echo "<td>";
													  echo $row[anno_date]; 
													  echo "   -   ";
													  echo "<strong>" . $row[anno_title] . "</strong>";
													  echo "</br>";
													  echo $anno_description;
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
		         <h3 class="box-title">PROMOTIONAL LINKS</h3>
	           </div>
		       <!-- /.box-header -->
		       <div class="box-body">
		         <table class="table table-bordered">
		           <tr>
		             <td width="163">Business Website</td>
		             <td width="178"><a href="http://www.golestary.com.my" target="_blank">http://www.golestary.com.my</a></td>
	               </tr>
		           <tr>
		             <td>Your Promotional Link</td>
		             <td><a href="http://www.golestary.com.my?id=<?php echo $member_reg_no; ?>" target="_blank">http://www.golestary.com.my?id=<?php echo $member_reg_no; ?></a></td>
	               </tr>
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

		<?php if ($dashboard_pv_sw == 1) { ?>
		<div class="row">
		   <div class="col-md-6">
		     <div class="box">
		       <div class="box-header with-border">
		         <h3 class="box-title">Point Value (PV) Status</h3>
	           </div>
		       <!-- /.box-header -->
		       <div class="box-body">
		         <table class="table table-bordered">
		           <tr>
		             <td width="204">&nbsp;</td>
		             <td width="138">Current</td>
		             <td width="178">Balance PV For Bonus</td>
	               </tr>
		           <?php 
					$companyData = getCompanySetupDetailForm(1);
					$bonus_member_pv = $companyData['bonus_member_pv'];
					$bonus_downline_pv = $companyData['bonus_downline_pv'];
					?>
		           <tr>
		             <td>My PV</td>
		             <td><?php 
					  		$personal_pv = TotalPVUser($_SESSION['user_id']); 
					  		echo $personal_pv; 
							?></td>
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
							?></td>
	               </tr>
		           <tr>
		             <td>My Biz Network PV</td>
		             <td><?php 
							$downline_pv = TotalPVDownline($_SESSION['user_id']);
							echo $downline_pv;
							?></td>
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
							?></td>
	               </tr>
		           <tr>
		             <td colspan="2">Current Status To Earn Bonus </td>
                     <td>Not Qualify</td>
	               </tr>
	             </table>
	           </div>
		       <!-- /.box-body -->
	         </div>
		     <!-- /.box -->
	       </div>
	      </div>
		<?php } ?>	 
        
		<?php if ($dashboard_yearly_income_sw == 1) { ?>            
		<form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm" target="blank">
          <div class="row">
            <div class="col-md-6">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">YTD Income Summary</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <td><span class="box-title"><?php echo date("Y"); ?></span></td>
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
					
					$total_month1 = $month_1 + $bonus_month1;
					$total_month2 = $month_2 + $bonus_month2;
					$total_month3 = $month_3 + $bonus_month3;
					$total_month4 = $month_4 + $bonus_month4;
					$total_month5 = $month_5 + $bonus_month5;
					$total_month6 = $month_6 + $bonus_month6;
					$total_month7 = $month_7 + $bonus_month7;
					$total_month8 = $month_8 + $bonus_month8;
					$total_month9 = $month_9 + $bonus_month9;
					$total_month10 = $month_10 + $bonus_month10;
					$total_month11 = $month_11 + $bonus_month11;
					$total_month12 = $month_12 + $bonus_month12;
					
					$total_commission = $month_1 + $month_2 + $month_3 + $month_4 + $month_5 + $month_6 + $month_7 + $month_8 + $month_9 + $month_10 + $month_11 + $month_12; 
					$total_bonus = $bonus_month_1 + $bonus_month_2 + $bonus_month_3 + $bonus_month_4 + $bonus_month_5 + $bonus_month_6 + $bonus_month_7 + $bonus_month_8 + $bonus_month_9 + $bonus_month_10 + $bonus_month_11 + $bonus_month_12;
					$total_commission_bonus = $total_commission + $total_bonus;
					?>
                    <tr>
                      <td width="163">January</td>
                      <td width="178"><?php echo $month_1; ?></td>
                      <td width="178"><?php echo $bonus_month_1; ?></td>
                      <td width="178"><?php echo number_format((float)$total_month1, 2, '.', ''); ?></td>
                    </tr>
                    
                    <tr>
                      <td width="163">February</td>
                      <td width="178"><?php echo $month_2; ?></td>
                      <td width="178"><?php echo $bonus_month_2; ?></td>
                      <td width="178"><?php echo number_format((float)$total_month2, 2, '.', ''); ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">March</td>
                      <td width="178"><?php echo $month_3; ?></td>
                      <td width="178"><?php echo $bonus_month_3; ?></td>
                      <td width="178"><?php echo number_format((float)$total_month3, 2, '.', ''); ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">April</td>
                      <td width="178"><?php echo $month_4; ?></td>
                      <td width="178"><?php echo $bonus_month_4; ?></td>
                      <td width="178"><?php echo number_format((float)$total_month4, 2, '.', ''); ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">May</td>
                      <td width="178"><?php echo $month_5; ?></td>
                      <td width="178"><?php echo $bonus_month_5; ?></td>
                      <td width="178"><?php echo number_format((float)$total_month5, 2, '.', ''); ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">June</td>
                      <td width="178"><?php echo $month_6; ?></td>
                      <td width="178"><?php echo $bonus_month_6; ?></td>
                      <td width="178"><?php echo number_format((float)$total_month6, 2, '.', ''); ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">July</td>
                      <td width="178"><?php echo $month_7; ?></td>
                      <td width="178"><?php echo $bonus_month_7; ?></td>
                      <td width="178"><?php echo number_format((float)$total_month7, 2, '.', ''); ?></td>
                    </tr>
                    
                    <tr>
                      <td width="163">August</td>
                      <td width="178"><?php echo $month_8; ?></td>
                      <td width="178"><?php echo $bonus_month_8; ?></td>
                      <td width="178"><?php echo number_format((float)$total_month8, 2, '.', ''); ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">September</td>
                      <td width="178"><?php echo $month_9; ?></td>
                      <td width="178"><?php echo $bonus_month_9; ?></td>
                      <td width="178"><?php echo number_format((float)$total_month9, 2, '.', ''); ?></td>
                    </tr>  
                    
                    <tr>
                      <td width="163">October</td>
                      <td width="178"><?php echo $month_10; ?></td>
                      <td width="178"><?php echo $bonus_month_10; ?></td>
                      <td width="178"><?php echo number_format((float)$total_month10, 2, '.', ''); ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">November</td>
                      <td width="178"><?php echo $month_11; ?></td>
                      <td width="178"><?php echo $bonus_month_11; ?></td>
                      <td width="178"><?php echo number_format((float)$total_month11, 2, '.', ''); ?></td>
                    </tr> 
                    
                    <tr>
                      <td width="163">December</td>
                      <td width="178"><?php echo $month_12; ?></td>
                      <td width="178"><?php echo $bonus_month_12; ?></td>
                      <td width="178"><?php echo number_format((float)$total_month12, 2, '.', ''); ?></td>
                    </tr>
					

                    <tr>
                      <td width="163">TOTAL YTD</td>
                      <td width="178"><?php echo number_format((float)$total_commission, 2, '.', ''); ?></td>
                      <td width="178"><?php echo number_format((float)$total_bonus, 2, '.', ''); ?></td>
                      <td width="178"><?php echo number_format((float)$total_commission_bonus, 2, '.', ''); ?></td>
                    </tr>
                    
                    <tr>
                      <td colspan="2"><div align="right">Enter Year to Print Report</div></td>
                      <td width="178"><input type="text" name="year_id" id="year_id" value="<?php echo date("Y"); ?>"/></td>
                      <td width="178"><span class="box-header with-border">
                      <input type="submit" value="Generate" id="buttonPrint2" class="btn btn-primary" onclick="document.theForm.action='info_inc.php?action=printReportAll&id=<?php echo $id; ?>'"/>
                      </span></td>
                    </tr>                                          
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
           </div>
           
         
         </div> <!-- row -->     
		</form>
		<?php } ?>
                                  
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
				{ name: 'product_sold_this_month', type: 'string'},
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
				{ text: 'Product Name',editable: false, datafield: 'product_name', width: 150 },
				{ text: 'Sold This Month',editable: false, datafield: 'product_sold_this_month', width: 150 },
				{ text: 'Balance',editable: false, datafield: 'balance', width: 100 }
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
				{ text: 'Product Name', editable: false, datafield: 'product_name', width: 100 },
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

