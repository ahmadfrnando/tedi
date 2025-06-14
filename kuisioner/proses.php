<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jawaban = $_POST['jawaban'];
    $total = 0;
    
    foreach ($jawaban as $id_pertanyaan => $nilai) {
        $sql = "INSERT INTO jawaban (id_pertanyaan, nilai) VALUES ($id_pertanyaan, $nilai)";
        mysqli_query($conn, $sql);
        $total += $nilai;
    }
    
    $jumlah_pertanyaan = count($jawaban);
    $rata_rata = $total / $jumlah_pertanyaan;
    
    header("Location: hasil.php?total=$total&rata=$rata_rata");
    exit;
} else {
    header("Location: index.php");
    exit;
}
?>