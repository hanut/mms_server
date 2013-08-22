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
            //Blank Fields validation
            
            //Check the login credentials
            if(verify_login_credentials($uname, $pass)){
                echo "success;".$uname;
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
            if(add_new_patient($details)){
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

}
catch(Exception $e){
    echo "<pre>".$e->getTraceAsString()."</pre>";
}

/**
 * Function for validating the login details based on a given username and 
 * password.
 * 
 * @param type $uname
 * @param type $pass
 * @return boolean 
 */
function verify_login_credentials($uname, $pass){
    $dbo = myPDO::get_dbcon(array("db"=>"mms_demo"));
    $conditions['UserName'] = $uname;
    $pstmt = $dbo->select_conditional('mms_login',$conditions);
//    $pstmt->bindValue(":uname", $uname);
//    $pstmt->setFetchMode(PDO::FETCH_ASSOC);
//    $pstmt->execute();
    $result = $dbo->execute($pstmt,true);
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

/**
 * Function for adding new users to the database
 * Accepts an array of user details as input and adds to the database.
 * 
 * @param type $details['pname']
 * @param type $details['gender']
 * @param type $details['address']
 * @param type $details['age']
 * @param type $details['allergies']
 * @return boolean 
 */
  function add_new_patient(array $details){
      try{
              $dbo = myPDO::get_dbcon();
              $pstmt = $dbo->prepare("INSERT INTO `mms_patients` "
                      ."(`Name`,`Age`,`Gender`,`Address`,`Allergies` )"
                      ."VALUES (:name, :age, :gender, :add, :alg)");
              $pstmt->bindValue(":name", $details['pname']);
              $pstmt->bindValue(":age", $details['age']);
              $pstmt->bindValue(":gender", $details['gender']);
              $pstmt->bindValue(":add", $details['address']);
              $pstmt->bindValue(":alg", $details['allergies']);

              $chk = $pstmt->execute();
              if ($chk){
                  return TRUE;
              }
              else{
                  return FALSE;
              }
      }
      catch(PDOException $e){
          echo $e->getTraceAsString();
      }
  }

function get_user_details($name, $value){
    
}
?>
