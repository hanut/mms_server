<?php
    $script = "login test";
    include_once "core_functions.php";
    
    //Change username and password here
    $usr = "aditya";
    $pass = "123";
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $script; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style type="text/css">
            label{
                cursor: pointer;
                padding: 1%;
                border-radius: 10px;
            }
            label:hover, label:active{
                color: darkred;
                box-shadow: 0px 0px 10px 1px darkgray inset;
            }
        </style>
    </head>
    <body>
        <div style="position: absolute;top: 10%;left: 10%;right: 15%;bottom: 0%;">
            <h1 style="text-align: center;font-family: sans-serif;">Login Form</h1>
            <hr/>
            <form name='login' method="post" action="data_server.php" style="margin-left: 35%;">
                <label for="username">Username</label>
                <input type="text" name="username" id="username"
                       value="<?php echo $usr;?>"/>
                <br/>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" 
                       value="<?php echo $pass;?>"/>
                <input type="hidden" name="rtype" value="login"/>
                <br/>
                <button>Submit</button>
                <br/>
            </form>
        <hr/>
        <table>
            <thead>
                <tr>
                    <th>Sno.</th>
                    <th>Key</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tr>
                <td>1.</td>
                <td>PK</td>
                <td><?php $keypair = rsa_keypair_generator($usr,$pass);echo $keypair['pk']; ?></td>
            </tr>
            <tr>
                <td>2.</td>
                <td>SK</td>
                <td><?php echo $keypair['sk']; ?></td>
            </tr>
        </table>
        </div>
    </body>
</html>
