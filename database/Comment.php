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

        public function getComments(int $post_id){
            $connection = $this->getConnection();
            $user_id = $_SESSION['userId'];
            
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
                    <div class="comment" comment-id="'. $row['comment_id'] .'">
                        <p>'. $row['comment_text'] .'</p>
                            <div>
                                <button class="add-btn">
                                    <img src="../src/assets/add.svg" width="100%" height="100%" alt="">
                                </button>
                                <button class="delete-btn">
                                    <img src="../src/assets/delete.svg" width="100%" height="100%" alt="">
                                </button>
                            </div>
                    </div>';
                }
            }else{
                echo "<div style='height: 92%; display: flex; justify-content: center; align-items: center;'><p style='color: gray;'>No suggestions from users yet</p></div>";
            }
        }
    }
