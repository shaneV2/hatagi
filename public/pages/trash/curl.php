<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $action = $_GET['action'];
        $ch;
    
        switch ($action){
            case 'create-post':
                $ch = curl_init('http://localhost/hatagi3/database/create_post.php');
                break;
            
            case 'delete-post':
                $ch = curl_init('http://localhost/hatagi3/database/delete_post.php');
                break;
    
            default:
                throw new Exception("No such action.");
        }
    
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
        
        curl_exec($ch);
    
        if (curl_error($ch)){
            die("cURL error: " . curl_error($ch));
        }
    
        curl_close($ch);
        return;
    }