
<?php
    
    require('db_conn.php');
    $customer_id = $_GET['id'];

    $connection = new DatabaseConnection();
        
        $result = $connection->get_order($customer_id);
        
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {

            echo "<tr class = "."orderhead"."><td>" . " " . "</td><td>" . "O " . "</td><td>" . " " . "</td><td>" . " " . "</td><td>" . " " . "</td></tr>" ;
            echo "<tr class = "."orderheading"."><th>" . "Order Id" . "</th><th>" . "Order Date" . "</th><th>" . "Total Price" . "</th><th colspan="."2".">" . "<button class="."invoicebtn"." alt=".$row["order_id"]." >Print Invoice</button>" . "</th></tr>" ;

            echo "<tr class = "."orderheadingContent"."><td>" . $row["order_id"] . "</td><td>" . $row["order_date"] . "</td><td>" . $row["total_price"] . "</td></tr>" ;
            
            $order_id =  $row["order_id"];

            $results = $connection->get_order_details($customer_id, $order_id);
            
                echo "<tr class = "."ordersubheading"."><td>" . " " . "</td><th>" . "Product name" . "</th><th>" . "Quantity" . "</th><th>" . "Unit Price" . "</th><th>" . "Total" . "</th></tr>" ;
                if ($results->num_rows > 0) {
               
                    while($roww = $results->fetch_assoc()) {

                    echo "<tr class = "."contents"."><td>" . " " . "</td><td>" . $roww["name"] . "</td><td>" . $roww["quantity"] ."</td><td>" . $roww["unit_price"] . "</td><td>" . $roww["total_price"] . "</td></tr>" ;
                   
                }
            } 
        }
    } 
?>