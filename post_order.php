
<?php

if($_POST['action'] == 'call_this') {
    
  require('db_conn.php');

  $connection = new DatabaseConnection();
        
      $customer_id =  $_REQUEST['customer_id'];

        $result = $connection->run_procedure($customer_id);

        if($result){
          echo "Order Placed";
        } else {
          echo "Error: ";
        }

        // $result = mysqli_query($conn, "CALL usp_create_customer_order($customer_id)") or die("database error:");

  }
    
?>