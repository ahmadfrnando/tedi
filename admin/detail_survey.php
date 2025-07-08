<?php
session_start();

// set session login
if (isset($_SESSION['login'])) {
    header('location: login.php');
    exit;
}

require '../function.php';

$userId = intval($_GET['user_id']); // amankan
$data_pertanyaan = mysqli_query($conn, "SELECT user_id, persepsi0, persepsi1, persepsi2, persepsi3, persepsi4, persepsi5, persepsi6, persepsi7, persepsi8, persepsi9, total_penilaian, rata_rata_penilaian, tingkat_kepuasan FROM survey WHERE user_id = $userId LIMIT 1");
$data_pertanyaan = mysqli_fetch_assoc($data_pertanyaan);

if (!$data_pertanyaan) {
    die("Data tidak ditemukan.");
}

$data_kategori = mysqli_query($conn, "SELECT * FROM ref_kategori");
$data_kategori = mysqli_fetch_all($data_kategori, MYSQLI_ASSOC);

$rata_rata = $data_pertanyaan['rata_rata_penilaian'];
$total = $data_pertanyaan['total_penilaian'];
$tingkat = $data_pertanyaan['tingkat_kepuasan'];



$data_pertanyaan = [
    0 => (float)($data_pertanyaan['persepsi0'] + $data_pertanyaan['persepsi1']) / 2,
    1 => (float)($data_pertanyaan['persepsi2'] + $data_pertanyaan['persepsi3']) / 2,
    2 => (float)($data_pertanyaan['persepsi4'] + $data_pertanyaan['persepsi5']) / 2,
    3 => (float)($data_pertanyaan['persepsi6'] + $data_pertanyaan['persepsi7']) / 2,
    4 => (float)($data_pertanyaan['persepsi8'] + $data_pertanyaan['persepsi9']) / 2,
];

$jenis = [];
for ($i=0; $i < 5; $i++) { 
    if($data_pertanyaan[$i] < 5){
        $jenis[] = $data_kategori[$i]['kategori'];
    }
}
// var_dump($jenis); exit;

$labels = [];
$data = [];

for ($i = 0; $i < 5; $i++) {
    $labels[] = $data_kategori[$i]['kategori_en'];
    $data[] = $data_pertanyaan[$i];
}
// var_dump($labels); exit;

$nama = mysqli_fetch_assoc(mysqli_query($conn, "SELECT username FROM user WHERE id = $userId"));
$nomor = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nomor FROM user WHERE id = $userId"));


// Tentukan tingkat kepuasan
if ($rata_rata >= 4.5) {
    $warna = "success";
} elseif ($rata_rata >= 3.5) {
    $warna = "primary";
} elseif ($rata_rata >= 2.5) {
    $warna = "warning";
} elseif ($rata_rata >= 1.5) {
    $warna = "danger";
} else {
    $warna = "dark";
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
    <!-- ==========================================
                  Breakpoint
    =========================================== -->
    <link rel="stylesheet" href="../css/breakpoint.css" />

    <title>Dashboard</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            height: 400px;
            margin: 30px 0;
        }

        .hasil-card {
            max-width: 800px;
            margin: 30px auto;
        }

        .progress {
            height: 25px;
        }

        /* Container Card */
        .hasil-card {
            max-width: 800px;
            margin: 30px auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            /* background: #fff; */
            /* background-color: var(--bs-color); */
            /* background-color: #333; */
            background-color: #1f1f1f;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Header Card */
        .hasil-card .card-header {
            /* background-color: #4A90E2; */
            /* background-color: var(--main-color); */
            background-color: #00C2CB;
            color: #333;
            padding: 20px;
            text-align: center;
        }

        .hasil-card .card-header h3 {
            margin: 0;
            font-size: 1.5rem;
        }

        /* Body Card */
        .hasil-card .card-body {
            padding: 20px;
        }

        /* Info Box */
        .hasil-card .card-body .info-box,
        {
        flex: 1;
        margin: 10px;
        text-align: center;
        background: var(--bg-color);
        border-radius: 10px;
        padding: 20px;
        }

        .info-box h5 {
            margin-bottom: 10px;
            background: var(--bs-color);
            color: #fff;
        }

        .info-box h2 {
            font-size: 2rem;
            margin: 0;
        }

        /* Row */
        .flex-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        /* Chart container */
        .chart-container {
            margin-top: 30px;
            height: 400px;
        }

        /* Kepuasan Warna */
        .text-success {
            color: #45d178;
        }

        .text-primary {
            color: #007bff;
        }

        .text-warning {
            color: #ffc107;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-dark {
            color: #343a40;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .flex-row {
                flex-direction: column;
                gap: 20px;
            }
        }

        .btn-back.kembali {
            background-color: #00c2cb;
            /* warna toska soft */
            color: #fff;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 194, 203, 0.5);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            display: inline-block;
            margin: 20px 0;
            text-align: center;
            user-select: none;
        }

        .btn-back.kembali:hover {
            background-color: #009ea4;
            box-shadow: 0 6px 20px rgba(0, 158, 164, 0.7);
        }

        .btn-back.kembali:active {
            background-color: #007a7f;
            box-shadow: none;
            transform: translateY(2px);
        }
    </style>
