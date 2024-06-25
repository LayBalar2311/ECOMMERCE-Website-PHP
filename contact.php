<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['send'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

    if(mysqli_num_rows($select_message) > 0){
        $message[] = 'message sent already!';
    }else{
        mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
        $message[] = 'message sent successfully!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact-The Siya Fashion</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="shortcut icon" href="logo.png" type="image/x-icon">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>contact us</h3>

</section>


<section class="content-wrapper">

    <section class="contact-info">
        <h2>Do you have any questions?</h2>
        <p>Incase of any queries or doubts regarding your order, please reach out at laybalar189@gmail.com or 9099312442 (available from 9:00am to 6:00pm, Monday to Friday on Whatsapp) for any information or inquiries. You can also fill the contact form.</p>
    </section>

    <section class="contact-form" style="background:#d2bab6;">
        <form action="" method="POST">
            
            <input type="text" name="name" placeholder="Enter your name" class="box" required> 
            <input type="email" name="email" placeholder="Enter your email" class="box" required>
            <input type="number" name="number" placeholder="Enter your number" class="box" required>
            <textarea name="message" class="box" placeholder="Enter your message" required cols="30" rows="10"></textarea>
            <input type="submit" value="send" name="send" class="btn">
        </form>
    </section>

</section>




<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>