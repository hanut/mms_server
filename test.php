<?php
$script='test';

include_once 'myPDO.php';
include_once 'core_functions.php';

try{
?>
<html>
    <head>
        <title>Test</title>
    </head>    
    <body>
        <?php
            $uname = "hanut";
            $pass = "123";
//            $result = rsa_keypair_generator($usr, $pass);
            $dbo = myPDO::get_dbcon();
            $conditions['UserName'] = $uname;
            $pstmt = $dbo->select_conditional('mms_login',$conditions);
//            $pstmt = $dbo->prepare("SELECT * FROM `mms_login` WHERE `UserName` = :uname");
//            $pstmt->bindValue(":uname", $uname);
//            $pstmt->setFetchMode(PDO::FETCH_ASSOC);
//            $pstmt->execute();
            $result = $dbo->execute($pstmt,true);
            die(xdebug_var_dump($result));
            if($result){
                if(rsa_keypair_check($uname, $pass, $result['Private_Key'], $result['Secret_Key'])){
                    echo "TRUE";
                }
                else{
                    echo "FALSE";
                }
            }
            else{
                echo "FALSE";
            }
        ?>
    </body>
</html>
<?php
}
catch(Exception $e){
    echo "<pre>".$e->getTraceAsString()."</pre>";
}
?>