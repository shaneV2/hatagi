<?php
    require '../../database/Database.php';
    require '../../database/Comment.php';

    class Post {

        public function getDbConnection(){
            return (new Database())->getConnection();
        }

        public function createPost(){
            $connection = $this->getDbConnection();

            $userId = $_SESSION['userId'];
            $post_description = $_POST['description'];
            $post_list = $_POST['post-list'];

            $query = "INSERT INTO `posts`(`user_id`, `post_description`, `post_list`) VALUES(?,?,?)";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'iss', $userId, $post_description, $post_list);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        public function deletePost(){
            $connection = $this->getDbConnection();
            
            $post_id = $_GET['post_id'];
            
            $query = "DELETE FROM posts WHERE post_id=?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'i', $post_id);
            mysqli_stmt_execute($stmt);

            $delete_comments_query = "DELETE FROM comments WHERE post_id=?";
            $stmt2 = mysqli_prepare($connection, $delete_comments_query);
            mysqli_stmt_bind_param($stmt2, 'i', $post_id);
            mysqli_stmt_execute($stmt2);

            mysqli_stmt_close($stmt);
            mysqli_stmt_close($stmt2);
        }
        
        public function saveEditedPost(){
            $post_id = $_GET['post_id'];
            $post_description = $_POST['description'];
            $post_list = $_POST['post-list'];
            $connection = $this->getDbConnection();

            $query = "
                UPDATE posts 
                SET post_description =?, post_list =?
                WHERE post_id =?;
            ";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'ssi', $post_description, $post_list, $post_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

        }
        
        public function editPost(int $post_id){
            $connection = $this->getDbConnection();

            $query = "SELECT * FROM posts WHERE post_id=?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'i', $post_id);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            echo '<header>
                    <h2>Edit Idea</h2>
                    <button class="close-btn" onclick="closeEditPost()">X</button>
                </header>
                <div>
                    <form action="./queries.php?action=save-post&post_id='. $row['post_id'] .'" method="post">
                        <input 
                            type="text" 
                            class="post-description" 
                            placeholder="Description" 
                            name="description"
                            value="'. $row['post_description'] .'"    
                        >
                        <textarea 
                            name="post-list" id="post-idea"
                            placeholder="Create a list, separated by commas (,)"
                        >'. $row['post_list'] .'</textarea>
                        <input type="submit" name="submit" id="submit-btn" value="Save Edit">
                    </form>
                </div>';
        }

        public function getPost(){
            $connection = $this->getDbConnection();

            $userId = $_SESSION['userId'];

            // Get post
            $get_post_query = "
                    SELECT 
                        posts.*,
                        users.username 
                    FROM
                        posts
                    INNER JOIN
                        users
                    ON
                        posts.user_id = users.user_id
                    
                    ORDER BY
                        posts.date_created DESC";
                        
            $stmt = mysqli_prepare($connection, $get_post_query);
            // mysqli_stmt_bind_param($stmt,);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $comment = new Comment();

            while ($row = mysqli_fetch_assoc($result)){
                echo "<div class='post' post-id='". $row['post_id'] ."'>";
                echo '<section class="post-section">
                        <div class="profile-section">
                            <div class="profile">
                                <div class="picture">
                                    <img src="../src/assets/person.svg" alt=""> 
                                </div>
                                <div class="person-info">
                                    <p>@'. htmlspecialchars($row['username']) .'</p>
                                    <p class="person-title">#tester</p>
                                </div>
                            </div>'; 
                                if($_SESSION['userId'] == $row['user_id']){
                                    echo '
                                        <div class="post-options">
                                            <div><button onclick="viewEditPost('. $row['post_id'] .')"><img class="edit-post-icon" src="../src/assets/edit.svg" width="20" height="20" alt=""></button></div>
                                            <div><a href="./queries.php?action=delete-post&post_id='. $row['post_id'] .'"><img class="delete-post-icon" src="../src/assets/delete.svg" width="20" height="20" alt=""></a></div>
                                        </div>';
                                }
                            
                        echo '</div>
                        <div class="idea-section">
                            <p><span>Description</span>: <p class="description-text">'. htmlspecialchars($row['post_description']) .'</p></p>
                            <p><span>--List--</span></p>
                            <div class="ideas-list">';

                            $list = explode(',',$row['post_list']);
                            
                            echo '<ul>';
                            $listed = 0;
                            foreach($list as $idea){
                                if(!empty($idea)){
                                    echo "<li>". htmlspecialchars($idea) ."</li>";
                                    $listed += 1;
                                }
                            }
                            if($listed == 0){
                                echo "<p style='text-align:center; color:rgb(128, 125, 125)'>No ideas/suggestions added. Pick from suggestions to add.</p>";
                            }
                            echo '</ul>';

                        echo '
                            </div>
                        </div>
                        <div class="engagement-section">
                            <div><button post-number="'. $row['post_id'] .'"><img src="../src/assets/bulb.svg" width="20" height="20" alt=""></button></div>
                        </div>
                        </section>
                    <div>';
            }
            mysqli_stmt_close($stmt);
        }
    }