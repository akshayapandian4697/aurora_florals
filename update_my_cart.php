
<?php

if($_POST['action'] == 'call_this') {
    
  require('db_conn.php');

    $connection = new DatabaseConnection();
        
        $customer_id =  $_REQUEST['customer_id'];
        $bouquet_id =  $_REQUEST['bouquet_id'];
        $quantity =  $_REQUEST['quantity'];

        if(is_null($quantity) || (trim($quantity) =="")){
          echo "Please give a quantity";
        }
        
        else if(!is_numeric($quantity)){
            echo "Quantity should be a number";
        }

        else{

          $result = $connection->update_cart($customer_id, $bouquet_id, $quantity);

            if($result){
              echo "true";
            } else {
              echo "Error: ";
            }
        }

        
        
  }
    
?>