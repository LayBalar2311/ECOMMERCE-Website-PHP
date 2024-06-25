<?php
// Include your database connection and necessary configurations
@include 'config.php';// Path to Composer autoload.php


if (isset($_POST['submit'])) {
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($conn, $filter_email);

    // Check if the email exists in the database
    $check_email = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($check_email) > 0) {
        // Email exists, generate a new password
        $new_password = generateRandomString(); // Function to generate a random password
        $hashed_password = md5($new_password); // Hash the new password

        // Update the user's password in the database
        $update_password = mysqli_query($conn, "UPDATE `users` SET password = '$hashed_password' WHERE email = '$email'");

        if ($update_password) {
            // Send the new password to the user's email
            $to = $email;
            $subject = "Password Reset";
            $message = "Your new password is: $new_password";

            // Gmail SMTP configuration
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->Username = 'laybalar189@gmail.com'; // Replace with your Gmail email address
            $mail->Password = 'rvyr rncy yrbf eshw'; // Replace with your Gmail password

            $mail->SetFrom('laybalar189@gmail.com@gmail.com', 'The Siya Fashion'); // Replace with your name
            $mail->AddAddress($to);

            $mail->Subject = $subject;
            $mail->Body = $message;

            if ($mail->Send()) {
                $success_message = 'New password has been sent to your email.';
            } else {
                $error_message = 'Failed to send the new password. Please contact support.';
            }
        } else {
            $error_message = 'Failed to update password. Please try again later.';
        }
    } else {
        $error_message = 'Email not found in our records.';
    }
}

function generateRandomString($length = 8)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $char_length = strlen($characters);
    $random_string = '';

    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, $char_length - 1)];
    }

    return $random_string;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head content -->
</head>

<body>
    <!-- Your HTML content -->

    <?php if (isset($error_message)) : ?>
        <div class="message" id="error">
            <span><?php echo $error_message; ?></span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
    <?php elseif (isset($success_message)) : ?>
        <div class="message" id="success">
            <span><?php echo $success_message; ?></span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
    <?php endif; ?>

    <div class="container">
        <h1 class="login_header">Forgot Password</h1>
        <form action="" method="post" class="form">
            <input type="text" name="email" placeholder="Enter your email">
            <button class="btn" name="submit">Reset Password</button><br><br>
        </form>
    </div>

    <!-- Your HTML content -->

</body>

</html>
