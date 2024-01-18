
<?php

    require('db_conn.php');

    $connection = new DatabaseConnection();
    
    $bouquet_id = $_REQUEST['bouquet_id'];
    $customer_id = $_REQUEST['id'];

    $result = $connection->delete_cart_product($customer_id, $bouquet_id);
    
    if($result){
        echo "Product deleted Successfully";
    } else {
        echo "</br>Some error in Saving the data";
    }


?>