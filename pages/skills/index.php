<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills</title>
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/display.css">
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



$sql = "SELECT * FROM Skills";
$stm = $pdo->prepare($sql);
$stm->execute();
$skills = $stm->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['delete'])) {
    $skill_id = $_POST['id'];


    $sql = "DELETE FROM Skills WHERE id=:id";
    $stm = $pdo->prepare($sql);
    $stm->execute([
        ':id' => $skill_id
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


            <a href="add.php">add</a>
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
            <div class="cards_container">
                <?php foreach ($skills as $skill): ?>
                <div class="card">

                    <div class="svg_container">
                        <?=$skill['svg']?>
                    </div>
                    <h2>
                        <?= $skill['name'] ?>
                    </h2>
                    <p>

                        <?= $skill['id'] ?>
                    </p>
                    <p>

                        <?= $skill['created_at'] ?>
                    </p>
                    <a href="edit.php?id=<?= $skill['id'] ?>" class="edit_btn">Edit</a>
                    <form action="" method="post">

                        <input type="hidden" name="id" value="<?= $skill['id'] ?>">
                        <button class="delete_btn" type="submit" name="delete">Delete</button>
                    </form>

                </div>
                <?php endforeach ?>
            </div>
        </section>


    </main>


</body>

</html>
