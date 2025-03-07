<?php
// forgot_password.php - The form where users request a password reset
session_start();
require_once 'propertyMgt/config.php';

// Create password_reset table if it doesn't exist
try {
    $conn->exec("
        CREATE TABLE IF NOT EXISTS password_reset (
            email VARCHAR(255) PRIMARY KEY,
            token VARCHAR(255) NOT NULL,
            expiry DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
} catch (PDOException $e) {
    // Silently continue if there's an error, we'll catch it later if needed
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    
    try {
        // Check if email exists in the database
        $stmt = $conn->prepare("SELECT * FROM login WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            // Generate a unique token
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expires in 1 hour
            
            // Store the token in the database
            $resetStmt = $conn->prepare("INSERT INTO password_reset (email, token, expiry) VALUES (:email, :token, :expiry) ON DUPLICATE KEY UPDATE token = :token, expiry = :expiry");
            $resetStmt->bindParam(':email', $email);
            $resetStmt->bindParam(':token', $token);
            $resetStmt->bindParam(':expiry', $expiry);
            $resetStmt->execute();
            
            // Generate reset link
            $resetLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=" . $token;
            
            // For local development: redirect directly to reset_password.php
            if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
                header("Location: reset_password.php?token=" . $token);
                exit();
            } else {
                // This is for production - attempt to send email
                $to = $email;
                $subject = "Fair Law Firm - Password Reset";
                $message = "Hello,\n\n";
                $message .= "You have requested to reset your password. Please click the link below to reset your password:\n\n";
                $message .= $resetLink . "\n\n";
                $message .= "This link will expire in 1 hour.\n\n";
                $message .= "If you did not request this password reset, please ignore this email.\n\n";
                $message .= "Regards,\nFair Law Firm";
                $headers = "From: noreply@fairlawfirm.com";
                
                if (mail($to, $subject, $message, $headers)) {
                    $_SESSION['success_message'] = "Password reset instructions have been sent to your email.";
                    header("Location: index");
                    exit();
                } else {
                    $error_message = "Failed to send email. Please try again later or contact support.";
                }
            }
        } else {
            // Don't reveal that the email doesn't exist for security reasons
            // For local development, we'll be more informative
            if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
                $error_message = "Email not found in database. For testing, please use an email that exists in your login table.";
            } else {
                $_SESSION['success_message'] = "If your email exists in our system, you will receive password reset instructions.";
                header("Location: index");
                exit();
            }
        }
    } catch (PDOException $e) {
        $error_message = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fair Law Firm - Forgot Password</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="inner_page login">
    <div class="full_container">
        <div class="container">
            <div class="center verticle_center full_height">
                <div class="login_section">
                    <div class="logo_login">
                        <div class="center">
                            <h2 style="color: #fff;">Fair Law Firm</h2>
                        </div>
                    </div>
                    <div class="login_form">
                        <?php if (!empty($error_message)) : ?>
                            <div class="alert alert-danger">
                                <?php echo htmlspecialchars($error_message); ?>
                            </div>
                        <?php endif; ?>
                        
                        <h3>Forgot Password</h3>
                        <p>Enter your email address and we'll send you instructions to reset your password.</p>
                        
                        <form method="POST" action="">
                            <fieldset>
                                <div class="field">
                                    <label class="label_field">Email</label>
                                    <input type="email" name="email" placeholder="Enter your email" required />
                                </div>
                                <div class="field margin_0">
                                    <button type="submit" class="main_bt">Send Reset Link</button>
                                </div>
                                <div class="field margin_top_15">
                                    <a href="index">Back to Login</a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>