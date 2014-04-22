<!DOCTYPE html>
<?php
include "usefulQueries.php";
session_start();
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
	    //check for isManager
	    $match2 = staffCheckIfManager($_POST['staffID']);
            if ($match && $match2) {
                $_SESSION['staffLoggedIn'] = $_POST['staffID'];
                header("Location: viewInventory.php"); 
            } else if ($match){
                $_SESSION['staffLoggedIn'] = $_POST['staffID'];
		header("Location: viewInventory.php");
	    } else {
                 echo "Password does not match! Hit back and try again!";
            }
        }
        else {
        ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                StaffID (must be an integer): <input type="number" name="staffID"><br>
                Password (max length of 20): <input type="text" name="password"><br>
                <input type="submit" name="submit" value="Sign In!">
            </form>        
        <?php
        }
        ?>
    </body>
</html>
