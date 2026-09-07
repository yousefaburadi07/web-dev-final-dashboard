<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: /final/pages/signin.php");
    exit;
} elseif ($_SESSION['is_admin'] == 0) {
    session_destroy();
    header("Location: /final/pages/signin.php");
    exit;
}
