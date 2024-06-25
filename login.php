<?php 

@include 'config.php';

session_start();

if(isset($_POST['submit'])){
  $filter_email=filter_var($_POST['email'],FILTER_SANITIZE_STRING);
  $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      
    $row = mysqli_fetch_assoc($select_users);

    if($row['user_type'] == 'admin'){

       $_SESSION['admin_name'] = $row['name'];
       $_SESSION['admin_email'] = $row['email'];
       $_SESSION['admin_id'] = $row['id'];
       header('location:admin_page.php');

    }elseif($row['user_type'] == 'user'){

       $_SESSION['user_name'] = $row['name'];
       $_SESSION['user_email'] = $row['email'];
       $_SESSION['user_id'] = $row['id'];
       header('location:home.php');

    }else{
       $message[] = 'no user found!';
    }

 }else{
    $message[] = 'incorrect email or password!';
 }

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page-The Siya Fashion</title>
  <link rel="stylesheet" href="styleU-L.css">
  <link rel="shortcut icon" href="logo.png" type="image/x-icon">

</head>
<body>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message" id="error" >
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
  
  <div class="container">
    <h1 class="login_header">Login</h1>
    
    <form action="" method="post" class="form">
      <input type="text" name="email" placeholder="username">
      <input type="password" name="pass" placeholder="password">
      <button class="btn" name="submit" >Login</button><br><br>
      <!-- <div class="forgot">
      <a href="forgot_password.php" id="forgot" class="footer_link">Forgot Password?</a>
      </div> -->
      <div class="bottom">
        <p class="footer_text">You have not registered yet?</p><a href="register.php" class="footer_link">create an account</a>
      </div>
    </form>
  </div>
  
</body>
</html>