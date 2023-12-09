<?php
require 'config.php';
if(!empty($_SESSION["id"])){
  $id = $_SESSION["id"];
  $result = mysqli_query($conn, "SELECT * FROM admin WHERE id_admin = $id");
  $row = mysqli_fetch_assoc($result);
}
else{
  header("Location: login.php");
}
if(isset($_POST["submit"])){
  $password_lama = $_POST["password_lama"];
  $password_baru = $_POST["password_baru"];
  $konfirmasi_password = $_POST["konfirmasi_password"];
  $id_admin = $_SESSION["id"];
  $result2 = mysqli_query($conn, "SELECT * FROM admin WHERE id_admin = '$id_admin'");
  $row = mysqli_fetch_assoc($result2);
  $key="SIPALINGRAMA";
  $decrypted_string=openssl_decrypt($row['password_hash'],"AES-128-ECB",$key);
  if(mysqli_num_rows($result2) > 0){
    if($password_lama == $decrypted_string){
      if($password_baru == $konfirmasi_password){
        $key="SIPALINGRAMA";
        $encrypted_string=openssl_encrypt($password_baru,"AES-128-ECB",$key);
        $id_admin = $_SESSION["id"];
        $query = "UPDATE admin SET password_hash = '$encrypted_string' WHERE id_admin = '$id_admin'";
        mysqli_query($conn, $query);
        echo
        "<script> alert('Change Password Successful'); </script>";
      }else{
        echo
        "<script> alert('Password Does Not Match'); </script>";
      }
    }else{
      echo
      "<script> alert('Password saat ini salah!'); </script>";
    }
  }

}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>CHANGE PASSWORD</title>
  </head>
  <body>
  <h1>Welcome <?php echo $row["nama_admin"]; ?></h1>
    <h2>CHANGE PASSWORD</h2>
    <form class="" action="" method="post" autocomplete="off">
      <label for="password_lama">Password saat ini : </label>
      <input type="password_lama" name="password_lama" id = "password_lama" required value=""> <br>
      <label for="password_baru">Password baru : </label>
      <input type="password_baru" name="password_baru" id = "password_baru" required value=""> <br>
      <label for="konfirmasi_password">Confirm Password : </label>
      <input type="konfirmasi_password" name="konfirmasi_password" id = "konfirmasi_password" required value=""> <br>
      <button type="submit" name="submit">Change Password</button>
    </form>
    <br>
    <a href="index.php">Home</a>
  </body>
</html>