
<?php
    
    require('db_conn.php');

    $connection = new DatabaseConnection();
        
    $result = $connection->get_view_products();

    if ($result->num_rows > 0) {

        // output data of each row
        while($row = $result->fetch_assoc()) {

            $bouquet_id = $connection->prepare_data($row['bouquet_id']);
            $name = $connection->prepare_data($row['name']);
            $unit_price = $connection->prepare_data($row['unit_price']);
            $stock = $connection->prepare_data($row['stock']);

            echo "<tr><td>" . $name . "</td><td>" . $unit_price . "</td><td>" . $stock ."</td></tr>" ;
        }
    } else { echo "0 results"; }

    
?>