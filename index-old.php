<?php
session_start();

// set session login
if (!isset($_SESSION['login'])) {
  header('location: login.php');
  exit;
}

require 'function.php';

$query = "SELECT pertanyaan, no_urut FROM pertanyaan";
$result = mysqli_query($conn, $query);

$pertanyaan = [];
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $pertanyaan[$row['no_urut']] = $row['pertanyaan'];
    $no_urut[$row['no_urut']] = $row['no_urut'];
  }
} else {
  // Kalau belum ada data, buat array kosong untuk 10 pertanyaan
  for ($i = 1; $i <= 10; $i++) {
    $pertanyaan[$i] = "";
  }
}

$user_id = $_SESSION['user_id'];
if (isset($_POST['submit'])) {
    // Ambil nilai persepsi1 sampai persepsi10 dari form dan simpan di array agar mudah looping
    // $persepsi = [];
    // for ($i = 1; $i <= 10; $i++) {
    //     $key = 'persepsi' . $i;
    //     $persepsi[$i] = isset($_POST[$key]) ? (int)$_POST[$key] : 0; // casting ke int
    // }
    $persepsi = [
      1 => $persepsi1 = isset($_POST['persepsi1']) ? (int)$_POST['persepsi1'] : 0,
      2 => $persepsi2 = isset($_POST['persepsi2']) ? (int)$_POST['persepsi2'] : 0,
      3 => $persepsi3 = isset($_POST['persepsi3']) ? (int)$_POST['persepsi3'] : 0,
      4 => $persepsi4 = isset($_POST['persepsi4']) ? (int)$_POST['persepsi4'] : 0,
      5 => $persepsi5 = isset($_POST['persepsi5']) ? (int)$_POST['persepsi5'] : 0,
      6 => $persepsi6 = isset($_POST['persepsi6']) ? (int)$_POST['persepsi6'] : 0,
      7 => $persepsi7 = isset($_POST['persepsi7']) ? (int)$_POST['persepsi7'] : 0,
      8 => $persepsi8 = isset($_POST['persepsi8']) ? (int)$_POST['persepsi8'] : 0,
      9 => $persepsi9 = isset($_POST['persepsi9']) ? (int)$_POST['persepsi9'] : 0,
      10 => $persepsi10 = isset($_POST['persepsi10']) ? (int)$_POST['persepsi10'] : 0,
    ];
    $kategori = [
      1 => ($persepsi[1] + $persepsi[2]) / 2,
      2 => ($persepsi[3] + $persepsi[4]) / 2,
      3 => ($persepsi[5] + $persepsi[6]) / 2,
      4 => ($persepsi[7] + $persepsi[8]) / 2,
      5 => ($persepsi[9] + $persepsi[10]) / 2,
    ];
    for ($i = 1; $i <= 5; $i++) {
        $key = 'kategori' . $i;
        $kategori[$i] = $kategori[$i]; // casting ke int
    }

    // Hitung total dan rata-rata
    $total = array_sum($kategori);
    $rata_rata = $total / 5;
    // // Hitung total dan rata-rata
    // $total = array_sum($persepsi);
    // $rata_rata = $total / 10;

    // Tentukan tingkat kepuasan
    if ($rata_rata >= 4.5) {
        $tingkat = "Sangat Puas";
    } elseif ($rata_rata >= 3.5) {
        $tingkat = "Puas";
    } elseif ($rata_rata >= 2.5) {
        $tingkat = "Cukup";
    } elseif ($rata_rata >= 1.5) {
        $tingkat = "Kurang Puas";
    } else {
        $tingkat = "Sangat Tidak Puas";
    }

    // $sql = "INSERT INTO survey (
    //             user_id,
    //             persepsi0, persepsi1, persepsi2, persepsi3, persepsi4,
    //             persepsi5, persepsi6, persepsi7, persepsi8, persepsi9,
    //             total_penilaian, rata_rata_penilaian, tingkat_kepuasan
    //         ) VALUES (
    //             '$user_id',
    //             '{$persepsi[1]}', '{$persepsi[2]}', '{$persepsi[3]}', '{$persepsi[4]}', '{$persepsi[5]}',
    //             '{$persepsi[6]}', '{$persepsi[7]}', '{$persepsi[8]}', '{$persepsi[9]}', '{$persepsi[10]}',
    //             $total, $rata_rata, '$tingkat'
    //         )";
    $sql = "INSERT INTO survey_new (
                user_id,
                kategori1, kategori2, kategori3, kategori4, kategori5, total, rata_rata, tingkat_kepuasan
            ) VALUES (
                '$user_id',
                '{$kategori[1]}', '{$kategori[2]}', '{$kategori[3]}', '{$kategori[4]}', '{$kategori[5]}',
                $total, $rata_rata, '$tingkat'
            )";

    $insert = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));

    if ($insert) {
        echo "<script>alert('Terima kasih atas penilaian Anda!')</script>";
        header('Location: index.php');
        exit();
    }
}

