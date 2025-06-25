<?php
require_once 'koneksi.php';

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: ../auth/login.php');
        exit;
    }
}
