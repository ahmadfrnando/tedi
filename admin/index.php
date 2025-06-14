<?php

require __DIR__ . '/../function.php';

session_start();

if (isset($_SESSION['login'])) {
  header('location: index.php');
  exit;
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
      <a href="/admin" class="active">Admin</a>
      <a href="/admin/kelola_pertanyaan.php">Kelola Pertanyaan</a>
      <a href="logout.php">Log Out</a>
    </nav>
  </header>

  <section>
    <div class="survey-container">
      <button class="btn btn-print" onclick="window.open('cetak_survey.php', '_blank')">Cetak Survey</button>

      <table>
        <thead>
          <tr style="font-size: 12px;">
            <th rowspan="2">No.</th>
            <th rowspan="2">Nama</th>
            <th colspan="10">Pertanyaan</th>
            <th rowspan="2">Action</th>
          </tr>
          <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          $survey = mysqli_query($conn, 'SELECT * FROM `survey` LEFT JOIN user ON survey.user_id = user.id');
          while ($surveyData = mysqli_fetch_assoc($survey)):
          ?>
            <tr style="font-size: 12px;">
              <td><?= $no++; ?></td>
              <td><?= htmlspecialchars($surveyData['username']); ?></td>
              <td><?= mapping($surveyData['persepsi0']); ?></td>
              <td><?= mapping($surveyData['persepsi1']); ?></td>
              <td><?= mapping($surveyData['persepsi2']); ?></td>
              <td><?= mapping($surveyData['persepsi3']); ?></td>
              <td><?= mapping($surveyData['persepsi4']); ?></td>
              <td><?= mapping($surveyData['persepsi5']); ?></td>
              <td><?= mapping($surveyData['persepsi6']); ?></td>
              <td><?= mapping($surveyData['persepsi7']); ?></td>
              <td><?= mapping($surveyData['persepsi8']); ?></td>
              <td><?= mapping($surveyData['persepsi9']); ?></td>
              <td>
                <button class="btn btn-detail" onclick="showDetail('<?= htmlspecialchars($surveyData['user_id']); ?>')">Detail Penilaian</button>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <script>
      function showDetail(userId) {
        // Contoh redirect ke halaman detail, sesuaikan URL
        window.location.href = 'detail_survey.php?user_id=' + userId;
      }
    </script>

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