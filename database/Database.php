<?php 
    class Database {
        function getConnection(){
            $server_name = "localhost";
            $username = "root";
            $password = "";
            $database = "hatagi_db"; 
        
            $connection = mysqli_connect($server_name, $username,$password, $database);
        
            if(!$connection) {
                die("Failed to connect database: " . mysqli_connect_error());
            }

            return $connection;       
        }
    }