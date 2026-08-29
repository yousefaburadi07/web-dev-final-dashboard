
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Skill</title>
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

$page_title = "Skills";



if (isset($_POST['add'])) {
    $name = trim($_POST['name']);
    $svg = trim($_POST['svg']);
    $sql = "INSERT INTO Skills (name, svg) VALUES (:name, :svg);";
    $stm = $pdo->prepare($sql);
    $stm->execute([
        ':name' => $name,
        ':svg' => $svg
    ]);
    header("Location: index.php");
    exit;
}

?>

<body>
    <?php
    include('../../components/header.php');
    include('../../components/aside.php');
    ?>

    <main>

        <section>

            <form method="post" action="">
                <div class="input_container">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" max="255" required>
                </div>
                <div class="input_container">
                    <label for="svg">SVG:</label>
                    <textarea name="svg" id="svg" required></textarea>
                </div>
                <button type="submit" name="add">add</button>

            </form>
        </section>


    </main>


</body>

</html>
