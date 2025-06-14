<?php

require __DIR__ . '/../function.php';

session_start();

if (isset($_SESSION['login'])) {
    header('location: index.php');
    exit;
}

// Ambil data pertanyaan dari database
$queryKategori = "SELECT * FROM ref_kategori";
$query = "SELECT pertanyaan, no_urut FROM pertanyaan";
$result = mysqli_query($conn, $query);
$resultKategori = mysqli_query($conn, $queryKategori);

$pertanyaan = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pertanyaan[$row['no_urut']] = $row['pertanyaan'];
    }
} else {
    // Kalau belum ada data, buat array kosong untuk 10 pertanyaan
    for ($i = 1; $i <= 10; $i++) {
        $pertanyaan[$i] = "";
    }
}

$kategori = [];
if (mysqli_num_rows($resultKategori) > 0) {
    while ($row = mysqli_fetch_assoc($resultKategori)) {
        $kategori[$row['id']] = $row['kategori'];
    }
} else {
    // Kalau belum ada data, buat array kosong untuk 10 pertanyaan
    for ($i = 1; $i <= 10; $i++) {
        $kategori[$i] = "";
    }
}

$kt = [
    1 => 1,
    2 => 1,
    3 => 2,
    4 => 2,
    5 => 3,
    6 => 3,
    7 => 4,
    8 => 4,
    9 => 5,
    10 => 5,
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    for ($i = 1; $i <= 10; $i++) {
        $q = mysqli_real_escape_string($conn, trim($_POST["pertanyaan$i"]));
        $sql = "INSERT INTO pertanyaan (no_urut, pertanyaan, id_kategori) VALUES ($i, '$q', $kt[$i])
                ON DUPLICATE KEY UPDATE pertanyaan = VALUES(pertanyaan), id_kategori = VALUES(id_kategori)";
        mysqli_query($conn, $sql);
        if (mysqli_error($conn)) {
            echo "Error: " . mysqli_error($conn);
            exit;
        }
    }
    mysqli_close($conn);
    header("Location: kelola_pertanyaan.php");
    exit();
}


?>


<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- ==========================================
                  Box Icons
    =========================================== -->
    <link
        href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet" />
    <!-- ==========================================
                  Custom CSS
    =========================================== -->
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/admin.css" />
    <!-- ==========================================
                  Breakpoint
    =========================================== -->
    <link rel="stylesheet" href="../css/breakpoint.css" />
    <title>Dashboard</title>
</head>

<body>
    <!-- ==========================================
                    Header
    =========================================== -->
    <header class="header">
        <a href="#" class="logo">PUSTU<span> Medan Sinembah</span></a>

        <i class="bx bx-menu" id="menu-icon"></i>

        <nav class="navbar">
            <a href="/admin">Admin</a>
            <a href="/pertanyaan" class="active">Kelola Pertanyaan</a>
            <a href="logout.php">Log Out</a>
        </nav>
    </header>

    <section>
        <div class="survey-container">
            <form method="post">
                <table class="form-table" style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <th style="padding: 10px;">No.</th>
                        <th style="padding: 10px;">Pertanyaan</th>
                    </tr>
                    <th colspan="2" style="text-align: left;"><?= $kategori[1]; ?></th>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?= "Pertanyaan Ke 1" ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <input type="text" value="<?= $pertanyaan[1]; ?>" name="pertanyaan1" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?= "Pertanyaan Ke 2" ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <input type="text" value="<?= $pertanyaan[2]; ?>" name="pertanyaan2" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                        </td>
                    </tr>
                    <th colspan="2" style="text-align: left;"><?= $kategori[2]; ?></th>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?= "Pertanyaan Ke 3" ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <input type="text" value="<?= $pertanyaan[3]; ?>" name="pertanyaan3" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?= "Pertanyaan Ke 4" ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <input type="text" value="<?= $pertanyaan[4]; ?>" name="pertanyaan4" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                        </td>
                    </tr>
                    <th colspan="2" style="text-align: left;"><?= $kategori[3]; ?></th>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?= "Pertanyaan Ke 5" ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <input type="text" value="<?= $pertanyaan[5]; ?>" name="pertanyaan5" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?= "Pertanyaan Ke 6" ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <input type="text" value="<?= $pertanyaan[6]; ?>" name="pertanyaan6" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                        </td>
                    </tr>
                    <th colspan="2" style="text-align: left;"><?= $kategori[4]; ?></th>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?= "Pertanyaan Ke 7" ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <input type="text" value="<?= $pertanyaan[7]; ?>" name="pertanyaan7" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?= "Pertanyaan Ke 8" ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <input type="text" value="<?= $pertanyaan[8]; ?>" name="pertanyaan8" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                        </td>
                    </tr>
                    <th colspan="2" style="text-align: left;"><?= $kategori[5]; ?></th>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?= "Pertanyaan Ke 9" ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <input type="text" value="<?= $pertanyaan[9]; ?>" name="pertanyaan9" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;"><?= "Pertanyaan Ke 10" ?></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            <input type="text" value="<?= $pertanyaan[10]; ?>" name="pertanyaan10" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center; padding: 20px;">
                            <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Simpan</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

    </section>

    <!-- ==========================================
                    Footer
    =========================================== -->
    <footer class="footer">
        <div class="footer-text">
            <p>Copyright &copy; 2024 by Callmerev | All Rights Reserved.</p>
        </div>

        <div class="footer-iconTop">
            <a href="#home"><i class="bx bx-up-arrow-alt"></i></a>
        </div>
    </footer>

    <!-- ==========================================
                  Scroll Reveal
    =========================================== -->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!-- ==========================================
                   Typed Js
    =========================================== -->
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>

    <!-- ==========================================
                  Custom Js
    =========================================== -->
    <script src="main.js"></script>
</body>

</html>