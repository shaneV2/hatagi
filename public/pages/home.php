<?php session_start();?>
<?php 
    if(!isset($_SESSION['userId'])){ 
        header("Location: ./login.php"); 
        exit;
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Outfit:wght@100..900&family=Passion+One:wght@400;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../src/css/main.css">
    <link rel="stylesheet" href="../src/css/homepage.css">
</head>
<body>
    <div class="modal">
        <div class="modal-section">
            <header>
                <h2>Share Idea</h2>
                <button class="close-btn" onclick="closeCreatePost()">X</button>
            </header>
            <div>
                <form action="./queries.php?action=create-post" method="post">
                    <input type="text" class="post-description" placeholder="Description" name="description" required>
                    <textarea 
                        name="post-list" id="post-idea"
                        placeholder="Create a list, separated by commas (,)"
                    ></textarea>
                    <input type="submit" name="submit" id="submit-btn" value="Post">
                </form>
            </div>
        </div>
    </div>
    <main>
        <!-- Edit modal -->
        <div class="modal">
            <div class="modal-section">
            </div>
        </div>
        <div class="navigation-bar">
            <header>
                <p class="appname" style="font-weight: 600; letter-spacing: 1.2px;">HATAGI<span style="color: #00BFA6">.</span></p>
                <nav>
                    <div class="add-idea-icon">
                        <button onclick="viewCreatePost()">
                            <img src="../src/assets/bulb.svg" style="" width="34" height="30" alt="">
                        </button>
                    </div>
                    <!-- <div><img src="../src/assets/follow.svg" width="23" height="23" alt=""></div>
                    <div><img src="../src/assets/notification.svg" width="23" height="23" alt=""></div> -->
                </nav>
                <div>
                    <!-- <img src="../src/assets/logout.svg" width="23" height="23" alt=""> -->
                    <p><a href="./queries.php?action=logout" style="text-decoration: none; color: white;">logout</a></p>
                </div>
            </header>
        </div>
        <div class="content"></div>
    </main>
    <script src="../src/js/create-post.js"></script>
    <script src="../src/js/edit-post.js"></script>
    <script src="../src/js/get-post.js"></script>
</body>
</html>