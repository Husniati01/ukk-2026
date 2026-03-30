<?php
session_start();
include "db.php";

/* CEK LOGIN */
if (!isset($_SESSION['status_login'])) {
    header("Location: login.php");
    exit;
}

/* TOTAL SISWA */
$siswa = mysqli_query($conn, "SELECT COUNT(*) as total FROM siswa");
$total_siswa = mysqli_fetch_assoc($siswa)['total'];

/* TOTAL KATEGORI */
$kategori = mysqli_query($conn, "SELECT COUNT(*) as total FROM kategori");
$total_kategori = mysqli_fetch_assoc($kategori)['total'];

/* TOTAL ASPIRASI */
$aspirasi = mysqli_query($conn, "SELECT COUNT(*) as total FROM input_aspirasi");
$total_aspirasi = mysqli_fetch_assoc($aspirasi)['total'];

$aspirasi_selesai = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total 
FROM aspirasi 
WHERE status='Selesai'
"))['total'];

/* CEK APAKAH ADA KOLOM STATUS */
$cek_status = mysqli_query($conn, "SHOW COLUMNS FROM input_aspirasi LIKE 'status'");

if (mysqli_num_rows($cek_status) > 0) {
    $selesai = mysqli_query($conn, "SELECT COUNT(*) as total FROM input_aspirasi WHERE status='Selesai'");
    $total_selesai = mysqli_fetch_assoc($selesai)['total'];
} else {
    $total_selesai = 0;
}

/* ASPIRASI TERBARU */
$query = mysqli_query($conn, "
SELECT
input_aspirasi.*,
kategori.ket_kategori,
IFNULL(aspirasi.status,'Menunggu') AS status

FROM input_aspirasi

LEFT JOIN kategori
ON input_aspirasi.id_kategori = kategori.id_kategori

LEFT JOIN aspirasi
ON input_aspirasi.id_pelaporan = aspirasi.id_pelaporan

ORDER BY input_aspirasi.created_at DESC
LIMIT 5
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">

</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">

        <div class="logo">
            Dashboard Admin
        </div>

        <div class="menu">
            <a href="dashboard.php">Dashboard</a>
            <a href="kelola_aspirasi.php">Kelola Aspirasi</a>
            <a href="logout.php">Logout</a>
        </div>

    </div>

    <div class="container">

        <h2>Dashboard</h2>

        <!-- STATISTIK -->
        <div class="card-container">

            <div class="card">
                <h3>Total Siswa</h3>
                <p><?php echo $total_siswa; ?></p>
            </div>

            <div class="card">
                <h3>Total Kategori</h3>
                <p><?php echo $total_kategori; ?></p>
            </div>

            <div class="card">
                <h3>Total Aspirasi</h3>
                <p><?php echo $total_aspirasi; ?></p>
            </div>

            <div class="card">
                <h3>Aspirasi Selesai</h3>
                <p><?php echo $aspirasi_selesai; ?></p>
            </div>

        </div>


        <!-- ASPIRASI TERBARU -->
        <h3>Aspirasi Terbaru</h3>

        <table>

            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
                <th>Status</th>
            </tr>

            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($query)) {
            ?>

                <tr>

                    <td><?php echo $no++; ?></td>

                    <td>
                        <?php
                        if (isset($row['created_at'])) {
                            echo date('d-m-Y', strtotime($row['created_at']));
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>

                    <td><?php echo $row['nis']; ?></td>

                    <td><?php echo $row['ket_kategori']; ?></td>

                    <td><?php echo $row['lokasi']; ?></td>

                    <td><?php echo $row['ket']; ?></td>

                    <td>
                        <?php
                        if (isset($row['status'])) {
                            echo $row['status'];
                        } else {
                            echo "Diproses";
                        }
                        ?>
                    </td>

                </tr>

            <?php } ?>

        </table>

    </div>


    <!-- FOOTER -->
    <footer class="footer">

        <div class="footer-content">

            <div class="footer-left">
                <h3>Sistem Aspirasi Sekolah</h3>

                <p>
                    Website untuk menampung aspirasi, saran,
                    dan keluhan siswa agar sekolah menjadi lebih baik.
                </p>

            </div>

        </div>

        <div class="footer-bottom">
            © 2026 Sistem Aspirasi Sekolah
        </div>

    </footer>

</body>

</html>