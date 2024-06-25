<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About Us - The Siya Fashion</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="logo.png" type="image/x-icon">

   <style>
      /* Common styles */
      body {
         font-family: Arial, sans-serif;
         line-height: 1.6;
         margin: 0;
         padding: 0;
         background: #DEB3AD;
      }

      .container {
         max-width: 100%;
         background:#d2bab6;
         margin: 0 auto;
         padding: 20px;
         text-align: center;
         display: flex;
         flex-direction: column;
         justify-content: center;
         align-items: center;
         height: 100vh;
      }

      .logo img {
         max-width: 200px;
         height: auto;
         margin-bottom: 20px;
      }

      p {
         font-size: 18px;
         text-align: justify;
         margin: 0 25px 20px;
         color: #333;
         line-height: 1.8;
      }

      span {
         color: #000;
         font-size: 20px;
         font-family: 'Times New Roman', Times, serif;
         font-weight: 500;
      }

      /* Box styles */
      .content-box {
         background-color: #fff;
         border: 1px solid #ccc;
         border-radius: 5px;
         padding: 20px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      @media (max-width: 600px) {
         .logo img {
            max-width: 150px;
            margin-bottom: 10px;
            margin-top:100px;
         }}
   </style>
</head>
<body>
   <?php @include 'header.php'; ?>

   <section class="heading">
      <h3 class="h3">about us</h3>
   </section>

   <div class="container">
      <div class="logo">
         <img src="logo.png" alt="The Siya Fashion Logo">
      </div>

      <p class="content-box">
      Welcome to <span>The Siya Fashion</span>, your go-to destination for quality products and personalized service. 
         At <span>The Siya Fashion</span>, we believe in simplicity and community. Browse through our thoughtfully curated 
         selection of handpicked items, carefully chosen with you in mind. Our user-friendly platform allows you to effortlessly discover,
          view, and purchase products, ensuring a convenient and enjoyable shopping experience. Whether you're looking for everyday essentials 
          or unique finds, we're here to cater to your needs. Thank you for supporting our small business; 
         we appreciate every order and look forward to serving you with a personal touch. <br><br>Thank You.<br><span> <b>The siya Fashion</b></span>
         
         <!-- Rest of your content -->
      </p>
   </div>
</body>


<script src="js/script.js"></script>
</html>
