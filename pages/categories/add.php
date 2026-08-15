<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/add.css">
    <link rel="stylesheet" href="../../styles/header.css">
    <link rel="stylesheet" href="../../styles/layout.css">
</head>

<?php
require("../../db/db.php");
require("../../signin_check.php");

if (isset($_POST['signout'])) {
    session_destroy();
    header("Location: /final");
    exit;
}

$page_title = "Categories";



if (isset($_POST['add'])) {
    $name = trim($_POST['name']);
    $sql = "INSERT INTO Categories (name) VALUES (:name);";
    $stm = $pdo->prepare($sql);
    $stm->execute([
        ':name' => $name
    ]);
    header("Location: index.php");
    exit;
}

?>

<body>
    <header>
        <section class="logo">
            <h1>Dashborad</h1>
        </section>

        <section class="header_body">
            <h1>
                <?= $page_title ?>
            </h1>
        </section>
    </header>

    <aside>
        <nav>
            <a href="../projects/" class="side_btn">projects</a>
            <a href="../categories/" class="side_btn">categories</a>
            <a href="../skills/" class="side_btn">skills</a>
        </nav>

        <form method="post" action="">
            <button type="submit" name="signout" class="side_btn" id="sign_out">Sign out</button>
        </form>
    </aside>

    <main>

        <section>

            <form method="post" action="">
                <div class="input_container">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" max="255" required>
                </div>
                <button type="submit" name="add">add</button>

            </form>
        </section>


    </main>


</body>

</html>
