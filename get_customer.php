
<?php

if($_GET['action'] == 'call_this') {
    
    require('db_conn.php');

    $connection = new DatabaseConnection();
        
    $customer_name =  $_REQUEST['customer_nameVal'];
    $customer_address = $_REQUEST['customer_addressVal'];
    $customer_phone =  $_REQUEST['customer_phoneVal'];
    $customer_email = $_REQUEST['customer_emailVal'];
        
    if(is_null($customer_name) || is_null($customer_address) || is_null($customer_phone) || is_null($customer_email) || trim($customer_name) =="" || trim($customer_address) == "" || trim($customer_phone) == "" || trim($customer_email) == ""){
        echo "Please fill all the fields";
    }
    else if(!is_numeric($customer_phone)){
        echo "Phone number should be 10 digits number";
    }
    else if(!($connection->validate_phonuNumber(trim($customer_phone)))){
        echo "Phone number should be 10 digits";
    }
    else if(!($connection->validate_email_str(trim($customer_email)))){
        echo "Email is not valid";
    }
    
    else{

        $getresult = $connection->get_customer_byMail($customer_email);
       
        $customer_id = $getresult->fetch_array()['customer_id'] ?? '';

        if($customer_id == ''){

            $sqlinsert = $connection->create_customer($customer_name, $customer_address, $customer_phone, $customer_email);

            if ($sqlinsert) {
                $results = $connection->get_customer_byMail($customer_email);
                $customer_id = $results->fetch_array()['customer_id'] ?? '';
                echo $customer_id;
            } else {
                echo "Error: ";
            }

        }else{
            echo "Customer already exists. Please login.";
        }
    }

        
        
  }
    
?>