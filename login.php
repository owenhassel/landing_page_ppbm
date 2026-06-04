<!DOCTYPE html>
<html>
<head>
    <meta id_admin="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
</head>

<body class="w3-light-grey">

<?php
    include 'db.php';

    if (isset($_SESSION["login"])) {
        header("Location: list-user.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_admin = $_POST["id_admin"];
        $passcode = md5($_POST["passcode"]);
        
        $sql = "SELECT * FROM users WHERE userid='$id_admin' AND passcode='$passcode'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            session_start();
            $_SESSION["login"] = true;
            $_SESSION["id_admin"] = $id_admin;

            setcookie("userid_admin", $id_admin, time() + 3600, "/");
            header("Location: list-user.php");
            exit();
        } else {
            $error = "Invalid id_admin or passcode!";
        }
    }
?>

<div class="w3-card-4 w3-white w3-padding w3-margin-top"
    style="width:400px; margin:auto; border-radius:10px;">

    <form method="post" action="login.php">

        <h2>Login</h2>
        <p>Please, Register or Login to our site first !</p>

        <label for="id_admin">id_admin</label><br>
        <input class="w3-input w3-border"
            type="text"
            id="id_admin"
            name="id_admin"
            value="<?php
                if (isset($_COOKIE["userid_admin"])) {
                    echo $_COOKIE["userid_admin"];
                }
            ?>">
        <br>

        <label for="passcode">Passcode</label><br>
        <input class="w3-input w3-border"
            type="password"
            id="passcode"
            name="passcode">
        <br>

        <input type="submit"
            class="w3-button w3-green w3-margin-top"
            value="Login">

    </form>

    <?php
        if (isset($error)) {
    ?>
    <div class="w3-panel w3-pale-red w3-leftbar w3-border-red w3-margin-top">
        <p><?php echo $error; ?></p>
    </div>

    <?php
        }
    ?>

</div>

</body>
</html>