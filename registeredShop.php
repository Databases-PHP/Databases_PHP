<!DOCTYPE html>
<?php
//include addToCart.php;
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Registered Customer Shop</title>
    </head>
    <body>
    <?php
        include "sql_connect.php";

        $query = "select * from Item";
        $result = mysql_query ($query);

        $num = mysql_numrows ($result);

        echo "<table border='1'><tr><th>Item ID</th><th>Item Name</th><th>Price</th><th># In Stock</th><th>Add To Cart</th>";

        for ($i = 0; $i < $num; $i++) {
                
                $itemID = mysql_result ($result, $i, "itemID");
                $numberInStock = mysql_result ($result, $i, "numberInStock");
                $name = mysql_result ($result, $i, "name");
                $price = mysql_result ($result, $i, "price");
                $cartString = "<input type='submit' name='addToCart$itemID' value='Add To Cart'>";
                echo "<tr>";
    ?>
                <form action="<?php //Do something; ?>" method="post">
                <?php
                echo "<td>$itemID</td> <td>$name</td> <td>$price</td> <td>$numberInStock</td> <td>$cartString</td>";
                echo "</tr>";
                ?>
                </form>
        <?php
        }	
    
        echo "</table>";
        ?>
    </body>
</html>
