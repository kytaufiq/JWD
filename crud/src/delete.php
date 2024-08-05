<?php
require 'connect.php';

if (isset($_GET['userId'])) {
    $userId = intval($_GET['userId']);
    $sql = "DELETE FROM mahasiswa WHERE id = $userId";

    if (mysqli_query($con, $sql)) {
        echo "Data berhasil dihapus. <a href='index.php'>Kembali ke page index.</a>";
    } else {
        echo "Terjadi kesalahan! " . mysqli_error($con);
    }
} else {
    echo "ID pengguna tidak ditemukan.";
}

mysqli_close($con);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CRUD:Delete</title>
</html>