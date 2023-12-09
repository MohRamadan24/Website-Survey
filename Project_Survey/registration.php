<?php
require 'config.php';
if(!empty($_SESSION["id"])){
  header("Location: index.php");
}
if(isset($_POST["submit"])){
  $keyword = $_POST["keyword"];
  $name = $_POST["name"];
  $password = $_POST["password"];
  $confirmpassword = $_POST["confirmpassword"];
  $duplicate = mysqli_query($conn, "SELECT * FROM admin WHERE nama_admin = '$name'");
  if($keyword == "SIPALINGRAMA"){
    if(mysqli_num_rows($duplicate) > 0){
      echo
      "<script> alert('Nama telah dipakai, silahkan menggunakan nama lain.'); </script>";
    }
    else{
      $key="SIPALINGRAMA";
      $encrypted_string=openssl_encrypt($password,"AES-128-ECB",$key);
    
      if($password == $confirmpassword){
        $query = "INSERT INTO admin VALUES('','$name',0,'$encrypted_string',1,'')";
        mysqli_query($conn, $query);
        echo
        "<script> alert('Registration Successful'); </script>";
      }
      else{
        echo 
        "<script> alert('Password Does Not Match'); </script>";
      }
    }
  }else {
    echo 
        "<script> alert('Keyword salah!'); </script>";
  }

}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Registration</title>
  </head>
  <body>
    <h2>Registration</h2>
    <form class="" action="" method="post" autocomplete="off">
      <label for="name">Keyword : </label>
      <input type="text" name="keyword" id = "keyword" required value=""> <br>
      <label for="name">Name : </label>
      <input type="text" name="name" id = "name" required value=""> <br>
      <label for="password">Password : </label>
      <input type="password" name="password" id = "password" required value=""> <br>
      <label for="confirmpassword">Confirm Password : </label>
      <input type="password" name="confirmpassword" id = "confirmpassword" required value=""> <br>
      <button type="submit" name="submit">Register</button>
    </form>
    <br>
    <a href="login.php">Login</a>
  </body>
</html>