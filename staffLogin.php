<!DOCTYPE html>
<?php
include "staffCheckPassword.php";
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Staff Login</title>
    </head>
    <body>
        <?php
        if (isset($_POST['submit']) && $_POST['staffID'] != "")
        {
            $match = staffCheckPassword($_POST['staffID'], $_POST['password']);
            if ($match) {
                header("Location: staffPage.php"); 
            } else {
                echo "Password does not match! Hit back and try again!";
            }
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
