<?php
	class DatabaseConnection {

		const DB_USER = 'root';
		const DB_PASSWORD = '';
		const DB_HOST = 'localhost:3306';
		const DB_NAME = 'aurora_florals';

		private $dbc;

		function __construct() {
			$this->dbc = @mysqli_connect(
				self::DB_HOST,
				self::DB_USER,
				self::DB_PASSWORD,
				self::DB_NAME
			)
			OR die(
				'Could not connect to MySQL: ' . mysqli_connect_error()
			);

			mysqli_set_charset($this->dbc, 'utf8');
		}

        function get_dbc() {
			return $this->dbc;
		}

		function prepare_string($string) {

            $data = filter_var($string, FILTER_SANITIZE_STRING);
            $striped_string = strip_tags($data);
			$string_trimmed =  trim(htmlspecialchars($striped_string));
            $string_escaped = mysqli_real_escape_string($this->dbc, $string_trimmed);
            $string_sanitized = filter_var($string_escaped, FILTER_SANITIZE_SPECIAL_CHARS);
            return $string_sanitized;

		}

        function prepare_data($string) {
            $string_trimmed = trim($string);
            $string = htmlspecialchars(mysqli_real_escape_string($this->dbc, $string_trimmed));
            $string_sanitized = filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
            return $string_sanitized;
        }

		
        function register_user($name, $email, $phone, $province){
            
            $name_clean = $this->prepare_string($name);
            $email_clean = $this->prepare_string($email);
            $phone_clean = $this->prepare_string($phone);
            $province_clean = $this->prepare_string($province);

            $query = "INSERT INTO users(name , email, phone, province) VALUES (?,?,?,?)";
        
            $stmt = mysqli_prepare($this->dbc, $query);

            mysqli_stmt_bind_param(
                $stmt,
                'ssss',
                $name_clean,
                $email_clean,
                $phone_clean,
                $province_clean
            );

            $result = mysqli_stmt_execute($stmt);

            return $result;
        }
        
        function get_users() {
            $query = 'SELECT * FROM users;';
            $result = @mysqli_query($this->dbc,$query);
            return $result;
        }
        
        function get_user_by_id($user_id) {
            $user_id_clean = $this->prepare_string($user_id);
            $query = "SELECT * FROM users WHERE user_id = ?;";
            $stmt = mysqli_prepare($this->dbc, $query);
            mysqli_stmt_bind_param(
                $stmt,
                's',
                $user_id_clean
            );
            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return $result;
        }
        
        function update_user($user_id, $name, $email, $phone, $province){
            
            $user_id_clean = $this->prepare_string($user_id);
            $name_clean = $this->prepare_string($name);
            $email_clean = $this->prepare_string($email);
            $phone_clean = $this->prepare_string($phone);
            $province_clean = $this->prepare_string($province);

            $query = "UPDATE users SET name = ?, email = ?, phone = ?, province = ? WHERE  user_id = ?;";

            $stmt = mysqli_prepare($this->dbc, $query);

            mysqli_stmt_bind_param(
                $stmt,
                'sssss',
                $name_clean,
                $email_clean,
                $phone_clean,
                $province_clean,
                $user_id_clean
            );

            $result = mysqli_stmt_execute($stmt);
            return $result;
        }
        
        function delete_user_by_id($user_id) {
            
            $user_id_clean = $this->prepare_string($user_id);
            $query = "DELETE FROM Users WHERE user_id = ? ;";
            $stmt = mysqli_prepare($this->dbc, $query);
            mysqli_stmt_bind_param(
                $stmt,
                's',
                $user_id_clean
            );
            
            $result = mysqli_stmt_execute($stmt);

            return $result;
        }

        ########################################

        function get_view_products() {
            $query = "SELECT bouquet_id, name, unit_price, stock FROM bouquet ORDER BY bouquet_id";
            $result = @mysqli_query($this->dbc,$query);
            return $result;
        }


        function run_procedure($customer_id) {
           
            $customer_id_clean = $this->prepare_string($customer_id);

            $query = 'CALL usp_create_customer_order(?)';

            $stmt = mysqli_prepare($this->dbc, $query);

            mysqli_stmt_bind_param(
                $stmt,
                's',
                $customer_id_clean
            );
            
            $result = mysqli_stmt_execute($stmt);

            return $result;

        }
        

        function save_florals($name, $price, $stock ){
            
            $name_clean = $this->prepare_string($name);
            $price_clean = $this->prepare_string($price);
            $stock_clean = $this->prepare_string($stock);

            $query = "INSERT INTO bouquet(`name`, `unit_price`, `stock`)  VALUES (?,?,?)";
        
            $stmt = mysqli_prepare($this->dbc, $query);

            mysqli_stmt_bind_param(
                $stmt,
                'sss',
                $name_clean,
                $price_clean,
                $stock_clean
            );

            $result = mysqli_stmt_execute($stmt);

            return $result;
        }


        function add_product_toCart($floral_id, $quantity, $customer_id ){
            
            $floral_id_clean = $this->prepare_string($floral_id);
            $quantity_clean = $this->prepare_string($quantity);
            $customer_id_clean = $this->prepare_string($customer_id);

            $query =  "INSERT INTO customer_cart(`customer_id`, `bouquet_id`, `quantity`)  VALUES (?,?,?)";
        
            $stmt = mysqli_prepare($this->dbc, $query);

            mysqli_stmt_bind_param(
                $stmt,
                'sss',
                $customer_id_clean,
                $floral_id_clean,
                $quantity_clean
            );

            $result = mysqli_stmt_execute($stmt);

            return $result;

        }


        function delete_cart_product($customer_id, $floral_id) {
            
            $customer_id_clean = $this->prepare_string($customer_id);
            $floral_id_clean = $this->prepare_string($floral_id);

            $query = "DELETE FROM customer_cart WHERE customer_id = ? AND bouquet_id = ? ;";
            $stmt = mysqli_prepare($this->dbc, $query);
            mysqli_stmt_bind_param(
                $stmt,
                'ss',
                $customer_id_clean,
                $floral_id_clean
            );
            
            $result = mysqli_stmt_execute($stmt);

            return $result;
        }


        function get_customer_byMail($customer_email) {
            
            $customer_email_clean = $this->prepare_string($customer_email);

            $query = "SELECT customer_id FROM customer WHERE email_address= ? ;";

            $stmt = mysqli_prepare($this->dbc, $query);
            mysqli_stmt_bind_param(
                $stmt,
                's',
                $customer_email_clean
            );
            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            return $result;
        }


        function get_customer_byId($customer_id) {
            
            $customer_id_clean = $this->prepare_string($customer_id);

            $query = "SELECT name, address, phone_num, email_address FROM customer WHERE customer_id = ? ;";

            $stmt = mysqli_prepare($this->dbc, $query);
            mysqli_stmt_bind_param(
                $stmt,
                's',
                $customer_id_clean
            );
            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            return $result;
        }


        function create_customer($name, $address, $phone, $email){
            
            $name_clean = $this->prepare_string($name);
            $email_clean = $this->prepare_string($email);
            $phone_clean = $this->prepare_string($phone);
            $address_clean = $this->prepare_string($address);

            $query = "INSERT INTO customer(`name`, `address`, `phone_num`,`email_address`) VALUES (?,?,?,?)";
        
            $stmt = mysqli_prepare($this->dbc, $query);

            mysqli_stmt_bind_param(
                $stmt,
                'ssss',
                $name_clean,
                $address_clean,
                $phone_clean,
                $email_clean
            );

            $result = mysqli_stmt_execute($stmt);

            return $result;
        }


        function get_order($customer_id) {
            
            $customer_id_clean = $this->prepare_string($customer_id);

            $query = "SELECT order_id, total_price, date AS order_date FROM aurora_florals.order WHERE customer_id = ? ;";

            $stmt = mysqli_prepare($this->dbc, $query);

            mysqli_stmt_bind_param(
                $stmt,
                's',
                $customer_id_clean
            );
            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            return $result;
        }


        function get_order_details($customer_id, $order_id) {
            
            $customer_id_clean = $this->prepare_string($customer_id);
            $order_id_clean = $this->prepare_string($order_id);

            $query = "SELECT g.name, g.unit_price, og.quantity, og.total_price FROM order_bouquets og
            INNER JOIN aurora_florals.order o ON
            og.order_id = o.order_id
            INNER JOIN bouquet g ON
            g.bouquet_id = og.bouquet_id
            WHERE o.customer_id = ? AND og.order_id = ? ;";

            $stmt = mysqli_prepare($this->dbc, $query);

            mysqli_stmt_bind_param(
                $stmt,
                'ss',
                $customer_id_clean,
                $order_id_clean
            );
            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            return $result;
        }


        function get_order_by_ids($customer_id, $order_id) {
            
            $customer_id_clean = $this->prepare_string($customer_id);
            $order_id_clean = $this->prepare_string($order_id);

            $query = "SELECT total_price, date AS order_date FROM aurora_florals.order WHERE customer_id = ? AND order_id = ? ;";

            $stmt = mysqli_prepare($this->dbc, $query);

            mysqli_stmt_bind_param(
                $stmt,
                'ss',
                $customer_id_clean,
                $order_id_clean
            );
            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            return $result;
        }


        function get_order_details_products($customer_id, $order_id) {
            
            $customer_id_clean = $this->prepare_string($customer_id);
            $order_id_clean = $this->prepare_string($order_id);

            $query = "SELECT g.name, g.unit_price, og.quantity, og.total_price FROM order_bouquets og
            INNER JOIN aurora_florals.order o ON
            og.order_id = o.order_id
            INNER JOIN bouquet g ON
            g.bouquet_id = og.bouquet_id
            WHERE o.customer_id = ? AND og.order_id = ? ;";

            $stmt = mysqli_prepare($this->dbc, $query);

            mysqli_stmt_bind_param(
                $stmt,
                'ss',
                $customer_id_clean,
                $order_id_clean
            );
            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            return $result;
        }


        function update_cart($customer_id, $bouquet_id, $quantity){
            
            $customer_id_clean = $this->prepare_string($customer_id);
            $bouquet_id_clean = $this->prepare_string($bouquet_id);
            $quantity_clean = $this->prepare_string($quantity);

            $query = "UPDATE customer_cart SET quantity = ? WHERE customer_id = ? AND bouquet_id = ?";

            $stmt = mysqli_prepare($this->dbc, $query);

            mysqli_stmt_bind_param(
                $stmt,
                'sss',
                $quantity_clean,
                $customer_id_clean,
                $bouquet_id_clean
            );

            $result = mysqli_stmt_execute($stmt);
            return $result;
        }


        function get_view_cart($customer_id) {
            
            $customer_id_clean = $this->prepare_string($customer_id);

            $query = "SELECT g.name AS name, ca.quantity AS quantity, g.unit_price AS unit_price, ca.total_price AS total, ca.bouquet_id 
            FROM customer_cart ca 
            INNER JOIN bouquet g ON g.bouquet_id = ca.bouquet_id  
            WHERE ca.customer_id =  ? ;";

            $stmt = mysqli_prepare($this->dbc, $query);

            mysqli_stmt_bind_param(
                $stmt,
                's',
                $customer_id_clean
            );
            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            return $result;
        }

        function validate_email_str($user_email) {
            if(filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        }

        function validate_phonuNumber($phoneNum) {
            if(preg_match("/\d{10}$/" ,$phoneNum)) {
                return true;
            } else { 
                return false;
            }
        }

	}
?>