<?php
include("Upgrades.php");
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

//Check if logged in
if(isset($_COOKIE['logged_in_user']))
{
    $username = $_COOKIE["logged_in_user"];
    $check_login = $mysqli->query("SELECT id FROM capybaraClicker WHERE login='$username'");
    if ($_COOKIE["logged_in_user"] == NULL || $check_login->num_rows == 0)
    {
        header("Location: loginPage.php");
    }
} else {
    header("Location: loginPage.php");
}
//Logging out
if(isset($_POST['logout']))
{
    setcookie("logged_in_user", "", time() - (86400), "/" );
    header("Location: loginPage.php");
}

//Adding to counter
$capybara = $mysqli->query("SELECT capybara FROM capybaraClicker WHERE login='$username'");
$capybara_int = intval($capybara->fetch_array()[0]);
$upgrade = $mysqli->query("SELECT upgrade FROM capybaraClicker WHERE login='$username'");
$upgrade_int = intval($upgrade->fetch_array()[0]);
if(isset($_POST['count']))
{
    $capybara_int = $capybara_int + $upgrade_int + 1;
    $mysqli->query("UPDATE capybaraClicker SET capybara='$capybara_int' WHERE login='$username'");
}

//Unlocking upgrades

$cost = costCalc($upgrade_int);
if(isset($_POST['upg']))
{
    if($capybara_int>=$cost) {
        if($upgrade_int < 12)
        {
            $upgrade_int += 1;
            $mysqli->query("UPDATE capybaraClicker SET upgrade='$upgrade_int' WHERE login='$username'");

        } else {
            $upgrade_int += 5;
            $mysqli->query("UPDATE capybaraClicker SET upgrade='$upgrade_int' WHERE login='$username'");
        }
        $capybara_int -= $cost;
    } else {
        echo "<script>alert('Not enough Capybaras!')</script>";
    }
    $mysqli->query("UPDATE capybaraClicker SET capybara='$capybara_int' WHERE login='$username'");
    $cost = costCalc($upgrade_int);
}

//functions
function costCalc($upgrade_int)
{
    switch($upgrade_int)
    {
        case 0: $cost = 10;break;
        case 1: $cost = 35;break;
        case 2: $cost = 90;break;
        case 3: $cost = 115;break;
        case 4: $cost = 250;break;
        case 5: $cost = 600;break;
        case 6: $cost = 1250;break;
        case 7: $cost = 2600;break;
        case 8: $cost = 7000;break;
        case 9: $cost = 20000;break;
        case 10: $cost = 50000;break;
        case 11: $cost = 120000;break;
        default: $cost = 500000;break;
    }
    return $cost;
}

?>
<!--Graphic Design is my passion-->
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="utf-8">
    <title>CapyClick</title>
    <link href="CapySheet.css" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        Capybara Clicker
    </header>
    <div class="main">
        <div class="hello">
            <?php
            echo "<form method='post' id='hello'>Hello " . $_COOKIE["logged_in_user"] . "!&emsp;&emsp;&emsp;";
            //Counter
            echo "<input type='submit' value='Log out :(' name='logout'></form>";
            ?>
        </div>
        <div class="counter">
            Current Capybara count: <?php echo $capybara_int; ?><br>
            Capybaras per click: <?php echo $upgrade_int + 1; ?><br>
        </div>
        <div class="clicker">
            <form method="post" id="clicker">
                <?php
                if($upgrade_int >= 12)
                {
                    $rand = rand(0, 11);
                } else {$rand = rand(0, $upgrade_int);}
                $image = 'url("capy' . $rand . '.jpg")';
                $style = "<input type='submit' name='count' value='' style='background: " . $image . "; background-size: 100% 100%'>";">";
                echo $style;
                ?>
            </form>
        </div>
        <div class="upgrades">
            <form method="post" id="upgrades">
                <?php
                $showUpgrades = new Upgrades($upgrade_int, $cost);
                ?>
            </form>
        </div>
    </div>
    <footer>
        Copyright &copy; 2024 Maciej Zaremba; Wszystkie prawa zastrzeżone.
    </footer>
</body>
</html>