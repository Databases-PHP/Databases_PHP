<!DOCTYPE html>
<?php
include "customerCheckPassword.php";
include "customerRegister.php";
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
                header("Location: customerPage.php"); 
            } else {
                echo "Password does not match! Hit back and try again!";
            }
        } else if (isset($_POST['submitRegister']) && $_POST['customerID'] != "") {
            //Register new customer. Must check that ID is not taken already
            $match = customerRegister($_POST['customerID'], $_POST['password']);
            if ($match) {
                header("Location: customerPage.php");
            } else {
                echo "Adding the user failed! Hit back and try again!";
            }
            
        } else {
        ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                CustomerID: <input type="text" name="customerID"><br>
                Password: <input type="text" name="password"><br>
                <input type="submit" name="submitLogin" value="Sign In">
                <input type="submit" name="submitRegister" value="Register">
            </form>
        <?php
        }
        ?>
    </body>
</html>