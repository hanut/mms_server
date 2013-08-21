<?php
/**
 * This is the backend data processing script for the MMS medical management
 * system developed by Koresoft.
 * 
 * @author Hanut Singh, <hanut@koresoft.in>
 *  
 */
try{

$script = "data_server";

require_once 'myPDO.php';
require_once 'core_functions.php';

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
            else{
                echo "Wrong user-name or password.";
            }
            break;
        default         :
            echo "undefined";break;
    }
}

function verify_login_credentials($uname, $pass){
    $dbo = myPDO::get_dbcon();
    $conditions['UserName'] = $uname;
    $pstmt = $dbo->select_conditional(`mms_login`,$conditions);
//    $pstmt->bindValue(":uname", $uname);
//    $pstmt->setFetchMode(PDO::FETCH_ASSOC);
//    $pstmt->execute();
    $result = $dbo->execute($pstmt);
//    $result = $pstmt->fetch();
    if($result){
        if(rsa_keypair_check($uname, $pass, $result['Private_Key'], $result['Secret_Key'])){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    else{
        return FALSE;
    }
}
}
catch(Exception $e){
    echo "<pre>".$e->getTraceAsString()."</pre>";
}

function get_user_details($uname){
    
}
?>
