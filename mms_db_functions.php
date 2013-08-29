<?php
if(empty($script)){   
    exit();  
}
/**
 * This class contains code for handling all database interactions for the MMS
 * system on the server side.
 * 
 * @author Hanut Singh, <hanut@koresoft.in>
 * 
 */

class mms_server{
    
    function __construct() {
        return null;
    }
    function __clone() {
        return null;
    }
    
    /**
    * Function for validating the login details based on a given username and 
    * password.
    * 
    * @param type $uname
    * @param type $pass
    * @return boolean 
    */
    public static function verify_login_credentials($uname, $pass){
        $dbo = myPDO::get_dbcon(array("db"=>"mms_demo"));
        $pstmt = $dbo->prepare("SELECT  `UserName` ,  `Private_Key` ,  `Secret_Key` ,  "
                                ."`TypeName` as type "
                                ."FROM  `mms_login` ml "
                                ."LEFT JOIN  `mms_user_types` mut "
                                ."ON ml.`UserType` = mut.`TypeID` "
                                ."WHERE ml.`UserName`=:uname");
        $pstmt->bindValue(":uname", $uname);
        $pstmt->setFetchMode(PDO::FETCH_ASSOC);
        $pstmt->execute();
        $result = $pstmt->fetch();
    //    $result = $pstmt->fetch();
        if($result){
            if(rsa_keypair_check($uname, $pass, $result['Private_Key'], $result['Secret_Key'])){
                return $result;
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
    * Function for adding new patient to the database
    * Accepts an array of user details as input and adds to the database.
    * 
    * @param type $details['pname']
    * @param type $details['gender']
    * @param type $details['address']
    * @param type $details['age']
    * @param type $details['allergies']
    * @return boolean 
    */
    public static function add_new_patient(array $details){
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

    /**
    * Function for adding a new doctor to the database
    * Accepts an array of doctor's details as input and adds to the database.
    * 
    * @param type $details['pname']
    * @param type $details['gender']
    * @param type $details['address']
    * @param type $details['age']
    * @param type $details['allergies']
    * @return boolean 
    */
    public static function add_new_doctor(array $details){
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

    /**
    * Takes an id for a given doctor and returns his/her details from the database
    * 
    * @param type $id ID of the doctor
    * @return Mixed Returns array of doctors details on success or FALSE on failure. 
    */
    public static function get_doctor_details($id){
        try{
                $dbo = myPDO::get_dbcon();
                $pstmt = $dbo->prepare("SELECT * FROM `mms_doctors` "
                        ."WHERE `DoctorID`=:id");
                $pstmt->bindValue(":id", $id);
                $result = $pstmt->fetch();
                if ($result){
                    return $result;
                }
                else{
                    return FALSE;
                }
        }
        catch(PDOException $e){
            echo $e->getTraceAsString();
        }
    }

    /**
    * Takes an id for a given Chemis and returns his/her details from the database
    * 
    * @param type $id ID of the chemist
    * @return Mixed Returns array of doctors details on success or FALSE on failure. 
    */
    public static function get_chemist_details($id){
        try{
                $dbo = myPDO::get_dbcon();
                $pstmt = $dbo->prepare("SELECT * FROM `mms_pharmacists` "
                        ."WHERE `PharmacistID`=:id");
                $pstmt->bindValue(":id", $id);
                $result = $pstmt->fetch();
                if ($result){
                    return $result;
                }
                else{
                    return FALSE;
                }
        }
        catch(PDOException $e){
            echo $e->getTraceAsString();
        }
    }
}
?>
