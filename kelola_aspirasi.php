<?php
session_start();
include "db.php";

/* CEK LOGIN */
if (!isset($_SESSION['status_login'])) {
    header("Location: login.php");
    exit;
}

/* UPDATE STATUS */
if (isset($_POST['update'])) {

    $id_pelaporan = $_POST['id'] ?? '';
    $status = $_POST['status'] ?? '';
    $feedback = $_POST['feedback'] ?? '';

    if ($id_pelaporan != "") {

        $cek = mysqli_query($conn, "
    SELECT * FROM aspirasi 
    WHERE id_pelaporan='$id_pelaporan'
    ");

        if (mysqli_num_rows($cek) > 0) {

            mysqli_query($conn, "
    UPDATE aspirasi
    SET status='$status', feedback='$feedback'
    WHERE id_pelaporan='$id_pelaporan'
    ");
        } else {

            mysqli_query($conn, "
    INSERT INTO aspirasi (id_pelaporan,status,feedback)
    VALUES('$id_pelaporan','$status','$feedback')
    ");
        }
    }
}

/* HAPUS DATA */
if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    mysqli_query($conn, "DELETE FROM aspirasi WHERE id_pelaporan='$id'");
    mysqli_query($conn, "DELETE FROM input_aspirasi WHERE id_pelaporan='$id'");

    header("Location: kelola_aspirasi.php");
    exit;
}

/* =========================
   FILTER
========================= */

$where = "WHERE 1=1";

if (!empty($_GET['tanggal_awal']) && !empty($_GET['tanggal_akhir'])) {

    $tanggal_awal = $_GET['tanggal_awal'];
    $tanggal_akhir = $_GET['tanggal_akhir'];

    $where .= " AND DATE(input_aspirasi.created_at) 
    BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
}

if (!empty($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
    $where .= " AND MONTH(created_at)='$bulan'";
}

if (!empty($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $where .= " AND YEAR(created_at)='$tahun'";
}

if (!empty($_GET['kategori'])) {
    $kategori = $_GET['kategori'];
    $where .= " AND input_aspirasi.id_kategori='$kategori'";
}

if (!empty($_GET['nis'])) {
    $nis = $_GET['nis'];
    $where .= " AND input_aspirasi.nis='$nis'";
}

/* DATA FILTER */
$data = mysqli_query($conn, "
SELECT
input_aspirasi.*,
siswa.kelas,
kategori.ket_kategori,
aspirasi.status,
aspirasi.feedback

FROM input_aspirasi

LEFT JOIN siswa
ON input_aspirasi.nis=siswa.nis

LEFT JOIN kategori
ON input_aspirasi.id_kategori=kategori.id_kategori

LEFT JOIN aspirasi
ON input_aspirasi.id_pelaporan=aspirasi.id_pelaporan

$where

ORDER BY created_at DESC
");

/* DATA KATEGORI */
$kategori = mysqli_query($conn, "SELECT * FROM kategori");

/* DATA SISWA */
$siswa = mysqli_query($conn, "SELECT * FROM siswa");
?>

<!DOCTYPE html>

<html>

<head>
    <title>Kelola Aspirasi</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">

</head>

<body>

    <div class="navbar">
        <div class="logo">Dashboard Admin</div>

        <div class="menu">
            <a href="dashboard.php">Dashboard</a>
            <a href="kelola_aspirasi.php">Kelola Aspirasi</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">

        <h2>Kelola Aspirasi</h2>

        <!-- FILTER -->

        <form method="GET" class="filter-box">

            <label>Dari</label>
            <input type="date" name="tanggal_awal">

            <label>Sampai</label>
            <input type="date" name="tanggal_akhir">

            <select name="bulan">
                <option value="">Bulan</option>
                <?php
                for ($b = 1; $b <= 12; $b++) {
                    echo "<option value='$b'>$b</option>";
                }
                ?>
            </select>

            <select name="tahun">
                <option value="">Tahun</option>
                <?php
                for ($t = date("Y"); $t >= 2023; $t--) {
                    echo "<option value='$t'>$t</option>";
                }
                ?>
            </select>

            <select name="kategori">
                <option value="">Kategori</option>
                <?php while ($k = mysqli_fetch_assoc($kategori)) { ?>
                    <option value="<?php echo $k['id_kategori']; ?>">
                        <?php echo $k['ket_kategori']; ?>
                    </option>
                <?php } ?>
            </select>

            <select name="nis">
                <option value="">Siswa</option>
                <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>
                    <option value="<?php echo $s['nis']; ?>">
                        <?php echo $s['nis'] . " - " . $s['kelas']; ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit" class="btn-filter">Filter</button> <a href="kelola_aspirasi.php" class="btn-reset">Reset</a>

        </form>

        <br>

        <table>

            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Kelas</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Feedback</th>
                <th>Aksi</th>
            </tr>

            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($data)) {
            ?>

                <tr>
                    <form method="POST">

                        <input type="hidden" name="id" value="<?php echo $row['id_pelaporan']; ?>">

                        <td><?php echo $no++; ?></td>

                        <td><?php echo date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>

                        <td><?php echo $row['nis']; ?></td>

                        <td><?php echo $row['kelas']; ?></td>

                        <td><?php echo $row['ket_kategori']; ?></td>

                        <td><?php echo $row['lokasi']; ?></td>

                        <td><?php echo $row['ket']; ?></td>

                        <td>

                            <select name="status">

                                <option value="Menunggu" <?php if ($row['status'] == "Menunggu") echo "selected"; ?>>Menunggu</option>
                                <option value="Proses" <?php if ($row['status'] == "Proses") echo "selected"; ?>>Proses</option>
                                <option value="Selesai" <?php if ($row['status'] == "Selesai") echo "selected"; ?>>Selesai</option>

                            </select>

                        </td>

                        <td>
                            <input type="text" name="feedback" value="<?php echo $row['feedback']; ?>">
                        </td>

                        <td>
                            <div class="aksi-btn">

                                <button type="submit" name="update" class="btn-submit">
                                    Update
                                </button>

                                <a href="kelola_aspirasi.php?hapus=<?php echo $row['id_pelaporan']; ?>" class="btn-hapus">
                                    Hapus
                                </a>

                            </div>
                        </td>

                    </form>
                </tr>
                

            <?php } ?>

        </table>

    </div>

</body>

</html>