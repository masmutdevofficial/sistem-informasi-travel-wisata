<?php
require '../config/koneksi.php';
// require '../config/auth.php';
// require_login();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?? 'ADMIN LTE' ?></title>

    <!-- REQUIRED CSS -->
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../assets/css/adminlte.min.css">

    <!-- CUSTOM CSS -->
    <!-- Custom style -->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <?php echo $customCss ?? '' ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include 'admin_navbar.php' ?>
        <?php include 'admin_sidebar.php' ?>