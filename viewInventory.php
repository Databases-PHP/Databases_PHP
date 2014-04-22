<!DOCTYPE html>
<?php
include "usefulQueries.php";
session_start();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>View Inventory</title>
    </head>
    <body>

    <?php
    //Print the top toolbar based on whether this is a manager or not
    $staffID = $_SESSION['staffLoggedIn'];
    $managerBool = isManager($staffID);
    if ($managerBool) {
        //Print the manager version
        ?>
        <table border="1"><tr><th><a href = "index.php">Home</a></th><th><a href = "viewInventory.php">View Inventory</a></th><th><a href="updateInventory.php">Update Inventory</a></th><th><a href = "viewAndShipOrders.php">View / Ship Orders</a></th><th><a href="salesStatistics.php">Sales Stats</a></th><th><a = href="itemPromotion.php">Item Promotions</a></th></table><br>
        <?php
    } else {
        //Print the normal staff version
        ?>
        <table border="1"><tr><th><a href = "index.php">Home</a></th><th><a href = "viewInventory.php">View Inventory</a></th><th><a href="updateInventory.php">Update Inventory</a></th><th><a href = "viewAndShipOrders.php">View / Ship Orders</a></th></table><br>
        <?php
    }

    showInventory();
?>
</body>
</html>
