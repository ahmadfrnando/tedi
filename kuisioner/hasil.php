<?php
require 'config.php';

// Data dari URL
$total = $_GET['total'] ?? 0;
$rata_rata = $_GET['rata'] ?? 0;

// Data untuk chart
$data_pertanyaan = query("SELECT p.id, p.text, AVG(j.nilai) as rata FROM pertanyaan p LEFT JOIN jawaban j ON p.id = j.id_pertanyaan GROUP BY p.id");

// Konversi data untuk Chart.js
$labels = [];
$data = [];
foreach ($data_pertanyaan as $p) {
    $labels[] = "'Pertanyaan " . $p['id'] . "'";
    $data[] = $p['rata'];
}

$labels_str = implode(", ", $labels);
$data_str = implode(", ", $data);

// Tentukan tingkat kepuasan
if ($rata_rata >= 4.5) {
    $tingkat = "Sangat Puas";
    $warna = "success";
} elseif ($rata_rata >= 3.5) {
    $tingkat = "Puas";
    $warna = "primary";
} elseif ($rata_rata >= 2.5) {
    $tingkat = "Cukup";
    $warna = "warning";
} elseif ($rata_rata >= 1.5) {
    $tingkat = "Kurang Puas";
    $warna = "danger";
} else {
    $tingkat = "Sangat Tidak Puas";
    $warna = "dark";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kuesioner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>

<body>
    <div class="container">
        <div class="card shadow hasil-card">
            <div class="card-header bg-primary text-white">
                <h3 class="text-center">HASIL KUESIONER</h3>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Total Skor</h5>
                                <h2><?= $total ?></h2>
                                <p>dari <?= count($data_pertanyaan) * 5 ?> maksimal</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Rata-rata</h5>
                                <h2><?= number_format($rata_rata, 2) ?></h2>
                                <p>skala 1-5</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Tingkat Kepuasan</h5>
                                <h2 class="text-<?= $warna ?>"><?= $tingkat ?></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="myChart"></canvas>
                </div>

                <h4 class="mt-5">Detail Jawaban:</h4>
                <?php foreach ($pertanyaan as $p): ?>

                    <div class="mb-3">
                        <h5>Pertanyaan <?= $p['id'] ?>: <?= $p['text'] ?></h5>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: <?= $persentase ?>%"
                                aria-valuenow="<?= $persentase ?>"
                                aria-valuemin="0"
                                aria-valuemax="100">
                                <?= number_format($p['rata'], 2) ?> (<?= number_format($persentase, 1) ?>%)
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <a href="index.php" class="btn btn-primary mt-3">Kembali ke Form</a>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?= $labels_str ?>],
                datasets: [{
                    label: 'Rata-rata Nilai per Pertanyaan',
                    data: [<?= $data_str ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
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
                                return `Rata-rata: ${context.raw.toFixed(2)}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>