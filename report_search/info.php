<?php
function otherReport()
{
?>
<script type="text/javascript">
        $(document).ready(function () {						
		
		$('#date_from').datepicker({ dateFormat: 'dd-mm-yy' }); 	
		$('#date_to').datepicker({ dateFormat: 'dd-mm-yy' }); 			
			
        });
    </script>

				<!--=== Page Content ===-->
				<!--=== Full Size Inputs ===-->
				<form class="form-horizontal row-border" action="" method="post" target="_blank" name="theForm" id="theForm">				
				<div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                        <div class="box-header with-border">
                          <h3 class="box-title"></h3> 	
										<div style="float: right;">						
        						<input name="SubmitPreview" type="submit" class="btn btn-primary" id="SubmitPreview" value="Preview" onClick="document.theForm.action='info_inc.php?action=summary_report&id=<?php echo $id; ?>'" />	
										</div>
								</div>
											
								<div class="nav-tabs-custom">
                                    <!--
                                    <ul class="nav nav-tabs">
                                      <li class="active"><a href="#detail" data-toggle="tab">Worker Details</a></li>	
                                    </ul>
                                    -->
									<div class="tab-content">
                                      <div class="active tab-pane" id="detail">
                                		
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Date From</label>
                                                <div class="col-sm-2">
                                                	<input type="text" class="form-control" id="date_from" name="date_from" value="<?php echo date("01-01-Y"); ?>">
                                           		</div> 
                                            
                                                <label for="input" class="col-sm-1 control-label">Date To</label>
                                                <div class="col-sm-2">
                                                	<input type="text" class="form-control" id="date_to" name="date_to" value="<?php echo date("d-m-Y"); ?>">
                                                </div>   
                                            </div>
                                
                               								
                                            <div class="form-group">												
                                                <label class="col-md-3 control-label">Report :</label>
                                                <input name="report_name" type="hidden" id="report_name" value="master_data" />
                                                <div class="col-md-3">
                                                    <select name='database_table' id='database_table' class="form-control">
                                                    <option value='user' > Member Registration</option>
                                                    <option value='sorder' > Sales Order</option>
                                                    <option value='ewallet' > E-Wallet</option>
                                                    <option value='ewallet_withdraw' > Payout</option>
                                                    <option value='user_by_earning' >Member by Earnings</option>
                                                    </select>
                                            	</div>										
                                            </div>
										
										
                                            <div class="form-group">
                                            	<label class="col-md-3 control-label">Report Type :</label>
                                            	<div class="col-md-3">
                                                    <select name='report_type' id='report_type' class="form-control">
                                                    <?php
                                                        echo "<option value='pdf' > PDF</option>";
                                                        echo "<option value='excel' > Excel</option>";									
                                                    ?>
                                                    </select>
                                            	</div>
                                            </div>
										
                                   
                                      </div><!-- /.tab-pane -->
                                                                          
 
                                    </div><!-- /.tab-content -->
                                  </div><!-- /.nav-tabs-custom -->
                                </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
	
                  </div><!-- /.box-footer -->
               	
              </div><!-- /.box -->
		      </form>
				<!-- /Page Content -->
				

<?php } ?>

<?php
function addForm()
{
		include '../main/lang_default.php';
?>
             
              <form class="form-horizontal row-border" action="" method="post" name="theForm" id="theForm">
              <div class="box box-info">
                  <div class="box-body">                                   
                    <div class="col-md-12">
                    
                        <div class="box-header with-border">
                          <h3 class="box-title"></h3> 	
										<div style="float: right;">								
										<input name="submit" type="submit" class="btn btn-primary" id="submit" value="Preview" formtarget="_blank" onClick="document.theForm.action='info_inc.php?action=yearly_report&id=<?php echo $id; ?>'" />	
										</div>
                         </div>                       
								<div class="nav-tabs-custom">
                                    <!--
                                    <ul class="nav nav-tabs">
                                      <li class="active"><a href="#detail" data-toggle="tab">Worker Details</a></li>	
                                    </ul>
                                    -->
									<div class="tab-content">
                                      <div class="active tab-pane" id="detail">
                                    
                                    	<div class="form-group">												
											<label class="col-md-3 control-label">Year :</label>
											<div class="col-sm-2">
												<input type="text" name="year_id" id="year_id" value="<?php echo date("Y"); ?>" class="form-control"/>
                                            </div> 										
										</div> 
                                        
										<div class="form-group">												
											<label class="col-md-3 control-label">Report :</label>
											<input name="report_name" type="hidden" id="report_name" value="master_data" />
											<div class="col-md-2">
												<select name='database_table' id='database_table' width='100%' class="form-control">
                                                    <option value='sales_product' >Sales Perfomance Report</option>
												</select>
											</div>										
										</div> 
                                        
                                        <div class="form-group">												
											<label class="col-md-3 control-label">Report Type :</label>
											<input name="report_name" type="hidden" id="report_name" value="master_data" />
											<div class="col-md-2">
												<select name='report_type' id='report_type' width='100%' class="form-control">
                                                    <?php
													echo "<option value='pdf' > PDF</option>";									
													?>
												</select>
											</div>										
										</div>                      

                                   
                                      </div><!-- /.tab-pane -->
                                                                          
 
                                    </div><!-- /.tab-content -->
                                  </div><!-- /.nav-tabs-custom -->
                                </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
	
                  </div><!-- /.box-footer -->
               	
              </div><!-- /.box -->
		      </form>
<?php } ?>

