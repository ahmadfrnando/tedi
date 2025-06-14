<?php

require __DIR__ . '/../function.php';

session_start();

if (isset($_SESSION['login'])) {
    header('location: index.php');
    exit;
}

$data_pertanyaan = mysqli_query($conn, "SELECT user_id, persepsi0, persepsi1, persepsi2, persepsi3, persepsi4, persepsi5, persepsi6, persepsi7, persepsi8, persepsi9, total_penilaian, rata_rata_penilaian, tingkat_kepuasan FROM survey");

$pertanyaan = mysqli_query($conn, "SELECT * FROM pertanyaan");

if (!$data_pertanyaan) {
    die("Data tidak ditemukan.");
}

$data_pertanyaan = mysqli_fetch_all($data_pertanyaan, MYSQLI_ASSOC);
$nilai_deskripsi = [
    1 => 'Sangat Tidak Puas',
    2 => 'Tidak Puas',
    3 => 'Cukup Puas',
    4 => 'Puas',
    5 => 'Sangat Puas',
];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Survey</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body style="padding: 2rem;">
    <h1>Pertanyaan</h1>
    <?php foreach ($pertanyaan as $row) : ?>
        <div>
            <span><?= $row['no_urut']; ?></span>
            <span><?= $row['pertanyaan']; ?></span>
        </div>
    <?php endforeach; ?>
    <h1>Hasil Survey</h1>

    <table>
        <thead>
            <tr>
                <th rowspan="2">No.</th>
                <th rowspan="2">Nama</th>
                <th colspan="10">Pertanyaan</th>
                <th rowspan="2">Total Penilaian</th>
                <th rowspan="2">Rata - Rata Penilaian</th>
                <th rowspan="2">Tingkat Kepuasan</th>
            </tr>
            <tr>
                <?php for ($i = 1; $i <= 10; $i++) : ?>
                    <th><?= $i ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($data_pertanyaan as $row) :
                $nama_result = mysqli_query($conn, "SELECT username FROM user WHERE id = '" . $row['user_id'] . "'");
                $nama_row = mysqli_fetch_assoc($nama_result);
                $nama = $nama_row ? $nama_row['username'] : 'Unknown';


            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($nama); ?></td>
                    <?php for ($j = 0; $j <= 9; $j++) :
                        $angka = (int)$row["persepsi$j"];
                        $teks = $nilai_deskripsi[$angka] ?? 'Tidak Ada Nilai';
                    ?>
                        <td><?= htmlspecialchars($teks); ?></td>
                    <?php endfor; ?>
                    <td><?= htmlspecialchars($row['total_penilaian']); ?></td>
                    <td><?= htmlspecialchars($row['rata_rata_penilaian']); ?></td>
                    <td><?= htmlspecialchars($row['tingkat_kepuasan']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>