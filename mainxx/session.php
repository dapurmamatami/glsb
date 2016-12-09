<?php
session_name("glsb");
session_start(); 

//need to change this variable accordingly.
$folder = 'glsb';

$session_login = $_SESSION['basic_is_logged_in']; 
$session_uname = $_SESSION['user_name'];
$session_uid = $_SESSION['user_id'];
$session_ugrp = $_SESSION['user_grp'];


/**
    //if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1200)) {
		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 32400)) {
       // last request was more than 20 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
    }

    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp


    if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    } else if (time() - $_SESSION['CREATED'] > 32400) {
        
				// session started more than 9 hours  ago
        session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
        $_SESSION['CREATED'] = time();  // update creation time
    }
**/		

if (!isset($_SESSION['basic_is_logged_in']) || $_SESSION['basic_is_logged_in'] !== true) { 
    // not logged in, move to login page 
    header("Location: http://".$_SERVER['HTTP_HOST']."/".$folder."/main/login.php");
    exit; 
} 


?>
