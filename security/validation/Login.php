<?php 
    session_start();
    require_once "../../database/Database.php";

    class Login {
        private $errors = [
            'email' => ["empty" => "Email is required.", "invalid" => "Email is not valid."],
            'password' => ["empty" => "Password is required.", "incorrect" => "Password incorrect."],
            "user" => ["not-found" => "User not found."]
        ];

        function validate_input(string $input, string $type): string{
            // Sanitize request input data
            $data = trim($input);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);

            // If the input data is empty, redirect back to login with error messsage
            if(empty($data)) {
                $_SESSION["{$type}_ERROR"] = $this->errors[strtolower($type)]["empty"];
                $_SESSION["OLD_DATA"] = $_REQUEST['email']; 
                header("Location: ../../public/pages/login.php");
                exit;
            }

            return $data;
        }

        function proceed_login(){
            // Include connection to the database
            $db = new Database();
            $connection = $db->getConnection();

            // validate email and password inputs
            $validated_email = $this->validate_input($_REQUEST['email'], 'EMAIL');
            $validated_password = $this->validate_input($_REQUEST['password'], 'PASSWORD'); 

            // Get records from the database based on the inputs (email and password)
            $query = "SELECT * FROM users WHERE email='{$validated_email}'";
            $result = mysqli_query($connection, $query);

            // redirect back to login if no result is fetched, otherwise redirect to homepage  
            if(mysqli_num_rows($result) == 0){
                $_SESSION["USER_NOT_FOUND"] = $this->errors["user"]["not-found"]; 
                $_SESSION["OLD_DATA"] = $_REQUEST['email']; 
                $connection->close();
                header("Location: ../../public/pages/login.php");
                exit;
            }
            
            $user = mysqli_fetch_assoc($result);
            $hashed_password = $user['password'];

            if(password_verify($validated_password, $hashed_password)){
                $_SESSION['userId'] = $user['user_id'];
                $connection->close();
                header("Location: ../../public/pages/home.php");
                exit;
            }else{
                $_SESSION["USER_NOT_FOUND"] = $this->errors["user"]["not-found"]; 
                $_SESSION["OLD_DATA"] = $_REQUEST['email']; 
                $connection->close();
                header("Location: ../../public/pages/login.php");
                exit;
            }
        }
    }

    // proceed to log in
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $login = new Login(); 
        $login->proceed_login();
    }



    


    

    