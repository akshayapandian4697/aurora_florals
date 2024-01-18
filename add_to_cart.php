
<?php

if($_POST['action'] == 'call_this') {

    require('db_conn.php');

    $connection = new DatabaseConnection();
        
        $floral_id =  $_REQUEST['floral'];
        $quantity = $_REQUEST['quantity'];
        $customer_id = $_REQUEST['customer_id'];

        
        if(trim($floral_id) == "Select Floral Product"){
            echo "Please select a product";
        }
        else if(is_null($quantity) || (trim($quantity) =="")){
            echo "Please give a quantity";
        }
        
        else if(!is_numeric($quantity)){
            echo "Quantity should be a number";
        }
        else{

            try {
                $result = $connection->add_product_toCart($floral_id, $quantity, $customer_id );
                if($result){
                    echo "true";
                } 
              }
              
              catch(Exception $e) {
                echo "false";
              }

        }

        

  }
    
?>