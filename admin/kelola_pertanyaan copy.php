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
    while ($row = mysqli_fetch_assoc($resultKategroi)) {
        $kategori[$row['no_urut']] = $row['kategori'];
    }
} else {
    // Kalau belum ada data, buat array kosong untuk 10 pertanyaan
    for ($i = 1; $i <= 10; $i++) {
        $kategori[$i] = "";
    }
}

// Simpan data saat form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    for ($i = 1; $i <= 10; $i++) {
        $q = mysqli_real_escape_string($conn, trim($_POST["pertanyaan$i"]));
        $sql = "INSERT INTO pertanyaan (no_urut, pertanyaan) VALUES ($i, '$q')
                ON DUPLICATE KEY UPDATE pertanyaan = VALUES(pertanyaan)";
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
                    <?php for ($s = 1; $s <= 5; $s + 2): ?>
                        <th><?= $s . $kategori[$s]; ?></th>
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <tr>
                                <td style="padding: 10px; border: 1px solid #ddd;"><?= "Pertanyaan Ke $i"; ?></td>
                                <td style="padding: 10px; border: 1px solid #ddd;">
                                    <input type="text" name="pertanyaan<?= $i; ?>" value="<?= $pertanyaan[$i]; ?>" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                                    <input type="number" name="no_urut<?= $i; ?>" hidden readonly value="<?= $i; ?>">
                                </td>
                            </tr>
                        <?php endfor; ?>
                    <?php endfor; ?>
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