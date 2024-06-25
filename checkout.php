<?php
// Include your config and start session
@include 'config.php';

session_start();

// Redirect to login if user is not logged in
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
}



// Check if the order form is submitted
if (isset($_POST['order'])) {
    // Retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code']);
    $placed_on = date('d-M-Y');

    // Retrieve cart items and total
    $cart_total = 0;
    $cart_products = [];

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ', $cart_products);

    // Check if order already exists
    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

    // Handle different scenarios
    if ($cart_total == 0) {
        $message[] = 'Your cart is empty!';
    } elseif (mysqli_num_rows($order_query) > 0) {
        $message[] = 'Order already placed!';
    } else {
        // Insert order into database
        mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        $message[] = 'Order placed successfully!';
    
        
     
    
}}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout-The Siya Fashion</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="logo.png" type="image/x-icon">

</head>

<style>
    
</style>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>checkout </h3>
   
</section>

<section class="display-order" style=" background:#d2bab6; width:100%;" >
    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
    ?>    
    <p  > <?php echo $fetch_cart['name'] ?> <span>(<?php echo 'Rs. '.$fetch_cart['price'].'/-'.' x '.$fetch_cart['quantity']  ?>)</span> </p><br>
    <?php
        }
        }else{
            echo '<p class="empty">your cart is empty</p>';
        }
    ?>
    <div class="grand-total">Total : <span>Rs. <?php echo $grand_total; ?>/-</span></div>
</section>

<section class="checkout" >

    <form action="" method="POST">

        <h3>place order</h3>

        <div class="flex">
            <div class="inputBox">
                <span>Name :</span>
                <input type="text" name="name" placeholder="Enter your name">
            </div>
            <div class="inputBox">
                <span>Number :</span>
                <input type="number" name="number" min="0" placeholder="Enter your number">
            </div>
            <div class="inputBox">
                <span>Email :</span>
                <input type="email" name="email" placeholder="Enter your email">
            </div>
            <div class="inputBox">
                <span>Payment :</span>
                <select name="method">
                    <option value="cash on delivery">cash on delivery</option>
                    <option value="credit card">credit card</option>
                    <option value="paypal">paypal</option>
                    <option value="paytm">paytm</option>
                </select>
            </div>
            <div class="inputBox">
                <span>Address line 01 :</span>
                <input type="text" name="flat" placeholder="flat no.">
            </div>
            <div class="inputBox">
                <span>Address line 02 :</span>
                <input type="text" name="street" placeholder="street name">
            </div>
            <div class="inputBox">
                <span>City :</span>
                <input type="text" name="city" placeholder="Surat">
            </div>
            <div class="inputBox">
                <span>State :</span>
                <input type="text" name="state" placeholder="Gujarat">
            </div>
            
            <div class="inputBox">
                <span>Pin code :</span>
                <input type="number" min="0" name="pin_code" placeholder="395008   ">
            </div>
            <div class="inputBox">
                <span>Country :</span>
                <input type="text" name="country" placeholder="India">
            </div>
        </div>

        <input type="submit" name="order" value="order now" class="btn" style="width: 120px;" >

    </form>

</section>






<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>