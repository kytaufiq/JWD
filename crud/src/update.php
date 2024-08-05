<?php
require 'connect.php';

function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    return $randomString;
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $npm = $_POST['npm'];
    $name = $_POST['name'];
    $JenisKelamin = $_POST['JenisKelamin'];
    $tanggallahir = $_POST['tanggallahir'];
    $alamat = $_POST['alamat'];
    $foto = $_POST['foto'];

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . generateRandomString() . "_" . basename($_FILES["foto"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        
        if ($check === false) {
            echo "File bukan gambar.";
            $uploadOk = 0;
        }

        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "File tidak diupload.";
        } else {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                echo "File " . htmlspecialchars(basename($_FILES["foto"]["name"])) . " telah diupload.";
                $foto = $target_file;
            } else {
                echo "Terjadi kesalahan saat mengupload.";
            }
        }
    }

    $sql = "UPDATE `mahasiswa` SET npm='$npm', name='$name', JenisKelamin='$JenisKelamin', tanggallahir='$tanggallahir', alamat='$alamat', foto='$foto' WHERE id=$id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "Data berhasil diupdate!";
    } else {
        echo "Gagal update data: " . mysqli_error($con);
    }
}

if (isset($_GET['userId'])) {
    $id = $_GET['userId'];
    $sql = "SELECT * FROM `mahasiswa` WHERE id=$id";
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "ID pengguna tidak disediakan.";
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD: Update</title>
    <link rel="stylesheet" href="./output.css">
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="date"], input[type="file"], input[type="radio"], input[type="hidden"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Update Data Mahasiswa</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
        
        <label for="npm">NPM:</label>
        <input type="text" id="npm" name="npm" value="<?php echo htmlspecialchars($row['npm']); ?>" required>
        
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
        
        <label for="JenisKelamin">Jenis Kelamin:</label>
        <input type="radio" id="JenisKelaminPria" name="JenisKelamin" value="1" <?php echo ($row['JenisKelamin'] == '1') ? 'checked' : ''; ?>> Pria
        <input type="radio" id="JenisKelaminWanita" name="JenisKelamin" value="0" <?php echo ($row['JenisKelamin'] == '0') ? 'checked' : ''; ?>> Wanita
        
        <label for="tanggallahir">Tanggal Lahir:</label>
        <input type="date" id="tanggallahir" name="tanggallahir" value="<?php echo htmlspecialchars($row['tanggallahir']); ?>" required>
        
        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($row['alamat']); ?>" required>
        
        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto">
        <input type="hidden" name="foto" value="<?php echo htmlspecialchars($row['foto']); ?>">
        
        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>
