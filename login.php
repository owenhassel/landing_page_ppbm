<?php
    session_start();
    
    include 'db.php';

    if (isset($_SESSION["login"])) {
        header("Location: admin.php"); 
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_admin = mysqli_real_escape_string($conn, $_POST["id_admin"]);
        $passcode = md5($_POST["passcode"]);
        
        $sql = "SELECT * FROM users WHERE id_admin='$id_admin' AND passcode='$passcode'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            $_SESSION["login"] = true;
            $_SESSION["id_admin"] = $id_admin;

            header("Location: admin.php");
            exit();
        } else {
            $error = "ID Admin atau Passcode salah!";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
</head>

<body class="w3-light-grey">

<div class="w3-card-4 w3-white w3-padding w3-margin-top"
    style="width:400px; margin:auto; border-radius:10px;">

    <form method="post">

        <h2>Login Admin</h2>
        <p>Silakan masuk untuk mengakses Admin Panel PPBM.</p>

        <label for="id_admin">ID Admin</label><br>
        <input class="w3-input w3-border"
            type="text"
            id="id_admin"
            name="id_admin"
            required
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
            name="passcode"
            required>
        <br>

        <input type="submit"
            class="w3-button w3-red w3-margin-top"
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