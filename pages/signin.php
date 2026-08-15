<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signin</title>
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/sigin.css">
</head>

<?php
session_start();
require("../db/db.php");
$err_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];
    if (!empty(trim($input_username)) && !empty($input_password)) {
        $input_username = htmlspecialchars($input_username);
        $sql = "SELECT password, id, is_admin FROM Users WHERE username = :username;";
        $stm = $pdo->prepare($sql);
        $stm->execute([
            ':username' => $input_username
        ]);
        $user = $stm->fetch(PDO::FETCH_ASSOC);
        if (empty($user['id'])) {
            $err_msg = "user doesn't exist";
        } else {
            $right_pass = $user['password'];
            if (password_verify($input_password, $right_pass)) {
                if ($user['is_admin'] == 1) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $input_username;
                    $_SESSION['is_admin'] = $user['is_admin'];

                    header("Location: ../index.php");
                    exit;
                } else {
                    $err_msg =  "unauthorized";
                }
            } else {
                $err_msg =  "wrong pass";
            }
        }
    }
}


?>

<body class=".jetbrains-mono">

    <fieldset>
        <legend>signin</legend>
        <form method="POST" id="signin-form" action="signin.php">
            <label for="username">Username:</label>
            <input type="text" placeholder="username" name="username" id="username" required />

            <label for="password">Passwrod:</label>
            <input type="password" placeholder="password" name="password" id="password" required />

            <input type="submit" value="sign in" />
            <h2 id="error">
                <?= $err_msg ?>
            </h2>
        </form>
    </fieldset>

</body>

</html>
