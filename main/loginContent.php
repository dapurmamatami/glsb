<?php
session_name("glsb");
session_start(); 

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
	$password = $_POST['password'];
	$lang = $_POST['lang'];

  //check if username n password are empty first
  if($username!="" && $password!="")
  {
    //check if username exist
    $sql = "SELECT user_id, user_name, password, company_id,
						name, status_id, temp_password, user_group,temp_password,
						user_branch, u_id
            FROM user inner join user_group on user.user_group = user_group.user_group_id
            WHERE user_name = '$username'
           ";
    //echo $sql."<BR>";
    $result=dbQuery($sql);
    if(dbNumRows($result)==1)
    {
      $row=dbFetchAssoc($result);
			

			
			$full_mlm_sw = 1;
					
	  
			$user_id = $row['user_id'];
			$status_id = $row['status_id'];
			$pword = $row['password'];
			$u_grp = $row['user_group'];
			$company_id = $row['company_id'];
			$branch_id = $row['user_branch'];
			$temp_password = $row['temp_password'];
			$name = $row['name'];
			$u_id = $row['u_id'];
      
      //check if account suspended
      if($status_id <> 1)
      {
        if($status_id == 0) {
			$errMsg = 'Account Not Active Yet! Please contact the administrator.<BR>';
		}

        if($status_id == 9) {
			$errMsg = 'Account Suspended! Please contact the administrator.<BR>';
		}			
      }
      else
      {
          if($pword!= md5($password))
          {
            $errMsg = 'Sorry, invalid Login Name or Password wrong!<BR>';
          }
      }
	  
    }
    else
    {
      $errMsg = 'Invalid Login Name or Passwordxxx!<BR>';
    }
  }
  else
  {
    $errMsg = 'Invalid Login Name or Passwordbb!<BR>';
  }
  
  if($errMsg!='')
  {
    //return $errMsg;
  }
  else
  {

    $sql = "SELECT *
            FROM system_config
            WHERE system_id = 1
           ";
    //echo $sql."<BR>";
    $result=dbQuery($sql);
    if(dbNumRows($result)==1)
    {
      $row=dbFetchAssoc($result);
	  $host = $row['host'];
	  $logo = $row['logo'];
	  $alias = $row['alias'];
	  $validate_key = $row['validate_key'];
	  $version_no = $row['version_no'];
	  
	}
			
    $log_id = logSession($user_id, 'Login', 1, session_id());
    setSession(true, $username, $user_id, $u_grp, session_id(), $log_id, $main_page, $full_mlm_sw, $company_id,$branch_id, $host, $logo, $alias, $validate_key, $version_no, $name, $lang, $u_id);

	
	header("Location: ../go-mobile-onepage/mycart.php");
		

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
       <b>My Account</b>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in</p>
        <?php 
  			echo "<span style='color: red; font-weight: bold;'>$errMsg</span>";
		?>
        <form action="loginContent.php" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="username" name="username" class="form-control" placeholder="Username">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password"  class="form-control" placeholder="Password">
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
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

        <!--
        <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div><!-- /.social-auth-links -->
       

     </div></div></body></html>