<?php

include "../main/functions.php";
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";
include "../inc/pdoconfig.php";
include "../main/appfunctions.php";
include "../main/sessionLogin.php";


$user_id = $_SESSION['user_id'];
$userData = getUserDetailApp($user_id);

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
      

      
   
      

          
        
              
        <div id="signup">   
          <h1>My Profile</h1>
          
          <form action="/" method="post">
 
    
          <div class="top-row">

            <div class="field-wrap">
            <label>Name</label>

            </div>
                        
            <div class="field-wrap">
     
  
              <input type="text" required autocomplete="off" value="<?php echo $userData[name]; ?>"/>
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
            <input type="password" autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
          <button type="submit" class="button button-block"/>Update</button>
           </div>
            <div class="col-xs-4">
              <a href="../main/logoutApp.php" class="btn btn-default btn-flat">Logout</a>
            </div><!-- /.col -->
          
          </form>

        </div>
        
 
        
   
      
</div> <!-- /form -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="js/index.js"></script>

    
    
    
  </body>
</html>
