<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'propertyMgt/config.php';

date_default_timezone_set('UTC');

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
    echo "Table creation error: " . $e->getMessage();
}

$token = isset($_GET['token']) ? $_GET['token'] : null;
$valid_token = false;

if ($token) {
    try {
        $stmt = $conn->prepare("SELECT * FROM password_reset WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $reset_data = $stmt->fetch(PDO::FETCH_ASSOC);
            $expiry = strtotime($reset_data['expiry']);
            $current_time = time();
            
            if ($expiry > $current_time) {
                $valid_token = true;
                $email = $reset_data['email'];
            }
        }
    } catch (PDOException $e) {
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['token'])) {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    try {
        $stmt = $conn->prepare("SELECT * FROM password_reset WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $reset_data = $stmt->fetch(PDO::FETCH_ASSOC);
            $expiry = strtotime($reset_data['expiry']);
            $current_time = time();
            
            if ($expiry > $current_time) {
                $email = $reset_data['email'];
                
                if ($new_password === $confirm_password) {
                    if (strlen($new_password) >= 8) {
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                        
                        $updateStmt = $conn->prepare("UPDATE login SET password = :password WHERE email = :email");
                        $updateStmt->bindParam(':password', $hashed_password);
                        $updateStmt->bindParam(':email', $email);
                        $updateStmt->execute();
                        
                        $deleteStmt = $conn->prepare("DELETE FROM password_reset WHERE token = :token");
                        $deleteStmt->bindParam(':token', $token);
                        $deleteStmt->execute();
                        
                        $_SESSION['success_message'] = "Your password has been reset successfully. You can now login with your new password.";
                        header("Location: index");
                        exit();
                    } else {
                        $error_message = "Password must be at least 8 characters long.";
                    }
                } else {
                    $error_message = "Passwords do not match.";
                }
            } else {
                $error_message = "Invalid or expired token.";
            }
        } else {
            $error_message = "Invalid or expired token.";
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
    <title>Fair Law Firm - Reset Password</title>
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
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .login-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 30px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h2 {
            color: var(--primary-color);
            font-weight: 700;
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
        
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
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
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <!-- <a href="welcome"> -->
                    <img src="propertyMgt/logoImg/logo-0-0-0.png" alt="firdip HTML" height="60" width="200">
                <!-- </a> -->
                <!-- <h2>Fair Law Firm</h2> -->
            </div>
            
            <?php if (!empty($error_message)) : ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($valid_token) : ?>
                <!-- <h3 class="text-center">Reset Password</h3> -->
                <!-- <p class="info-text">Enter your new password below.</p> -->
                
                <form method="POST" action="">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" required minlength="8">
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required minlength="8">
                    </div>
                    
                    <button type="submit" class="btn btn-login mt-3">Reset Password</button>
                    
                    <div class="text-center mt-3">
                        <a href="index" class="forgot-password">Back to Login</a>
                    </div>
                </form>
            <?php else : ?>
                <div class="alert alert-danger">
                    Invalid or expired password reset link. Please request a new password reset.
                </div>
                
                <a href="forgot_password.php" class="btn btn-login">Request New Reset Link</a>
                
                <div class="text-center mt-3">
                    <a href="index" class="forgot-password">Back to Login</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>