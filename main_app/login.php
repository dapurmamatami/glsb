<?php
session_name("glsb");
session_start(); 

include "../main/functions.php";
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
      $errMsg = 'Invalid Login Name or Password!<BR>';
    }
  }
  else
  {
    $errMsg = 'Invalid Login Name or Password!<BR>';
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

	
	$page = $_GET['page'];
	


	header("Location: ../userApp/index.php?view=detail&id=$user_id");

	
		

  }
}



?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Sign-Up/Login Form</title>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    
    <link rel="stylesheet" href="css/normalize.css">

    
        <link rel="stylesheet" href="css/style.css">

    
    
    
  </head>

  <body>

    <div class="form">
      
      <ul class="tab-group">
      

        
      </ul>
      
      


		<div class="tab-content">                
       <div id="login">   
          <h1>Welcome Back!</h1>

        <?php 
  			echo "<span style='color: red; font-weight: bold;'>$errMsg</span>";
		?>          

        <form action="login.php" method="post">
        <div class="field-wrap">
          <div class="form-group has-feedback">
            <input type="text" name="username" name="username" class="form-control" placeholder="Username">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password"  class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
		</div>
        
        <div class="field-wrap">
        </div>
        
        
        <div class="field-wrap">
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
         </div>
            <div class="col-xs-4">
              <button type="submit" class="button button-block">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>


        </div>
        
            
        <div id="signup" >   
          <h1>Sign Up for Free</h1>
          
          <form action="login.php" method="post">
          
          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" />
            </div>
        
            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input type="text"required autocomplete="off"/>
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Set A Password<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off"/>
          </div>
          
          <button type="submit" class="button button-block" id="btn_insert" name="btn_insert"/>Get Started</button>
          
          </form>

        </div>
        
 
        
      </div><!-- tab-content -->
      
</div> <!-- /form -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="js/index.js"></script>

    
    
    
  </body>
</html>
