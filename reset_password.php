<?php
session_start();

if (isset($_GET['token'])) {
    $token = $_GET['token']; // Fetching token from URL

    $conn = new mysqli("localhost", "root", "", "shop_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $tokenFromURL = $conn->real_escape_string($token);

    $sql = "SELECT * FROM password_reset_tokens WHERE token = '$tokenFromURL'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Token is found in the database, display the password reset form
        // Fetch other details as needed
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <!-- Head content -->
        </head>
        <body>
            <div class="container">
                <h1 class="reset_header">Reset Password</h1>
                <form action="process_reset.php" method="post" class="form">
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <input type="password" name="new_password" placeholder="Enter new password">
                    <button class="btn" name="submit">Reset Password</button><br><br>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        // Token is not found in the database, display an error message
        echo "Invalid token. Please try again or request a new password reset.";
    }

    $conn->close();
} else {
    echo "Token not found.";
}
?>
