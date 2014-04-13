<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>The Project Website</title>
    </head>
    <body>
        <?php
        if (isset($_POST['submit']))
        {
            echo "Hello, ".$_POST['staffID']."!<br>";
        }
        else {
        ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                StaffID: <input type="text" name="staffID"><br>
                Password: <input type="text" name="password"><br>
                <input type="submit" name="submit" value="Sign In!">
            </form> 
        
        <?php
        }
        ?>
    </body>
</html>
