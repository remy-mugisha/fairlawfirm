<?php
session_start();

require_once 'propertyMgt/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    try {
        // Query login table for authentication
        $stmt = $conn->prepare("SELECT l.*, u.first_name, u.last_name, u.profile_image, u.status 
                               FROM login l
                               LEFT JOIN users u ON l.email = u.email
                               WHERE l.email = :email");
        $stmt->bindParam(':email', $email);
        
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Check user status
            if (isset($user['status']) && $user['status'] !== 'Active') {
                $error_message = "Your account is not active yet. Please contact the administrator.";
            } 
            // Verify password
            else if (password_verify($password, $user['password'])) {
                $_SESSION['user_type'] = $user['usertype'];
                $_SESSION['email'] = $user['email'];
                
                // Store additional user information
                if (isset($user['first_name'])) {
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['profile_image'] = $user['profile_image'];
                }

                if ($user['usertype'] == 'admin') {
                    header("Location: dashboard.php");
                    exit();
                } elseif ($user['usertype'] == 'user') {
                    header("Location: dashboard.php");
                    exit();
                }
            } else {
                $error_message = "Invalid email or password";
            }
        } else {
            $error_message = "User not found";
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
                        
                        <?php 
                        // Display success message if exists
                        if (!empty($_SESSION['success_message'])) : ?>
                            <div class="alert alert-success">
                                <?php 
                                echo htmlspecialchars($_SESSION['success_message']); 
                                unset($_SESSION['success_message']);
                                ?>
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