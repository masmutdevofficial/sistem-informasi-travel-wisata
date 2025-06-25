<?php include 'session.php' ?>
<?php include 'function.php' ?>
<?php include 'init.php' ?>

<?php
$host     = "localhost";
$user     = "root";
$password = "";
$database = "db_travel";

$koneksi = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>