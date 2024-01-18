
<?php
    
    require('db_conn.php');

    $connection = new DatabaseConnection();
        
        $result = $connection->get_view_products();
        
        if($result){
            while ($category = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        
                echo "<option value='$category[bouquet_id]'>$category[name]</option>";
            }
        }

?>