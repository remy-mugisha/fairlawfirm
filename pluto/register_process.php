<?php
session_start();
require_once 'propertyMgt/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
    $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $gender = $_POST['gender'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $confirm_password = $_POST['confirm_password'];
    $role_id = filter_var($_POST['role_id'], FILTER_SANITIZE_NUMBER_INT);
    
    // Change default status to 'Active' so users appear immediately in the management panel
    $status = 'Active'; 
    
    // Determine user type based on role_id
    $usertype = ($role_id == 1) ? 'admin' : 'user';
    
    try {
        // Begin transaction
        $conn->beginTransaction();
        
        // Check if passwords match
        if ($_POST['password'] !== $confirm_password) {
            throw new Exception("Passwords do not match");
        }
        
        // Check if email already exists
        $stmt = $conn->prepare("SELECT email FROM login WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            throw new Exception("Email already exists");
        }
        
        // Handle file upload
        $profile_image = "";
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            
            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Generate unique filename
            $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $file_extension;
            $target_file = $upload_dir . $filename;
            
            // Check if file is an image
            $check = getimagesize($_FILES['profile_image']['tmp_name']);
            if ($check === false) {
                throw new Exception("File is not an image");
            }
            
            // Check file size (limit to 5MB)
            if ($_FILES['profile_image']['size'] > 5000000) {
                throw new Exception("File is too large (max 5MB)");
            }
            
            // Allow certain file formats
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array(strtolower($file_extension), $allowed_extensions)) {
                throw new Exception("Only JPG, JPEG, PNG & GIF files are allowed");
            }
            
            // Move uploaded file
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                $profile_image = $target_file;
            } else {
                throw new Exception("Error uploading file");
            }
        }
        
        // Insert into login table
        $stmt = $conn->prepare("INSERT INTO login (email, password, usertype) VALUES (:email, :password, :usertype)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password); // Store hashed password
        $stmt->bindParam(':usertype', $usertype);
        $stmt->execute();
        
        // Insert into users table
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, gender, profile_image, role_id, status) 
                               VALUES (:first_name, :last_name, :email, :phone, :gender, :profile_image, :role_id, :status)");
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':profile_image', $profile_image);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        
        // Commit transaction
        $conn->commit();
        
        $_SESSION['success_message'] = "Registration successful! User has been added.";
        
        // Redirect based on where the registration came from
        if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'manage_users.php') !== false) {
            header("Location: manage_users.php");
        } else {
            header("Location: index.php");
        }
        exit();
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
        header("Location: register.php");
        exit();
    }
}
?>