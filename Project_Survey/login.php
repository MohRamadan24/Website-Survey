<?php
require 'config.php';
if(!empty($_SESSION["id"])){
  header("Location: index.php");
}
if(isset($_POST["submit"])){
  $nama = $_POST["nama"];
  $password = $_POST["password"];
  $result = mysqli_query($conn, "SELECT * FROM admin WHERE nama_admin = '$nama'");
  $row = mysqli_fetch_assoc($result);
  $key="SIPALINGRAMA";
  $decrypted_string=openssl_decrypt($row['password_hash'],"AES-128-ECB",$key);
  if(mysqli_num_rows($result) > 0){
    if($password == $decrypted_string){
      $_SESSION["login"] = true;
      $_SESSION["id"] = $row["id_admin"];
      header("Location: index.php");
    }
    else{
      echo
      "<script> alert('Wrong Password'); </script>";
    }
  }
  else{
    echo
    "<script> alert('User Not Registered'); </script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <h2>Login</h2>
    <form class="" action="" method="post" autocomplete="off">
      <label for="nama">Nama : </label>
      <input type="text" name="nama" id = "nama" required value=""> <br>
      <label for="password">Password : </label>
      <input type="password" name="password" id = "password" required value=""> <br>
      <button type="submit" name="submit">Login</button>
    </form>
    <br>
    <a href="registration.php">Registration</a>
  </body>
</html>
