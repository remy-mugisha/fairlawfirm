<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'propertyMgt/config.php';

// Set timezone
date_default_timezone_set('UTC');

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
    echo "Table creation error: " . $e->getMessage();
}

$token = isset($_GET['token']) ? $_GET['token'] : null;
$valid_token = false;

if ($token) {
    try {
        // Fetch the token regardless of expiry
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
        // Handle database error silently in production
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['token'])) {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    try {
        // Verify token again
        $stmt = $conn->prepare("SELECT * FROM password_reset WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $reset_data = $stmt->fetch(PDO::FETCH_ASSOC);
            $expiry = strtotime($reset_data['expiry']);
            $current_time = time();
            
            if ($expiry > $current_time) {
                $email = $reset_data['email'];
                
                // Validate passwords
                if ($new_password === $confirm_password) {
                    if (strlen($new_password) >= 8) {
                        // Hash the new password
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                        
                        // Update the password in the database
                        $updateStmt = $conn->prepare("UPDATE login SET password = :password WHERE email = :email");
                        $updateStmt->bindParam(':password', $hashed_password);
                        $updateStmt->bindParam(':email', $email);
                        $updateStmt->execute();
                        
                        // Delete the used token
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fair Law Firm - Reset Password</title>
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
                        
                        <?php if ($valid_token) : ?>
                            <h3>Reset Password</h3>
                            <p>Enter your new password below.</p>
                            
                            <form method="POST" action="">
                                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                                <fieldset>
                                    <div class="field">
                                        <label class="label_field">New Password</label>
                                        <input type="password" name="new_password" placeholder="Enter new password" required minlength="8" />
                                    </div>
                                    <div class="field">
                                        <label class="label_field">Confirm Password</label>
                                        <input type="password" name="confirm_password" placeholder="Confirm new password" required minlength="8" />
                                    </div>
                                    <div class="field margin_0">
                                        <button type="submit" class="main_bt">Reset Password</button>
                                    </div>
                                </fieldset>
                            </form>
                        <?php else : ?>
                            <div class="alert alert-danger">
                                Invalid or expired password reset link. Please request a new password reset.
                            </div>
                            <div class="field margin_top_15">
                                <a href="forgot_password.php" class="main_bt">Request New Reset Link</a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="field margin_top_15">
                            <a href="index">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>