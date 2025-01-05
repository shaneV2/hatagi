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
                <p><span>Signup<span style="color: #00BFA6">.</span></span></p>
            </header>
            <section>
                <form action="../../security/validation/Signup.php" method="post">
                    <div class="input-fields">
                        <!-- ERRORS: Username, Username already exists -->
                        <p style="<?php echo isset($_SESSION['USERNAME_TAKEN']) ? 
                            'display: block; color: red;' : 
                            'display: none;'?> text-align: left;">
                            Username taken.
                        </p>
                        <!-- USERNAME INPUT FIELD -->
                        <input 
                            type="text" 
                            placeholder="Username" 
                            name="username"
                            value="<?= isset($_SESSION['OLD_USERNAME']) ? $_SESSION['OLD_USERNAME'] : ''; ?>"
                            required
                            <?php 
                                if(isset($_SESSION['USERNAME_TAKEN'])){
                                    echo "class='input-error'";
                                    echo "autofocus";
                                    unset($_SESSION['USERNAME_TAKEN']);
                                }else{
                                    echo "class='input-no-error'";
                                }
                                
                                if(isset($_SESSION['OLD_USERNAME'])){
                                    unset($_SESSION['OLD_USERNAME']);
                                }
                            ?>
                        >
                        <p style="<?php echo isset($_SESSION['EMAIL_TAKEN']) ? 
                            'display: block; color: red;' : 
                            'display: none;'?> text-align: left;">
                            Email taken.
                        </p>
                        <!-- EMAIL INPUT FIELD -->
                        <input 
                            type="email" 
                            placeholder="Email" 
                            name="email"
                            class="input-no-error"
                            required
                            <?php 
                                if(isset($_SESSION['EMAIL_TAKEN'])){
                                    echo "class='input-error'";
                                    echo "autofocus";
                                    unset($_SESSION['EMAIL_TAKEN']);
                                }else{
                                    echo "class='input-no-error'";
                                }
                                
                                if(isset($_SESSION['OLD_EMAIL'])){
                                    echo "value='" . $_SESSION['OLD_EMAIL'] . "'";
                                    unset($_SESSION['OLD_EMAIL']);
                                }
                            ?>
                        >
                        <!-- ERROR: PASSWORD NOT MATCHED  -->
                        <p style="<?php echo isset($_SESSION['PASSWORD_UNMATCHED']) ? 
                            'display: block; color: red;' : 
                            'display: none;'?> text-align: left;"><?php unset($_SESSION['PASSWORD_UNMATCHED']);?>
                            Passwords don't match. Please try again.
                        </p>
                        <!-- PASSWORD INPUT FIELD -->
                        <input 
                            type="password" 
                            placeholder="Password" 
                            name="password"
                            class="input-no-error"
                            required
                            <?php if(isset($_SESSION['PASSWORD_UNMATCHED'])){
                                echo "autofocus";
                                unset($_SESSION['PASSWORD_UNMATCHED']);
                            }?>
                        >
                        <!-- RE-PASSWORD INPUT FIELD -->
                        <input 
                            type="password" 
                            placeholder="Re-Password" 
                            name="re-password"
                            class="input-no-error"
                            required
                        >
                    </div>
                    <div><input class="login-btn" type="submit" value="register"></div>
                </form>
            </section>
            <p>Already have an account? <a href="./login.php" style="color: #00BFA6">login</a></p>
        </div>
    </main>
</body>
</html>