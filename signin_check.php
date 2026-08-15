<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /final/pages/signin.php");
    exit;
}
