<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
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

$page_title = "Projects";



$sql = "SELECT * FROM Projects";
$stm = $pdo->prepare($sql);
$stm->execute();
$projects = $stm->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['delete'])) {
    $project_id = $_POST['id'];


    $sql = "DELETE FROM Projects WHERE id=:id";
    $stm = $pdo->prepare($sql);
    $stm->execute([
        ':id' => $project_id
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
                <?php foreach ($projects as $project):
                    $sql = "SELECT * FROM Images WHERE project_id = :project_id;";
                    $stm = $pdo->prepare($sql);
                    $stm->execute([
                        ':project_id' => $project['id']
                    ]);
                    $imgs = $stm->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <div class="card">

                    <div class="image_container">
                        <img style="width: 100%;" src="../../uploads/<?= $imgs[0]['image_URL'] ?>"
                            alt="<?= $project['name'] ?>">
                    </div>

                    <h2>
                        <?= $project['name'] ?>
                    </h2>
                    <p>

                        <?= $project['id'] ?>
                    </p>
                    <p>

                        <?= $project['created_at'] ?>
                    </p>
                    <a href="edit.php?id=<?= $project['id'] ?>" class="edit_btn">Edit</a>
                    <form action="" method="post">

                        <input type="hidden" name="id" value="<?= $project['id'] ?>">
                        <button class="delete_btn" type="submit" name="delete">Delete</button>
                    </form>

                </div>
                <?php endforeach ?>
            </div>
        </section>


    </main>


</body>

</html>
