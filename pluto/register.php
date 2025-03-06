<?php
require_once 'include/header.php';
// session_start();
require_once 'propertyMgt/config.php';

// Fetch roles from database for dropdown
try {
    $stmt = $conn->prepare("SELECT * FROM roles");
    $stmt->execute();
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Database error: " . $e->getMessage();
}
?>


                <div class="login_section">
                    <div class="login_form">
                        <h3 class="text-center mb-4">Create an Account</h3>
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
                        
                        <form method="POST" action="register_process.php" enctype="multipart/form-data">
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="field">
                                            <label class="label_field">First Name</label>
                                            <input type="text" name="first_name" placeholder="First Name" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="field">
                                            <label class="label_field">Last Name</label>
                                            <input type="text" name="last_name" placeholder="Last Name" required />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="field">
                                    <label class="label_field">Email</label>
                                    <input type="email" name="email" placeholder="Email" required />
                                </div>
                                
                                <div class="field">
                                    <label class="label_field">Phone</label>
                                    <input type="tel" name="phone" placeholder="Phone Number" required />
                                </div>
                                
                                <div class="field">
                                    <label class="label_field">Gender</label>
                                    <div class="radio_option">
                                        <input type="radio" name="gender" id="male" value="Male" checked>
                                        <label for="male">Male</label>
                                        <input type="radio" name="gender" id="female" value="Female">
                                        <label for="female">Female</label>
                                        <input type="radio" name="gender" id="other" value="Other">
                                        <label for="other">Other</label>
                                    </div>
                                </div>
                                
                                <div class="field">
                                    <label class="label_field">Password</label>
                                    <input type="password" name="password" id="password" placeholder="Password" required />
                                </div>
                                
                                <div class="field">
                                    <label class="label_field">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required />
                                </div>
                                
                                <div class="field">
                                    <label class="label_field">Role</label>
                                    <select name="role_id" class="form-select">
                                        <?php foreach ($roles as $role): ?>
                                            <option value="<?php echo $role['role_id']; ?>">
                                                <?php echo htmlspecialchars($role['role_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="field">
                                    <label class="label_field">Profile Image</label>
                                    <input type="file" name="profile_image" class="form-control" accept="image/*" />
                                </div>
                                
                                <div class="field margin_0">
                                    <button type="submit" class="main_bt">Register</button>
                                </div>
                                
                                <div class="field text-center mt-3">
                                    <p>Already have an account? <a href="index">Login here</a></p>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
           
                    <?php
                    require_once 'include/footer.php';
                    ?>

    <style>


.login_section {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

.login_form {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    width: 100%;
}

.login_form h3 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

/* Form Field Styles */
.field {
    margin-bottom: 20px;
}

.label_field {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

input[type="text"],
input[type="email"],
input[type="tel"],
input[type="password"],
select,
.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="tel"]:focus,
input[type="password"]:focus,
select:focus,
.form-control:focus {
    border-color: #007bff;
    outline: none;
}

/* Radio Button Styles */
.radio_option {
    display: flex;
    gap: 15px;
    margin-top: 10px;
}

.radio_option label {
    font-weight: normal;
    color: #555;
}

/* File Upload Styles */
input[type="file"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background: #f9f9f9;
    width: 100%;
    box-sizing: border-box;
}

/* Button Styles */
.main_bt {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.main_bt:hover {
    background-color: #0056b3;
}

/* Link Styles */
.field.text-center a {
    color: #007bff;
    text-decoration: none;
}

.field.text-center a:hover {
    text-decoration: underline;
}

/* Alert Styles */
.alert {
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
    text-align: center;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .login_form {
        padding: 20px;
    }

    .radio_option {
        flex-direction: column;
        gap: 10px;
    }

    .field {
        margin-bottom: 15px;
    }
}

@media (max-width: 480px) {
    .login_form {
        padding: 15px;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="password"],
    select,
    .form-control {
        font-size: 14px;
    }

    .main_bt {
        font-size: 14px;
    }
}
    </style>                

    <script>
        // Password validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
            }
        });
    </script>
