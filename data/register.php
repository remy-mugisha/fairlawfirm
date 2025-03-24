<?php
require_once 'include/header.php';
require_once 'propertyMgt/config.php';

try {
    $stmt = $conn->prepare("SELECT * FROM roles");
    $stmt->execute();
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Database error: " . $e->getMessage();
}
?>

<div class="full_container">
    <div class="inner_container">
        <div class="midde_cont">
            <div class="container-fluid">
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="white_shd full margin_bottom_30">
                            <div class="full graph_head">
                                <div class="heading1 margin_0">
                                    <h2>Registration Form</h2>
                                </div>
                            </div>
                            <div class="full padding_infor_info">
                                <?php if (!empty($error_message)): ?>
                                    <div class="alert alert-danger">
                                        <?php echo htmlspecialchars($error_message); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($_SESSION['success_message'])): ?>
                                    <div class="alert alert-success">
                                        <?php 
                                        echo htmlspecialchars($_SESSION['success_message']); 
                                        unset($_SESSION['success_message']);
                                        ?>
                                    </div>
                                <?php endif; ?>
                                
                                <form method="POST" action="register_process.php" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="field">
                                                <label class="label_field">First Name</label>
                                                <input type="text" name="first_name" placeholder="First Name" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="field">
                                                <label class="label_field">Last Name</label>
                                                <input type="text" name="last_name" placeholder="Last Name" required class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="field">
                                        <label class="label_field">Email</label>
                                        <input type="email" name="email" placeholder="Email" required class="form-control">
                                    </div>
                                    
                                    <div class="field">
                                        <label class="label_field">Phone</label>
                                        <input type="tel" name="phone" placeholder="Phone Number" required class="form-control">
                                    </div>
                                    
                                    <div class="field">
                                        <label class="label_field">Gender</label>
                                        <div class="radio_group">
                                            <div class="radio_option">
                                                <input type="radio" name="gender" id="male" value="Male" checked class="radio_input">
                                                <label for="male" class="radio_label">
                                                    <span class="radio_custom"></span>
                                                    Male
                                                </label>
                                            </div>
                                            <div class="radio_option">
                                                <input type="radio" name="gender" id="female" value="Female" class="radio_input">
                                                <label for="female" class="radio_label">
                                                    <span class="radio_custom"></span>
                                                    Female
                                                </label>
                                            </div>
                                            <div class="radio_option">
                                                <input type="radio" name="gender" id="other" value="Other" class="radio_input">
                                                <label for="other" class="radio_label">
                                                    <span class="radio_custom"></span>
                                                    Other
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="field">
                                        <label class="label_field">Password</label>
                                        <input type="password" name="password" id="password" placeholder="Password" required class="form-control">
                                    </div>
                                    
                                    <div class="field">
                                        <label class="label_field">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required class="form-control">
                                    </div>
                                    
                                    <div class="field">
                                        <label class="label_field">Role</label>
                                        <select name="role_id" class="form-control" required>
                                            <?php foreach ($roles as $role): ?>
                                                <option value="<?php echo $role['role_id']; ?>">
                                                    <?php echo htmlspecialchars($role['role_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="field">
                                        <label class="label_field">Profile Image</label>
                                        <input type="file" name="profile_image" class="form-control" accept="image/*">
                                    </div>
                                    
                                    <div class="field margin_0">
                                        <button type="submit" class="btn btn-info btn-block">Register</button>
                                    </div>
                                    
                                    <div class="field text-center mt-3">
                                        <p>Already have an account? <a href="index">Login here</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'include/footer.php';
?>
<style>
.white_shd {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.field {
    margin-bottom: 20px;
}

.label_field {
    font-weight: bold;
    color: #555;
    display: block;
    margin-bottom: 8px;
}

/* Radio button styles */
.radio_group {
    display: flex;
    gap: 20px;
    margin-top: 10px;
}

.radio_option {
    display: flex;
    align-items: center;
}

.radio_input {
    position: absolute;
    opacity: 0;
}

.radio_label {
    position: relative;
    padding-left: 30px;
    cursor: pointer;
    font-weight: normal;
    color: #555;
    display: flex;
    align-items: center;
}

.radio_custom {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #fff;
    border: 2px solid #ddd;
    border-radius: 50%;
    transition: all 0.3s;
}

.radio_input:checked ~ .radio_label .radio_custom {
    background-color: #17a2b8;
    border-color: #17a2b8;
}

.radio_input:checked ~ .radio_label .radio_custom::after {
    content: "";
    position: absolute;
    top: 4px;
    left: 4px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: white;
}

.radio_input:focus ~ .radio_label .radio_custom {
    box-shadow: 0 0 0 3px rgba(23, 162, 184, 0.2);
}

.btn-block {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    background-color: #17a2b8;
    border-color: #17a2b8;
}

.btn-block:hover {
    background-color: #138496;
    border-color: #117a8b;
}

@media (max-width: 768px) {
    .white_shd {
        padding: 15px;
    }

    .radio_group {
        flex-direction: column;
        gap: 10px;
    }

    .field {
        margin-bottom: 15px;
    }
}

@media (max-width: 480px) {
    .white_shd {
        padding: 10px;
    }

    .btn-block {
        font-size: 14px;
    }
}
</style>