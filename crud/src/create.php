<?php
  require 'connect.php';

  function generateRandomString($length = 10) {
    // Karakter yang dapat digunakan
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    
    // Menghasilkan string acak
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

    // Check if image file is a actual image or fake image
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

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["foto"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["foto"]["name"])). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }

    $sql = "INSERT INTO `mahasiswa` (npm,name,JenisKelamin,tanggallahir,alamat,foto) VALUES('$npm','$name', '$JenisKelamin', '$tanggallahir', '$alamat','$target_file')";
    $result = mysqli_query($con, $sql);

    if ($result) {
        // echo 'Data inserted successfully';
        header('location:index.php');
    }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CRUD</title>
    <link rel="stylesheet" href="./output.css" />
  </head>
  <body class="flex min-h-screen items-center justify-center bg-gray-100">
    <form
      method="post"
      enctype="multipart/form-data"
      class="w-full max-w-md rounded bg-white p-8 shadow-md"
    >
      <h2 class="mb-6 text-center text-2xl font-bold">Form Data</h2>

      <div class="mb-4">
        <label for="npm" class="mb-2 block font-medium text-gray-700"
          >NPM</label
        >
        <input
          type="text"
          id="npm"
          name="npm"
          minlength="10"
          maxlength="10"
          pattern="\d{10}"
          required
          class="w-full rounded border border-gray-300 px-3 py-2"
        />
      </div>

      <div class="mb-4">
        <label for="name" class="mb-2 block font-medium text-gray-700"
          >Nama</label
        >
        <input
          type="text"
          id="name"
          name="name"
          minlength="5"
          maxlength="128"
          pattern="[A-Za-z]+"
          required
          class="w-full rounded border border-gray-300 px-3 py-2"
        />
      </div>

      <div class="mb-4">
        <label class="mb-2 block font-medium text-gray-700"
          >Jenis Kelamin</label
        >
        <div class="mb-2 flex items-center">
          <input
            type="radio"
            id="JenisKelaminPria"
            name="JenisKelamin"
            value="1"
            class="mr-2"
            required
          />
          <label for="JenisKelaminPria" class="text-gray-700">Pria</label>
        </div>
        <div class="flex items-center">
          <input
            type="radio"
            id="JenisKelaminWanita"
            name="JenisKelamin"
            value="0"
            class="mr-2"
            required
          />
          <label for="JenisKelaminWanita" class="text-gray-700">Wanita</label>
        </div>
      </div>

      <div class="mb-4">
        <label for="tanggallahir" class="mb-2 block font-medium text-gray-700"
          >Tanggal Lahir</label
        >
        <input
          type="date"
          id="tanggallahir"
          name="tanggallahir"
          required
          max="<?php echo date('Y-m-d'); ?>"
          class="w-full rounded border border-gray-300 px-3 py-2"
        />
      </div>

      <div class="mb-4">
        <label for="alamat" class="mb-2 block font-medium text-gray-700"
          >Alamat</label
        >
        <textarea 
          rows="4"
          cols="50"
          id="alamat"
          name="alamat"
          required
          class="w-full rounded border border-gray-300 px-3 py-2"
        ></textarea>
      </div>

      <div class="mb-4">
        <label for="foto" class="mb-2 block font-medium text-gray-700"
          >Foto</label
        >
        <input
          type="file"
          id="foto"
          name="foto"
          required
          accept="image/*"
          class="w-full rounded border border-gray-300 px-3 py-2"
        />
      </div>

      <button
        type="submit"
        name="submit"
        class="w-full rounded bg-blue-500 py-2 text-white hover:bg-blue-600"
      >
        Kirim
      </button>
    </form>
  </body>
</html>