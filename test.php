<html>
    <head>
        <title>Test</title>
    </head>    
    <body>
        <?php
            $script = "test";
            require_once 'myPDO.php';
            
            $dbo= myPDO::get_dbcon();
            $pstmt = $dbo->select_unconditional('mms_login',array("UserID","UserName","UserType"));
            echo "<pre>".  xdebug_var_dump($pstmt)."</pre>";
        ?>
    </body>
</html>
