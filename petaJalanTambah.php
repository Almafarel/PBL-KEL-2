<?php
include("koneksi.php");
session_start();

// Jika form disubmit
if (isset($_POST['submit'])) {

    $judul      = $_POST['judul'];
    $tahun      = $_POST['tahun'];
    $deskripsi  = $_POST['deskripsi'];
    $user_id    = $_SESSION['user_id'] ?? 1; // default 1 jika tidak pakai login

    // ---- Proses Upload File ----
    $fileName = null;

    if (!empty($_FILES['file']['name'])) {

        $uploadDir = "uploads/";
        $fileName  = time() . "_" . basename($_FILES["file"]["name"]);
        $targetPath = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath)) {
            die("Gagal upload file!");
        }
    }

    // ---- Insert ke database ----
    $query = "INSERT INTO peta_jalan (judul, tahun, deskripsi, file_path, user_id)
              VALUES ($1, $2, $3, $4, $5)";

    $result = pg_query_params($koneksi, $query, [
        $judul, $tahun, $deskripsi, $fileName, $user_id
    ]);

    if ($result) {
        header("Location: petaJalanTabel.php?status=success");
        exit;
    } else {
        echo "Gagal menambah data: " . pg_last_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Peta Jalan</title>
    <link rel="stylesheet" href="assets/css/base.css">
</head>

<body>

<h2>Tambah Data Peta Jalan</h2>

<form action="" method="POST" enctype="multipart/form-data">

    <label>Judul:</label>
    <input type="text" name="judul" required>

    <label>Tahun:</label>
    <input type="number" name="tahun" required>

    <label>Deskripsi:</label>
    <textarea name="deskripsi" required></textarea>

    <label>Upload File (PDF):</label>
    <input type="file" name="file" accept="application/pdf" required>

    <button type="submit" name="submit">Simpan</button>
    <a href="petaJalanTabel.php">Kembali</a>

</form>

</body>
</html>
