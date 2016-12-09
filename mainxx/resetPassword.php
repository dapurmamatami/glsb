<?php

include "functions.php";
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";

//encryption key
srand();
$challenge = "";
for ($i = 0; $i < 80; $i++) 
{
  $challenge .= dechex(rand(0, 15));
}
$_SESSION[challenge] = $challenge;
/****************************************/
//$challenge = $_SESSION[challenge];


if($_SERVER["REQUEST_METHOD"] == "POST")
{
  $errMsg = '';
  $u_id = '';
  $u_type = '';
  $suspend = '';
  $pword = '';
  
	$username = $_POST['username'];
	$hp = $_POST['hp'];
	$id_no = $_POST['id_no'];

  //check if username n password are empty first
  if($username!="" && $hp!="" && $id_no!="")
  {
    //check if username exist
    $sql = "SELECT * 
            FROM user 
            WHERE user_name = '$username' and hp='$hp' and id_no = '$id_no'
           ";
    //echo $sql."<BR>";
    $result=dbQuery($sql);
    if(dbNumRows($result)==1)
    {
      $row=dbFetchAssoc($result);
			

					
	  $id = $row['u_id'];
	  $user_id = $row['user_id'];
	  $user_name = $row['user_name'];
	  $hpSend = $row['hpSend'];

      if($hpSend <> '')
	  {

		require_once ("../sendsms/sms_send_include.php");

		$temp_password = createRandomPassword();
		$password = md5($temp_password);	
			
		$sql = "UPDATE user
				SET password = '$password',temp_password = '$temp_password',
				modified_by = 0
				WHERE u_id = '$id'
			   ";
		dbQuery($sql);
				  
		$mysms = new sms();
		echo $mysms->session;
		$smsDescrption = 'Temporary Pass: ' . $temp_password;
		$APIresponse = $mysms->send ($hpSend, "rbs", "$smsDescrption", "0", "dipping");		  
	  }
	  else
	  {
		  
	  }

	  
    }
    else
    {
      $errMsg = 'Your username and mobile number and ID number not matched!<BR>';
    }
  }
  else
  {
    $errMsg = 'You need to input your user name and mobile number and id number!<BR>';
  }
  
  if($errMsg!='')
  {
    //return $errMsg;
  }
  else
  {

	header("Location: login.php");
		

  }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <!--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    -->
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <!--
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    -->
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
      <!--
        <a href="../index2.html"><b>Admin</b>LTE</a>
       -->
       <b>RBS Network</b>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Reset Password</p>
        <?php 
  			echo "<span style='color: red; font-weight: bold;'>$errMsg</span>";
		?>
        <form action="resetPassword.php" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="username" name="username" class="form-control" placeholder="Username">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="hp"  class="form-control" placeholder="Mobile Number">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="id_no"  class="form-control" placeholder="IC/Passport/Company Register No">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>          
          <div class="row">
            <div class="col-xs-8">
            <!--
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            -->
            </div><!-- /.col -->

            <div class="col-xs-5">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password</button>
            </div><!-- /.col -->
          </div>
        </form>

        <!--
        <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div><!-- /.social-auth-links -->
 
            <a href="login.php">Login Page</a>
        

        <br>
        <br>
        Temporary Password will directly send to your registered mobile number
        <!--
        <a href="register.html" class="text-center">Register a new membership</a>
        -->

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="../plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
