<?php
// session_start();
require_once 'include/header.php';
require_once 'propertyMgt/config.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index");
    exit();
}

// Get user information from database
try {
    $stmt = $conn->prepare("SELECT u.*, r.role_name 
                           FROM users u
                           JOIN roles r ON u.role_id = r.role_id
                           WHERE u.email = :email");
    $stmt->bindParam(':email', $_SESSION['email']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        // If user record doesn't exist in the users table
        $stmt = $conn->prepare("SELECT * FROM login WHERE email = :email");
        $stmt->bindParam(':email', $_SESSION['email']);
        $stmt->execute();
        $login_user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($login_user) {
            $user = [
                'email' => $login_user['email'],
                'role_name' => $login_user['usertype'],
                'first_name' => 'User',
                'last_name' => '',
                'profile_image' => '',
                'phone' => '',
                'gender' => '',
                'status' => 'Active'
            ];
        }
    }
} catch (PDOException $e) {
    $error_message = "Database error: " . $e->getMessage();
}

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    try {
        $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
        $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
        $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
        $gender = $_POST['gender'];
        
        // Check if file was uploaded
        $profile_image = $user['profile_image']; // Keep existing image by default
        
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
                // If successful upload, delete old image if it exists
                if (!empty($user['profile_image']) && file_exists($user['profile_image'])) {
                    unlink($user['profile_image']);
                }
                $profile_image = $target_file;
            } else {
                throw new Exception("Error uploading file");
            }
        }
        
        // Update users table
        $stmt = $conn->prepare("UPDATE users 
                               SET first_name = :first_name, 
                                   last_name = :last_name, 
                                   phone = :phone, 
                                   gender = :gender,
                                   profile_image = :profile_image
                               WHERE email = :email");
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':profile_image', $profile_image);
        $stmt->bindParam(':email', $_SESSION['email']);
        $stmt->execute();
        
        $success_message = "Profile updated successfully!";
        
        // Update session variables
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['profile_image'] = $profile_image;
        
    } catch (Exception $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>


                
                <!-- Dashboard Content -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>User Profile</h2>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Profile Information</h2>
                                        </div>
                                    </div>
                                    <div class="full padding_infor_info">
                                        <!-- Display messages -->
                                        <?php if (!empty($error_message)): ?>
                                            <div class="alert alert-danger">
                                                <?php echo htmlspecialchars($error_message); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($success_message)): ?>
                                            <div class="alert alert-success">
                                                <?php echo htmlspecialchars($success_message); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="profile_img text-center">
                                                    <?php if (!empty($user['profile_image']) && file_exists($user['profile_image'])): ?>
                                                        <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Image" class="img-responsive" style="max-width: 200px; margin: 0 auto;">
                                                    <?php else: ?>
                                                        <img src="images/default-avatar.png" alt="Default Avatar" class="img-responsive" style="max-width: 200px; margin: 0 auto;">
                                                    <?php endif; ?>
                                                    <h4 class="mt-3"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h4>
                                                    <p><?php echo htmlspecialchars($user['role_name']); ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <form method="POST" action="" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="field">
                                                                <label class="label_field">First Name</label>
                                                                <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="field">
                                                                <label class="label_field">Last Name</label>
                                                                <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="field">
                                                        <label class="label_field">Email</label>
                                                        <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                                                    </div>
                                                    
                                                    <div class="field">
                                                        <label class="label_field">Phone</label>
                                                        <input type="tel" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                                                    </div>
                                                    
                                                    <div class="field">
                                                        <label class="label_field">Gender</label>
                                                        <div class="radio_option">
                                                            <input type="radio" name="gender" id="male" value="Male" <?php echo ($user['gender'] == 'Male') ? 'checked' : ''; ?>>
                                                            <label for="male">Male</label>
                                                            <input type="radio" name="gender" id="female" value="Female" <?php echo ($user['gender'] == 'Female') ? 'checked' : ''; ?>>
                                                            <label for="female">Female</label>
                                                            <input type="radio" name="gender" id="other" value="Other" <?php echo ($user['gender'] == 'Other') ? 'checked' : ''; ?>>
                                                            <label for="other">Other</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="field">
                                                        <label class="label_field">Role</label>
                                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['role_name']); ?>" readonly>
                                                    </div>
                                                    
                                                    </div>

<?php
require_once 'include/footer.php';
?>
