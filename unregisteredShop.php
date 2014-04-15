<?php
    include "sql_connect.php";

    $query = "select * from Item";
    $result = mysql_query ($query);

    $num = mysql_numrows ($result);

    echo "<table border='1'><tr><th>Item ID</th><th>Item Name</th><th>Price</th><th># In Stock</th>";

    for ($i = 0; $i < $num; $i++) {
            echo "<tr>";
            $itemID = mysql_result ($result, $i, "itemID");
            $numberInStock = mysql_result ($result, $i, "numberInStock");
            $name = mysql_result ($result, $i, "name");
            $price = mysql_result ($result, $i, "price");
            echo "<td>$itemID</td> <td>$name</td> <td>$price</td> <td>$numberInStock</td>";
            echo "</tr>";
    }	

    echo "</table>";
?>