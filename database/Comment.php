<?php 
    class Comment {
        private function getConnection(){
            $connection = (new Database())->getConnection();
            return $connection;
        }

        public function createComment(){
            $connection = $this->getConnection();

            $post_id = $_GET['post_id'];
            $userId = $_SESSION['userId'];
            $comment_text = $_POST['comment_text'];

            $query = "INSERT INTO `comments`(`post_id`, `user_id`, `comment_text`) VALUES(?,?,?)";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'iis', $post_id, $userId, $comment_text);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        public function deleteCommentFromPost(int $comment_id){
            $connection = $this->getConnection();
            
            $query = "DELETE FROM comments WHERE comment_id=?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'i', $comment_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        
        public function addCommentToPost(int $post_id, string $comment_text){
            $connection = $this->getConnection();

            $query = "
                UPDATE posts
                SET post_list = CONCAT(post_list, ?)
                WHERE post_id = ?;
                ";
            
            $comment_text_with_comma = ', ' . $comment_text;
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'si',$comment_text_with_comma, $post_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

        }

        public function getComments(int $post_id, int $user_id){
            $connection = $this->getConnection();
            
            // Get Comments
            $query = "
                    SELECT 
                        posts.*,
                        users.username,
                        comments.*
                    FROM
                        posts
                    INNER JOIN
                        users
                    ON
                        posts.user_id = users.user_id
                    INNER JOIN 
                        comments
                    ON 
                        comments.post_id = posts.post_id
                    WHERE
                        posts.post_id = ?
                    ORDER BY
                        posts.date_created DESC";

            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'i', $post_id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) != 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo '
                        <div class="suggestion">
                            <p>'. $row['comment_text'] .'</p>';
                            if($_SESSION['userId'] == $user_id){
                                echo '<div><a href="./queries.php?action=add-comment-to-post&post_id='. $row['post_id'] .'&comment_text='. $row['comment_text'] .'"><img src="../src/assets/add.svg" width="20" height="20" alt=""></a></div>';
                            }
                            if($_SESSION['userId'] == $row['user_id']){
                                echo '<div><a href="./queries.php?action=delete-comment-from-post&comment_id='. $row['comment_id'] .'"><img style="background-color: #770202;" src="../src/assets/delete.svg" width="20" height="20" alt=""></a></div>';
                            }
                    echo '</div>';
                }
            }else{
                echo "<div style='text-align: center; padding: 10px 0 20px; color:rgb(71, 69, 69)'></p>No suggestions from users yet.</p></div>";
            }
        }
    }
