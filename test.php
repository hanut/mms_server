<?php
try{
?>
<html>
    <head>
        <title>Test</title>
    </head>    
    <body>
        <?php
            $script = "test";
            require_once 'myPDO.php';
            
            $dbo= myPDO::get_dbcon();
            $pstmt = $dbo->select_conditional('mms_login',array("UserName"=>"aditya"),
                                        array("UserID","UserName","UserType"));
            $result = $dbo->execute($pstmt,true);
            xdebug_var_dump($result);
        ?>
    </body>
</html>
<?php
}
catch(Exception $e){
    echo "<pre>".$e->getTraceAsString()."</pre>";
}
?>