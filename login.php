<?php

require './function.php';

session_start();

// set session login
if (isset($_SESSION['login'])) {
    header('location: index.php');
    exit;
}

if (isset($_POST['register'])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
        alert('user baru berhasil ditambahkan')
        </script>";
    } else {
        echo mysqli_error($conn);
    }
}

// Set session variables

if (isset($_POST['login'])) {
    $nik = $_POST['nik'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE nik = '$nik'");

    // cek nik
    if (mysqli_num_rows($result) === 1) {
        // cek password dari data base
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // set session
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id'];
            header('location: index.php');
            exit;
        }
    }

    $error = true;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/alert.css">
    <title>Login Page | Pustu Medan Sinembah</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="" method="post">
                <h1>Create Account</h1>
                <!-- <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div> -->
                <span></span>
                <label for="username"></label>
                <input type="text" placeholder="Username" name="username" id="username">
                
                <label for="nik"></label>
                <input type="text" placeholder="NIK" name="nik" id="nik">

                <label for="nomor"></label>
                <input type="number" placeholder="Nomor BPJS" name="nomor" id="nomor">

                <label for="password"></label>
                <input type="password" placeholder="Password" name="password" id="password">

                <label for="password2"></label>
                <input type="password" placeholder="Konfirmasi Password" name="password2" id="password2">

                <button type="submit" name="register">Register</button>
            </form>
        </div>
        <div class="form-container sign-in">


            <form action="" method="post">
                <?php if (isset($error)): ?>
                    <div class="alert">Password / Username salah</div>
                <?php endif; ?>
                <h1>Sign In</h1>
                <!-- <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div> -->
                <span></span>
                <label for="nik"></label>
                <input type="text" placeholder="NIK" name="nik" id="nik">

                <label for="password"></label>
                <input type="password" placeholder="Password" name="password" id="password">
                <!-- <a href="survey.html">Survey Kepuasan Pengguna</a> -->
                <button type="submit" name="login">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <a href="admin/login.php" class="btn">Login Sebagai Admin</a>

    <script src="jvs/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>