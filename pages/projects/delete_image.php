<?php
require("../../db/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $img_id = $_POST['img_id'];
    $img_url = $_POST['img_url'];

    $file_path = "../../uploads/" . $img_url;
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    $sql = "DELETE FROM Images WHERE id = :id";
    $stm = $pdo->prepare($sql);

    if ($stm->execute([':id' => $img_id])) {
        echo "success";
    } else {
        echo "Database error";
    }
}
