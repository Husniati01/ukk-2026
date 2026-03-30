<?php
include "db.php";

/* ambil kategori */
$kategori = mysqli_query($conn, "SELECT * FROM kategori");

/* ambil siswa untuk dropdown NIS */
$siswa = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nis ASC");

/* insert aspirasi */
if (isset($_POST['kirim'])) {

    $nis = $_POST['nis'];
    $id_kategori = $_POST['id_kategori'];
    $lokasi = $_POST['lokasi'];
    $ket = $_POST['ket'];

    mysqli_query($conn, "
INSERT INTO input_aspirasi
(nis,id_kategori,lokasi,ket,created_at)
VALUES
('$nis','$id_kategori','$lokasi','$ket',NOW())
");

    echo "<script>
alert('Aspirasi berhasil dikirim');
window.location='aspirasi.php';
</script>";
}

/* tampilkan aspirasi */
$query = mysqli_query($conn, "
SELECT 
input_aspirasi.*,
kategori.ket_kategori,
aspirasi.status,
aspirasi.feedback

FROM input_aspirasi

LEFT JOIN kategori
ON input_aspirasi.id_kategori = kategori.id_kategori

LEFT JOIN aspirasi
ON input_aspirasi.id_pelaporan = aspirasi.id_pelaporan

ORDER BY input_aspirasi.created_at DESC
");
?>

<!DOCTYPE html>

<html>

<head>
    <title>Aspirasi Siswa</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">

</head>

<body>

    <div class="navbar">

        <div class="logo">
            Sistem Aspirasi
        </div>

        <div class="menu">
            <a href="index.php">Home</a>
            <a href="aspirasi.php">Aspirasi</a>
            <a href="login.php">Login Admin</a>
        </div>

    </div>

    <div class="container">

        <div class="header-page">

            <h2>Daftar Aspirasi</h2>

            <br>
            <br>
            <br>

            <button class="btn-add" onclick="openModal()">
                + Tambah Aspirasi
            </button>

        </div>

        <table>

            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Feedback</th>
            </tr>

            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($query)) {
            ?>

                <tr>

                    <td><?php echo $no++; ?></td>

                    <td><?php echo $row['ket_kategori']; ?></td>

                    <td><?php echo $row['lokasi']; ?></td>

                    <td><?php echo $row['ket']; ?></td>

                    <td>

                        <?php
                        if ($row['status'] == "Proses") {
                            echo "<span class='status proses'>Proses</span>";
                        } elseif ($row['status'] == "Selesai") {
                            echo "<span class='status selesai'>Selesai</span>";
                        } else {
                            echo "<span class='status menunggu'>Menunggu</span>";
                        }
                        ?>

                    </td>

                    <td>
                        <?php echo $row['feedback'] ?? "-"; ?>
                    </td>

                </tr>

            <?php } ?>

        </table>

    </div>

    <div class="modal" id="modal">

        <div class="modal-box">

            <h3>Form Aspirasi</h3>

            <form method="POST">

                <div class="form-grid">

                    <div>

                        <label>NIS</label>

                        <select name="nis" required>

                            <option value="">Pilih NIS</option>

                            <?php
                            while ($s = mysqli_fetch_assoc($siswa)) {
                            ?>

                                <option value="<?php echo $s['nis']; ?>">
                                    <?php echo $s['nis'] . " - " . $s['kelas']; ?>
                                </option>

                            <?php } ?>

                        </select>

                    </div>

                    <div>

                        <label>Kategori</label>

                        <select name="id_kategori" required>

                            <option value="">Pilih Kategori</option>

                            <?php
                            mysqli_data_seek($kategori, 0);
                            while ($k = mysqli_fetch_assoc($kategori)) {
                            ?>

                                <option value="<?php echo $k['id_kategori']; ?>">
                                    <?php echo $k['ket_kategori']; ?>
                                </option>

                            <?php } ?>

                        </select>

                    </div>

                </div>

                <label>Lokasi</label> <input type="text" name="lokasi" required>

                <label>Keterangan</label>

                <textarea name="ket" required></textarea>

                <div class="modal-btn">

                    <button type="button" onclick="closeModal()" class="btn-cancel">
                        Batal
                    </button>

                    <button type="submit" name="kirim" class="btn-save">
                        Kirim
                    </button>

                </div>
            </form>

        </div>

    </div>

    <script>
        function openModal() {
            document.getElementById("modal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("modal").style.display = "none";
        }
    </script>

</body>

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

</html>