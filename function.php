<?php
// koneksi database
$conn = mysqli_connect('localhost:3307', 'root', 'root', 'tedi');

// registrasi
function registrasi($data)
{
    global $conn;

    $username = strtolower(stripslashes($data['username']));
    $nomor = strtolower(stripslashes($data['nomor']));
    $nik = strtolower(stripslashes($data['nik']));
    $password = mysqli_real_escape_string($conn, $data['password']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);

    // cek username sudah terdaftar atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
        alert('username telah terdaftar')
        </script>";
        return false;
    }

    // cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
        alert('konfirmasi password tidak sesuai');
        
        </script>";
        return false;
    }

    // enkripsi password login
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambah data ke data base
    $query = "INSERT INTO user (username, nomor, nik, password) VALUES('$username', '$nomor', '$nik', '$password')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function mapping(string $value): string
{
    switch ($value) {
        case 1:
            return 'Tidak Puas';
            break;
        case 2:
            return 'Tidak Puas';
            break;
        case 3:
            return 'Cukup Puas';
            break;
        case 4:
            return 'Puas';
            break;
        case 5:
            return 'Sangat Puas';
            break;
        default:
            return '';
    }
}

?>
