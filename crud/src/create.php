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

  if (isset($_POST['submit'])) {
    $npm = $_POST['npm'];
    $name = $_POST['name'];
    $JenisKelamin = $_POST['JenisKelamin'];
    $tanggallahir = $_POST['tanggallahir'];
    $alamat = $_POST['alamat'];

    $target_dir = "uploads/";
    $target_file = $target_dir  . generateRandomString() . basename($_FILES["foto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["foto"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }

    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    if ($_FILES["foto"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    } else {
      if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["foto"]["name"])). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }

    $sql = "INSERT INTO `mahasiswa` (npm, name, JenisKelamin, tanggallahir, alamat, foto) VALUES ('$npm', '$name', '$JenisKelamin', '$tanggallahir', '$alamat', '$target_file')";
    $result = mysqli_query($con, $sql);

    if ($result) {
        header('location:index.php');
    }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Crud</title>
    <link href="./output.css" rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
      rel="stylesheet"
    />
  </head>
  <body class="bg-gray-100 text-gray-900 antialiased">
    <form
      class="mx-outo my-32 max-w-3xl px-4"
      method="post"
      enctype="multipart/form-data"
    >
      <h1 class="text-3xl font-semibold">Pendaftaran</h1>
      <p class="text-gray-600">Masukkan data diri dengan benar.</p>
      <br />
      <div class="flex space-x-4">
        <div>
          <label for="npm">NPM</label><br />
          <input
            required
            pattern="\d{10}"
            minlength="10"
            maxlength="10"
            placeholder="Masukkan NPM"
            class="full block rounded border border-gray-400 px-4 py-2 placeholder-gray-400 focus:border-teal-500 focus:outline-none"
            type="text"
            id="npm"
            name="npm"
          />
        </div>
        <div>
          <label for="name">Nama</label><br />
          <input
            placeholder="Masukkan Nama"
            required
            pattern="[A-Za-z\s]+"
            minlength="5"
            maxlength="128"
            class="full block rounded border border-gray-400 px-4 py-2 placeholder-gray-400 focus:border-teal-500 focus:outline-none"
            type="text"
            id="name"
            name="name"
          /><br />
        </div>
      </div>

      <label for="alamat">Alamat</label><br />
      <textarea
        rows="4" 
        cols="50"
        placeholder="Masukkan Alamat"
        class="block w-1/2 rounded border border-gray-400 px-4 py-2 placeholder-gray-400 focus:border-teal-500 focus:outline-none"
        id="alamat"
        name="alamat"
      ></textarea>

      <label for="JenisKelaminPria">Jenis Kelamin Pria</label><br />
      <input
        type="radio"
        id="JenisKelaminPria"
        name="JenisKelamin"
        value="1"
        required
      /><br />
      <label for="JenisKelaminWanita">Jenis Kelamin Wanita</label><br />
      <input
        type="radio"
        id="JenisKelaminWanita"
        name="JenisKelamin"
        value="0"
        required
      /><br />
      <label for="tanggallahir">Tanggal Lahir</label><br />
      <input
        class="rounded border border-gray-400 px-4 py-2 focus:border-teal-500 focus:outline-none"
        type="date"
        id="tanggallahir"
        name="tanggallahir"
        required
        max="<?php echo date('Y-m-d'); ?>"
      /><br />

      <label for="foto">Foto:</label><br />
      <input 
      type="file" 
      id="foto" 
      name="foto"
      required
      accept="image/*" 
      /><br />
      <br />
      <button
        class="rounded border border-blue-700 bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700"
        name="submit"
        type="submit"
      >
        kirim
      </button>
    </form>
  </body>
</html>
