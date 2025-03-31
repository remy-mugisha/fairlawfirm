<?php
session_start();
require_once 'propertyMgt/config.php';

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
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    
    try {
        $stmt = $conn->prepare("SELECT * FROM login WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); 
            $resetStmt = $conn->prepare("INSERT INTO password_reset (email, token, expiry) VALUES (:email, :token, :expiry) ON DUPLICATE KEY UPDATE token = :token, expiry = :expiry");
            $resetStmt->bindParam(':email', $email);
            $resetStmt->bindParam(':token', $token);
            $resetStmt->bindParam(':expiry', $expiry);
            $resetStmt->execute();
            
            $resetLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=" . $token;
            
            if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
                header("Location: reset_password.php?token=" . $token);
                exit();
            } else {
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
            $error_message = "The email address you entered is not registered. Please check your email or contact support.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fair Law Firm - Forgot Password</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        :root {
            --primary-color: rgb(247, 247, 247);
            --secondary-color: #3498db;
            --light-color: #ecf0f1;
        }
        
        body {
            background-color: var(--primary-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .logo-container {
            margin-bottom: 30px;
            text-align: center;
        }
        
        .login-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 30px;
        }
        
        .form-control {
            height: 45px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding-left: 15px;
        }
        
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: none;
        }
        
        .btn-login {
            background-color: var(--secondary-color);
            border: none;
            color: white;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        .forgot-password {
            color: var(--secondary-color);
            text-decoration: none;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .info-text {
            margin-bottom: 20px;
            color: #666;
            text-align: center;
        }
        
        @media (max-width: 576px) {
            .login-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Logo positioned above the login card -->
        <div class="logo-container">
            <img src="propertyMgt/logoImg/logo-0-0-0.png" alt="Fair Law Firm Logo" height="60" width="200">
        </div>
        
        <div class="login-card">
            <?php if (!empty($error_message)) : ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <!-- <h3 class="text-center">Forgot Password</h3> -->
            <p class="info-text">Enter your email address and we'll send you instructions to reset your password.</p>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <button type="submit" class="btn btn-login mt-3">Send Reset Link</button>
                
                <div class="text-center mt-3">
                    <a href="index" class="forgot-password">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
    
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>