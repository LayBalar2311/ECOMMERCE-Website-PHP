<?php

@include 'config.php';

// Initialize an empty array for messages
$message = [];

if(isset($_POST['submit'])){

   $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $name = mysqli_real_escape_string($conn, $filter_name);
   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));
   $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
   $cpass = mysqli_real_escape_string($conn, md5($filter_cpass));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'User already exists!';
   } else {
      if($pass != $cpass){
         $message[] = 'Confirm password not matched!';
      } else {
         mysqli_query($conn, "INSERT INTO `users` (name, email, password) VALUES ('$name', '$email', '$pass')") or die('query failed');
         $message[] = 'Registered successfully!';
         header('location: login.php');
         exit(); // Ensure no more code is executed after the redirect
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Page-The Siya Fashion</title>
  <link rel="stylesheet" href="styleU-R.css">
  <link rel="shortcut icon" href="logo.png" type="image/x-icon">
</head>
<body>

<?php
if(isset($message)){
  foreach($message as $message){
    echo '
    <div class="message">
      <span>'.$message.'</span>
      <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>
    ';
  }
}
?>
  
  <div class="container">
    <h1 class="login_header">Registration</h1>
    <form action="" method="post" class="form">
      <input type="text" name="name" placeholder="Username">
      <input type="text" name="email" placeholder="Email"> <!-- Added email input -->
      <input type="password" name="pass" placeholder="Password">
      <input type="password" name="cpass" placeholder="Confirm Password">
      <button type="submit" name="submit" class="btn">Register</button>
      <div class="bottom">
        <p class="footer_text">Already have an account?</p><a href="login.php" class="footer_link">Login</a>
      </div>
    </form>
  </div>
  
</body>
</html>
