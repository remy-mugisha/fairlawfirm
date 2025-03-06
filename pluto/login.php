<?php
session_start();

// Use the existing config file for database connection
require_once 'propertyMgt/config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    // Prepare a parameterized query to prevent SQL injection
    $stmt = mysqli_prepare($data, "SELECT * FROM login WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    
    try {
        // Execute the query
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        // Verify password 
        if ($user) {
            // Here you would typically use password_verify() with hashed passwords
            // For now, we'll do a simple comparison (IMPORTANT: use password hashing in production!)
            if ($password === $user['password']) {
                // Start session and store user type
                $_SESSION['user_type'] = $user['usertype'];
                $_SESSION['email'] = $user['email'];

                // Redirect based on user type
                if ($user['usertype'] == 'admin') {
                    header("Location: admin_dashboard.php");
                    exit();
                } elseif ($user['usertype'] == 'user') {
                    header("Location: user_dashboard.php");
                    exit();
                }
            } else {
                $error_message = "Invalid email or password";
            }
        } else {
            $error_message = "User not found";
        }
    } catch (Exception $e) {
        $error_message = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fair Law Firm - Login</title>
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
                        <?php 
                        // Display error message if exists
                        if (!empty($error_message)) : ?>
                            <div class="alert alert-danger">
                                <?php echo htmlspecialchars($error_message); ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <fieldset>
                                <div class="field">
                                    <label class="label_field">Email</label>
                                    <input type="email" name="email" placeholder="Email" required />
                                </div>
                                <div class="field">
                                    <label class="label_field">Password</label>
                                    <input type="password" name="password" placeholder="Password" required />
                                </div>
                                <div class="field">
                                    <label class="form-check-label">
                                    <input type="checkbox" name="remember" class="form-check-input"> Remember Me
                                    </label>
                                    <a class="forgot" href="#">Forgotten Password?</a>
                                </div>
                                <div class="field margin_0">
                                    <button type="submit" class="main_bt">Login</button>
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