<?php 
require 'config.php';
$pertanyaan = query("SELECT * FROM pertanyaan");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kuesioner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .question-card {
            margin-bottom: 20px;
            border-left: 4px solid #0d6efd;
        }
        .form-container {
            max-width: 800px;
            margin: 30px auto;
        }
    </style>
</head>
<body>
    <div class="container form-container">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="text-center">FORM KUESIONER KEPUASAN PELANGGAN</h3>
            </div>
            <div class="card-body">
                <form action="proses.php" method="post">
                    <?php foreach($pertanyaan as $p): ?>
                    <div class="card question-card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $p['id'] ?>. <?= $p['text'] ?></h5>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jawaban[<?= $p['id'] ?>]" value="5" id="q<?= $p['id'] ?>_5" required>
                                <label class="form-check-label" for="q<?= $p['id'] ?>_5">5 - Sangat Puas</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jawaban[<?= $p['id'] ?>]" value="4" id="q<?= $p['id'] ?>_4">
                                <label class="form-check-label" for="q<?= $p['id'] ?>_4">4 - Puas</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jawaban[<?= $p['id'] ?>]" value="3" id="q<?= $p['id'] ?>_3">
                                <label class="form-check-label" for="q<?= $p['id'] ?>_3">3 - Cukup</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jawaban[<?= $p['id'] ?>]" value="2" id="q<?= $p['id'] ?>_2">
                                <label class="form-check-label" for="q<?= $p['id'] ?>_2">2 - Kurang Puas</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jawaban[<?= $p['id'] ?>]" value="1" id="q<?= $p['id'] ?>_1">
                                <label class="form-check-label" for="q<?= $p['id'] ?>_1">1 - Tidak Puas</label>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-primary btn-lg w-100">Submit Kuesioner</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>