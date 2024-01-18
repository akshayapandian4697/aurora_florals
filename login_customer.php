
<?php

if($_GET['action'] == 'call_this') {
    
    require('db_conn.php');

    $connection = new DatabaseConnection();
        
    $customer_email = $_REQUEST['customer_emailVal'];

    if(trim($customer_email) == "" || is_null($customer_email)){
        echo "Please enter the email";
    }
    else if(!($connection->validate_email_str(trim($customer_email)))){
        echo "Email is not valid";
    }

    else{
        
        $result = $connection->get_customer_byMail($customer_email);
        
        $customer_id = $result->fetch_array()['customer_id'] ?? '';

        if($customer_id == ''){
            echo "false";

        }else{
            echo $customer_id;
        }
    }
        
        
  }
    
?>