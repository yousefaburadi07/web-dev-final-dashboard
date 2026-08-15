<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Porject</title>
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

$page_title = "Projects";

$sql = "SELECT * FROM Skills;";
$stm = $pdo->prepare($sql);
$stm->execute();
$skills = $stm->fetchAll(PDO::FETCH_ASSOC);


$sql = "SELECT * FROM Categories;";
$stm = $pdo->prepare($sql);
$stm->execute();
$categories = $stm->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['add'])) {
    $uuid_stm = $pdo->query("SELECT UUID()");
    $project_id = $uuid_stm->fetchColumn();

    $name = trim($_POST['name']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $link = trim($_POST['link']);
    $github = trim($_POST['github']);
    $category_id = $_POST['category'];

    $sql = "INSERT INTO Projects (id,name, title, description, link, github, category_id, is_public) VALUES (:id ,:name, :title,:description, :link, :github, :category_id, :is_public);";
    $stm = $pdo->prepare($sql);
    $stm->execute([
        ':id' => $project_id,
        ':name' => $name,
        ':title' => $title,
        ':description' => $description,
        ':link' => $link,
        ':github' => $github,
        ':category_id' => $category_id,
        ':is_public' => 1
    ]);

    $selected_skills = $_POST['skills'] ?? [];
    $sql = "INSERT INTO ProjectSkill (project_id,skill_id) VALUES (:project_id, :skill_id);";
    $stm = $pdo->prepare($sql);
    foreach ($selected_skills as $id):
        $stm->execute([
            ':project_id' => $project_id,
            ':skill_id' => $id,
        ]);
    endforeach;


    if (isset($_FILES['project_images'])) {
        $img_sql = "INSERT INTO Images (project_id, image_URL) VALUES (:project_id, :url);";
        $img_stm = $pdo->prepare($img_sql);

        $total_images = count($_FILES['project_images']['name']);

        for ($i = 0; $i < $total_images; $i++) {
            if ($_FILES['project_images']['error'][$i] === UPLOAD_ERR_OK) {

                $tmp_name = $_FILES['project_images']['tmp_name'][$i];
                $original_name = $_FILES['project_images']['name'][$i];

                $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
                $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                if (in_array($ext, $allowed_ext)) {
                    $new_filename = uniqid() . '_' . $i . '.' . $ext;

                    $destination = "../../uploads/" . $new_filename;

                    if (move_uploaded_file($tmp_name, $destination)) {
                        $img_stm->execute([
                            ':project_id' => $project_id,
                            ':url' => $new_filename
                        ]);
                    }
                }
            } else {
                echo $_FILES['project_images']['error'][$i];
            }
        }
    }
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

            <form method="post" action="" enctype="multipart/form-data">
                <div class="next">
                    <div class="input_container">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" maxlength="255" required>
                    </div>
                    <div class="input_container">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" maxlength="255" required>
                    </div>
                </div>
                <div class="input_container">
                    <label for="description">description:</label>
                    <textarea name="description" id="description"></textarea>
                </div>
                <div class="input_container">
                    <h3>skills</h3>
                    <div class="skills_container">
                        <?php foreach ($skills as $skill): ?>
                        <div>
                            <input type="checkbox" name="skills[]" value="<?= $skill['id'] ?>"
                                id="s-<?= $skill['id'] ?>">
                            <label for="s-<?= $skill['id'] ?>">
                                <?= $skill['name'] ?>
                            </label>

                        </div>

                        <?php endforeach ?>
                    </div>
                </div>

                <div class="next">
                    <div class="input_container">
                        <label for="link">Link:</label>
                        <input type="text" name="link" id="link" maxlength="255">
                    </div>
                    <div class="input_container">
                        <label for="github">Github:</label>
                        <input type="text" name="github" id="github" maxlength="255">
                    </div>
                </div>
                <div class="input_container">
                    <label for="category">Category:</label>
                    <select name="category" id="category">
                        <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>">
                            <?= $category['name'] ?>
                        </option>
                        <?php endforeach ?>

                    </select>
                </div>
                <div class="input_container">
                    <label for="images">Images:</label>
                    <input type="file" name="project_images[]" id="images" accept="image/*" multiple required>
                </div>
                <button type="submit" name="add">add</button>

            </form>
        </section>


    </main>


</body>

</html>
