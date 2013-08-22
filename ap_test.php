<?php
    $script = "add patient test";
    include_once "core_functions.php";
    
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
            <form name='add_patient' method="post" action="data_server.php" style="margin-left: 35%;">
                <label for="name">Patient's name</label>
                <input type="text" value="hurrr" name="name" id="name" placeholder="name"/>
                <br/>
                <label for="age">Age</label>
                <select name="age" id="age">
                   <?php 
                        for($i=0;$i<=120;$i++){
                            echo "<option value=\"".$i."\">".$i."</option>";
                        }
                   ?>
                </select>
                <br/>
                <label for="gender">Gender</label>
                <select name="gender" id="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <br/>
                <label for="address">Address</label>
                <textarea name="address" id="address" placeholder="Address">dasdasdsa</textarea>
                <br/>
                <label for="allergies">Allergies</label>
                <textarea name="allergies" id="allergies" placeholder="Allergies">sdadasdas</textarea>
                <br/>
                <input type="hidden" name="rtype" value="add_patient"/>
                <button>Submit</button>
                <br/>
            </form>
        <hr/>
        </div>
    </body>
</html>
