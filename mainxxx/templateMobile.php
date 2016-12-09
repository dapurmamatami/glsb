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

	<?php include "jsincApp.php"; ?>
   

    


    
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
 





        <!-- Content Header (Page header) -->
        <section class="content-header">
 
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