</head>

<body>
    <!-- ==========================================
                    Header
    =========================================== -->
    <header class="header">
        <a href="#" class="logo">PUSTU<span> Medan Sinembah</span></a>

        <i class="bx bx-menu" id="menu-icon"></i>

        <nav class="navbar">
            <a href="/admin" class="active">Admin</a>
            <a href="logout.php">Log Out</a>
        </nav>
    </header>

    <section>
        <div class="survey-container">
            <button class="btn btn-back kembali" onclick="backToDashboard()">Kembali</button>
            <div class="card shadow hasil-card">
                <div class="card-header">
                    <h3 class="text-center">HASIL KUESIONER (<?= implode(' ', $nomor) . ' - ' . implode(' ', $nama); ?>)</h3>
                </div>
                <div class="card-body">
                    <div class="flex-row">
                        <div class="info-box">
                            <h5>Total Skor</h5>
                            <h2><?= $total ?></h2>
                            <p>dari <?= 10 * 5 ?> maksimal</p>
                        </div>
                        <div class="info-box">
                            <h5>Rata-rata</h5>
                            <h2><?= $rata_rata ?></h2>
                            <p>skala 1-5</p>
                        </div>
                        <div class="info-box">
                            <h5>Tingkat Kepuasan</h5>
                            <h2 class="text-<?= $warna ?>"><?= $tingkat ?></h2>
                        </div>
                    </div>

                    <div class="chart-container">
                        <canvas id="myChart"></canvas>
                    </div>
                    <div class="info-box">
                        <h5>Saran</h5>
                        <p>
                            <?php
                            if (is_array($jenis)) {
                                $jenis_count = count($jenis);
                                if ($jenis_count > 1) {
                                    $last = array_pop($jenis);
                                    $jenis_text = implode(', ', $jenis) . ' dan ' . $last;
                                } else {
                                    $jenis_text = $jenis[0];
                                }
                            } else {
                                $jenis_text = $jenis;
                            }
                            ?>
                            <?= $jenis_text; ?> lebih ditingkatkan.
                        </p>
                    </div>
                </div>
            </div>
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
    <script>
        function backToDashboard() {
            // Contoh redirect ke halaman detail, sesuaikan URL
            window.location.href = '/admin'
        }
        const data = <?php echo json_encode($data); ?>;
        const labels = <?php echo json_encode($labels); ?>;
        console.log(labels);
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, // "Pertanyaan 1", ..., "Pertanyaan 10"
                datasets: [{
                    label: 'Nilai per kategori',
                    data: data, // Nilai dari persepsi0 sampai persepsi9
                    backgroundColor: 'rgba(0,194,203,0.7)',
                    // backgroundColor: '#00fbff',
                    borderColor: 'rgba(0,194,203,0.7)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Nilai: ${context.raw.toFixed(2)}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>