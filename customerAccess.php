<!DOCTYPE html>
<?php
include "usefulQueries.php";
session_start();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Customer Access</title>
    </head>
    <body>
        <?php
        if (isset($_POST['submitLogin']) && $_POST['customerID'] != "")
        {
            //Login customer
            $match = customerCheckPassword($_POST['customerID'], $_POST['password']);
            if ($match) {
                //Save the customer that is logged in
                //session_start();
                $_SESSION['customerLoggedIn'] = $_POST['customerID'];
                header("Location: registeredShop.php"); 
            } else {
                echo "Password does not match! Hit back and try again!";
            }
        } else if (isset($_POST['submitRegister']) && $_POST['customerID'] != "") {
            //Register new customer. Must check that ID is not taken already
            $match = customerRegister($_POST['customerID'], $_POST['password']);
            if ($match) {
                //$GLOBALS['customerIDLoggedIn']=$_POST['customerID'];
		$_SESSION['customerLoggedIn']=$_POST['customerID'];
                header("Location: registeredShop.php");
            } else {
                echo "Adding the user failed! Hit back and try again!";
            }
            
        } else {
        ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                CustomerID (must be an integer): <input type="text" name="customerID"><br>
                Password (max length of 20): <input type="text" name="password"><br>
                <input type="submit" name="submitLogin" value="Sign In">
                <input type="submit" name="submitRegister" value="Register">
            </form>
        <?php
        }
        ?>
    </body>
</html>
