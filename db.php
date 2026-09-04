<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "asrago_db1";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Sambungan Pangkalan Data Gagal: " . $conn->connect_error);
}
?>