<?php
function getDetailForm($id)
{
	include '../main/lang_default.php';
	
 $data = getCompanyDetailForm($id);
 $data2 = getCompanySetupDetailForm($id);
	
	 
		if ($data != ""){
?>
<script type="text/javascript">

$(document).ready(function () {    
          
	$('input:radio[name=gst_sw]:nth(<?php echo $data2['gst_sw']; ?>)').attr('checked',true);  

});

</script>    
              <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
              <div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                       
                                  <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                      <li class="active"><a href="#detail" data-toggle="tab"><?php echo $lang['NEW_COMPANY']; ?></a></li>
                                      <li><a href="#company_setup" data-toggle="tab"><?php echo $lang['NEW_COMPANY_SETUP']; ?></a></li>	
                                   
                                    </ul>
                                    
                                    <div class="tab-content">
                                    
                                      <div class="active tab-pane" id="detail">
                                      
							 <div class="box-header with-border">
                          <h3 class="box-title"></h3> 	
										<div style="float: right;">								
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        						<input type="button" value="<?php echo $lang['BUTTON_UPDATE']; ?>" id="buttonUpdate" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=update&id=<?php echo $id; ?>'"/>
	                  <?php } ?>
								                    
										</div>
                         </div>                                                             
                                      
                                      		<div class="form-group">
                                            </div>
                                        
                                        	<div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_COMPANY_NAME']; ?></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="company_name" value="<?php echo $data['company_name']; ?>">
                                             </div>
                                              
                                            <label for="inputName" class="col-sm-1 control-label"><?php echo $lang['NEW_COMPANY_COMPANY_CODE']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="code" value="<?php echo $data['code']; ?>">
                                            </div> 
                                            
                                            <label for="inputName" class="col-sm-1 control-label"><?php echo $lang['NEW_COMPANY_REGISTER_NUMBER']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="register_no" value="<?php echo $data['register_no']; ?>">
                                            </div> 
                                          </div>
                                             
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_GST_NUMBER']; ?></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="gst_no" value="<?php echo $data['gst_no']; ?>">
                                             </div>
                                              
                                           <label for="inputExperience" class="col-sm-1 control-label"><?php echo $lang['NEW_COMPANY_ADDRESS']; ?></label>
                                            <div class="col-sm-5">
                                              <textarea class="form-control" id="address1"><?php echo $data['address1']; ?></textarea>
                                            </div>
                                          </div>
                                          
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_POSTCODE']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="postcode" value="<?php echo $data['postcode']; ?>">
                                             </div>
                                              
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_CITY']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="city" value="<?php echo $data['city']; ?>">
                                            </div>
                                          
                                             <label for="inputName" class="col-sm-1 control-label"><?php echo $lang['NEW_COMPANY_STATE']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="state" value="<?php echo $data['state']; ?>">
                                            </div>
                                          </div>
                                            
                                            
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_COUNTRY']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="country" value="<?php echo $data['country']; ?>">
                                            </div>   
                                             
                                               <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_TEL_NUMBER']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="tel" value="<?php echo $data['tel']; ?>">
                                            </div> 
                                            
                                             <label for="inputName" class="col-sm-1 control-label"><?php echo $lang['NEW_COMPANY_FAX']; ?></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="fax" value="<?php echo $data['fax']; ?>">
                                            </div> 
                                            </div>
                                            
                                             <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_EMAIL']; ?></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="email" value="<?php echo $data['email']; ?>">
                                            </div> 
                                            
                                              <label for="inputExperience" class="col-sm-1 control-label"><?php echo $lang['NEW_COMPANY_REMARK']; ?></label>
                                            <div class="col-sm-5">
                                              <textarea class="form-control" id="remark"><?php echo $data['remark']; ?></textarea>
                                            </div>
                                          </div>
                                                                                                                                                             
                                         <div class="form-group">
                                            <label for="inputExperience" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_INVOICE_MESSAGE']; ?></label>
                                            <div class="col-sm-9">
                                              <textarea class="form-control" id="invoice_message"><?php echo $data['invoice_message']; ?></textarea>
                                            </div>
                                           </div> 
                                           
                                           <div class="form-group">
                                             <label for="inputExperience" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_STATEMENT_MESSAGE']; ?></label>
                                            <div class="col-sm-9">
                                              <textarea class="form-control" id="statement_message"><?php echo $data['statement_message']; ?></textarea>
                                            </div>
                                          </div>
                                          
                                           <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_CHEQUE_PAYABLE']; ?></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="cheque_payable" value="<?php echo $data['cheque_payable']; ?>">
                                            </div> 
                                            
                                             <label for="inputName" class="col-sm-1 control-label"><?php echo $lang['NEW_COMPANY_REMIT_TO']; ?></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="remit_to" value="<?php echo $data['remit_to']; ?>">
                                            </div> 
                                            </div>
                                            
                                             <div class="form-group">
                                              <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_BANK_NAME']; ?></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="bank_name" value="<?php echo $data['bank_name']; ?>">
                                            </div>
                                             
                                              <label for="inputName" class="col-sm-1 control-label"><?php echo $lang['NEW_COMPANY_ACCOUNT_TYPE']; ?></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="acct_type" value="<?php echo $data['acct_type']; ?>">
                                            </div> 
                                            </div>
                                            
                                            <div class="form-group">
                                              <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_ACCOUNT_NUMBER']; ?></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="acct_no" value="<?php echo $data['acct_no']; ?>">
                                            </div> 
                                            
                                             <label for="inputName" class="col-sm-1 control-label"><?php echo $lang['NEW_COMPANY_SWIFTCODE']; ?></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="swiftcode" value="<?php echo $data['swiftcode']; ?>">
                                            </div> 
                                          </div>
                                          
                                 		 <div class="form-group">
                                             <label for="inputExperience" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_SENT_TO']; ?></label>
                                            <div class="col-sm-9">
                                              <textarea class="form-control" id="send_to"><?php echo $data['send_to']; ?></textarea>
                                            </div>
                                          </div>
                                          
                                      </div><!-- /.tab-pane -->
                                      
 										 <div class="tab-pane" id="company_setup">
                                        <!-- Post -->                                           
                                        <div class="post">
                                        
                                        <div class="box-header with-border">
                          <h3 class="box-title"></h3> 	
										<div style="float: right;">								
										<?php if(checkAccess($_SESSION['user_grp'], basename(dirname($_SERVER['PHP_SELF'])), 'update_sw')){ ?>
        						<input type="button" value="<?php echo $lang['BUTTON_UPDATE']; ?>" id="buttonUpdate2" class="btn btn-primary" onClick="document.theForm.action='info_inc.php?action=updateCompanySetup&id=<?php echo $id; ?>'"/>
	                  <?php } ?>
								                    
										</div>
                         </div>                                                             
                                      
                                      		<div class="form-group">
                                            </div>
                                        
                                        	<div class="form-group">
                                             <label for="inputEmail" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_SETUP_GST_ACTIVE']; ?></label>
                                            <div class="col-sm-2">
                                              <input name="gst_sw" id="gst_sw" type="radio" value="0" />
											<?php echo $lang['RADIO_BUTTON_NO']; ?> &nbsp;&nbsp;&nbsp;&nbsp;    
											<input name="gst_sw" id="gst_sw" type="radio" value="1" /> 
											<?php echo $lang['RADIO_BUTTON_YES']; ?>
                                            </div>  
                                              
                                            <label for="inputName" class="col-sm-1 control-label"><?php echo $lang['NEW_COMPANY_SETUP_GST_RATE']; ?></label>
                                            <div class="col-sm-1">
                                              <input type="text" class="form-control" id="gst_rate" value="<?php echo $data2['gst_rate']; ?>">
                                            </div> 
                                            
                                            <label for="inputName" class="col-sm-3 control-label"><?php echo $lang['NEW_COMPANY_SETUP_PENDING_MEMBER_DAY']; ?></label>
                                            <div class="col-sm-1">
                                              <input type="text" class="form-control" id="pending_member_day" value="<?php echo $data2['pending_member_day']; ?>">
                                            </div> 
                                          </div>
                                             
                                            <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_SETUP_PENDING_SALE_ORDER_DAY']; ?></label>
                                            <div class="col-sm-1">
                                              <input type="text" class="form-control" id="pending_sale_order_day" value="<?php echo $data2['pending_sale_order_day']; ?>">
                                             </div>
                                             
                                              <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_SETUP_MONTHLY_PAYOUT_DAY']; ?></label>
                                            <div class="col-sm-1">
                                              <input type="text" class="form-control" id="monthly_payout_day" value="<?php echo $data2['monthly_payout_day']; ?>">
                                             </div>
                                             
                                              <label for="inputName" class="col-sm-3 control-label"><?php echo $lang['NEW_COMPANY_SETUP_MONTHLY_BONUS_LIMIT']; ?></label>
                                            <div class="col-sm-1">
                                              <input type="text" class="form-control" id="monthly_bonus_limit" value="<?php echo $data2['monthly_bonus_limit']; ?>">
                                            </div>
                                          </div>
                                                                                  
                                            <div class="form-group">
                                             <label for="inputName" class="col-sm-2 control-label">Pool Bonus PV Qualification (Personal)</label>
                                            <div class="col-sm-1">
                                              <input type="text" class="form-control" id="bonus_member_pv" value="<?php echo $data2['bonus_member_pv']; ?>">
                                            </div>
                                            
                                             <label for="inputName" class="col-sm-2 control-label">Pool Bonus PV Qualification (Downline)</label>
                                            <div class="col-sm-1">
                                              <input type="text" class="form-control" id="bonus_downline_pv" value="<?php echo $data2['bonus_downline_pv']; ?>">
                                            </div> 
                                            
                                            <label for="inputName" class="col-sm-3 control-label"><?php echo $lang['NEW_COMPANY_SETUP_MINIMUM_ACCOUNT_VALUE']; ?></label>
                                            <div class="col-sm-1">
                                              <input type="text" class="form-control" id="min_account_value" value="<?php echo $data2['min_account_value']; ?>">
                                            </div>   
                                          </div>
                                            
                                            
         
                                            
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_SETUP_ACTIVATE_ACCOUNT_CHARGE']; ?></label>
                                                <div class="col-sm-2">
                                                  <input type="text" class="form-control" id="activate_account_charge" value="<?php echo $data2['activate_account_charge']; ?>">
                                                </div>                                             
                                            
                                            	<label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_SETUP_MANUAL_WITHDRAW_CHARGE']; ?></label>
                                            	<div class="col-sm-2">
                                              	<input type="text" class="form-control" id="manual_withdrawal_charge" value="<?php echo $data2['manual_withdrawal_charge']; ?>">
                                            	</div> 
                                            </div>
                                            <div class="form-group">
                                            	<label for="inputName" class="col-sm-2 control-label"><?php echo $lang['NEW_COMPANY_SETUP_ADMIN_CHARGE']; ?></label>
                                            	<div class="col-sm-2">
                                              	<input type="text" class="form-control" id="admin_charge" value="<?php echo $data2['admin_charge']; ?>">
                                            	</div>
                                            </div>
                                            
											<div class="form-group">
												<label for="inputName" class="col-sm-2 control-label">Minimum Balance to Keep</label>
                                                <div class="col-sm-2">
                                              	<input type="text" class="form-control" id="min_balance_to_keep" value="<?php echo $data2['min_balance_to_keep']; ?>">
                                            	</div>
                                            </div>  
                                            

                                                                                       
                                            <input id='setup_id' type="hidden"  value="<?php echo $data2['setup_id']; ?>"/>
                                            

                                        </div><!-- /.post -->
                                      </div><!-- /.tab-pane -->  
                                    </div><!-- /.tab-content -->
                                  </div><!-- /.nav-tabs-custom -->
                                </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
	
                  </div><!-- /.box-footer -->
               	
              </div><!-- /.box -->
		      </form>


<?php }
else {
	echo 'No Record Found';
	}
	
}
	
?>
