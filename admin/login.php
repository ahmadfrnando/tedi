<?php
require __DIR__ . '/../function.php';

if (isset($_SESSION['login'])) {
    header('location: index.php');
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' AND role = 'admin'");

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

// if (isset($_POST['login'])) {

//     $username = $_POST["username"];
//     $password = $_POST["password"];

//     $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' AND role = 'admin'");


//     // cek username 
//     if (mysqli_num_rows($result) === 1) {
//         // cek password
//         $row = mysqli_fetch_assoc($result);
//         if (password_verify($password, $row["password"])) {
//             header("location: index.php");
//             exit;
//         }
//     }
// }

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./loginadmin.css">
    <link rel="stylesheet" href="css/alert.css">
    <title>Login Page | Pustu Medan Sinembah</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-in">
            <form action="" method="post">
                <?php if (isset($error)): ?>
                    <div class="alert">Password / Username salah</div>
                <?php endif; ?>
                <h1>Sign In</h1>
                <span></span>
                <label for="username"></label>
                <input type="text" placeholder="Username" name="username" id="username">

                <label for="password"></label>
                <input type="password" placeholder="Password" name="password" id="password">
                <button type="submit" name="login">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Admin!</h1>
                </div>
            </div>
        </div>
    </div>
    <a href="../login.php" class="btn">Login Sebagai Masyarakat</a>

    <script src="jvs/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>