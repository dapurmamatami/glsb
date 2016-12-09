<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>System</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<?php include "jsinc.php"; ?>

    


    
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="hold-transition skin-blue sidebar-mini">
 

  <?php 

	include '../main/lang_default.php';
	  
  ?> 
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="../main/index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>System</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>System</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

			<?php if($_SESSION['user_grp'] == 1){ ?>
              <!--
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                 <!--
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs">Testing(Auto Run)</span>
                </a>
                <ul class="dropdown-menu">
 
 
                <li><a href="../wallet/index.php?view=manualFlush">Daily Flush</a></li>
                <li><a href="../wallet/index.php?view=manualWithdraw">Weekly Withdraw</a></li>
                </ul>
              </li>  
              -->
              <!-- TopUp Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                  <span class="hidden-xs"><?php echo $lang['MENU_CUSTOMER']; ?></span>
                </a>
                <ul class="dropdown-menu">
 
                
                <li><a href="../user/index.php?view=add">New Member</a></li>
                <li><a href="../user/index.php?view=listMember&status_id=1">Member Listing</a></li>
                <li><a href="../user/index.php?view=listMember&status_id=0">Pending Member Listing</a></li>
                <li><a href="../user/index.php?view=listMember&status_id=9">Suspended Account</a></li>


                </ul>
              </li>              

              <!-- TopUp Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                  <span class="hidden-xs">Sales Order</span>
                </a>
                <ul class="dropdown-menu">
 
                <li><a href="../my_order/index.php?view=add">New Sales Order</a></li>
                <li><a href="../my_order/index.php?view=list&sub=AllOrder">Member Order</a></li>
                <li><a href="../my_order/index.php?view=list&sub=pending">Pending Member Order</a></li>
                <li><a href="../my_order/index.php?view=list&sub=pendingdelivery">Pending Delivery Listing</a></li>

                </ul>
              </li>                                
 
              <!-- Payout Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                  <span class="hidden-xs">Payout</span>
                </a>
                <ul class="dropdown-menu">
 
                <li><a href="../wallet/index.php?view=listWithdrawPending">Pending Withdraw Request</a></li>
                <li><a href="../wallet_payout/index.php?view=listPending">Pending Monthly Payout</a></li>
                <li><a href="../wallet_payout/index.php?view=list">Monthly Payout Listing</a></li>

                </ul>
              </li>              
              <!-- TopUp Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                  <span class="hidden-xs"><?php echo $lang['MENU_PRODUCT']; ?></span>
                </a>
                <ul class="dropdown-menu">
 
                
                <li><a href="../product/index.php?view=add"><?php echo $lang['MENU_PRODUCT_NEW_PRODUCT']; ?></a></li>
                <li><a href="../product/index.php?view=list"><?php echo $lang['MENU_PRODUCT_LISTING']; ?></a></li>
                <li><a href="../stock_history/index.php?view=list">Inventory Listing</a></li>

                </ul>
              </li>
              
               <!-- TopUp Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                  <span class="hidden-xs">Others</span>
                </a>
                <ul class="dropdown-menu">
 
                
                <li><a href="../announcement/index.php?view=add">New Announcement</a></li>
                <li><a href="../announcement/index.php?view=list">Announcement Listing</a></li>
                <!--
                <li><a href="../email/index.php?view=add">New Send Email</a></li>
                <li><a href="../email/index.php?view=list">Send Email Listing</a></li>
                
                 <li><a href="../instant_message/index.php?view=add">New Instant Message</a></li>
                <li><a href="../instant_message/index.php?view=list">Instant Message Listing</a></li>
                -->

                </ul>
              </li>      


              <!-- Setting Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <!--
                  <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                  -->
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo $lang['MENU_SETTING']; ?></span>
                </a>
                <ul class="dropdown-menu">
 
                
                <li><a href="../company/index.php?view=detail&id=1">Company Setting</a></li>
                <li><a href="../setting/index.php?view=detail&id=1&sub=email">Email Setting</a></li>
                <li><a href="../default_message/index.php?view=list">Default Message</a></li>
                <li><a href="../setting/index.php?view=detail&sub=delivery_charge">Delivery Charge Setting</a></li>
                <li><a href="../setting/index.php?view=detail&sub=country_setting">Country Setting</a></li>
                <li><a href="../setting/index.php?view=detail&sub=bank_setting">Bank Setting</a></li>
                <!--
                <li><a href="../announcement/index.php?view=list">Annoucement</a></li>
                -->
                </ul>
              </li>    
 
 
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                  <span class="hidden-xs">User</span>
                </a>
                <ul class="dropdown-menu">
 
                
                <li><a href="../user_office/index.php?view=add">New User</a></li>
                <li><a href="../user_office/index.php?view=list">User Listing</a></li>
                <!--
                <li><a href="../email/index.php?view=add">New Send Email</a></li>
                <li><a href="../email/index.php?view=list">Send Email Listing</a></li>
                
                 <li><a href="../instant_message/index.php?view=add">New Instant Message</a></li>
                <li><a href="../instant_message/index.php?view=list">Instant Message Listing</a></li>
                -->

                </ul>
              </li>                
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <!--
                  <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                  -->
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo $lang['MENU_REPORT']; ?></span>
                </a>
                <ul class="dropdown-menu">
 
				
                <li><a href="../report_search/index.php?view=add">All Report</a></li>
                <!--
                <li><a href="../product_select/index.php?view=list">Report 2</a></li>
                <li><a href="../report_search/index.php?view=list&rpt=exportExcel">Report 3</a></li>
                -->
                </ul>
              </li> 
              <?php } ?>			

              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <!--
                  <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                  -->
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo $_SESSION['user_name']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  
  
                  <!-- Menu Body -->
                  <!--
                  <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li>
                  -->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="../user/index.php?view=detail&id=<?php echo $_SESSION['u_id']; ?>" class="btn btn-default btn-flat"><?php echo $lang['MENU_PROFILE']; ?></a>
                    </div>
                    <div class="pull-right">
                      <a href="../main/logout.php" class="btn btn-default btn-flat"><?php echo $lang['MENU_SIGN_OUT']; ?></a>
                    </div>
                  </li>
                </ul>
              </li>
              
                          
              <!-- Control Sidebar Toggle Button -->
              <!--
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
               -->
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <!--
          <div class="user-panel">
            <div class="pull-left image">
              <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>Alexander Pierce</p>
              <!-- Status -->
              
          <!--    
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          -->

          <!-- search form (Optional) -->
          <!--
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          -->
          <!-- /.search form -->

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
          	<!--
            <li class="header">HEADER</li>
            -->
            <!-- Optionally, you can add icons to the links -->
 
             <li <?php if($current_folder == "user" and $_GET['view']=='detail') { echo "class='active'"; }?>>
              <a href="#"><i class="fa fa-link"></i> <span><?php echo $lang['MENU_MY_PROFILE']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                
				<li><a href="../main/index.php"><?php echo $lang['MENU_HOME']; ?></a></li> 
                <li <?php if($current_folder == "user" and $_GET['view']=='detail') { echo "class='active'"; }?>><a href="../user/index.php?view=detail&id=<?php echo $_SESSION['u_id']; ?>"><?php echo $lang['MENU_PROFILE']; ?></a></li>
                <li <?php if($current_folder == "password") { echo "class='active'"; }?>><a href="../password/index.php?view=detail"><?php echo $lang['MENU_CHANGE_PASSWORD']; ?></a></li>                
                <!--
                <li><a href="../user/index.php?view=list">Bank Information </a></li>
                <li><a href="../user/index.php?view=list">Change Password</a></li>
                
                <!--
                <li><a href="../user/index.php?view=genealogy_universal&id=admin">Universal Genealogy</a></li>
                -->
              </ul>
            </li>              

                
        
			 
            <li <?php if($current_folder == "wallet") { echo "class='active'"; }?>>
              <a href="#"><i class="fa fa-link"></i> <span><?php echo $lang['MENU_WALLET']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                
                <li <?php if($_GET['wallet'] == "ewallet") { echo "class='active'"; }?>><a href="../wallet/index.php?view=list&wallet=ewallet"><?php echo $lang['MENU_E_WALLET_HISTORY']; ?></a></li>
