<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_wishlist'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_image = $_POST['product_image'];
   
   $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_wishlist_numbers) > 0){
       $message[] = 'already added to wishlist';
   }elseif(mysqli_num_rows($check_cart_numbers) > 0){
       $message[] = 'already added to cart';
   }else{
       mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
       $message[] = 'product added to wishlist';
   }

}

if(isset($_POST['add_to_cart'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_image = $_POST['product_image'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
       $message[] = 'already added to cart';
   }else{

       $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

       if(mysqli_num_rows($check_wishlist_numbers) > 0){
           mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
       }

       mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
       $message[] = 'product added to cart';
   }

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home-The Siya Fashion</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <link rel="shortcut icon" href="logo.png" type="image/x-icon">

   <!-- Add these links to your existing head section -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

</head>
<body>
   
<?php @include 'header.php'; ?>


<section class="home" id="ani" style="  background-image: url('images/background.jpg');" >
    <div class="content">
        <h3>The Siya Fashion</h3>
        <p>New Collection Everyday!!</p>
    </div>
</section>


<section class="products" style="" >

   <h1 class="title">Products</h1>

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
<a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="product-link">
   <div class="product-card">
      <div class="product-image-container">
         <div class="overlay">
            <div class="overlay-content">
               <div class="product-name"><?php echo $fetch_products['name']; ?></div>
               <div class="product-price"> Rs.<?php echo $fetch_products['price']; ?>/-</div>
            </div>
         </div>
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="product-image">
      </div>
   </div>
</a>     
 <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   </div>

  
</section>


<div class="slideshow-container"  >



<div class="mySlides fade">
  <img src="The siya fashion s.png" style="width:100%">
  <div class="text"> </div>
</div>
<div class="mySlides fade">
  <img src="com.png" style="width:100%">
  <div class="text"> </div>
</div>

</div>
<br>

<div style="text-align:center; "  >
  <span class="dot"></span> 
  <span class="dot"></span> 
 
</div>   


<section class="icons-fe">
   <div class="icon-container">
      <img src="delivery.png" alt="">
      <span>Free Delivery</span> <br>
      <p> On Order Above 5000 Rupee Only</p>
   </div>
   <div class="icon-container">
      <img src="distribution.png" alt="">
      <span>Easy Return</span> <br>
       <p>7-Days Return policy</p>
   </div>
   <div class="icon-container">
      <img src="cash-on-delivery.png" alt="">
      <span>COD</span> <br>
     <p> Cash on Delivery available </p>
   </div>
</section>

<section class="home-contact">

   <div class="content_">
      <h3>Connect with us</h3>
      <p>Send us...  reviews, complaints, and suggestions.</p>
      <a href="contact.php" class="btn">contact us</a>
   </div>

</section>




<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>