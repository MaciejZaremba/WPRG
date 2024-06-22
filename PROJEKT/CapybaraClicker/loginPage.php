<?php
setcookie("logged_in_user", "", time() - (86400), "/" );
//Database Setup
$dbhost = "localhost";
$dbuser = "s30282";
$dbpass = "Mac.Zare";
try {
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass);
    $mysqli->query("CREATE DATABASE IF NOT EXISTS capybara");
    $mysqli->query("USE capybara");
    $mysqli->query("CREATE TABLE IF NOT EXISTS capybaraClicker(
        id INT NOT NULL AUTO_INCREMENT,
        login VARCHAR(30) NOT NULL UNIQUE,
        password VARCHAR(30) NOT NULL,
        capybara INT NOT NULL DEFAULT 0,
        upgrade INT NOT NULL DEFAULT 0,
        PRIMARY KEY (id)
    )");
} catch(Exception $e) {echo "Error: " . $e->getMessage();}
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="utf-8">
    <title>CapyLogIn</title>
    <link href="loginSheet.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    Welcome to Capybara Clicker!
</header>
<div class="main">
    <div class="filler"><!--Empty Space--></div>
    <form method="post">
        <p>Please log in or register an account!</p>
        <label for="username">Login:</label>
        <input type="text" name="username" placeholder="Login">
        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Password">
        <div><!--Empty Space--></div>
        <input type="submit" value="Register" name="register">
        <input type="submit" value="Log in" name="login">
        <p>
            <?php
            //Registering
            if(isset($_POST['register']))
            {
                $username = $_POST['username'];
                $check_login = $mysqli->query("SELECT id FROM capybaraClicker WHERE login = '$username'");
                if($check_login->num_rows == 0)
                {
                    $password = $_POST['password'];
                    $mysqli->query("INSERT INTO capybaraClicker (login, password) VALUES ('$username', '$password')");
                    echo "Registered successfully!";
                }  else echo "Username already exists!";
            }
            //Logging in
            if(isset($_POST["login"]))
            {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $check_login = $mysqli->query("SELECT id FROM capybaraClicker WHERE login='$username' AND password='$password'");
                if($check_login->num_rows > 0)
                {
                    setcookie("logged_in_user", $username, time() + (86400), "/" );
                    header('Location: index.php');
                } else {
                    echo "Error: Wrong username or password.";
                }
            }
            ?>
        </p>
    </form>
    <div class="filler"><!--Empty Space--></div>
</div>
<footer>
    Copyright &copy; 2024 Maciej Zaremba; Wszystkie prawa zastrzeżone.
</footer>