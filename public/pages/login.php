<?php session_start();?>

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
    <link rel="stylesheet" href="../src/css/loginpage.css">
</head>
<body>
    <main>
        <div class="login-section">
            <header>
                <p>Welcome</p>
                <p>TO <span class="appname">HATAGI<span style="color: #00BFA6">.</span></span></p>
            </header>
            <section>
                <div class="oauth-section">
                    <div class="oauth-button"><img src="../src/assets/fbsvg.svg" alt=""></div>
                    <div class="oauth-button">2</div>
                    <div class="oauth-button">3</div>
                </div>    
                <p>or</p>
                <form action="../../security/validation/Login.php" method="post">
                    <div class="input-fields">
                        <!-- ERRORS: Email, User-not found -->
                        <p style="<?php echo isset($_SESSION['USER_NOT_FOUND']) ? 
                            'display: block; color: red;' : 
                            'display: none;'?> text-align: left;"><?= ucfirst(strtolower($_SESSION['USER_NOT_FOUND']))?><?php unset($_SESSION['USER_NOT_FOUND'])?>
                        </p>
                        <p style="<?php echo isset($_SESSION['EMAIL_ERROR']) ? 
                            'display: block; color: white;' : 
                            'display: none;'?> text-align: left;"><?= ucfirst(strtolower($_SESSION['EMAIL_ERROR']))?>
                        </p>
                        <!-- EMAIL INPUT FIELD -->
                        <input 
                            type="email" 
                            placeholder="Email" 
                            name="email"
                            value="admin6@gmail.com"
                            autofocus
                            <?php 
                                if(isset($_SESSION['OLD_DATA'])){ 
                                    echo "value='" . $_SESSION['OLD_DATA'] . "'"; 
                                    unset($_SESSION['OLD_DATA']);
                                }
                            ?>
                            <?php 
                                if (isset($_SESSION['EMAIL_ERROR'])){
                                    unset($_SESSION['EMAIL_ERROR']); 
                                    echo "class='input-error'";
                                    echo "autofocus";
                                }else {
                                    echo "class='input-no-error'";
                                } 
                            ?>
                        >
                        <!-- PASSWORD ERROR -->
                        <p style="<?php echo isset($_SESSION['PASSWORD_ERROR']) ? 
                                'display: block; color: white;' : 
                                'display: none;'?> text-align: left;"><?= ucfirst(strtolower($_SESSION['PASSWORD_ERROR']))?>
                        </p>
                        <!-- PASSWORD INPUT FIELD -->
                        <input 
                            type="password" 
                            placeholder="Password" 
                            name="password"
                            value="123"
                            <?php 
                                if (isset($_SESSION['PASSWORD_ERROR'])){
                                    unset($_SESSION['PASSWORD_ERROR']); 
                                    echo "class='input-error'";
                                    echo "autofocus";
                                }else {
                                    echo "class='input-no-error'";
                                } 
                            ?>
                        >
                    </div>
                    <div><input class="login-btn" type="submit" value="login"></div>
                </form>
            </section>
            <p>No registered account? <a href="./signup.php" style="color: #00BFA6">sign up</a></p>
        </div>
    </main>
</body>
</html>