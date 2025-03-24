<?php
    session_start();
    if(!isset($_SESSION['userId'])){ 
        header("Location: ./login.php"); 
        exit;
    }

    require '../../database/Post.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $action = $_GET['action'];
        $post = new Post();
        $comment = new Comment();
        
        switch ($action){
            // Post
            case 'create-post':
                $post->createPost();
                header("Location: ./home.php");
                exit;

            case 'save-post':
                $post_id = $_GET['post_id'] ?? null;
                $post->saveEditedPost();
                header("Location: ./home.php");
                exit;

            // Comment
            case 'create-comment':
                if(!empty($_POST['comment_text'])){
                    $comment->createComment();
                    header("Location: ./home.php");
                }else{
                    header("Location: ./home.php");
                }
                exit;

            default:
                throw new Exception("No such action.");
        }
            
    }else if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        $action = $_GET['action'];
        $post_id = $_GET['post_id'] ?? null;
        $post = new Post();
        $comment = new Comment();
        
        switch ($action){
            case 'get-post':
                $post->getPost();
                exit;

            case 'edit-post':
                $post->editPost($post_id);
                exit;

            case 'delete-post':
                $post->deletePost();
                header("Location: ./home.php");
                exit;
            
            // Comment
            case 'add-comment-to-post':
                $post_id = $_GET['post_id'] ?? null;
                $comment_text = $_GET['comment_text'];
                $comment->addCommentToPost($post_id, $comment_text);
                header("Location: ./home.php");
                exit;

            case 'get-comments':
                return $comment->getComments($_GET['post_id'], $_GET['u_id']);

            case 'delete-comment-from-post':
                $comment_id = $_GET['comment_id'] ?? null;
                $comment->deleteCommentFromPost($comment_id);
                header("Location: ./home.php");
                exit;
                
            // Logout
            case 'logout':
                session_unset();
                session_destroy();
                header("Location: ./login.php");
                exit;

            default:
                throw new Exception("No such action.");
    }
}