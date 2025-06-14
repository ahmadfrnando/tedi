<?php
$host = 'localhost:3307';
$username = 'root';
$password = 'root';
$database = 'tedi_kuisioner';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function query($sql) {
    global $conn;
    $result = mysqli_query($conn, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
?>