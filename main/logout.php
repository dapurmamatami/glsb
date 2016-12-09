<?php 
// i will keep yelling this 
// DON'T FORGET TO START THE SESSION !!! 
session_name("glsb");
session_start(); 

include "functions.php";
include "../inc/dbconfig.php";
include "../inc/dbfunctions.php";

logSession($_SESSION['user_id'], 'Logout', $_SERVER['REMOTE_ADDR'], $_SESSION['sid'] );
// if the user is logged in, unset the session 
/*
if (isset($_SESSION['basic_is_logged_in'])) { 
    unset($_SESSION['basic_is_logged_in']); 
} 

if (isset($_SESSION['user_name'])) { 
    unset($_SESSION['user_name']); 
} 
*/

$_SESSION = array();

session_destroy();
// now that the user is logged out, 
// go to login page 
header('Location: ../main/login.php'); 
?> 
