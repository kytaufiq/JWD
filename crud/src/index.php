<?php
  require 'connect.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CRUD</title>
    <link rel="stylesheet" href="./output.css" />
  </head>
  <body>
    <h2>Tabel</h2>
    <table>
      <tr>
        <th>NPM</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Tanggal Lahir</th>
        <th>Alamat</th>
        <th>Foto</th>
      </tr>
      <?php
        $sql = "SELECT id, npm, name, JenisKelamin, tanggallahir, alamat, foto FROM `mahasiswa`";
        $result = mysqli_query($con, $sql);

        if ($result) {
          while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $npm = $row['npm'];
            $name = $row['name'];
            $JenisKelamin = $row['JenisKelamin'];
            $tanggallahir = $row['tanggallahir'];
            $alamat = $row['alamat'];
            $foto = $row['foto'];
            echo '<tr>';
            echo "<th scope=\"row\">$id</th>";
            echo "<td>$npm</td>";
            echo "<td>$name</td>";
            
            if ($JenisKelamin == 1) {
              echo "<td>Pria</td>";
            }
            else {
              echo "<td>Wanita</td>";
            }

            echo "<td>$tanggallahir</td>";
            echo "<td>$alamat</td>";
            echo '<td> <img src="'.$foto.'" width="240" height="240"> </td>'.
            '<td>
            <button><a href="update.php?userId='.$id.'">Update</a></button>
            <button><a href="delete.php?userId='.$id.'">Delete</a></button>
            </td>'.
            '</tr>';
          }
        }
      ?>
    </table>
  </body>
</html>