<?php 
    session_start();
    require_once '../../database/Database.php';

    function checkIfInputExistsInDb(string $input, $connection, string $name){
        $query = '';
        if($name == 'username'){
            $query = "SELECT * FROM users WHERE username = ?";
        }else{
            $query = "SELECT * FROM users WHERE email = ?";
        }
                    
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 's', $input);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) > 0){
            return true;
        }else{
            return false;
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){   
        $connection = (new Database())->getConnection();

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING); 
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];
        $repassword = $_POST['re-password'];

        if(checkIfInputExistsInDb($username, $connection, 'username')){
            $_SESSION['OLD_USERNAME'] = $username;            
            $_SESSION['OLD_EMAIL'] = $email;           
            $_SESSION['USERNAME_TAKEN'] = true;
            header("Location: ../../public/pages/signup.php");
            exit;
        }
        
        if(checkIfInputExistsInDb($email, $connection, 'email')){
            $_SESSION['OLD_USERNAME'] = $username;            
            $_SESSION['EMAIL_TAKEN'] = true;            
            header("Location: ../../public/pages/signup.php");
            exit;
        }
        
        if ($password !== $repassword){
            $_SESSION['OLD_USERNAME'] = $username;            
            $_SESSION['OLD_EMAIL'] = $email;            
            $_SESSION['PASSWORD_UNMATCHED'] = true;            
            header("Location: ../../public/pages/signup.php");
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO `users`(`username`, `email`, `password`) VALUES(?,?,?)";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $hashed_password);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: ../../public/pages/login.php");
        exit;
    }