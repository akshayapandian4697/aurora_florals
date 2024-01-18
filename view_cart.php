
<?php
    
    require('db_conn.php');

    $connection = new DatabaseConnection();

    $customer_id = $_GET['id'];

    $result = $connection->get_view_cart($customer_id);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {

        echo "<tr><td>" . $row["name"] . "</td><td>" . $row["unit_price"] . "</td><td>" . $row["quantity"] ." </td><td>" . $row["total"] . "</td><td>" . "<button class="."updatebtn"." alt=".$row["bouquet_id"]. 
        " altt=".$row["quantity"]." name=".$row["name"]." ><img src="."imgs/edit.png"." /></button>" . 
        "</td><td>" . "<button class="."deletebtn"." alt=".$row["bouquet_id"]. " altt=".$row["quantity"]." name=".$row["name"]." >
        <img src="."imgs/delete.png"." /></button>" . "</td></tr>";
        
        }
    } 
    
?>