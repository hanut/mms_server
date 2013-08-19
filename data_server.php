<?php
/**
 * This is the backend data processing script for the MMS medical management
 * system developed by Koresoft.
 * 
 * @author Hanut Singh, <hanut@koresoft.in>
 *  
 */
$script = "data_server";

require_once('myPDO.php');

if(!isset($_POST['rtype'])){
    die("Invalid Request");
}
else{
    switch($_POST['rtype']){
        case "login"    :
            //Ensure the required values are there in $_POST
            if(!isset($_POST['username']) || !isset($_POST['password'])){
                die("Invalid credentials[ERR146]");
            }
            $uname = $_POST['username'];
            $pass = $_POST['password'];
            //Check the login credentials
            if(verify_login_credentials($uname, $pass)){
                echo "success";
            }
        default         :
            echo "undefined";
    }
}

function verify_login_credentials($uname, $pass){
    if($uname=="hanut" && $pass="123")
        return true;
    else
        return false;
}
?>