?>



<!DOCTYPE html>
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
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/table_survey_user.css" />
  <!-- ==========================================
                  Breakpoint
    =========================================== -->
  <link rel="stylesheet" href="css/breakpoint.css" />
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
      <a href="#home" class="active">Home</a>
      <a href="#about">About</a>
      <a href="#services">Services</a>
      <a href="#portfolio">Portfolio</a>
      <a href="#contact">Survey</a>
      <a href="logout.php">Log Out</a>
    </nav>
  </header>

  <!-- ==========================================
                  Home Section
    =========================================== -->
  <section class="home" id="home">
    <div class="home-content">
      <h3>Hello, It's Me</h3>
      <h1><?php echo $_SESSION['username']; ?></h1>
      <h3><span class="multiple-text"></span></h3>
      <div class="social-media">
        <a href=""><i class="bx bxl-facebook"></i></a>
        <a href=""><i class="bx bxl-twitter"></i></a>
        <a href=""><i class="bx bxl-instagram-alt"></i></a>
        <a href=""><i class="bx bxl-linkedin"></i></a>
      </div>
      <!-- add link for your CV into `href` -->
    </div>

    <div class="home-img">
      <img src="assets/image/suntik.png" alt="home" />
    </div>
  </section>

  <!-- ==========================================
                  About Section
    =========================================== -->
  <section class="about" id="about">
    <div class="about-img">
      <img src="assets/image/pustudepan.jpg" alt="about" />
    </div>

    <div class="about-content">
      <h2 class="heading">About <span>Pustu</span></h2>
      <p>
        Puskesmas Pembantu Medan Sinembah Deli Serdang. Salah satu puskesmas di Kabupaten Deli Serdang melayani pemeriksaan kesehatan, rujukan, surat kesehatan dll. Puskesmas ini melayani berbagai program puskesmas seperti periksa kesehatan (check up), pembuatan surat keterangan sehat, rawat jalan, lepas jahitan, ganti balutan, jahit luka, cabut gigi, periksan tensi, tes hamil, periksa anak, tes golongan darah, asam urat, kolesterol dan lainnya.
      </p>
      <p>
        Puskesmas juga melayani pembuatan rujukan bagi pasien BPJS ke rumah sakit untuk mendapatkan perawatan lanjutan.

        Pelayanan Puskesmas Pembantu Medan Sinembah juga baik dengan tenaga kesehatan yang baik, mulai dari perawat, dokter, alat kesehatan dan obatnya. Puskesmas ini dapat menjadi salah satu pilihan warga masyarakat Kabupaten Deli Serdang untuk memenuhi kebutuhan terkait kesehatan.
      </p>
      <a href="#" class="btn">Read More</a>
    </div>
  </section>

  <!-- ==========================================
                  Services Section
    =========================================== -->
  <!---<section class="services" id="services">
      <h2 class="heading">Our <span>Services</span></h2>

      <div class="services-container">
        <div class="services-box">
          <i class="bx bx-code-alt"></i>
          <h3>Front End</h3>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque amet
            atque voluptate saepe magni aspernatur id nemo quasi quibusdam
            ratione.
          </p>
          <a href="#" class="btn">Read More</a>
        </div>

        <div class="services-box">
          <i class="bx bxs-paint"></i>
          <h3>Graphic Design</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia
            fugiat quaerat vero magnam? Sunt exercitationem atque distinctio
            deleniti culpa minus.
          </p>
          <a href="#" class="btn">Read More</a>
        </div>

        <div class="services-box">
          <i class="bx bx-data"></i>
          <h3>Back End</h3>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque amet
            atque voluptate saepe magni aspernatur id nemo quasi quibusdam
            ratione.
          </p>

          <a href="#" class="btn">Read More</a>
        </div>
      </div>
    </section> -->

  <!-- ==========================================
                  Portfolio Section
    =========================================== -->
  <section class="portfolio" id="portfolio">
    <h2 class="heading">Ruangan <span>Pustu</span></h2>

    <div class="portfolio-container">
      <div class="portfolio-box">
        <img src="assets/image/ruang_admin[1].png" alt="portfolio" />
        <div class="portfolio-layer">
          <h4>Web Design</h4>
          <p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit.
            Provident, nihil.
          </p>
          <a href="#"><i class="bx bx-link-external"></i></a>
        </div>
      </div>

      <div class="portfolio-box">
        <img src="assets/image/ruang_obat[1].png" alt="portfolio" />
        <div class="portfolio-layer">
          <h4>Web Design</h4>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sit,
            dignissimos.
          </p>
          <a href="#"><i class="bx bx-link-external"></i></a>
        </div>
      </div>

      <div class="portfolio-box">
        <img src="assets/image/ruang_pelayanan[1].png" alt="portfolio" />
        <div class="portfolio-layer">
          <h4>Web Design</h4>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Accusamus, sequi!
          </p>
          <a href="#"><i class="bx bx-link-external"></i></a>
        </div>
      </div>

      <div class="portfolio-box">
        <img src="assets/image/ruang_pemeriksaan[1].png" alt="portfolio" />
        <div class="portfolio-layer">
          <h4>Web Design</h4>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur,
            nulla?
          </p>
          <a href="#"><i class="bx bx-link-external"></i></a>
        </div>
      </div>

      <div class="portfolio-box">
        <img src="assets/image/ruang_sholat[1].png" alt="portfolio" />
        <div class="portfolio-layer">
          <h4>Web Design</h4>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus,
            cum!
          </p>
          <a href="#"><i class="bx bx-link-external"></i></a>
        </div>
      </div>

      <div class="portfolio-box">
        <img src="assets/image/ruang_tunggu[1].png" alt="portfolio" />
        <div class="portfolio-layer">
          <h4>Web Design</h4>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt, ut!
          </p>
          <a href="#"><i class="bx bx-link-external"></i></a>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================
                  Contact Section
    =========================================== -->
  <div class="contact" id="contact" style="padding: 2rem;">
    <h2 class="heading">Survey <span>Kepuasan</span></h2>

    <center>
      <?php

      $survey = mysqli_query($conn, "SELECT * FROM survey where user_id = '$user_id' ") or die(mysqli_error($conn));;
      $countSurvey = mysqli_num_rows($survey);

      if ($countSurvey > 0):
      ?>
        <h4 class="survey_done"><span>Terima Kasih Telah Mengisi Survey</span></h4>


      <?php else: ?>
        <table border=0 class='table1' width=100% style="margin-bottom: 80px;">
          <form action="index.php" method="post">
            <tr class="header-row" align=center height=20 bgcolor=green style='color:white'>
              <td>
                <font size=2>No.</font>
              </td>
              <td>
                <font size=2>Attribut</font>
              </td>
              <td>
                <font size=2>Persepsi</font>
              </td>
            </tr>
            <?php for ($i = 1; $i <= 10; $i++) : ?>
              <tr align=center>
                <td>
                  <font size=2><label style='border:none'><?= $no_urut[$i] ?></font>
                </td>
                <td>
                  <font size=2><label style='border:none'><?= $pertanyaan[$i] ?></font>
                </td>
                <td>
                  <font size=2>
                    <select name="<?='persepsi'.$i?>">
                      <option value='5' selected>Sangat Puas</option>
                      <option value='4'>Puas</option>
                      <option value='3'>Cukup Puas</option>
                      <option value='2'>Tidak Puas</option>
                      <option value='1'>Sangat Tidak Puas</option>
                    </select>
                  </font>
                </td>
              </tr>
            <?php endfor; ?>
            <tr align=center>
              <td colspan=3>
                <!-- <hr color=green style='height:2px'> -->
                <hr class="green-line" />
              </td>
            </tr>
            <tr class="##" style="text-align: end;">
              <td colspan="3" style="text-align: right;"><input type=submit name="submit" value='SUBMIT'></td>
            </tr>
            <tr align=center>
              <td colspan=3>
                <!-- <hr color=green style='height:2px'> -->
                <hr class="green-line" />
              </td>
            </tr>
          </form>
        </table>
      <?php endif; ?>


  </div>

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