<?php
// Start output buffering
ob_start();

// Include necessary files
require_once 'include/header.php';
require_once 'propertyMgt/config.php';

// Check if the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch user details for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $conn->prepare("SELECT u.*, r.role_name 
                                FROM users u 
                                JOIN roles r ON u.role_id = r.role_id 
                                WHERE u.id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            $_SESSION['error_message'] = "User not found!";
            header("Location: manage_users.php");
            exit();
        }
    } catch(PDOException $e) {
        $_SESSION['error_message'] = "Error fetching user: " . $e->getMessage();
        header("Location: manage_users.php");
        exit();
    }
} else {
    header("Location: manage_users.php");
    exit();
}

// Handle form submission for updating user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
    $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $gender = $_POST['gender'];
    $role_id = filter_var($_POST['role_id'], FILTER_SANITIZE_NUMBER_INT);
    $status = $_POST['status'];
    
    try {
        // Begin transaction
        $conn->beginTransaction();

        // Temporarily disable foreign key checks (if supported by your database)
        $conn->exec("SET FOREIGN_KEY_CHECKS=0");

        // Check if email changed and if it's already in use
        if ($email !== $user['email']) {
            $check_email = $conn->prepare("SELECT email FROM login WHERE email = :email AND email != :current_email");
            $check_email->bindParam(':email', $email);
            $check_email->bindParam(':current_email', $user['email']);
            $check_email->execute();
            
            if ($check_email->rowCount() > 0) {
                throw new Exception("Email already exists");
            }
            
            // Update email in login table first (parent table)
            $update_login = $conn->prepare("UPDATE login SET email = :new_email WHERE email = :old_email");
            $update_login->bindParam(':new_email', $email);
            $update_login->bindParam(':old_email', $user['email']);
            $update_login->execute();
        }
        
        // Update user type in login table if role changed
        $new_usertype = ($role_id == 1) ? 'admin' : 'user';
        $update_usertype = $conn->prepare("UPDATE login SET usertype = :usertype WHERE email = :email");
        $update_usertype->bindParam(':usertype', $new_usertype);
        $update_usertype->bindParam(':email', $email);
        $update_usertype->execute();
        
        // Update user details in users table (child table)
        $stmt = $conn->prepare("UPDATE users 
                                SET first_name = :first_name, 
                                    last_name = :last_name, 
                                    email = :email, 
                                    phone = :phone, 
                                    gender = :gender, 
                                    role_id = :role_id, 
                                    status = :status 
                                WHERE id = :id");
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        // Handle profile image update if provided
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
                // Delete old image if exists
                if (!empty($user['profile_image']) && file_exists($user['profile_image'])) {
                    unlink($user['profile_image']);
                }
                
                // Update profile image in database
                $update_image = $conn->prepare("UPDATE users SET profile_image = :profile_image WHERE id = :id");
                $update_image->bindParam(':profile_image', $target_file);
                $update_image->bindParam(':id', $id);
                $update_image->execute();
            } else {
                throw new Exception("Error uploading file");
            }
        }
        
        // Re-enable foreign key checks
        $conn->exec("SET FOREIGN_KEY_CHECKS=1");

        // Commit transaction
        $conn->commit();
        
        $_SESSION['success_message'] = "User updated successfully!";
        header("Location: manage_users.php");
        exit();
    } catch(Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        
        // Re-enable foreign key checks in case of error
        $conn->exec("SET FOREIGN_KEY_CHECKS=1");

        $_SESSION['error_message'] = "Error updating user: " . $e->getMessage();
        header("Location: edit_user.php?id=" . $id);
        exit();
    }
}

// Fetch roles for dropdown
try {
    $stmt = $conn->query("SELECT * FROM roles");
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error = "Error fetching roles: " . $e->getMessage();
}
?>

<!-- Rest of your HTML form remains the same -->

<div class="row column1">
    <div class="col-md-12">
        <div class="white_shd full margin_bottom_30">
            <div class="full graph_head">
                <div class="heading1 margin_0">
                    <h2>Edit User</h2>
                </div>
            </div>
            <div class="full padding_infor_info">
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                        echo $_SESSION['error_message']; 
                        unset($_SESSION['error_message']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="field">
                                <label class="label_field">First Name</label>
                                <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field">
                                <label class="label_field">Last Name</label>
                                <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label_field">Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required class="form-control">
                    </div>
                    <div class="field">
                        <label class="label_field">Phone</label>
                        <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required class="form-control">
                    </div>
                    <div class="field">
                        <label class="label_field">Gender</label>
                        <div class="radio_option">
                            <input type="radio" name="gender" id="male" value="Male" <?php echo ($user['gender'] == 'Male') ? 'checked' : ''; ?> class="form-check-input">
                            <label for="male" class="form-check-label">Male</label>
                            <input type="radio" name="gender" id="female" value="Female" <?php echo ($user['gender'] == 'Female') ? 'checked' : ''; ?> class="form-check-input">
                            <label for="female" class="form-check-label">Female</label>
                            <input type="radio" name="gender" id="other" value="Other" <?php echo ($user['gender'] == 'Other') ? 'checked' : ''; ?> class="form-check-input">
                            <label for="other" class="form-check-label">Other</label>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label_field">Role</label>
                        <select name="role_id" class="form-control" required>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role['role_id']; ?>" <?php echo ($role['role_id'] == $user['role_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($role['role_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="field">
                        <label class="label_field">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="Active" <?php echo ($user['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                            <option value="Inactive" <?php echo ($user['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                            <option value="Pending" <?php echo ($user['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                        </select>
                    </div>
                    <div class="field">
                        <label class="label_field">Profile Image</label>
                        <?php if (!empty($user['profile_image']) && file_exists($user['profile_image'])): ?>
                            <div class="mb-2">
                                <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Current Profile Image" class="img-thumbnail" style="max-height: 100px;">
                                <p class="text-muted">Current profile image</p>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="profile_image" class="form-control" accept="image/*">
                        <small class="text-muted">Leave empty to keep the current image</small>
                    </div>
                    <div class="field margin_0">
                        <button type="submit" class="btn btn-primary btn-block">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'include/footer.php';
// End output buffering and send the output to the browser
ob_end_flush();
?>