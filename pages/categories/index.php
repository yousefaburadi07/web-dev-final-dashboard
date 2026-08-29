<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
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

$page_title = "Categories";



$sql = "SELECT * FROM Categories";
$stm = $pdo->prepare($sql);
$stm->execute();
$categories = $stm->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['delete'])) {
    $category_id = $_POST['id'];


    $sql = "DELETE FROM Categories WHERE id=:id";
    $stm = $pdo->prepare($sql);
    $stm->execute([
        ':id' => $category_id
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
            <div class="cards_container">
                <?php foreach ($categories as $category): ?>
                <div class="card">
                    <h2>
                        <?= $category['name'] ?>
                    </h2>
                    <p>

                        <?= $category['id'] ?>
                    </p>
                    <p>

                        <?= $category['created_at'] ?>
                    </p>
                    <a href="edit.php?id=<?= $category['id'] ?>" class="edit_btn">Edit</a>
                    <form action="" method="post">

                        <input type="hidden" name="id" value="<?= $category['id'] ?>">
                        <button class="delete_btn" type="submit" name="delete">Delete</button>
                    </form>

                </div>
                <?php endforeach ?>
            </div>
        </section>


    </main>


</body>

</html>