<li <?php if($_GET['wallet'] == "ewalletWithdraw") { echo "class='active'"; }?>><a href="../wallet/index.php?view=list&wallet=ewalletWithdraw"><?php echo $lang['MENU_E_WALLET_WITHDRAM_HISTORY']; ?></a></li>      

 
                <li><a href="../wallet/index.php?view=add">E-Wallet Withdraw Request</a></li>
        
              </ul>
            </li>   
 

            <li <?php if($current_folder == "user") { echo "class='active'"; } ?>>
              <a href="#"><i class="fa fa-link"></i> <span>My Network</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
            <li><a href="../user/index.php?view=list&sub=1"><i class="fa fa-link"></i> <span>Sponsor Level 1</span></a></li>  
            <li><a href="../user/index.php?view=list&sub=2"><i class="fa fa-link"></i> <span>Sponsor Level 2</span></a></li>            
            <li><a href="../user/index.php?view=list&sub=3"><i class="fa fa-link"></i> <span>Sponsor Level 3</span></a></li>
            <li><a href="../user/index.php?view=treeview_binary&id=admin"><i class="fa fa-link"></i> <span>TreeView</span></a></li>                                                      
              </ul>
            </li>  
            

            <li <?php if($current_folder == "my_order") { echo "class='active'"; } ?>>
              <a href="#"><i class="fa fa-link"></i> <span><?php echo $lang['MENU_MY_ORDER']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
            <li><a href="../my_order/index.php?view=add"><i class="fa fa-link"></i> <span><?php echo $lang['MENU_NEW_ORDER']; ?></span></a></li>  
            <li><a href="../my_order/index.php?view=list&sub=myorder"><i class="fa fa-link"></i> <span><?php echo $lang['MENU_MY_ORDER_HISTORY']; ?></span></a></li>

            <li><a href="../my_order/index.php?view=list&sub=downlineorder"><i class="fa fa-link"></i> <span>My Downline Order History</span></a></li>
                      
              </ul>
            </li>  
                        

            
			<li><a href="../main/logout.php"><i class="fa fa-link"></i> <span><?php echo $lang['MENU_SIGN_OUT']; ?></span></a></li>

 
                                    
 
                                              
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $pageTitle; ?>
            <small><?php echo $pageDescription; ?></small>
          </h1>
          <!--
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">Here</li>
          </ol>
          --!>
        </section>

        <!-- Main content -->
        <section class="content">
						<?php if($_GET[displayMsg] != '') { ?>

								<div class="alert alert-info alert-dismissable">
									<?php displayMsg($_GET[displayMsg]); ?>
								</div>

						
						
						<?php } ?>
        
        <div id="errMsg" name="errMsg" class="error_msg" align="center">		
        </div>	

                        
          <!-- Your Page Content Here -->
          <?php require_once $content; ?>


                        
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->



    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
  	<!--
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    -->
    

    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <!--
    <script src="../dist/js/app.min.js"></script>
    -->
   
	<script src="../dist/js/app.min.js"></script>
    
    
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout. -->
         

              
  </body>
</html>
