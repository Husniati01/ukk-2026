<?php
session_start();
include "db.php";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = md5($_POST['password']); // ubah password ke md5

    $query = mysqli_query($conn, "
    SELECT * FROM admin
    WHERE username='$username'
    AND password='$password'
    ");

    $cek = mysqli_num_rows($query);

    if ($cek > 0) {

        $_SESSION['status_login'] = true;

        header("Location: dashboard.php");
        exit;
    } else {

        echo "<script>
        alert('Username atau Password salah');
        window.location='login.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Login Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">



</head>

<body>

    <div class="login-box">

        <h2>Login Admin</h2>

        <form method="POST">

            <input type="text" name="username" placeholder="Username" required>

            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" name="login" class="btn-login">
                Login
            </button>

        </form>

    </div>

</body>

</html>