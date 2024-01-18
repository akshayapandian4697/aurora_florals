<?php

if($_POST['action'] == 'call_this') {
    
    require('db_conn.php');

    $connection = new DatabaseConnection();
        
        $floral =  $_REQUEST['floral'];
        $unitprice = $_REQUEST['unitprice'];
        $stock = $_REQUEST['stock'];

        if(is_null($unitprice) || is_null($floral) || is_null($stock) || (trim($unitprice) =="") || (trim($floral) == "") || (trim($stock) =="")){
            echo "Please fill all the fields";
        }
        else if(!is_numeric($unitprice)){
            echo "Unit price should be a number";
        }
        else if(!is_numeric($stock)){
            echo "Stock should be a number";
        }
        else{
            $result = $connection->save_florals($floral, $unitprice, $stock);
        
            if($result){
                echo "true";
            } else {
                echo "</br>Some error in Saving the data";
            }
    
        }

       
  }
    
?>