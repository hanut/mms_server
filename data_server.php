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
            if(!isset($_POST['name']) || !isset($_POST['gender']) || !isset($_POST['address'])
                    || !isset($_POST['age']) || !isset($_POST['allergies'])){
                die("Invalid Patient Data[ERR156]");
            }
            $pname = $_POST['name'];
            $gender = $_POST['gender']; 
            $address = $_POST['address'];
            $age = $_POST['age']; 
            $allergies = $_POST['allergies'];
            if(add_new_patient($pname,$gender,$address,$age,$allergies)){
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

  function add_new_patient($pname,$gender,$address,$age,$allergies){
      try{
              $dbo = myPDO::get_dbcon();
              $pstmt = $dbo->prepare("INSERT INTO `mms_patients` "
                      ."(`Name`,`Age`,`Gender`,`Address`,`Allergies` )"
                      ."VALUES (:name, :age, :gender, :add, :alg)");
              $pstmt->bindValue(":name", $pname);
              $pstmt->bindValue(":age", $age);
              $pstmt->bindValue(":gender", $gender);
              $pstmt->bindValue(":add", $address);
              $pstmt->bindValue(":alg", $allergies);

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

function get_user_details($uname){
    
}
?>
