<?php
/**
 * This is the backend data processing script for the MMS medical management
 * system developed by Koresoft.
 * 
 * @author Hanut Singh, <hanut@koresoft.in>
 *  
 */
$script = "data_server";

require_once 'myPDO.php';
require_once 'core_functions.php';
require_once 'mms_db_functions.php';


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
            //Blank Fields validation
            
            //Check the login credentials
            $user = mms_server::verify_login_credentials($uname, $pass);
            if($user){
                $id="";
                switch($user['type']){
                    case 'doctor'       :   $id = mms_server::getDoctorID($user['UserID']);break;
                    case 'chemist'      :   $id = mms_server::getChemistID($user['UserID']);break;
                    case 'admin'        :   $id = "admin";break;
                    case 'super-admin'  :   $id = "super-admin";break;
                    case 'god'          :   $id = "GOD";break;
                    default             :   die("Unknown usertype");
                }
                echo "success;".$uname.";".$user['type'].";".$id;
            }
            else{
                echo "Wrong user-name or password.";
            }
            break;
        case "add_patient"  :
            //Validate request POSTDATA for errors
            if(!isset($_POST['name']) || !isset($_POST['gender']) || !isset($_POST['address'])
                    || !isset($_POST['age']) || !isset($_POST['allergies'])){
                die("Invalid Patient Data[ERR156]");
            }
            $details = array();
            $details['pname'] = $_POST['name'];
            $details['gender'] = $_POST['gender']; 
            $details['address'] = $_POST['address'];
            $details['age'] = $_POST['age']; 
            $details['allergies'] = $_POST['allergies'];
            if(mms_server::add_new_patient($details)){
                echo "New Patient Added";
            }
            else{
                echo "Error Adding New Patient.Contact server admin...";
            }
            break;
        default         :
            echo "undefined";break;
    }
}

?>
